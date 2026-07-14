@if (auth()->user()->hasRole('staff'))
    <div class="extra_hours_btn_wrapper" style="margin: 10px 0px;">
        <button type="button" style=" background: #32346A"
            class="btn_global extra-hours-btn w-100"
            data-bs-toggle="modal"
            data-bs-target="#extraHoursModal"
            data-route-id="{{ $staffRoute->id }}"
            data-week-number="{{ $schedule['week_number'] }}"
            data-week-start="{{ \Carbon\Carbon::parse($schedule['start_date'])->format('Y-m-d') }}"
            data-week-end="{{ \Carbon\Carbon::parse($schedule['end_date'])->format('Y-m-d') }}"
            data-week-label="Week {{ $schedule['week_number'] }} ({{ \Carbon\Carbon::parse($schedule['start_date'])->format('d M') }} - {{ \Carbon\Carbon::parse($schedule['end_date'])->format('d M') }})">
            Log Hours <i class="fa-solid fa-clock"></i>
        </button>
    </div>
@endif
