@if (auth()->user()->hasRole('staff'))
    @php
        $logHoursWeekStart = \Carbon\Carbon::parse($schedule['start_date'])->format('Y-m-d');
        $logHoursTotal = \App\Models\StaffLogHour::where('staff_id', auth()->id())
            ->where('route_id', $staffRoute->id)
            ->whereDate('week_start_date', $logHoursWeekStart)
            ->sum('duration_hours');
    @endphp
    <div class="log_hours_btn_wrapper" style="margin: 10px 0px;">
        <button type="button" style=" background: #32346A"
            class="btn_global log-hours-btn w-100"
            data-bs-toggle="modal"
            data-bs-target="#logHoursModal"
            data-route-id="{{ $staffRoute->id }}"
            data-week-number="{{ $schedule['week_number'] }}"
            data-week-start="{{ $logHoursWeekStart }}"
            data-week-end="{{ \Carbon\Carbon::parse($schedule['end_date'])->format('Y-m-d') }}"
            data-week-label="Week {{ $schedule['week_number'] }} ({{ \Carbon\Carbon::parse($schedule['start_date'])->format('d M') }} - {{ \Carbon\Carbon::parse($schedule['end_date'])->format('d M') }})">
            Log Hours (<span class="log-hours-btn-total" data-route-id="{{ $staffRoute->id }}" data-week-start="{{ $logHoursWeekStart }}">{{ number_format($logHoursTotal, 2) }}</span> hrs) <i class="fa-solid fa-clock"></i>
        </button>
    </div>
@endif
