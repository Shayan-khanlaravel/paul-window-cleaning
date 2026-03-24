@extends('theme.layout.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Complete Jobs</h2>
    </div>
    <div class="txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection

@section('content')
    <section class="client_management staff_manag complete_jobs_section">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <!-- Tabs -->
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-cash-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-cash" type="button" role="tab" aria-controls="pills-cash"
                                        aria-selected="true">Cash</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-invoice-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-invoice" type="button" role="tab"
                                        aria-controls="pills-invoice" aria-selected="false">Invoice</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Cash Tab -->
                            <div class="tab-pane fade show active" id="pills-cash" role="tabpanel"
                                 aria-labelledby="pills-cash-tab" tabindex="0">

                                <!-- Filters -->
                                <div class="row row_gap">
                                    <div class="col-md-4">
                                        <div class="txt_field">
                                            <label for="cash_filter_date">Filter by Date</label>
                                            <input class="form-control" type="date" id="cash_filter_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="txt_field custom_select_route">
                                            <label for="cash_filter_route">Filter by Route</label>
                                            <select class="form-select selectRoute" id="cash_filter_route">
                                                <option value="">All Routes</option>
                                                @foreach ($routes ?? [] as $route)
                                                    <option value="{{ $route->id }}">{{ $route->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="txt_field">
                                            <label for="cash_filter_week">Filter by Week</label>
                                            <select class="form-select" id="cash_filter_week">
                                                <option value="">All Weeks</option>
                                                <option value="week0">Week 1</option>
                                                <option value="week1">Week 2</option>
                                                <option value="week2">Week 3</option>
                                                <option value="week3">Week 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_table">
                                            <div class="table-responsive">
                                                <table id="cash_jobs_table" class="table cash_jobs_table datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Client Name</th>
                                                        <th>Amount</th>
                                                        <th>Service Date</th>
                                                        <th>Route</th>
                                                        <th>Week</th>
                                                        <th>Staff Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse ($completeJobs->filter(function($job) { return $job->clientSchedulePayment && $job->clientSchedulePayment->payment_type == 'cash'; }) as $job)
                                                        <tr data-route-id="{{ $job->clientName->clientRouteStaff->first()->route_id ?? '' }}"
                                                            data-week="{{ $job->week }}"
                                                            data-date="{{ $job->service_date }}">
                                                            <td>{{ $job->clientName->name ?? 'N/A' }}</td>
                                                            <td>${{ $job->clientSchedulePayment->final_price ?? 'N/A' }}</td>
                                                            <td>
                                                                {{ $job->service_date ? \Carbon\Carbon::parse($job->service_date)->format('m-d-Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->clientName->clientRouteStaff->first()->route->name ?? 'N/A' }}
                                                            </td>
                                                            <td>Week {{ (int) str_replace('week', '', $job->week) + 1 }}</td>
                                                            <td>
                                                                @if ($job->staff_id)
                                                                    {{ \App\Models\User::find($job->staff_id)->name ?? 'N/A' }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>
                                                            <span class="badge bg-success">
                                                                {{ ucfirst($job->status) }}
                                                            </span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="dropdown-toggle"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
{{--                                                                        <li>--}}
{{--                                                                            <a class="dropdown-item"--}}
{{--                                                                               href="{{ route('clients.show', $job->client_id) }}">--}}
{{--                                                                                <i class="fa-solid fa-user me-2"></i>View Client--}}
{{--                                                                            </a>--}}
{{--                                                                        </li>--}}
                                                                        <li>
                                                                            <a class="dropdown-item view-report-btn"
                                                                               href="javascript:void(0)"
                                                                               data-job-id="{{ $job->id }}"
                                                                               data-payment-type="cash"
                                                                               data-client-name="{{ $job->clientName->name ?? 'N/A' }}"
                                                                               data-service-date="{{ $job->service_date }}"
                                                                               data-option="{{ $job->clientSchedulePayment->option ?? '' }}"
                                                                               data-option-two="{{ $job->clientSchedulePayment->option_two ?? '' }}"
                                                                               data-option-three="{{ $job->clientSchedulePayment->option_three ?? '' }}"
                                                                               data-option-four="{{ $job->clientSchedulePayment->option_four ?? '' }}"
                                                                               data-reason="{{ $job->clientSchedulePayment->reason ?? '' }}"
                                                                               data-scope="{{ $job->clientSchedulePayment->scope ?? '' }}"
                                                                               data-partial-scope="{{ $job->clientSchedulePayment->partial_completed_scope ?? '' }}"
                                                                               data-price-one="{{ $job->clientSchedulePayment->price_charge_one ?? '' }}"
                                                                               data-price-two="{{ $job->clientSchedulePayment->price_charge_two ?? '' }}"
                                                                               data-amount="{{ $job->clientSchedulePayment->amount ?? '' }}"
                                                                               data-final-price="{{ $job->clientSchedulePayment->final_price ?? '' }}">
                                                                                <i class="fa-solid fa-file-lines me-2"></i>View
                                                                                Report
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Tab -->
                            <div class="tab-pane fade" id="pills-invoice" role="tabpanel"
                                 aria-labelledby="pills-invoice-tab" tabindex="0">

                                <!-- Filters -->
                                <div class="row row_gap">
                                    <div class="col-md-4">
                                        <div class="txt_field">
                                            <label for="invoice_filter_date">Filter by Date</label>
                                            <input class="form-control" type="date" id="invoice_filter_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="txt_field custom_select_route">
                                            <label for="invoice_filter_route">Filter by Route</label>
                                            <select class="form-select selectRoute" id="invoice_filter_route">
                                                <option value="">All Routes</option>
                                                @foreach ($routes ?? [] as $route)
                                                    <option value="{{ $route->id }}">{{ $route->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="txt_field">
                                            <label for="invoice_filter_week">Filter by Week</label>
                                            <select class="form-select" id="invoice_filter_week">
                                                <option value="">All Weeks</option>
                                                <option value="week0">Week 1</option>
                                                <option value="week1">Week 2</option>
                                                <option value="week2">Week 3</option>
                                                <option value="week3">Week 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_table">
                                            <div class="table-responsive">
                                                <table id="invoice_jobs_table" class="table invoice_jobs_table datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Client Name</th>
                                                        <th>Amount</th>
                                                        <th>Service Date</th>
                                                        <th>Route</th>
                                                        <th>Week</th>
                                                        <th>Staff Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse ($completeJobs->filter(function($job) { return $job->clientSchedulePayment && $job->clientSchedulePayment->payment_type == 'invoice'; }) as $job)
                                                        <tr data-route-id="{{ $job->clientName->clientRouteStaff->first()->route_id ?? '' }}"
                                                            data-week="{{ $job->week }}"
                                                            data-date="{{ $job->service_date }}">
                                                            <td>{{ $job->clientName->name ?? 'N/A' }}</td>
                                                            <td>${{ $job->clientSchedulePayment->final_price ?? 'N/A' }}</td>
                                                            <td>
                                                                {{ $job->service_date ? \Carbon\Carbon::parse($job->service_date)->format('m-d-Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->clientName->clientRouteStaff->first()->route->name ?? 'N/A' }}
                                                            </td>
                                                            <td>Week {{ (int) str_replace('week', '', $job->week) + 1 }}</td>
                                                            <td>
                                                                @if ($job->staff_id)
                                                                    {{ \App\Models\User::find($job->staff_id)->name ?? 'N/A' }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>
                                                            <span class="badge bg-success">
                                                                {{ ucfirst($job->status) }}
                                                            </span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="dropdown-toggle"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                               href="{{ route('clients.show', $job->client_id) }}">
                                                                                <i class="fa-solid fa-user me-2"></i>View
                                                                                Client
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item view-report-btn"
                                                                               href="javascript:void(0)"
                                                                               data-job-id="{{ $job->id }}"
                                                                               data-payment-type="invoice"
                                                                               data-client-name="{{ $job->clientName->name ?? 'N/A' }}"
                                                                               data-service-date="{{ $job->service_date }}"
                                                                               data-option="{{ $job->clientSchedulePayment->option ?? '' }}"
                                                                               data-option-two="{{ $job->clientSchedulePayment->option_two ?? '' }}"
                                                                               data-option-three="{{ $job->clientSchedulePayment->option_three ?? '' }}"
                                                                               data-option-four="{{ $job->clientSchedulePayment->option_four ?? '' }}"
                                                                               data-reason="{{ $job->clientSchedulePayment->reason ?? '' }}"
                                                                               data-scope="{{ $job->clientSchedulePayment->scope ?? '' }}"
                                                                               data-partial-scope="{{ $job->clientSchedulePayment->partial_completed_scope ?? '' }}"
                                                                               data-price-one="{{ $job->clientSchedulePayment->price_charge_one ?? '' }}"
                                                                               data-price-two="{{ $job->clientSchedulePayment->price_charge_two ?? '' }}"
                                                                               data-amount="{{ $job->clientSchedulePayment->amount ?? '' }}"
                                                                               data-start-time="{{ $job->clientSchedulePayment->start_time ?? '' }}"
                                                                               data-end-time="{{ $job->clientSchedulePayment->end_time ?? '' }}"
                                                                               data-final-price="{{ $job->clientSchedulePayment->final_price ?? '' }}">
                                                                                <i class="fa-solid fa-file-lines me-2"></i>View
                                                                                Report
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- View Report Modal - CASH -->
    <div class="modal fade" id="viewReportModalCash" tabindex="-1" aria-labelledby="viewReportModalCashLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportModalCashLabel">Job Completion Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="create_clients_wrapper_staff shadow_box_wrapper">
                        <div class="custom_justify_between">
                            <div class="custom_radio_mullerHonda">
                                <label class="form-check-label" id="modal_cash_client_name">Client Name</label>
                                <span>(Cash)</span>
                            </div>
                            <h3 class="pricePlus" id="modal_cash_final_price">$0.00</h3>
                        </div>

                        <!-- Service Date -->
                        <div class="row custom_row mt-3">
                            <div class="col-md-6">
                                <div class="txt_field">
                                    <label for="modal_cash_service_date">Service Date</label>
                                    <input class="form-control" type="text" id="modal_cash_service_date" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="custom_partially_changed">
                            <div class="row custom_row">
                                <!-- Completed no Change -->
                                <div class="col-md-12 custom_no_change">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_completed"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_completed">Completed no
                                            Change</label>
                                    </div>
                                </div>

                                <!-- Completed but did not receive payment -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_noPayment"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_noPayment">Completed but did not
                                            receive payment</label>
                                    </div>
                                    <div class="row reason_input_fileds_wrapper" id="modal_cash_noPayment_reason"
                                         style="display: none;">
                                        <div class="col-md-12">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_cash_reason_noPayment" placeholder="Reason" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Partially Completed -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_partially"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_partially">Partially
                                            Completed</label>
                                    </div>
                                    <div class="row reason_input_fileds_wrapper" id="modal_cash_partially_fields"
                                         style="display: none;">
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_cash_reason_partially" placeholder="Reason" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_cash_scope_partially" placeholder="Scope Of Work Completed"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_cash_price_charged_one" placeholder="Price Charged"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paid on prior date of service -->
                                <div class="col-md-12">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_option_two"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_option_two">Paid on prior date of
                                            service</label>
                                    </div>
                                </div>

                                <!-- Paid extra for dates -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_option_three"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_option_three">Paid extra for
                                            dates</label>
                                    </div>
                                </div>

                                <!-- Extra Work Completed -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_option_four"
                                               disabled>
                                        <label class="form-check-label" for="modal_cash_option_four">Extra Work
                                            Completed</label>
                                    </div>
                                </div>

                                <!-- Omit -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_cash_omit" disabled>
                                        <label class="form-check-label" for="modal_cash_omit">Omit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Report Modal - INVOICE -->
    <div class="modal fade" id="viewReportModalInvoice" tabindex="-1" aria-labelledby="viewReportModalInvoiceLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportModalInvoiceLabel">Job Completion Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="create_clients_wrapper_staff shadow_box_wrapper">
                        <div class="custom_justify_between">
                            <div class="custom_radio_mullerHonda">
                                <label class="form-check-label" id="modal_invoice_client_name">Client Name</label>
                                <span>(Invoice)</span>
                            </div>
                            <h3 class="pricePlus" id="modal_invoice_final_price">$0.00</h3>
                        </div>

                        <!-- Service Date -->
                        <div class="row custom_row mt-3">
                            <div class="col-md-6">
                                <div class="txt_field">
                                    <label for="modal_invoice_service_date">Service Date</label>
                                    <input class="form-control" type="text" id="modal_invoice_service_date" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="custom_partially_changed">
                            <div class="row custom_row">
                                <!-- Completed no Change -->
                                <div class="col-md-12 custom_no_change">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_invoice_completed"
                                               disabled>
                                        <label class="form-check-label" for="modal_invoice_completed">Completed no
                                            Change</label>
                                    </div>
                                </div>

                                <!-- Partially Completed -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_invoice_partially"
                                               disabled>
                                        <label class="form-check-label" for="modal_invoice_partially">Partially
                                            Completed</label>
                                    </div>
                                    <div class="row reason_input_fileds_wrapper" id="modal_invoice_partially_fields"
                                         style="display: none;">
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_invoice_reason_partially" placeholder="Reason" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_invoice_scope_partially"
                                                       placeholder="Scope Of Work Completed" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_invoice_price_charged_one" placeholder="Price Charged"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Extra Work Completed (option_two for invoice) -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_invoice_option_two"
                                               disabled>
                                        <label class="form-check-label" for="modal_invoice_option_two">Extra Work
                                            Completed</label>
                                    </div>
                                    <div class="row reason_input_fileds_wrapper" id="modal_invoice_extra_work_fields"
                                         style="display: none;">
                                        <div class="col-md-6">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_invoice_scope_extra_work"
                                                       placeholder="Scope Of Additional Work Completed" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field">
                                                <input class="form-control" type="text"
                                                       id="modal_invoice_price_charged_two" placeholder="Price Charged"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Log time (option_three for invoice) -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_invoice_option_three"
                                               disabled>
                                        <label class="form-check-label" for="modal_invoice_option_three">Log time</label>
                                    </div>
                                    <div class="row reason_input_fileds_wrapper" id="modal_invoice_log_time_fields"
                                         style="display: none;">
                                        <div class="col-md-6">
                                            <div class="txt_field">
                                                <label>Start Time</label>
                                                <input class="form-control" type="time" id="modal_invoice_start_time"
                                                       placeholder="Start Time" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field">
                                                <label>End Time</label>
                                                <input class="form-control" type="time" id="modal_invoice_end_time"
                                                       placeholder="End Time" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Omit -->
                                <div class="col-md-12 partially_completed_wrapper">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" id="modal_invoice_omit" disabled>
                                        <label class="form-check-label" for="modal_invoice_omit">Omit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $(".selectRoute").select2({
                placeholder: "Select a Route",
                allowClear: true
            });

            // Initialize DataTables for both tabs
            var cashTable = $('.cash_jobs_table').DataTable({
                "searching": true,
                "bLengthChange": true,
                "paging": true,
                "info": true,
                "ordering": true,
                "order": [
                    [2, "desc"]
                ], // Sort by service date descending
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            var invoiceTable = $('.invoice_jobs_table').DataTable({
                "searching": true,
                "bLengthChange": true,
                "paging": true,
                "info": true,
                "ordering": true,
                "order": [
                    [2, "desc"]
                ], // Sort by service date descending
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            // Custom search box
            $(document).on("input", '.custom_search_box', function() {
                var searchValue = $(this).val();
                cashTable.search(searchValue).draw();
                invoiceTable.search(searchValue).draw();
            });

            // Cash Tab Filters
            function applyCashFilters() {
                var filterDate = $('#cash_filter_date').val();
                var filterRoute = $('#cash_filter_route').val();
                var filterWeek = $('#cash_filter_week').val();

                // Use DataTables custom search
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        // Only apply to cash table
                        if (settings.nTable.id !== 'cash_jobs_table') {
                            return true;
                        }

                        var row = cashTable.row(dataIndex).node();
                        var routeId = $(row).data('route-id') || '';
                        var week = $(row).data('week') || '';
                        var date = $(row).data('date') || '';

                        if (filterRoute && routeId != filterRoute) {
                            return false;
                        }

                        if (filterWeek && week != filterWeek) {
                            return false;
                        }

                        if (filterDate && date != filterDate) {
                            return false;
                        }

                        return true;
                    }
                );

                cashTable.draw();
                $.fn.dataTable.ext.search.pop();
            }

            $('#cash_filter_date, #cash_filter_route, #cash_filter_week').on('change', applyCashFilters);

            // Invoice Tab Filters
            function applyInvoiceFilters() {
                var filterDate = $('#invoice_filter_date').val();
                var filterRoute = $('#invoice_filter_route').val();
                var filterWeek = $('#invoice_filter_week').val();

                // Use DataTables custom search
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        // Only apply to invoice table
                        if (settings.nTable.id !== 'invoice_jobs_table') {
                            return true;
                        }

                        var row = invoiceTable.row(dataIndex).node();
                        var routeId = $(row).data('route-id') || '';
                        var week = $(row).data('week') || '';
                        var date = $(row).data('date') || '';

                        if (filterRoute && routeId != filterRoute) {
                            return false;
                        }

                        if (filterWeek && week != filterWeek) {
                            return false;
                        }

                        if (filterDate && date != filterDate) {
                            return false;
                        }

                        return true;
                    }
                );

                invoiceTable.draw();
                $.fn.dataTable.ext.search.pop();
            }

            $('#invoice_filter_date, #invoice_filter_route, #invoice_filter_week').on('change',
                applyInvoiceFilters);

            // Handle View Report button click
            $(document).on('click', '.view-report-btn', function() {
                var serviceDate = $(this).data('service-date');
                var option = $(this).data('option');
                var optionTwo = $(this).data('option-two');
                var optionThree = $(this).data('option-three');
                var optionFour = $(this).data('option-four');
                var reason = $(this).data('reason');
                var scope = $(this).data('scope');
                var partialScope = $(this).data('partial-scope');
                var priceOne = $(this).data('price-one');
                var priceTwo = $(this).data('price-two');
                var amount = $(this).data('amount');
                var startTime = $(this).data('start-time');
                var endTime = $(this).data('end-time');
                var finalPrice = $(this).data('final-price');
                var clientName = $(this).data('client-name');
                var paymentType = $(this).data('payment-type'); // 'cash' or 'invoice'

                // Format service date
                var formattedDate = 'N/A';
                if (serviceDate) {
                    var date = new Date(serviceDate);
                    formattedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                        ('0' + date.getDate()).slice(-2) + '-' +
                        date.getFullYear();
                }

                if (paymentType === 'cash') {
                    // CASH MODAL
                    // Reset all checkboxes and fields
                    $('#modal_cash_completed, #modal_cash_noPayment, #modal_cash_partially, #modal_cash_option_two, #modal_cash_option_three, #modal_cash_option_four, #modal_cash_omit')
                        .prop('checked', false);
                    $('#modal_cash_noPayment_reason, #modal_cash_partially_fields').hide();
                    $('#modal_cash_reason_noPayment, #modal_cash_reason_partially, #modal_cash_scope_partially, #modal_cash_price_charged_one')
                        .val('');

                    // Set client name and final price
                    $('#modal_cash_client_name').text(clientName);
                    $('#modal_cash_final_price').text(finalPrice ? '$' + parseFloat(finalPrice).toFixed(2) :
                        '$0.00');
                    $('#modal_cash_service_date').val(formattedDate);

                    // Set completion status checkboxes
                    if (option === 'completed') {
                        $('#modal_cash_completed').prop('checked', true);
                    } else if (option === 'no_payment') {
                        $('#modal_cash_noPayment').prop('checked', true);
                        if (reason) {
                            $('#modal_cash_noPayment_reason').show();
                            $('#modal_cash_reason_noPayment').val(reason);
                        }
                    } else if (option === 'partially') {
                        $('#modal_cash_partially').prop('checked', true);
                        $('#modal_cash_partially_fields').show();
                        if (reason) {
                            $('#modal_cash_reason_partially').val(reason);
                        }
                        if (partialScope) {
                            $('#modal_cash_scope_partially').val(partialScope);
                        }
                        if (priceOne) {
                            $('#modal_cash_price_charged_one').val(priceOne);
                        }
                    } else if (option === 'omit') {
                        $('#modal_cash_omit').prop('checked', true);
                    }

                    // Set additional options for CASH
                    if (optionTwo === 'paid_on_prior') {
                        $('#modal_cash_option_two').prop('checked', true);
                    }
                    if (optionThree === 'extra_paid_for_date') {
                        $('#modal_cash_option_three').prop('checked', true);
                    }
                    if (optionFour === 'extra_work') {
                        $('#modal_cash_option_four').prop('checked', true);
                    }

                    // Show CASH modal
                    $('#viewReportModalCash').modal('show');

                } else if (paymentType === 'invoice') {
                    // INVOICE MODAL
                    // Reset all checkboxes and fields
                    $('#modal_invoice_completed, #modal_invoice_partially, #modal_invoice_option_two, #modal_invoice_option_three, #modal_invoice_omit')
                        .prop('checked', false);
                    $('#modal_invoice_partially_fields, #modal_invoice_extra_work_fields, #modal_invoice_log_time_fields')
                        .hide();
                    $('#modal_invoice_reason_partially, #modal_invoice_scope_partially, #modal_invoice_price_charged_one')
                        .val('');
                    $('#modal_invoice_scope_extra_work, #modal_invoice_price_charged_two').val('');
                    $('#modal_invoice_start_time, #modal_invoice_end_time').val('');

                    // Set client name and final price
                    $('#modal_invoice_client_name').text(clientName);
                    $('#modal_invoice_final_price').text(finalPrice ? '$' + parseFloat(finalPrice).toFixed(
                        2) : '$0.00');
                    $('#modal_invoice_service_date').val(formattedDate);

                    // Set completion status checkboxes
                    if (option === 'completed') {
                        $('#modal_invoice_completed').prop('checked', true);
                    } else if (option === 'partially') {
                        $('#modal_invoice_partially').prop('checked', true);
                        $('#modal_invoice_partially_fields').show();
                        if (reason) {
                            $('#modal_invoice_reason_partially').val(reason);
                        }
                        if (partialScope) {
                            $('#modal_invoice_scope_partially').val(partialScope);
                        }
                        if (priceOne) {
                            $('#modal_invoice_price_charged_one').val(priceOne);
                        }
                    } else if (option === 'omit') {
                        $('#modal_invoice_omit').prop('checked', true);
                    }

                    // Set additional options for INVOICE
                    if (optionTwo === 'extraWork') {
                        $('#modal_invoice_option_two').prop('checked', true);
                        $('#modal_invoice_extra_work_fields').show();
                        if (scope) {
                            $('#modal_invoice_scope_extra_work').val(scope);
                        }
                        if (priceTwo) {
                            $('#modal_invoice_price_charged_two').val(priceTwo);
                        }
                    }
                    if (optionThree === 'logTime') {
                        $('#modal_invoice_option_three').prop('checked', true);
                        $('#modal_invoice_log_time_fields').show();
                        if (startTime) {
                            $('#modal_invoice_start_time').val(startTime);
                        }
                        if (endTime) {
                            $('#modal_invoice_end_time').val(endTime);
                        }
                    }

                    // Show INVOICE modal
                    $('#viewReportModalInvoice').modal('show');
                }
            });
        });
    </script>
@endpush
