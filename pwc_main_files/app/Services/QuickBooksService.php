<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Clevpro\LaravelQuickbooks\Services\QuickbooksCustomerService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\QuickBooksToken;
use Carbon\Carbon;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksService
{
    protected $customerService;
    protected $accessToken;
    protected $realmId;
    protected $tokenModel;
    protected $baseUrl;

    public function __construct()
    {
        try {
            // Auto-refresh token if needed
            $this->refreshTokenIfNeeded();

            // Get active token from database
            $this->tokenModel = QuickBooksToken::getActiveToken();

            if (!$this->tokenModel) {
                // Fallback to .env if no database token
                $this->accessToken = env('QUICKBOOKS_ACCESS_TOKEN');
                $this->realmId = env('QUICKBOOKS_COMPANY_ID');

                if (empty($this->accessToken) || empty($this->realmId)) {
                    Log::warning('QuickBooks credentials missing in both database and .env', [
                        'has_access_token' => !empty($this->accessToken),
                        'has_realm_id' => !empty($this->realmId)
                    ]);
                    $this->customerService = null;
                    return;
                }
            } else {
                $this->accessToken = $this->tokenModel->access_token;
                $this->realmId = $this->tokenModel->realm_id;
            }

            // Set base URL based on environment (sandbox or production)
            $isSandbox = env('QUICKBOOKS_SANDBOX', true);
            $this->baseUrl = $isSandbox
                ? 'https://sandbox-quickbooks.api.intuit.com/v3'
                : 'https://quickbooks.api.intuit.com/v3';

            // Initialize the Clevpro QuickBooks Customer Service
            $this->customerService = new QuickbooksCustomerService($this->accessToken, $this->realmId);

            Log::info('QuickBooks Service initialized successfully', [
                'source' => $this->tokenModel ? 'database' : 'env',
                'environment' => $isSandbox ? 'sandbox' : 'production',
                'base_url' => $this->baseUrl,
                'expires_at' => $this->tokenModel ? $this->tokenModel->expires_at : 'unknown'
            ]);
        } catch (\Exception $e) {
            Log::error('QuickBooks Service Constructor Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->customerService = null;
        }
    }

    /**
     * Auto-refresh token if expired or about to expire
     */
    protected function refreshTokenIfNeeded()
    {
        try {
            $token = QuickBooksToken::getActiveToken();

            if (!$token) {
                Log::warning('❌ No active QuickBooks token found in database');
                return;
            }

            Log::info('🔍 Checking QuickBooks token status...', [
                'token_id' => $token->id,
                'expires_at' => $token->expires_at->format('Y-m-d H:i:s'),
                'current_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'is_expired' => $token->isExpired()
            ]);

            // Check if token is expired or about to expire (within 5 minutes)
            if ($token->isExpired()) {
                Log::warning('⚠️ QuickBooks token EXPIRED or about to expire - Starting refresh process...', [
                    'expired_at' => $token->expires_at->format('Y-m-d H:i:s'),
                    'time_since_expiry' => $token->expires_at->diffForHumans()
                ]);

                $refreshSuccess = $this->refreshAccessToken($token);

                if ($refreshSuccess) {
                    // Reload token to get updated values
                    $token->refresh();
                    Log::info('✅ NEW TOKEN GENERATED & SAVED', [
                        'new_expires_at' => $token->expires_at->format('Y-m-d H:i:s'),
                        'new_expiry_in' => $token->expires_at->diffForHumans()
                    ]);
                } else {
                    Log::error('❌ TOKEN REFRESH FAILED - Using old token (may cause errors)');
                }
            } else {
                Log::info('✅ USING EXISTING VALID TOKEN', [
                    'expires_at' => $token->expires_at->format('Y-m-d H:i:s'),
                    'time_remaining' => $token->expires_at->diffForHumans(),
                    'valid_for' => Carbon::now()->diffInMinutes($token->expires_at) . ' minutes'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error checking/refreshing token: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Refresh access token using refresh token
     */
    protected function refreshAccessToken($token)
    {
        try {
            Log::info('🔄 Starting token refresh via QuickBooks OAuth API...', [
                'old_access_token' => substr($token->access_token, 0, 20) . '...',
                'refresh_token' => substr($token->refresh_token, 0, 20) . '...'
            ]);

            // Use Guzzle HTTP client to refresh token directly
            $client = new Client();

            $response = $client->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode(
                        config('quickbooks.client_id') . ':' . config('quickbooks.client_secret')
                    )
                ],
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token->refresh_token
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('📥 Received response from QuickBooks OAuth API', [
                'has_access_token' => isset($result['access_token']),
                'has_refresh_token' => isset($result['refresh_token']),
                'expires_in' => $result['expires_in'] ?? 'N/A'
            ]);

            if (isset($result['access_token']) && isset($result['refresh_token'])) {
                $oldExpiresAt = $token->expires_at->format('Y-m-d H:i:s');

                // Update token in database
                $token->update([
                    'access_token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'],
                    'expires_at' => Carbon::now()->addSeconds($result['expires_in'])
                ]);

                Log::info('💾 Token saved to database', [
                    'old_expires_at' => $oldExpiresAt,
                    'new_expires_at' => $token->expires_at->format('Y-m-d H:i:s'),
                    'new_access_token' => substr($result['access_token'], 0, 20) . '...',
                    'expires_in_seconds' => $result['expires_in']
                ]);

                return true;
            } else {
                Log::error('❌ Invalid response from QuickBooks token refresh', [
                    'response' => $result
                ]);
                return false;
            }
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('❌ Failed to refresh QuickBooks token (Client Error): ' . $responseBody, [
                'status_code' => $e->getResponse()->getStatusCode()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('❌ Failed to refresh QuickBooks token: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Create customer in QuickBooks
     */
    public function createCustomer($clientData)
    {
        try {
            if (!$this->customerService) {
                Log::error('QuickBooks Customer Service is NULL');
                return [
                    'success' => false,
                    'error' => 'QuickBooks service not initialized'
                ];
            }

            // Prepare customer data for Clevpro package
            $customerData = [
                'full_name' => $clientData['name'],
                'display_name' => $clientData['name'],
                'email' => $clientData['email'] ?? '',
                'phone' => $clientData['phone'] ?? '',
                'company_name' => $clientData['company_name'] ?? '',
                'address_line1' => $clientData['address'] ?? '',
                'city' => $clientData['city'] ?? '',
                'state' => $clientData['state'] ?? '',
                'postal_code' => $clientData['zip_code'] ?? '',
                'country' => $clientData['country'] ?? 'US'
            ];

            // Create customer using Clevpro package
            $customer = $this->customerService->createCustomer($customerData);

            if ($customer && isset($customer->Id)) {
                Log::info('Customer created successfully in QuickBooks', [
                    'customer_id' => $customer->Id
                ]);
                return [
                    'success' => true,
                    'customer_id' => $customer->Id,
                    'customer' => $customer
                ];
            } else {
                Log::error('Failed to create customer in QuickBooks', [
                    'response' => $customer
                ]);
                return [
                    'success' => false,
                    'error' => 'Failed to create customer'
                ];
            }
        } catch (\Exception $e) {
            Log::error('QuickBooks Create Customer Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Update customer in QuickBooks
     */
    public function updateCustomer($quickbooksId, $clientData)
    {
        try {
            if (!$this->customerService) {
                Log::error('QuickBooks Customer Service is NULL in updateCustomer');
                return [
                    'success' => false,
                    'error' => 'QuickBooks service not initialized'
                ];
            }

            // Validate QuickBooks ID
            if (empty($quickbooksId)) {
                Log::warning('Empty QuickBooks ID provided for update');
                return [
                    'success' => false,
                    'error' => 'QuickBooks customer ID is empty'
                ];
            }

            Log::info('Attempting to update customer in QuickBooks', [
                'quickbooks_id' => $quickbooksId
            ]);

            // Prepare customer data for Clevpro package
            $customerData = [
                'full_name' => $clientData['name'],
                'display_name' => $clientData['name'],
                'email' => $clientData['email'] ?? '',
                'phone' => $clientData['phone'] ?? '',
                'company_name' => $clientData['company_name'] ?? '',
                'address_line1' => $clientData['address'] ?? '',
                'city' => $clientData['city'] ?? '',
                'state' => $clientData['state'] ?? '',
                'postal_code' => $clientData['zip_code'] ?? '',
                'country' => $clientData['country'] ?? 'US'
            ];

            // Update customer using Clevpro package
            $customer = $this->customerService->updateCustomer($quickbooksId, $customerData);

            if ($customer && isset($customer->Id)) {
                Log::info('Customer updated successfully in QuickBooks', [
                    'quickbooks_id' => $quickbooksId
                ]);
                return [
                    'success' => true,
                    'customer' => $customer
                ];
            } else {
                // Check if it's an error response
                if (is_string($customer)) {
                    Log::error('Failed to update customer in QuickBooks', [
                        'quickbooks_id' => $quickbooksId,
                        'error' => $customer
                    ]);
                    return [
                        'success' => false,
                        'error' => $customer
                    ];
                }

                Log::error('Failed to update customer in QuickBooks', [
                    'quickbooks_id' => $quickbooksId,
                    'response' => $customer
                ]);
                return [
                    'success' => false,
                    'error' => 'Failed to update customer'
                ];
            }
        } catch (\Exception $e) {
            Log::error('QuickBooks Update Error: ' . $e->getMessage(), [
                'quickbooks_id' => $quickbooksId ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Deactivate customer in QuickBooks (make inactive)
     *
     * Note: QuickBooks does NOT allow deleting customers that have transactions.
     * This method makes the customer INACTIVE, which is the recommended approach.
     */
    public function deactivateCustomer($quickbooksId)
    {
        try {
            if (!$this->accessToken || !$this->realmId) {
                Log::error('QuickBooks credentials missing for deactivate');
                return [
                    'success' => false,
                    'error' => 'QuickBooks service not initialized'
                ];
            }

            // Validate QuickBooks ID
            if (empty($quickbooksId)) {
                Log::warning('Empty QuickBooks ID provided for deactivation');
                return [
                    'success' => false,
                    'error' => 'QuickBooks customer ID is empty'
                ];
            }

            Log::info('Attempting to deactivate customer in QuickBooks', [
                'quickbooks_id' => $quickbooksId
            ]);

            // Create Guzzle client
            $client = new Client();

            // Step 1: Get existing customer to get SyncToken
            $response = $client->get("{$this->baseUrl}/company/{$this->realmId}/customer/{$quickbooksId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

            $customerResp = json_decode((string) $response->getBody(), false);

            if (!isset($customerResp->Customer)) {
                Log::error('Customer not found in QuickBooks for deactivation', [
                    'quickbooks_id' => $quickbooksId
                ]);
                return [
                    'success' => false,
                    'error' => 'Customer not found in QuickBooks'
                ];
            }

            $customer = $customerResp->Customer;
            $syncToken = $customer->SyncToken;

            // Step 2: Update customer with Active = false
            $response = $client->post("{$this->baseUrl}/company/{$this->realmId}/customer", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'Id' => $quickbooksId,
                    'SyncToken' => $syncToken,
                    'Active' => false,
                    'sparse' => true  // Only update the Active field
                ]
            ]);

            $updatedCustomerResp = json_decode((string) $response->getBody(), false);

            if (isset($updatedCustomerResp->Customer)) {
                Log::info('Customer deactivated successfully in QuickBooks', [
                    'quickbooks_id' => $quickbooksId
                ]);
                return [
                    'success' => true,
                    'customer' => $updatedCustomerResp->Customer,
                    'message' => 'Customer marked as INACTIVE in QuickBooks'
                ];
            } else {
                Log::error('Failed to deactivate customer in QuickBooks', [
                    'quickbooks_id' => $quickbooksId,
                    'response' => $updatedCustomerResp
                ]);
                return [
                    'success' => false,
                    'error' => 'Failed to deactivate customer'
                ];
            }
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('QuickBooks Deactivate Error (Client Exception)', [
                'quickbooks_id' => $quickbooksId,
                'error' => $responseBody
            ]);
            return [
                'success' => false,
                'error' => $responseBody
            ];
        } catch (\Exception $e) {
            Log::error('QuickBooks Deactivate Error: ' . $e->getMessage(), [
                'quickbooks_id' => $quickbooksId ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete customer from QuickBooks
     *
     * NOTE: QuickBooks API does NOT support DELETE operation for customers!
     * This method will always return failure and recommend using deactivateCustomer() instead.
     *
     * Reference: https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/customer
     */
    
    public function deleteCustomer($quickbooksId)
    {
        // QuickBooks does NOT support DELETE operation for customers
        // Always return failure and recommend deactivation
        Log::warning('QuickBooks DELETE operation not supported for customers', [
            'quickbooks_id' => $quickbooksId,
            'recommendation' => 'Use deactivateCustomer() instead'
        ]);

        return [
            'success' => false,
            'error' => 'QuickBooks API does not support DELETE operation for customers. Use deactivateCustomer() to make customer inactive.',
            'not_supported' => true
        ];
    }

    /**
     * Create Invoice in QuickBooks
     *
     * @param array $invoiceData - Invoice data containing:
     *   - customer_id (QuickBooks Customer ID)
     *   - customer_name
     *   - amount
     *   - description
     *   - service_date
     *   - due_date (optional)
     *   - line_items (optional array of items)
     *
     * @return array ['success' => bool, 'invoice' => object|null, 'error' => string|null]
     */
    public function createInvoice($invoiceData)
    {
        try {
            if (!$this->accessToken || !$this->realmId) {
                Log::error('QuickBooks credentials missing - cannot create invoice');
                return [
                    'success' => false,
                    'error' => 'QuickBooks credentials not configured'
                ];
            }

            Log::info('Creating invoice in QuickBooks', [
                'customer_id' => $invoiceData['customer_id'] ?? 'N/A',
                'customer_name' => $invoiceData['customer_name'] ?? 'N/A',
                'amount' => $invoiceData['amount'] ?? 0
            ]);

            // Prepare line items
            $lineItems = [];

            // Get default service item ID from QuickBooks
            $defaultServiceItemId = $this->getDefaultServiceItem();

            if (!$defaultServiceItemId) {
                Log::error('No service item found in QuickBooks - Cannot create invoice');
                return [
                    'success' => false,
                    'error' => 'No service item found in QuickBooks. Please create at least one service item in QuickBooks first.'
                ];
            }

            if (isset($invoiceData['line_items']) && is_array($invoiceData['line_items'])) {
                // Use provided line items
                foreach ($invoiceData['line_items'] as $item) {
                    $lineItems[] = [
                        'DetailType' => 'SalesItemLineDetail',
                        'Amount' => (float) ($item['amount'] ?? 0),
                        'Description' => $item['description'] ?? '',
                        'SalesItemLineDetail' => [
                            'ItemRef' => [
                                'value' => $defaultServiceItemId
                            ],
                            'Qty' => (int) ($item['quantity'] ?? 1),
                            'UnitPrice' => (float) ($item['unit_price'] ?? ($item['amount'] ?? 0)),
                        ]
                    ];
                }
            } else {
                // Create single line item from total amount
                $lineItems[] = [
                    'DetailType' => 'SalesItemLineDetail',
                    'Amount' => (float) ($invoiceData['amount'] ?? 0),
                    'Description' => $invoiceData['description'] ?? 'Window Cleaning Service',
                    'SalesItemLineDetail' => [
                        'ItemRef' => [
                            'value' => $defaultServiceItemId
                        ],
                        'Qty' => 1,
                        'UnitPrice' => (float) ($invoiceData['amount'] ?? 0),
                    ]
                ];
            }

            // Generate unique invoice number (max 21 chars for QuickBooks)
            // Format: INV-YYMMDD-XXXXX (e.g., INV-260207-12345) = 17 chars
            $timestamp = time();
            $shortTimestamp = substr($timestamp, -5); // Last 5 digits
            $docNumber = $invoiceData['invoice_number'] ?? 'INV-' . date('ymd') . '-' . $shortTimestamp;

            // Prepare invoice payload
            $invoicePayload = [
                'CustomerRef' => [
                    'value' => $invoiceData['customer_id']
                ],
                'Line' => $lineItems,
                'TxnDate' => $invoiceData['service_date'] ?? date('Y-m-d'),
                'DocNumber' => $docNumber,  // Max 21 chars
            ];

            // Add due date if provided
            if (isset($invoiceData['due_date'])) {
                $invoicePayload['DueDate'] = $invoiceData['due_date'];
            }

            // Add customer memo if provided
            if (isset($invoiceData['customer_memo'])) {
                $invoicePayload['CustomerMemo'] = [
                    'value' => $invoiceData['customer_memo']
                ];
            }

            // Make API request to create invoice
            $client = new Client();
            $response = $client->post(
                "{$this->baseUrl}/company/{$this->realmId}/invoice",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $invoicePayload
                ]
            );

            $invoiceResponse = json_decode((string) $response->getBody(), false);

            if (isset($invoiceResponse->Invoice)) {
                $invoice = $invoiceResponse->Invoice;

                Log::info('Invoice created successfully in QuickBooks', [
                    'invoice_id' => $invoice->Id ?? 'N/A',
                    'invoice_number' => $invoice->DocNumber ?? 'N/A',
                    'customer_id' => $invoiceData['customer_id'],
                    'amount' => $invoice->TotalAmt ?? 0
                ]);

                // Send invoice email to customer
                $emailSent = false;
                $emailError = null;

                try {
                    $sendResponse = $this->sendInvoiceEmail($invoice->Id, $invoiceData['customer_email'] ?? null);
                    $emailSent = $sendResponse['success'] ?? false;
                    $emailError = $sendResponse['error'] ?? null;

                    if ($emailSent) {
                        Log::info('Invoice email sent successfully', [
                            'invoice_id' => $invoice->Id,
                            'customer_email' => $invoiceData['customer_email'] ?? 'default'
                        ]);
                    } else {
                        Log::warning('Failed to send invoice email', [
                            'invoice_id' => $invoice->Id,
                            'error' => $emailError
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error sending invoice email', [
                        'invoice_id' => $invoice->Id,
                        'error' => $e->getMessage()
                    ]);
                    $emailError = $e->getMessage();
                }

                return [
                    'success' => true,
                    'invoice' => $invoice,
                    'invoice_id' => $invoice->Id ?? null,
                    'invoice_number' => $invoice->DocNumber ?? null,
                    'total_amount' => $invoice->TotalAmt ?? 0,
                    'email_sent' => $emailSent,
                    'email_error' => $emailError,
                    'message' => 'Invoice created successfully in QuickBooks' . ($emailSent ? ' and email sent to customer' : '')
                ];
            } else {
                Log::error('Failed to create invoice in QuickBooks - Invalid response', [
                    'response' => $invoiceResponse
                ]);
                return [
                    'success' => false,
                    'error' => 'Invalid response from QuickBooks API'
                ];
            }
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('QuickBooks Invoice Creation Error (Client Exception)', [
                'customer_id' => $invoiceData['customer_id'] ?? 'N/A',
                'error' => $responseBody
            ]);
            return [
                'success' => false,
                'error' => $responseBody
            ];
        } catch (\Exception $e) {
            Log::error('QuickBooks Invoice Creation Error: ' . $e->getMessage(), [
                'customer_id' => $invoiceData['customer_id'] ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get default service item from QuickBooks
     * This fetches the first available service item from QuickBooks
     *
     * @return string|null Service Item ID
     */
    protected function getDefaultServiceItem()
    {
        try {
            if (!$this->accessToken || !$this->realmId) {
                Log::error('QuickBooks credentials missing for fetching service item');
                return null;
            }

            $client = new Client();

            // Query for service items (Type = 'Service')
            $query = "SELECT * FROM Item WHERE Type = 'Service' AND Active = true MAXRESULTS 1";
            $encodedQuery = urlencode($query);

            $response = $client->get(
                "{$this->baseUrl}/company/{$this->realmId}/query?query={$encodedQuery}",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Accept' => 'application/json',
                    ]
                ]
            );

            $result = json_decode((string) $response->getBody(), false);

            if (isset($result->QueryResponse->Item) && count($result->QueryResponse->Item) > 0) {
                $serviceItem = $result->QueryResponse->Item[0];

                Log::info('Found service item in QuickBooks', [
                    'item_id' => $serviceItem->Id,
                    'item_name' => $serviceItem->Name ?? 'N/A'
                ]);

                return $serviceItem->Id;
            }

            // If no service item found, try to create one
            Log::warning('No service item found in QuickBooks - Creating default service item');
            return $this->createDefaultServiceItem();

        } catch (\Exception $e) {
            Log::error('Error fetching service item from QuickBooks: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Create a default service item in QuickBooks
     *
     * @return string|null Created Service Item ID
     */
    protected function createDefaultServiceItem()
    {
        try {
            if (!$this->accessToken || !$this->realmId) {
                Log::error('QuickBooks credentials missing for creating service item');
                return null;
            }

            $client = new Client();

            // Create a simple service item
            $itemPayload = [
                'Name' => 'Service',
                'Type' => 'Service',
                'IncomeAccountRef' => [
                    'value' => '1'  // Default income account (Sales)
                ]
            ];

            $response = $client->post(
                "{$this->baseUrl}/company/{$this->realmId}/item",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $itemPayload
                ]
            );

            $result = json_decode((string) $response->getBody(), false);

            if (isset($result->Item)) {
                Log::info('Created default service item in QuickBooks', [
                    'item_id' => $result->Item->Id,
                    'item_name' => $result->Item->Name
                ]);

                return $result->Item->Id;
            }

            Log::error('Failed to create service item in QuickBooks', [
                'response' => $result
            ]);
            return null;

        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('QuickBooks Create Service Item Error (Client Exception)', [
                'error' => $responseBody
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error creating service item in QuickBooks: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Send invoice email to customer
     *
     * @param string $invoiceId QuickBooks invoice ID
     * @param string|null $customerEmail Optional customer email (if not provided, uses QB customer email)
     * @return array
     */
    public function sendInvoiceEmail($invoiceId, $customerEmail = null)
    {
        try {
            if (!$this->accessToken || !$this->realmId) {
                Log::error('QuickBooks credentials missing for sending invoice email');
                return [
                    'success' => false,
                    'error' => 'QuickBooks service not initialized'
                ];
            }

            if (empty($invoiceId)) {
                Log::warning('Empty invoice ID provided for sending email');
                return [
                    'success' => false,
                    'error' => 'Invoice ID is required'
                ];
            }

            Log::info('Attempting to send invoice email', [
                'invoice_id' => $invoiceId,
                'customer_email' => $customerEmail ?? 'default'
            ]);

            $client = new Client();

            // Build the send URL
            $sendUrl = "{$this->baseUrl}/company/{$this->realmId}/invoice/{$invoiceId}/send";

            // Add email parameter if provided
            if ($customerEmail) {
                $sendUrl .= "?sendTo=" . urlencode($customerEmail);
            }

            // Send the invoice via QuickBooks API
            $response = $client->post($sendUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/octet-stream',
                ]
            ]);

            $responseBody = json_decode((string) $response->getBody(), false);

            if (isset($responseBody->Invoice)) {
                Log::info('Invoice email sent successfully', [
                    'invoice_id' => $invoiceId,
                    'email_status' => $responseBody->Invoice->EmailStatus ?? 'unknown'
                ]);

                return [
                    'success' => true,
                    'message' => 'Invoice email sent successfully',
                    'email_status' => $responseBody->Invoice->EmailStatus ?? 'sent'
                ];
            } else {
                Log::warning('Unexpected response when sending invoice email', [
                    'invoice_id' => $invoiceId,
                    'response' => $responseBody
                ]);

                return [
                    'success' => false,
                    'error' => 'Unexpected response from QuickBooks'
                ];
            }
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('QuickBooks Send Invoice Email Error (Client Exception)', [
                'invoice_id' => $invoiceId,
                'error' => $responseBody
            ]);

            return [
                'success' => false,
                'error' => $responseBody
            ];
        } catch (\Exception $e) {
            Log::error('QuickBooks Send Invoice Email Error: ' . $e->getMessage(), [
                'invoice_id' => $invoiceId,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get payment details from QuickBooks
     *
     * @param string $paymentId QuickBooks Payment ID
     * @return array
     */
    public function getPayment($paymentId)
    {
        try {
            Log::info('Fetching payment from QuickBooks', [
                'payment_id' => $paymentId
            ]);

            $client = new Client();

            $response = $client->get("{$this->baseUrl}/company/{$this->realmId}/payment/{$paymentId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Accept' => 'application/json',
                ]
            ]);

            $paymentResponse = json_decode((string) $response->getBody(), false);

            if (isset($paymentResponse->Payment)) {
                $payment = $paymentResponse->Payment;

                Log::info('Payment fetched successfully from QuickBooks', [
                    'payment_id' => $payment->Id ?? 'N/A',
                    'total_amount' => $payment->TotalAmt ?? 0,
                    'txn_date' => $payment->TxnDate ?? 'N/A'
                ]);

                return [
                    'success' => true,
                    'payment' => $payment
                ];
            } else {
                Log::error('Failed to fetch payment from QuickBooks - Invalid response', [
                    'payment_id' => $paymentId,
                    'response' => $paymentResponse
                ]);

                return [
                    'success' => false,
                    'error' => 'Invalid payment response from QuickBooks'
                ];
            }

        } catch (\Exception $e) {
            Log::error('QuickBooks Get Payment Error: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
