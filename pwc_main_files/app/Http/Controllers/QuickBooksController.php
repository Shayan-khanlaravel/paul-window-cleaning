<?php

namespace App\Http\Controllers;

use App\Models\ClientPriceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use QuickBooksOnline\API\DataService\DataService;
use App\Models\QuickBooksToken;
use Carbon\Carbon;

class QuickBooksController extends Controller
{
    /**
     * Get DataService instance
     */
    private function getDataService()
    {
        return DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => env('QUICKBOOKS_ENVIRONMENT') === 'production'
                ? "https://quickbooks.api.intuit.com"
                : "https://sandbox-quickbooks.api.intuit.com"
        ]);
    }

    /**
     * Redirect to QuickBooks OAuth
     */
    public function connect()
    {
        $dataService = $this->getDataService();
        // return $dataService;
        $authUrl = $dataService->getOAuth2LoginHelper()->getAuthorizationCodeURL();
        // dd($authUrl);
        return redirect($authUrl);
    }

    /**
     * Handle OAuth callback
     */
    public function callback(Request $request)
    {
        try {
            $code = $request->get('code');
            $realmId = $request->get('realmId');

            if (!$code || !$realmId) {
                return redirect('/dashboard_index')->with([
                    'title' => 'Error',
                    'message' => 'QuickBooks authorization failed',
                    'type' => 'error'
                ]);
            }

            // Exchange code for tokens
            $dataService = $this->getDataService();
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $accessTokenObj = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

            $dataService->updateOAuth2Token($accessTokenObj);

            // Get tokens
            $accessToken = $accessTokenObj->getAccessToken();
            $refreshToken = $accessTokenObj->getRefreshToken();
            $expiresIn = $accessTokenObj->getAccessTokenExpiresAt(); // seconds

            // Save to database (primary)
            $this->saveTokensToDatabase($accessToken, $refreshToken, $realmId, $expiresIn);


            $this->saveTokensToEnv($accessToken, $refreshToken, $realmId);

            return view('quickbooks.success', [
                'accessToken' => $accessToken,
                'refreshToken' => $refreshToken,
                'companyId' => $realmId,
                'expiresAt' => Carbon::now()->addSeconds($expiresIn)->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('QuickBooks OAuth Error: ' . $e->getMessage());

            return redirect('/dashboard_index')->with([
                'title' => 'Error',
                'message' => 'QuickBooks connection failed: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Test QuickBooks connection
     */
    public function testConnection()
    {
        try {
            $dataService = $this->getAuthenticatedDataService();

            // Try to get company info
            $companyInfo = $dataService->getCompanyInfo();

            return response()->json([
                'success' => true,
                'message' => 'QuickBooks connected successfully!',
                'company' => $companyInfo->CompanyName
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all customers from QuickBooks
     */
    public function listCustomers()
    {
        try {
            $dataService = $this->getAuthenticatedDataService();

            // 1. QuickBooks se data fetch karein
            $query = "SELECT * FROM Customer WHERE Active = true MAXRESULTS 1000";
            $customers = $dataService->Query($query);

            if (!$customers) {
                return view('quickbooks.customers', [
                    'customers' => [],
                    'message' => 'No active customers found in QuickBooks'
                ]);
            }

            // 2. Local Database se apne clients ke names fetch karein
            // Hum 'pluck' use karenge taake humein sirf names ka array mile
            $localClientNames = \App\Models\Client::pluck('name')->toArray();

            // 3. Customers ke array mein "is_matched" property add karein
            foreach ($customers as $customer) {
                // Hum trim() aur lowecase use karenge taake spelling/space ka masla na ho
                $qbName = trim(strtolower($customer->DisplayName));

                // Check karein ke ye name local array mein maujood hai?
                $customer->is_matched = in_array($qbName, array_map('strtolower', array_map('trim', $localClientNames)));
            }
            return view('quickbooks.customers', [
                'customers' => $customers,
                'message' => 'Found ' . count($customers) . ' customers'
            ]);
        } catch (\Exception $e) {
            Log::error('QuickBooks List Customers Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Import customers page - shows QuickBooks customers with import option
     */
    public function importCustomersPage()
    {
        try {
            $dataService = $this->getAuthenticatedDataService();

            // Query all customers from QuickBooks
            $qbCustomers = $dataService->Query("SELECT * FROM Customer WHERE Active = true MAXRESULTS 1000");

            if (!$qbCustomers) {
                return view('quickbooks.import', [
                    'customers' => [],
                    'total' => 0,
                    'already_imported' => 0,
                    'message' => 'No customers found in QuickBooks'
                ]);
            }

            // Get all local client names (lowercase for comparison)
            $localClientNames = \App\Models\Client::pluck('name')->map(function ($name) {
                return strtolower(trim($name));
            })->toArray();

            // Get all local client emails (lowercase for comparison)
            $localClientEmails = \App\Models\Client::whereNotNull('contact_email')
                ->pluck('contact_email')
                ->map(function ($email) {
                    return strtolower(trim($email));
                })->toArray();

            // Prepare customers array with match status
            $customers = [];
            $alreadyImportedCount = 0;

            foreach ($qbCustomers as $qbCustomer) {
                // Get customer name from QuickBooks
                $qbName = strtolower(trim($qbCustomer->DisplayName ?? $qbCustomer->CompanyName ?? ''));

                // Get customer email from QuickBooks
                $qbEmail = isset($qbCustomer->PrimaryEmailAddr->Address)
                    ? strtolower(trim($qbCustomer->PrimaryEmailAddr->Address))
                    : '';

                // Check if already imported by Name OR Email match
                $alreadyImported = in_array($qbName, $localClientNames)
                    || ($qbEmail && in_array($qbEmail, $localClientEmails));

                if ($alreadyImported) {
                    $alreadyImportedCount++;
                }

                $customers[] = [
                    'qb_data' => $qbCustomer,
                    'already_imported' => $alreadyImported
                ];
            }

            return view('quickbooks.import', [
                'customers' => $customers,
                'total' => count($qbCustomers),
                'already_imported' => $alreadyImportedCount
            ]);
        } catch (\Exception $e) {
            Log::error('QuickBooks Import Page Error: ' . $e->getMessage());

            return view('quickbooks.import', [
                'customers' => [],
                'total' => 0,
                'already_imported' => 0,
                'error' => 'Failed to fetch customers: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Import selected customers from QuickBooks
     */
    public function importCustomers(Request $request)
    {
        try {
            $customerIds = $request->input('customer_ids', []);

            if (empty($customerIds)) {
                return redirect()->back()->with([
                    'title' => 'Error',
                    'message' => 'Please select at least one customer to import',
                    'type' => 'error'
                ]);
            }

            $dataService = $this->getAuthenticatedDataService();
            $imported = 0;
            $skipped = 0;
            $errors = [];

            foreach ($customerIds as $qbCustomerId) {
                try {
                    // Check if already exists
                    $existingClient = \App\Models\Client::where('quickbooks_customer_id', $qbCustomerId)->first();
                    if ($existingClient) {
                        $skipped++;
                        continue;
                    }

                    // Fetch customer from QuickBooks
                    $customer = $dataService->FindById('Customer', $qbCustomerId);

                    if (!$customer) {
                        $errors[] = "Customer ID {$qbCustomerId} not found in QuickBooks";
                        continue;
                    }

                    // Extract customer data safely
                    $customerEmail = isset($customer->PrimaryEmailAddr->Address)
                        ? $customer->PrimaryEmailAddr->Address
                        : null;

                    $customerPhone = isset($customer->PrimaryPhone->FreeFormNumber)
                        ? $customer->PrimaryPhone->FreeFormNumber
                        : null;

                    $customerAddress = isset($customer->BillAddr->Line1)
                        ? $customer->BillAddr->Line1
                        : null;

                    $customerCity = isset($customer->BillAddr->City)
                        ? $customer->BillAddr->City
                        : null;

                    $customerPostal = isset($customer->BillAddr->PostalCode)
                        ? $customer->BillAddr->PostalCode
                        : null;

                    $startDate = $this->parseDate(date('Y-m-d', strtotime(str_replace('/', '-', now()->format('d/m/Y')))));

                    // Create client in database
                    $client = \App\Models\Client::create([
                        'name' => $customer->DisplayName ?? $customer->CompanyName ?? 'Unknown',
                        'contact_email' => $customerEmail,
                        'contact_phone' => $customerPhone,
                        'address' => $customerAddress,
                        'city' => $customerCity,
                        'postal' => $customerPostal,
                        'description' => $customer->Notes ?? null,
                        'status' => '1', // Active
                        'quickbooks_customer_id' => $customer->Id,
                        'quickbooks_synced' => true,
                        'quickbooks_synced_at' => now(),
                        'service_frequency' => 'normalWeek',
                        'start_date' => $startDate,
                        'schedule' => 'unassigned',
                        'payment_type' => 'invoice',
                    ]);

                    $names = ['Exterior', 'Interior', 'Interior & Exterior'];

                    foreach ($names as $name) {
                        ClientPriceList::create([
                            'client_id'  => $client->id,
                            'name'       => $name,
                            'value'      => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    // Create profile if email or phone exists
                    if ($customerEmail || $customerPhone) {
                        \App\Models\Profile::create([
                            'client_id' => $client->id,
                            'additional_emails' => $customerEmail ? json_encode([$customerEmail]) : json_encode([]),
                            'additional_phones' => $customerPhone ? json_encode([$customerPhone]) : json_encode([]),
                            'invoice_email' => $customerEmail ? json_encode([$customerEmail]) : json_encode([]),
                            'address' => $customerAddress,
                            'city' => $customerCity,
                            'postal' => $customerPostal,
                        ]);
                    }

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to import customer {$qbCustomerId}: " . $e->getMessage();
                    Log::error("QuickBooks Import Error for customer {$qbCustomerId}: " . $e->getMessage());
                }
            }

            $message = "Successfully imported {$imported} customer(s).";
            if ($skipped > 0) {
                $message .= " Skipped {$skipped} already imported.";
            }
            if (!empty($errors)) {
                $message .= " " . count($errors) . " error(s) occurred.";
            }

            return redirect()->route('quickbooks.import')->with([
                'title' => 'Import Complete',
                'message' => $message,
                'type' => $imported > 0 ? 'success' : 'warning',
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            Log::error('QuickBooks Import Error: ' . $e->getMessage());

            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Import failed: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }


    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Try Y-m-d format first (HTML date input)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
            }
            // Try m/d/Y format
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)) {
                return Carbon::createFromFormat('m/d/Y', $date)->format('d/m/Y');
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    /**
     * Get authenticated DataService
     */
    private function getAuthenticatedDataService()
    {
        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'accessTokenKey' => env('QUICKBOOKS_ACCESS_TOKEN'),
            'refreshTokenKey' => env('QUICKBOOKS_REFRESH_TOKEN'),
            'QBORealmID' => env('QUICKBOOKS_COMPANY_ID'),
            'baseUrl' => env('QUICKBOOKS_ENVIRONMENT') === 'production'
                ? "https://quickbooks.api.intuit.com"
                : "https://sandbox-quickbooks.api.intuit.com"
        ]);

        return $dataService;
    }

    /**
     * Save tokens to database
     */
    private function saveTokensToDatabase($accessToken, $refreshToken, $realmId, $expiresIn)
    {
        try {
            // Deactivate all existing tokens
            QuickBooksToken::where('is_active', true)->update(['is_active' => false]);

            // Create new active token
            QuickBooksToken::create([
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'realm_id' => $realmId,
                'expires_at' => Carbon::now()->addSeconds($expiresIn),
                'is_active' => true
            ]);

            Log::info('QuickBooks tokens saved to database successfully', [
                'realm_id' => $realmId,
                'expires_at' => Carbon::now()->addSeconds($expiresIn)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save QuickBooks tokens to database: ' . $e->getMessage());
        }
    }

    /**
     * Save tokens to .env file
     */
    private function saveTokensToEnv($accessToken, $refreshToken, $companyId)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // Update or add tokens
        $updates = [
            'QUICKBOOKS_ACCESS_TOKEN' => $accessToken,
            'QUICKBOOKS_REFRESH_TOKEN' => $refreshToken,
            'QUICKBOOKS_COMPANY_ID' => $companyId
        ];

        foreach ($updates as $key => $value) {
            if (preg_match("/^{$key}=/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }
}
