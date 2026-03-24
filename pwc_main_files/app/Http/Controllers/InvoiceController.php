<?php

namespace App\Http\Controllers;

use App\Models\{ClientPayment, ClientSchedule, StaffRoute, User};
use App\Services\QuickBooksService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    protected $quickBooksService;

    public function __construct(QuickBooksService $quickBooksService)
    {
        $this->quickBooksService = $quickBooksService;
    }
    public function index()
    {
        $routes = StaffRoute::with('clientRoute.clientSchedule.clientSchedulePayment')->get();
        $staffRoutes = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
        })->with('staffRoute.clientRoute.clientSchedule.clientSchedulePayment')->get();

        $currentYear = now()->year;
        $currentMonth = now()->format('F');
        $nextMonth = now()->addMonth()->format('F');

        $selectedMonth = "$currentMonth - $nextMonth $currentYear";
        $today = now();

        preg_match('/\d{4}/', $selectedMonth, $yearMatch);
        $selectedYear = $currentYear ?? $yearMatch[0];

        $firstMondayOfYear = Carbon::parse("first Monday of January $selectedYear");

        $customStartDates = [
            "January - February" => $firstMondayOfYear->copy()->addDays(0),
            "February - March" => $firstMondayOfYear->copy()->addWeeks(4),
            "March" => $firstMondayOfYear->copy()->addWeeks(8),
            "March - April" => $firstMondayOfYear->copy()->addWeeks(12),
            "April - May" => $firstMondayOfYear->copy()->addWeeks(16),
            "May - June" => $firstMondayOfYear->copy()->addWeeks(20),
            "June - July" => $firstMondayOfYear->copy()->addWeeks(24),
            "July - August" => $firstMondayOfYear->copy()->addWeeks(28),
            "August - September" => $firstMondayOfYear->copy()->addWeeks(32),
            "September - October" => $firstMondayOfYear->copy()->addWeeks(36),
            "October - November" => $firstMondayOfYear->copy()->addWeeks(40),
            "November - December" => $firstMondayOfYear->copy()->addWeeks(44),
            "December - January" => $firstMondayOfYear->copy()->addWeeks(48),
        ];

        $labels = array_keys($customStartDates);
        $baseMonthName = $labels[0];
        foreach ($labels as $i => $label) {
            $start = $customStartDates[$label]->copy()->startOfDay();
            $end   = ($i < count($labels) - 1)
                ? $customStartDates[$labels[$i + 1]]->copy()->startOfDay()
                : $firstMondayOfYear->copy()->addYear()->startOfDay();

            if ($today->betweenIncluded($start, $end->copy()->subSecond())) {
                $baseMonthName = $label;
                break;
            }
        }

        $firstDayOfMonth = $customStartDates[$baseMonthName]->copy();

        $weeks = collect();

        for ($i = 0; $i < 4; $i++) {
            $endOfWeek = $firstDayOfMonth->copy()->addDays(6);

            $weeks->push([
                'week_number' => $i + 1,
                'start_date' => $firstDayOfMonth->format('d F Y'),
                'end_date' => $endOfWeek->format('d F Y'),
                'routes' => [],
            ]);

            $firstDayOfMonth->addDays(7);
        }

        $routeInvoices = $weeks->map(function ($week) use ($routes) {
            $weekStartDate = Carbon::parse($week['start_date']);
            $weekEndDate = Carbon::parse($week['end_date']);
            $totalWeekGross = 0;

            foreach ($routes as $index => $mainRoute) {
                $filteredRoutes = $mainRoute->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate, &$totalWeekGross) {
                    return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
                        $scheduleStartDate = Carbon::parse($clientSchedule->start_date);
                        $scheduleEndDate = Carbon::parse($clientSchedule->end_date);

                        return (
                            ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
                            ($scheduleEndDate->gte($weekStartDate) && $scheduleEndDate->lte($weekEndDate)) ||
                            ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate))
                        ) && $clientSchedule->status == 'completed'
                            && $clientSchedule->clientSchedulePayment
                            && $clientSchedule->clientSchedulePayment->payment_type == 'invoice';
                    })->map(function ($clientSchedule) use (&$totalWeekGross) {
                        $invoiceAmount = $clientSchedule->clientSchedulePayment->final_price ?? 0;
                        $totalWeekGross += $invoiceAmount;

                        return [
                            'client_start_week' => $clientSchedule->start_date,
                            'client_end_week' => $clientSchedule->end_date,
                            'client_id' => $clientSchedule->clientName->id,
                            'schedule_id' => $clientSchedule->id,
                            'clientSchedule' => $clientSchedule->status,
                            'created_at' => $clientSchedule->created_at,
                            'client_name' => $clientSchedule->clientName->name ?? null,
                            'client_job' => $clientSchedule->clientName->description ?? null,
                            'payment_type' => $clientSchedule->clientSchedulePayment->payment_type,
                            'invoice_amount' => $invoiceAmount,
                            'is_completed' => $clientSchedule->status,
                        ];
                    });
                });
                $week['routes'][$mainRoute->name] = $filteredRoutes;
                $week['routes'][$mainRoute->name]->id = $mainRoute->id;
            }

            $week['week_gross_total'] = $totalWeekGross;
            return $week;
        });

        return view('dashboard.admin.route-invoices', compact('routeInvoices'));
    }

    public function scheduleRouteInvoices(Request $request, $route_id)
    {
        $route = StaffRoute::with('clientRoute.clientSchedule.clientSchedulePayment')->findOrFail($route_id);

        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        if (!$start_date || !$end_date) {
            return redirect()->back()->with('error', 'Start date and end date are required');
        }

        $weekStartDate = Carbon::parse($start_date);
        $weekEndDate = Carbon::parse($end_date);

        $allPayments = $route->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate) {
            return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
                $scheduleStartDate = Carbon::parse($clientSchedule->start_date);
                $scheduleEndDate = Carbon::parse($clientSchedule->end_date);

                return (
                    ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
                    ($scheduleEndDate->gte($weekStartDate) && $scheduleEndDate->lte($weekEndDate)) ||
                    ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate))
                ) && $clientSchedule->status == 'completed'
                    && $clientSchedule->clientSchedulePayment
                    && $clientSchedule->clientSchedulePayment->payment_type == 'invoice';
            })->map(function ($clientSchedule) {
                $payment = $clientSchedule->clientSchedulePayment;
                return [
                    'client_id' => $clientSchedule->clientName->id,
                    'invoice_id' => $payment->id,
                    'status' => $payment->status ?? 'pending',
                    'client_name' => $clientSchedule->clientName->name ?? 'N/A',
                    'payment_amount' => $payment ? $payment->final_price : 0,
                    'start_date' => $clientSchedule->start_date,
                    'end_date' => $clientSchedule->end_date,
                    'service_date' => $payment->created_at->format('F d, Y')
                ];
            });
        });

        $totalInvoiceAmount = $allPayments->sum('payment_amount');

        return view('dashboard.admin.schedule-route-invoices', compact('allPayments', 'route', 'totalInvoiceAmount', 'start_date', 'end_date'));
    }

    public function clientInvoices(Request $request, $invoice_id)
    {

        $payment = ClientPayment::with([
            'clientSchedule.clientName.user',
            'clientSchedule.clientName.parentClient.user', // Load parent's user too
            'clientSchedule.clientSchedulePrice.clientPaymentPrice'
        ])->where('id', $invoice_id)
            ->where('payment_type', 'invoice')
            ->first();
        // return $payment;
        if (!$payment) {
            return redirect()->back()->with('error', 'Invoice not found');
        }

        $clientSchedule = $payment->clientSchedule;
        $client = $clientSchedule->clientName;

        // Check if client has valid invoice_email in profile
        $clientProfile = $client ? $client->profile : null;
        $clientInvoiceEmails = $clientProfile && !empty($clientProfile->invoice_email) ? $clientProfile->invoice_email : [];
        $clientHasEmail = !empty($clientInvoiceEmails);

        // Check if it's a branch (has parent_id)
        $isBranch = $client && $client->parent_id;
        $parentClient = $isBranch ? $client->parentClient : null;

        // Check if parent has valid invoice_email
        $parentProfile = $parentClient ? $parentClient->profile : null;
        $parentInvoiceEmails = $parentProfile && !empty($parentProfile->invoice_email) ? $parentProfile->invoice_email : [];
        $parentHasEmail = !empty($parentInvoiceEmails);

        // Can send invoice if client OR parent has valid invoice_email
        $canSendInvoice = $clientHasEmail || ($isBranch && $parentHasEmail);

        return view('dashboard.admin.invoice', compact(
            'payment',
            'clientSchedule',
            'client',
            'canSendInvoice',
            'isBranch',
            'parentClient',
            'clientHasEmail',
            'parentHasEmail'
        ));
    }

    public function createQuickBooksInvoice(Request $request)
    {
        try {
            $request->validate([
                'payment_id' => 'required|exists:client_payments,id',
            ]);

            $payment = ClientPayment::with([
                'clientSchedule.clientName.profile',
                'clientSchedule.clientSchedulePrice.clientPaymentPrice'
            ])->findOrFail($request->payment_id);

            // Check if already synced to QuickBooks
            if ($payment->quickbooks_synced) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice already created in QuickBooks',
                    'invoice_number' => $payment->quickbooks_invoice_number
                ], 400);
            }

            $clientSchedule = $payment->clientSchedule;
            $client = $clientSchedule->clientName ?? null;

            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client not found for this payment'
                ], 404);
            }

            // Check if client is synced to QuickBooks
            if (!$client->quickbooks_customer_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client is not synced to QuickBooks. Please sync the client first.'
                ], 400);
            }

            Log::info('Creating QuickBooks invoice for payment', [
                'payment_id' => $payment->id,
                'client_id' => $client->id,
                'client_name' => $client->name,
                'quickbooks_customer_id' => $client->quickbooks_customer_id,
                'amount' => $payment->final_price
            ]);

            // Prepare invoice data with merged line item
            $customerMemo = 'Thank you for your business!';
            $lineItems = [];

            // Get base prices and extra work prices using the same logic as calculateTotalSum
            $multiPrices = $this->getMultiPriceWithExtra($clientSchedule);

            // Merge all descriptions and sum all prices into single line item
            $descriptions = [];
            $totalAmount = 0;

            foreach ($multiPrices as $priceItem) {
                if (!empty($priceItem['name'])) {
                    $descriptions[] = $priceItem['name'];
                }
                $totalAmount += (float) ($priceItem['value'] ?? 0);
            }

            // Create single merged line item
            $mergedDescription = !empty($descriptions)
                ? 'Cleaning Service - ' . implode(', ', $descriptions)
                : 'Window Cleaning Service';

            $lineItems[] = [
                'description' => $mergedDescription,
                'quantity' => 1,
                'unit_price' => $totalAmount,
                'amount' => $totalAmount,
            ];

            // Build customer memo based on payment options
            if ($payment->option == 'completed') {
                $customerMemo = 'Service completed as scheduled. Thank you for your business!';
            } elseif ($payment->option == 'partially') {
                $customerMemo = 'Partially Completed Work';
                if ($payment->partial_completed_scope) {
                    $customerMemo .= ' - Scope: ' . $payment->partial_completed_scope;
                }
                if ($payment->reason) {
                    $customerMemo .= ' | Reason: ' . $payment->reason;
                }
            } elseif ($payment->option == 'omit') {
                $customerMemo = 'Service Omitted';
                if ($payment->reason) {
                    $customerMemo .= ' - Reason: ' . $payment->reason;
                }
            }

            // Add extra work info to memo if applicable
            if ($payment->option_two == 'extraWork' && $payment->scope) {
                $customerMemo .= ' | Extra Work: ' . $payment->scope;
            }

            // Add Log Time info to memo if available
            if ($payment->option_three == 'logTime' && ($payment->start_time || $payment->end_time)) {
                $customerMemo .= ' | Time Logged: ' . ($payment->start_time ?? 'N/A') . ' - ' . ($payment->end_time ?? 'N/A');
            }

            // Fallback: If no line items, use final_price
            if (empty($lineItems)) {
                $lineItems[] = [
                    'description' => 'Window Cleaning Service',
                    'quantity' => 1,
                    'unit_price' => (float) ($payment->final_price ?? 0),
                    'amount' => (float) ($payment->final_price ?? 0),
                ];
            }

            // Get customer email from profile
            $customerEmail = null;
            if ($client->profile) {
                $additionalEmails = $client->profile->additional_emails ?? [];
                if (is_array($additionalEmails) && !empty($additionalEmails)) {
                    $customerEmail = $additionalEmails[0]; // Use first email
                }
            }

            $invoiceData = [
                'customer_id' => $client->quickbooks_customer_id,
                'customer_name' => $client->name,
                'customer_email' => $customerEmail,
                'amount' => (float) ($payment->final_price ?? 0),
                'description' => 'Window Cleaning Service',
                'service_date' => $payment->service_date ?? $clientSchedule->start_date ?? date('Y-m-d'),
                'customer_memo' => $customerMemo,
                'line_items' => $lineItems,
            ];

            // Create invoice in QuickBooks
            $result = $this->quickBooksService->createInvoice($invoiceData);

            if ($result['success']) {
                // Update payment record with QuickBooks data
                $payment->update([
                    'quickbooks_invoice_id' => $result['invoice_id'],
                    'quickbooks_invoice_number' => $result['invoice_number'],
                    'quickbooks_synced' => true,
                    'quickbooks_synced_at' => now(),
                ]);

                Log::info('QuickBooks invoice created successfully', [
                    'payment_id' => $payment->id,
                    'invoice_id' => $result['invoice_id'],
                    'invoice_number' => $result['invoice_number'],
                    'email_sent' => $result['email_sent'] ?? false
                ]);

                // Build success message
                $message = 'Invoice created successfully in QuickBooks!';
                if ($result['email_sent'] ?? false) {
                    $message .= ' Email sent to customer (' . $client->email . ').';
                } else {
                    $message .= ' Note: Email could not be sent automatically.';
                    if ($result['email_error'] ?? null) {
                        $message .= ' Error: ' . $result['email_error'];
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'invoice_id' => $result['invoice_id'],
                    'invoice_number' => $result['invoice_number'],
                    'total_amount' => $result['total_amount'],
                    'email_sent' => $result['email_sent'] ?? false,
                    'customer_email' => $client->email
                ]);
            } else {
                Log::error('Failed to create QuickBooks invoice', [
                    'payment_id' => $payment->id,
                    'error' => $result['error']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create invoice in QuickBooks: ' . ($result['error'] ?? 'Unknown error')
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('QuickBooks invoice creation error', [
                'payment_id' => $request->payment_id ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get multi-price with extra work
     * Same logic as WebsiteController::getMultiPriceWithExtra
     */
    private function getMultiPriceWithExtra($clientSchedule)
    {
        $basePrices = [];

        // Check if current schedule has prices (Note 1)
        $currentPrices = $clientSchedule->clientSchedulePrice;

        if ($currentPrices && $currentPrices->count() > 0) {
            // Note 1: Use current schedule prices
            foreach ($currentPrices as $sp) {
                $basePrices[] = [
                    'name' => optional($sp->clientPaymentPrice)->name,
                    'value' => (float) optional($sp->clientPaymentPrice)->value
                ];
            }
        } else {
            // Note 2+: Get base prices from Note 1 (same week, same client)
            $note1Schedule = ClientSchedule::where('client_id', $clientSchedule->client_id)
                ->where('week', $clientSchedule->week)
                ->where('week_month', $clientSchedule->week_month)
                ->whereHas('clientSchedulePrice')
                ->with('clientSchedulePrice.clientPaymentPrice')
                ->first();

            if ($note1Schedule) {
                foreach ($note1Schedule->clientSchedulePrice as $sp) {
                    $basePrices[] = [
                        'name' => optional($sp->clientPaymentPrice)->name,
                        'value' => (float) optional($sp->clientPaymentPrice)->value
                    ];
                }
            }
        }

        // Extra work prices (always from current schedule)
        $extraPrices = [];
        if (!empty($clientSchedule->extra_work) && !empty($clientSchedule->extra_work_price)) {
            $names = json_decode($clientSchedule->extra_work, true);
            $values = json_decode($clientSchedule->extra_work_price, true);

            if (is_array($names) && is_array($values)) {
                foreach ($names as $index => $name) {
                    $extraPrices[] = [
                        'name' => $name,
                        'value' => (float) ($values[$index] ?? 0)
                    ];
                }
            }
        }

        return array_merge($basePrices, $extraPrices);
    }

    /**
     * Handle QuickBooks Webhook for Payment notifications
     * This is called by QuickBooks when a payment is received
     */
    public function handleQuickBooksWebhook(Request $request)
    {
        try {
            // Verify webhook signature (optional but recommended)
            $webhookToken = env('QUICKBOOKS_WEBHOOK_TOKEN');
            $signature = $request->header('intuit-signature');

            if ($webhookToken && $signature) {
                $payload = $request->getContent();
                $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $webhookToken, true));

                if ($signature !== $expectedSignature) {
                    Log::warning('QuickBooks webhook signature mismatch', [
                        'expected' => $expectedSignature,
                        'received' => $signature
                    ]);
                    return response()->json(['error' => 'Invalid signature'], 401);
                }
            }

            // Log the incoming webhook
            Log::info('QuickBooks Webhook Received', [
                'payload' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Get the webhook payload
            $payload = $request->all();

            // QuickBooks sends notifications in eventNotifications array
            if (!isset($payload['eventNotifications'])) {
                Log::warning('QuickBooks webhook missing eventNotifications');
                return response()->json(['success' => true], 200);
            }

            foreach ($payload['eventNotifications'] as $notification) {
                // Check if this is a Payment entity change
                if (isset($notification['dataChangeEvent']['entities'])) {
                    foreach ($notification['dataChangeEvent']['entities'] as $entity) {
                        // Process Payment entities
                        if ($entity['name'] === 'Payment' && $entity['operation'] === 'Create') {
                            $this->processPaymentNotification($entity['id']);
                        }
                    }
                }
            }

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('QuickBooks webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Always return 200 to QuickBooks to avoid retries
            return response()->json(['success' => true], 200);
        }
    }

    /**
     * Process payment notification from QuickBooks
     */
    private function processPaymentNotification($paymentId)
    {
        try {
            Log::info('Processing QuickBooks payment notification', [
                'payment_id' => $paymentId
            ]);

            // Get payment details from QuickBooks
            $paymentDetails = $this->quickBooksService->getPayment($paymentId);

            if (!$paymentDetails || !isset($paymentDetails['success']) || !$paymentDetails['success']) {
                Log::warning('Failed to get payment details from QuickBooks', [
                    'payment_id' => $paymentId
                ]);
                return;
            }

            $payment = $paymentDetails['payment'];

            // Get linked invoice IDs from the payment
            if (isset($payment->Line)) {
                foreach ($payment->Line as $line) {
                    if (isset($line->LinkedTxn)) {
                        foreach ($line->LinkedTxn as $linkedTxn) {
                            if ($linkedTxn->TxnType === 'Invoice') {
                                $invoiceId = $linkedTxn->TxnId;

                                // Find our local payment record by QuickBooks invoice ID
                                $clientPayment = ClientPayment::where('quickbooks_invoice_id', $invoiceId)->first();

                                if ($clientPayment) {
                                    // Update payment status
                                    $clientPayment->update([
                                        'status' => 'paid',
                                        'payment_date' => $payment->TxnDate ?? now(),
                                        'quickbooks_payment_id' => $paymentId,
                                        'payment_method' => $payment->PaymentMethodRef->name ?? null,
                                    ]);

                                    Log::info('Payment status updated successfully', [
                                        'client_payment_id' => $clientPayment->id,
                                        'quickbooks_invoice_id' => $invoiceId,
                                        'quickbooks_payment_id' => $paymentId,
                                        'status' => 'paid'
                                    ]);
                                } else {
                                    Log::warning('No local payment found for QuickBooks invoice', [
                                        'quickbooks_invoice_id' => $invoiceId
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error processing payment notification', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
