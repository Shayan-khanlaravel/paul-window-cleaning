@foreach ($data as $weekName => $weekRoutes)
    @php
        // 1. Setup Week Context - Extract only the week number from "Week 1 | 02 February - 08 February"
        preg_match('/Week\s+(\d+)/', $weekName, $weekMatches);
        $currentWeekNum = isset($weekMatches[1]) ? (int) $weekMatches[1] : 1;
        $dbWeekNum = $currentWeekNum - 1;
        $weekString = 'week' . $dbWeekNum;

        // 2. Extract Year and Month Name
        preg_match('/\d{4}/', $selectedMonth ?? '', $yearMatch);
        $selectedYear = $yearMatch[0] ?? now()->year;

        // Extract full month name (March - April, not just March)
        // Remove year from string to get complete month range
        $selectedMonthName = trim(str_replace($selectedYear, '', $selectedMonth ?? ''));
        // Result: "March - April" or "January - February"
    @endphp

    <tr style="background-color: #f8f9fa; font-weight: bold; border:1px solid black !important;">
        <td colspan="4">
            <h3 class="m-0">{{ $weekName }}</h3>
        </td>
        <td colspan="5" class="text-end" style="padding-right:20px">
            <button type="button" class="btn_global btn_dark_blue exportWeekBtn" data-week="{{ $weekName }}" data-week-num="{{ $currentWeekNum }}">
                Export Excel <i class="fa-solid fa-file-excel"></i>
            </button>
        </td>
    </tr>

    @if ($weekRoutes->isEmpty())
        <tr>
            <td colspan="9" class="text-center text-muted">No Schedule To This Week</td>
        </tr>
    @else
        @foreach ($weekRoutes as $routeId => $schedules)
            @php
                // --- ROUTE CALCULATIONS ---
                $routeName = $schedules->first()->clientName->clientRouteStaff->first()->route->name ?? 'N/A';
                $staffName = $schedules->first()->StaffName->first_name ?? 'N/A';

                // Total Sales
                $totalSales = $schedules->sum(fn($s) => $s->clientSchedulePayment->final_price ?? 0);

                // Cash Logic
                $cashSchedules = $schedules->filter(fn($s) => ($s->clientSchedulePayment->payment_type ?? '') == 'cash');
                $cashRecord = $cashSchedules->sum(fn($s) => $s->clientSchedulePayment->final_price ?? 0);

                // Deposits
                $matchingDeposits = $allDeposits->where('route_id', $routeId)->where('week', $weekString)->where('month', $selectedMonthName)->where('year', $selectedYear);
                $totalDeposited = $matchingDeposits->sum('deposit_amount');

                // Invoice Logic
                $invoiceSchedules = $schedules->filter(fn($s) => ($s->clientSchedulePayment->payment_type ?? '') == 'invoice');
                $invoicePaid = $invoiceSchedules->filter(fn($s) => ($s->clientSchedulePayment->payment_status ?? null) == 'paid')->sum(fn($s) => $s->clientSchedulePayment->final_price ?? 0);
                $invoiceUnpaid = $invoiceSchedules->filter(fn($s) => ($s->clientSchedulePayment->payment_status ?? null) === null)->sum(fn($s) => $s->clientSchedulePayment->final_price ?? 0);

                // Totals
                $billed = $totalDeposited + $invoicePaid;
                $unpaid = $cashRecord - $totalDeposited + $invoiceUnpaid;

                // Calculate HRs from client_payments start_time and end_time
                $totalHours = 0;
                foreach ($schedules as $schedule) {
                    $payment = $schedule->clientSchedulePayment;
                    if ($payment && $payment->start_time && $payment->end_time) {
                        $startTime = \Carbon\Carbon::parse($payment->start_time);
                        $endTime = \Carbon\Carbon::parse($payment->end_time);
                        $totalHours += $endTime->diffInMinutes($startTime) / 60;
                    }
                }
            @endphp

            <tr class="route-invoice">
                <td>{{ $routeName }}</td>
                <td>{{ $staffName }}</td>

                <td>
                    <div class="table_hover">
                        <h3>{{ number_format($totalSales, 2) }}</h3>
                        <div class="tooltip_hover" style="min-width: 350px;">
                            <ul>
                                @foreach ($schedules as $s)
                                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                                        <span style="flex: 1;">
                                            {{ $s->clientName->name ?? 'Client' }}<br>
                                            <small style="color: {{ ($s->clientSchedulePayment->payment_type ?? '') == 'cash' ? '#28a745' : '#007bff' }}; font-weight: 600; font-size: 11px;">
                                                {{ ucfirst($s->clientSchedulePayment->payment_type ?? 'N/A') }}
                                            </small>
                                        </span>
                                        <span style="font-weight: 600; margin-left: 15px;">
                                            ${{ number_format($s->clientSchedulePayment->final_price ?? 0, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                                <li style="border-top: 2px solid #ddd; margin-top: 8px; padding-top: 8px; display: flex; justify-content: space-between;">
                                    <strong>Total:</strong>
                                    <strong>${{ number_format($totalSales, 2) }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="table_hover">
                        <h3>{{ number_format($cashRecord, 2) }}</h3>
                        <div class="tooltip_hover">
                            <ul>
                                @forelse ($cashSchedules as $s)
                                    <li style="display: flex; justify-content: space-between;">
                                        <span>{{ $s->clientName->name ?? 'Client' }}</span>
                                        <span>${{ number_format($s->clientSchedulePayment->final_price ?? 0, 2) }}</span>
                                    </li>
                                @empty
                                    <li style="justify-content: center; color: #858585;">No Cash Records</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="table_hover">
                        <h3>{{ number_format($totalHours, 2) }}</h3>
                        @if ($schedules->filter(fn($s) => $s->clientSchedulePayment && $s->clientSchedulePayment->start_time && $s->clientSchedulePayment->end_time)->count() > 0)
                            <div class="tooltip_hover">
                                <ul class="m-0 p-0" style="list-style: none;">
                                    @foreach ($schedules as $schedule)
                                        @php
                                            $payment = $schedule->clientSchedulePayment;
                                            if ($payment && $payment->start_time && $payment->end_time) {
                                                $start = \Carbon\Carbon::parse($payment->start_time);
                                                $end = \Carbon\Carbon::parse($payment->end_time);
                                                $hours = $end->diffInMinutes($start) / 60;
                                            } else {
                                                $hours = 0;
                                            }
                                        @endphp
                                        @if ($hours > 0)
                                            <li style="display: flex; justify-content: space-between; padding: 4px 0;">
                                                <span>{{ $schedule->clientName->name ?? 'Client' }}:</span>
                                                <span>{{ number_format($hours, 2) }} hrs</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </td>

                {{-- Billed Column (Cash Received + Invoice Paid) --}}
                <td>
                    <div class="table_hover">
                        <h3 class="billed-amount">{{ number_format($billed, 2) }}</h3>
                        <div class="tooltip_hover">
                            <ul>
                                <li><strong>Cash Received:</strong> {{ number_format($totalDeposited, 2) }}</li>
                                <li><strong>Invoice Paid:</strong> {{ number_format($invoicePaid, 2) }}</li>
                                <li><strong>Total Billed:</strong> {{ number_format($billed, 2) }}</li>
                            </ul>
                        </div>
                    </div>
                </td>

                {{-- Unpaid Column with Tooltip --}}
                <td class="text-danger">
                    <div class="table_hover">
                        <h3 style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">{{ number_format($unpaid, 2) }}
                        </h3>
                        <div class="tooltip_hover">
                            <ul>
                                <li><strong>Cash Unpaid:</strong>
                                    <span>${{ number_format($cashRecord - $totalDeposited, 2) }}</span>
                                </li>
                                <li><strong>Invoice Unpaid:</strong>
                                    <span>${{ number_format($invoiceUnpaid, 2) }}</span>
                                </li>
                                <li style="border-top: 2px solid #dc3545; margin-top: 5px; padding-top: 8px;">
                                    <strong>Total Unpaid:</strong> <span style="color: #dc3545; font-weight: bold;">${{ number_format($unpaid, 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>

                {{-- Omit Column with Conditional Hover --}}
                <td>
                    @php
                        $omitCount = $schedules->filter(fn($s) => ($s->clientSchedulePayment->option ?? '') == 'omit')->count();
                    @endphp
                    @if ($omitCount > 0)
                        <div class="table_hover">
                            <h3>{{ $omitCount }}</h3>
                            <div class="tooltip_hover">
                                <ul>
                                    @foreach ($schedules->filter(fn($s) => ($s->clientSchedulePayment->option ?? '') == 'omit') as $s)
                                        <li style="display: flex; flex-direction: column; align-items: flex-start;">
                                            <span><strong>{{ $s->clientName->name ?? 'Client' }}</strong> <span style="float:right; font-weight:600;">${{ number_format($s->clientSchedulePayment->final_price ?? 0, 2) }}</span></span>
                                            <span style="color:#dc3545; font-size:12px;">Reason:
                                                {{ isset($s->clientSchedulePayment->reason) && $s->clientSchedulePayment->reason !== '' ? $s->clientSchedulePayment->reason : '-' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </td>

                {{-- Partial Column with Conditional Hover --}}
                <td>
                    @php
                        $partialCount = $schedules->filter(fn($s) => ($s->clientSchedulePayment->option ?? '') == 'partially')->count();
                    @endphp
                    @if ($partialCount > 0)
                        <div class="table_hover">
                            <h3>{{ $partialCount }}</h3>
                            <div class="tooltip_hover">
                                <ul>
                                    @foreach ($schedules->filter(fn($s) => ($s->clientSchedulePayment->option ?? '') == 'partially') as $s)
                                        <li style="display: flex; flex-direction: column; align-items: flex-start;">
                                            <span><strong>{{ $s->clientName->name ?? 'Client' }}</strong> <span style="float:right; font-weight:600;">${{ number_format($s->clientSchedulePayment->final_price ?? 0, 2) }}</span></span>
                                            <span style="color:#dc3545; font-size:12px;">Reason:
                                                {{ isset($s->clientSchedulePayment->reason) && $s->clientSchedulePayment->reason !== '' ? $s->clientSchedulePayment->reason : '-' }}</span>
                                            <span style="color:#007bff; font-size:12px;">Partial Scope:
                                                {{ isset($s->clientSchedulePayment->partial_completed_scope) && $s->clientSchedulePayment->partial_completed_scope !== '' ? $s->clientSchedulePayment->partial_completed_scope : '-' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
@endforeach
