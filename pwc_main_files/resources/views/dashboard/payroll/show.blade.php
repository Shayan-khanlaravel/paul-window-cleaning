@extends('theme.layout.master')

@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{ route('payroll.index') }}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Payroll For {{ $staff->name }}</h2>
    </div>
@endsection

@section('content')
<section class="create_clients_sec">
    <div class="container-fluid custom_container">

        <div class="row mb-4 custom_justify_between align-items-center">
            <div class="col-md-12">
                <div class="months-pagination filter_download_dropdown_wrapper" style="display: flex; align-items: center; gap: 10px;">
                    <a href="{{ request()->fullUrlWithQuery(['period' => $previousPeriod]) }}" type="button" class="btn btn-sm btn-outline-secondary prevMonthBtn">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <div class="dropdown dropdown_months_wrapper">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-calendar"></i>
                            <span class="selected_month_text">{{ $selectedPeriodLabel }}</span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($periods as $period)
                                <li>
                                    <a class="dropdown-item {{ $period['value'] === $selectedPeriod ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['period' => $period['value']]) }}">
                                        {{ $period['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ request()->fullUrlWithQuery(['period' => $nextPeriod]) }}" class="btn btn-sm btn-outline-secondary nextMonthBtn" type="button">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="shadow_box_wrapper p-4">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4 myTable">
                            <thead>
                                <tr class="fw-bold">
                                    <th class="ps-4 min-w-150px rounded-start">Route</th>
                                    <th class="min-w-150px">Period</th>
                                    <th class="min-w-100px text-end">Gross Sales</th>
                                    <th class="min-w-100px text-end">Gross Commission</th>
                                    <th class="min-w-150px text-end">Bonus</th>
                                    <th class="min-w-100px text-end rounded-end">Total Gross Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($routePayrollData as $routeData)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-dark fw-bold d-block fs-6">{{ $routeData['route_name'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">
                                            {{ $routeData['start']->format('M d') }} - {{ $routeData['end']->format('M d') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">${{ number_format($routeData['gross_sales'], 2) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">${{ number_format($routeData['commission'], 2) }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if(auth()->user()->hasRole('admin'))
                                        <form action="{{ route('payroll.bonus.save', $staff->id) }}" method="POST" class="d-flex align-items-center justify-content-end">
                                            @csrf
                                            <input type="hidden" name="route_id" value="{{ $routeData['route_id'] }}">
                                            <input type="hidden" name="half" value="{{ $half }}">
                                            <input type="hidden" name="month" value="{{ $monthName }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <div class="input-group input-group-sm" style="width: 130px;">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" name="amount" class="form-control text-end" value="{{ $routeData['bonus'] }}">
                                                <button type="submit" class="btn btn-sm btn-success px-2" title="Save Bonus"><i class="fa-solid fa-check text-white m-0"></i></button>
                                            </div>
                                        </form>
                                        @else
                                        <span class="text-muted fw-semibold d-block fs-7">${{ number_format($routeData['bonus'], 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-dark fw-bold d-block fs-7">${{ number_format($routeData['total_gross_pay'], 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-muted py-4">No route-based payroll records found for this period.</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
