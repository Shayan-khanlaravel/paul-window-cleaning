@extends('theme.layout.master')

@push('css')
<style>
    .months-pagination {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .months-pagination .pag-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 50px;
        color: #32346A;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .months-pagination .pag-btn:hover {
        background: rgba(0, 173, 238, 0.05);
        color: #00ADEE;
        border-color: rgba(0, 173, 238, 0.05);
    }

    .dropdown_months_wrapper .btn {
        padding: 10px 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        color: #32346A;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .dropdown_months_wrapper .btn:hover {
        border-color: #00ADEE;
        background: rgba(0, 173, 238, 0.05);
    }

    .dropdown_months_wrapper .btn i {
        color: #00ADEE;
    }
</style>
@endpush

@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Unpaid Accounts Report</h2>
    </div>
@endsection

@section('content')
<section class="create_clients_sec">
    <div class="container-fluid custom_container">

        <div class="row mb-5">
            <div class="col-md-12">
                <div class="months-pagination filter_download_dropdown_wrapper" style="display: flex; align-items: center; gap: 10px;">
                    <a href="{{ request()->fullUrlWithQuery(['month' => $previousMonth]) }}" class="btn btn-sm btn-outline-secondary prevMonthBtn">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <div class="dropdown dropdown_months_wrapper">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-calendar"></i>
                            <span class="selected_month_text">{{ $selectedMonth }}</span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($months as $month)
                                <li>
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['month' => $month]) }}">
                                        {{ $month }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ request()->fullUrlWithQuery(['month' => $nextMonth]) }}" class="btn btn-sm btn-outline-secondary nextMonthBtn">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @forelse($groupedData as $staffName => $schedules)
                    <div class="card card-flush shadow-sm mb-5">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">{{ $staffName }}</span>
                                <span class="text-muted mt-1 fw-bold fs-7">{{ $schedules->count() }} Unpaid Schedules</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="min-w-150px">Client</th>
                                            <th class="min-w-100px text-end">Amount</th>
                                            <th class="min-w-150px">Schedule Date</th>
                                            <th class="min-w-150px">Date Serviced</th>
                                            <th class="min-w-150px">Route</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedules as $schedule)
                                        <tr>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $schedule->clientName->name ?? 'N/A' }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-dark fw-bold d-block fs-6">${{ number_format(optional($schedule->clientSchedulePayment)->final_price ?? 0, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ \Carbon\Carbon::parse($schedule->start_date)->format('m/d/y') }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $schedule->service_date }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $schedule->route_name }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="bg-light">
                                            <td class="fw-bolder">Total</td>
                                            <td class="text-end fw-bolder fs-5 text-danger">
                                                ${{ number_format($schedules->sum(fn($s) => optional($s->clientSchedulePayment)->final_price ?? 0), 2) }}
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card card-flush shadow-sm">
                        <div class="card-body text-center p-15">
                            <i class="fa-solid fa-check-circle fa-4x text-success mb-4"></i>
                            <h3 class="fs-4 fw-bolder text-dark">No unpaid accounts found.</h3>
                            <p class="text-muted fs-6">All schedules for the selected period are fully paid!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
