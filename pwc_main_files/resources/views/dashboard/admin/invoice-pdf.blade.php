<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - Pauls Window Cleaning</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 3px solid #00ADEE;
            padding-bottom: 15px;
        }

        .logo-cell {
            width: 150px;
        }

        .title-cell {
            text-align: center;
        }

        .title-cell h1 {
            margin: 0;
            font-size: 32px;
            color: #00ADEE;
        }

        .title-cell p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .two-col-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .two-col-table td {
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }

        .section-box {
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .section-title {
            background: #f5f5f5;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #ddd;
        }

        .section-title-green {
            background: #d4edda;
            color: #155724;
        }

        .section-title-red {
            background: #f8d7da;
            color: #721c24;
        }

        .section-title-yellow {
            background: #fff3cd;
            color: #856404;
        }

        .section-title-blue {
            background: #cce5ff;
            color: #004085;
        }

        .section-title-gray {
            background: #e2e3e5;
            color: #383d41;
        }

        .section-content {
            padding: 15px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #666;
            width: 120px;
        }

        .value {
            color: #333;
        }

        .badge {
            padding: 3px 10px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }

        .badge-invoice {
            background: #17a2b8;
        }

        .badge-unpaid {
            background: #dc3545;
        }

        .badge-paid {
            background: #28a745;
        }

        .badge-pending {
            background: #ffc107;
            color: #000;
        }

        .amount-box {
            background: #e8f4fc;
            border: 2px solid #00ADEE;
            padding: 15px;
            text-align: center;
            margin-top: 10px;
        }

        .amount-label {
            font-size: 11px;
            color: #666;
        }

        .amount-value {
            font-size: 28px;
            font-weight: bold;
            color: #00ADEE;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #00ADEE;
            color: #888;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <!-- HEADER with Logo -->
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="title-cell">
                <h1>INVOICE</h1>
            </td>
        </tr>
    </table>

    <!-- CLIENT INFO + PAYMENT INFO (Two Columns) -->
    <table class="two-col-table" cellpadding="0" cellspacing="0">
        <tr>
            <!-- Client Information -->
            <td>
                <div class="section-box">
                    <div class="section-title">Client Information</div>
                    <div class="section-content">
                        <table class="info-table" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="label">Name:</td>
                                <td class="value">{{ $clientName ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Email:</td>
                                <td class="value">{{ $clientEmail ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Phone:</td>
                                <td class="value">{{ $clientPhone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Address:</td>
                                <td class="value">{{ $clientAddress ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <!-- Payment Information -->
            <td>
                <div class="section-box">
                    <div class="section-title">Payment Information</div>
                    <div class="section-content">
                        <table class="info-table" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="label">Type:</td>
                                <td class="value"><span class="badge badge-invoice">Invoice</span></td>
                            </tr>
                            <tr>
                                <td class="label">Status:</td>
                                <td class="value"><span
                                        class="badge {{ $paymentStatus == 'Paid' ? 'badge-paid' : 'badge-unpaid' }}">{{ $paymentStatus ?? 'Unpaid' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Service Date:</td>
                                <td class="value">{{ $serviceDate ?? 'N/A' }}</td>
                            </tr>
                        </table>
                        <div class="amount-box">
                            <div class="amount-label">Total Amount</div>
                            <div class="amount-value">${{ number_format($amount ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- SCHEDULE INFORMATION -->
    <div class="section-box">
        <div class="section-title">Schedule Information</div>
        <div class="section-content">
            <table class="info-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="label">Scope:</td>
                    <td class="value">{{ $scheduleScope ?? 'N/A' }}</td>
                    <td class="label" style="padding-left: 20px;">Best Time:</td>
                    <td class="value">{{ $scheduleBestTime ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Note:</td>
                    <td class="value">{{ $scheduleNote ?? 'N/A' }}</td>
                    <td class="label" style="padding-left: 20px;">Status:</td>
                    <td class="value"><span
                            class="badge {{ $scheduleStatus == 'Completed' ? 'badge-paid' : 'badge-pending' }}">{{ $scheduleStatus ?? 'Pending' }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if (isset($paymentDetails) && count($paymentDetails) > 0)
        <!-- PAYMENT DETAILS -->
        <div class="section-box">
            <div class="section-title">Payment Details</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    @foreach ($paymentDetails as $detail)
                        <tr>
                            <td class="label">{{ $detail['scope'] ?? 'Service' }}:</td>
                            <td class="value" style="font-weight: bold; color: #28a745;">
                                ${{ number_format($detail['price'] ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif


    <!-- EXTRA WORK COMPLETED -->
    @if (isset($payment) && $payment->option_two == 'extraWork' && ($payment->scope || $payment->price_charge_two))
        <div class="section-box">
            <div class="section-title section-title-green">Extra Work Completed</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    @if ($payment->scope)
                        <tr>
                            <td class="label">Scope:</td>
                            <td class="value">{{ $payment->scope }}</td>
                        </tr>
                    @endif
                    @if ($payment->price_charge_two)
                        <tr>
                            <td class="label">Price:</td>
                            <td class="value" style="color: #28a745; font-weight: bold;">
                                ${{ number_format($payment->price_charge_two, 2) }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    @endif

    <!-- LOG TIME -->
    @if (isset($payment) && $payment->option_three == 'logTime')
        <div class="section-box">
            <div class="section-title section-title-green">Log Time</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    <tr>
                        @if ($payment->start_time)
                            <td class="label">Start Time:</td>
                            <td class="value">{{ $payment->start_time }}</td>
                        @endif
                        @if ($payment->end_time)
                            <td class="label" style="padding-left: 20px;">End Time:</td>
                            <td class="value" style="color: #28a745;">{{ $payment->end_time }}</td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <!-- OMITTED SERVICE -->
    @if (isset($payment) && $payment->option == 'omit' && $payment->reason)
        <div class="section-box">
            <div class="section-title section-title-yellow">Omitted Service</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="label">Reason:</td>
                        <td class="value">{{ $payment->reason }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <!-- PAYMENT NOT RECEIVED -->
    @if (isset($payment) && $payment->option == 'no_payment' && $payment->reason)
        <div class="section-box">
            <div class="section-title section-title-red">Payment Not Received</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="label">Reason:</td>
                        <td class="value">{{ $payment->reason }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <!-- EXTRA PAYMENT FOR DATES -->
    @if (isset($payment) && $payment->option_three == 'extra_paid_for_date' && ($payment->day_number || $payment->amount))
        <div class="section-box">
            <div class="section-title section-title-blue">Extra Payment for Dates</div>
            <div class="section-content">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    <tr>
                        @if ($payment->day_number)
                            <td class="label">Days:</td>
                            <td class="value">{{ $payment->day_number }} days</td>
                        @endif
                        @if ($payment->amount)
                            <td class="label" style="padding-left: 20px;">Extra Amount:</td>
                            <td class="value" style="color: #28a745; font-weight: bold;">
                                ${{ number_format($payment->amount, 2) }}</td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <!-- PRIOR DATE PAYMENT -->
    @if (isset($payment) && $payment->option_two == 'paid_on_prior')
        <div class="section-box">
            <div class="section-title section-title-gray">Prior Date Payment</div>
            <div class="section-content">
                <span class="badge" style="background: #6c757d;">Paid on prior date of service</span>
            </div>
        </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <p>Pauls Window Cleaning &copy; {{ date('Y') }}</p>
        <p>Thank you for your business!</p>
    </div>

</body>

</html>
