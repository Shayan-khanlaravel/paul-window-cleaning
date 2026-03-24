@extends('theme.layout.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Outstanding Deposits</h2>
    </div>
    <div class="txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    @if (auth()->user()->hasRole('admin'))
        <section class="client_management staff_manag complete_jobs_section">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="custom_justify_between">
                                <h3>Deposits</h3>
                            </div>
                            <!-- Filters -->
                            <div class="row mb-3" style="margin-top: 15px;">
                                <div class="col-md-3">
                                    <div class="txt_field custom_select_route">
                                        <label for="filter_route">Filter by Route</label>
                                        <select class="form-select selectRoute" id="filter_route" data-placeholder="Select a Route">
                                            <option value="">All Routes</option>
                                            @foreach ($routes ?? [] as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="filter_week">Filter by Week</label>
                                        <select class="form-select" id="filter_week">
                                            <option value="">All Weeks</option>
                                            <option value="week0">Week 1</option>
                                            <option value="week1">Week 2</option>
                                            <option value="week2">Week 3</option>
                                            <option value="week3">Week 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="filter_month">Filter by Month</label>
                                        <select class="form-select" id="filter_month">
                                            <option value="">All Months</option>
                                            <option value="January-february">January - February</option>
                                            <option value="February-march">February - March</option>
                                            <option value="March-april">March - April</option>
                                            <option value="April-may">April - May</option>
                                            <option value="May-june">May - June</option>
                                            <option value="June-july">June - July</option>
                                            <option value="July-august">July - August</option>
                                            <option value="August-september">August - September</option>
                                            <option value="September-october">September - October</option>
                                            <option value="October-november">October - November</option>
                                            <option value="November-december">November - December</option>
                                            <option value="December-january">December - January</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="filter_year">Filter by Year</label>
                                        <input class="form-control" type="number" id="filter_year" placeholder="Year" min="2020" max="2100">
                                    </div>
                                </div>
                            </div>
                            <div class="custom_table">
                                <div class="table-responsive">
                                    <table class="table myTable datatable">
                                        <thead>
                                            <tr>
                                                <th>Route</th>
                                                <th>Staff</th>
                                                <th>Week</th>
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Deposit Amount</th>
                                                <th>Deposited</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($deposits as $deposit)
                                                <tr data-route-id="{{ $deposit->route_id }}" data-route-name="{{ $deposit->route->name ?? 'N/A' }}" data-week="{{ $deposit->week }}" data-month="{{ $deposit->month }}" data-year="{{ $deposit->year }}" data-total-amount="{{ $deposit->total_amount }}" data-deposit-amount="{{ $deposit->deposit_amount }}">
                                                    <td>{{ $deposit->route->name ?? 'N/A' }}</td>
                                                    <td>{{ $deposit->staff->name ?? 'N/A' }}</td>
                                                    <td>Week {{ (int) str_replace('week', '', $deposit->week) + 1 }}</td>
                                                    <td>{{ $deposit->month }}</td>
                                                    <td>{{ $deposit->year }}</td>
                                                    <td>${{ number_format($deposit->deposit_amount, 2) }}</td>
                                                    <td>
                                                        <div class="table_checkbox">
                                                            <input class="form-check-input deposit-checkbox" type="checkbox" {{ $deposit->is_deposit ? 'checked' : '' }} data-deposit-id="{{ $deposit->id }}" id="tblCheck{{ $deposit->id }}">
                                                            <label for="tblCheck{{ $deposit->id }}">
                                                                {{ $deposit->deposit_date ? $deposit->deposit_date->format('m-d-Y') : 'N/A' }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Totals Display Below Table -->
                            <div class="row mt-3" id="admin_totals" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                                <div class="col-md-12 text-end">
                                    <strong>Total Deposit: $<span id="admin_total_deposit">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="client_management staff_manag complete_jobs_section">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="custom_justify_between">
                                <h3>Deposits</h3>
                                <button type="button" class="btn_global btn_blue" data-bs-target="#add_deposit" data-bs-toggle="modal">Add Deposit<i class="fa-solid fa-plus"></i></button>
                            </div>
                            <!-- Filters -->
                            <div class="row mb-3" style="margin-top: 15px;">
                                <div class="col-md-3">
                                    <div class="txt_field custom_select_route">
                                        <label for="staff_filter_route">Filter by Route</label>
                                        <select class="form-select selectRoute" id="staff_filter_route" data-placeholder="Select a Route">
                                            <option value="">All Routes</option>
                                            @foreach ($routes ?? [] as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="staff_filter_week">Filter by Week</label>
                                        <select class="form-select" id="staff_filter_week">
                                            <option value="">All Weeks</option>
                                            <option value="week0">Week 1</option>
                                            <option value="week1">Week 2</option>
                                            <option value="week2">Week 3</option>
                                            <option value="week3">Week 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="staff_filter_month">Filter by Month</label>
                                        <select class="form-select" id="staff_filter_month">
                                            <option value="">All Months</option>
                                            <option value="January-february">January - February</option>
                                            <option value="February-march">February - March</option>
                                            <option value="March-april">March - April</option>
                                            <option value="April-may">April - May</option>
                                            <option value="May-june">May - June</option>
                                            <option value="June-july">June - July</option>
                                            <option value="July-august">July - August</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="txt_field">
                                        <label for="staff_filter_year">Filter by Year</label>
                                        <input class="form-control" type="number" id="staff_filter_year" placeholder="Year" min="2020" max="2100">
                                    </div>
                                </div>
                            </div>
                            <div class="custom_table">
                                <div class="table-responsive">
                                    <table class="table myTable datatable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Route</th>
                                                <th>Week</th>
                                                <th>Amount</th>
                                                <th>Deposited</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($deposits as $deposit)
                                                <tr data-route-id="{{ $deposit->route_id }}" data-route-name="{{ $deposit->route->name ?? 'N/A' }}" data-week="{{ $deposit->week }}" data-month="{{ $deposit->month }}" data-year="{{ $deposit->year }}" data-total-amount="{{ $deposit->total_amount }}" data-deposit-amount="{{ $deposit->deposit_amount }}">
                                                    <td>{{ $deposit->deposit_date ? $deposit->deposit_date->format('m-d-Y') : 'N/A' }}
                                                    </td>
                                                    <td>{{ $deposit->route->name ?? 'N/A' }}</td>
                                                    <td>Week {{ (int) str_replace('week', '', $deposit->week) + 1 }}</td>
                                                    <td>${{ number_format($deposit->total_amount, 2) }}</td>
                                                    <td>
                                                        <input type="checkbox" {{ $deposit->is_deposit ? 'checked' : '' }} disabled>
                                                        ${{ number_format($deposit->deposit_amount, 2) }}
                                                    </td>
                                                    <td>
                                                        @if (auth()->user()->hasRole('staff'))
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $deposit->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $deposit->id }}">
                                                                    {{-- <li>
                                                                        <a class="dropdown-item edit-deposit-btn" href="javascript:void(0);"
                                                                            data-deposit-id="{{ $deposit->id }}">
                                                                            <i class="fa-solid fa-edit"></i> Edit
                                                                        </a>
                                                                    </li> --}}
                                                                    <li>
                                                                        <a class="dropdown-item delete-deposit-btn" href="javascript:void(0);" data-deposit-id="{{ $deposit->id }}" data-route-name="{{ $deposit->route->name ?? 'N/A' }}">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Totals Display Below Table -->
                            <div class="row mt-3" id="staff_totals" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                                <div class="col-md-12 text-end">
                                    <strong>Total Deposit: $<span id="staff_total_deposit">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade complete_jobs_section" id="add_deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document" style="max-width: 800px;">
                <div class="modal-content">
                    <form method="POST" action="{{ route('deposits.store') }}" id="deposit_form" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="deposit_id" id="deposit_id" value="">
                        <div class="modal-header">
                            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <h2 class="modal-title" id="modal_title" style="margin: 0;">Add Deposits</h2>

                                <div id="expected_cash_header" style="display: none; padding: 8px 12px; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid #007bff; margin-right: 10px;">
                                    <div>
                                        <strong style="color: #007bff; font-size: 14px;">
                                            Total Expected: $<span id="expected_cash_header_value">0.00</span>
                                        </strong>
                                    </div>
                                    <div id="already_deposited_info" style="display: none;">
                                        <small style="color:rgb(165, 6, 6); font-size: 12px;">
                                            <i class="fa-solid fa-info-circle" style="color:rgb(165, 6, 6);"></i> Already Deposited: $<span id="already_deposited_value">0.00</span>
                                        </small>
                                    </div>
                                    <div>
                                        <small style="color: #28a745; font-weight: 600; font-size: 12px;">
                                            <i class="fa-solid fa-check-circle" style="color: #28a745;"></i> Remaining: $<span id="remaining_cash_value">0.00</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Error Alert Box -->
                            <div id="form_errors" class="alert alert-danger" style="display: none;">
                                <ul id="error_list" class="mb-0"></ul>
                            </div>
                            <!-- Success Alert Box -->
                            <div id="form_success" class="alert alert-success" style="display: none;">
                                <span id="success_message"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="deposit_date">Deposit Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="deposit_date" id="deposit_date" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field custom_select_route">
                                        <label for="route_id">Select Route <span class="text-danger">*</span></label>
                                        <select class="form-select selectRouteModal" name="route_id" id="route_id" required data-placeholder="Select a Route">
                                            <option value="" selected disabled>Select Route</option>
                                            @foreach ($routes as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="week">Week <span class="text-danger">*</span></label>
                                        <select class="form-select" name="week" id="week" required>
                                            <option value="" selected disabled>Select Week</option>
                                            <option value="week0">Week 1</option>
                                            <option value="week1">Week 2</option>
                                            <option value="week2">Week 3</option>
                                            <option value="week3">Week 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="month">Month <span class="text-danger">*</span></label>
                                        <select class="form-select" name="month" id="month" required>
                                            <option value="" selected disabled>Select Month</option>
                                            <option value="January - February">January - February</option>
                                            <option value="February - March">February - March</option>
                                            <option value="March">March</option>
                                            <option value="March - April">March - April</option>
                                            <option value="April - May">April - May</option>
                                            <option value="May - June">May - June</option>
                                            <option value="June - July">June - July</option>
                                            <option value="July - August">July - August</option>
                                            <option value="August - September">August - September</option>
                                            <option value="September - October">September - October</option>
                                            <option value="October - November">October - November</option>
                                            <option value="November - December">November - December</option>
                                            <option value="December - January">December - January</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="year">Year <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="year" id="year" value="{{ date('Y') }}" min="2020" max="2100" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="total_amount">Total Expected Amount <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" step="0.01" name="total_amount" id="total_amount" placeholder="0.00" required readonly style="background-color: #e9ecef; height: 42px; padding: 6px 12px;">
                                        <small class="text-muted">
                                            <i class="fa-solid fa-info-circle"></i> This is the remaining expected cash (Total Expected - Already Deposited)
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="txt_field">
                                        <label for="deposit_amount">Deposit Amount <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" step="0.01" name="deposit_amount" id="deposit_amount" placeholder="0.00" required style="height: 42px; padding: 6px 12px;">
                                        <small id="deposit_amount_error" class="text-danger" style="display: none;"></small>
                                        <small id="remaining_info" class="text-muted" style="display: none;">
                                            <i class="fa-solid fa-wallet"></i> After this deposit, remaining will be: $<span id="remaining_available">0.00</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txt_field">
                                        <label for="notes">Notes (Optional)</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="2" style="padding: 6px 12px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer custom_justify_between">
                            <button type="button" class="btn_global btn_grey" data-bs-dismiss="modal" aria-label="Close">Cancel <i class="fa-solid fa-x"></i></button>
                            <button type="submit" class="btn_global btn_blue" id="submit_btn">Add Deposit<i class="fa-solid fa-check"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {

                $(".selectRoute").select2({
                    allowClear: true,
                });
                $(".selectRouteModal").select2({
                    allowClear: true,
                    dropdownParent: $('#add_deposit')
                });

                // Function to calculate and update totals for admin table
                function updateAdminTotals() {
                    let totalAmount = 0;
                    let totalDeposit = 0;

                    // Get filter values
                    const filterRoute = $('#filter_route').val() || '';
                    const filterWeek = $('#filter_week').val() || '';
                    const filterMonth = $('#filter_month').val() || '';
                    const filterYear = String($('#filter_year').val() || '').trim();

                    // Get DataTable instance if exists
                    let table = null;
                    let isDataTable = false;
                    try {
                        table = $('.myTable').DataTable();
                        isDataTable = table && $.fn.DataTable.isDataTable('.myTable');
                    } catch (e) {
                        isDataTable = false;
                    }

                    // Get all visible rows
                    const rows = isDataTable ? table.rows({
                        search: 'applied'
                    }).nodes() : $('.myTable tbody tr:visible');

                    $(rows).each(function() {
                        const $row = $(this);
                        if ($row.hasClass('d-none') || $row.css('display') === 'none') return;

                        let showRow = true;

                        // Use data attributes for filtering
                        const routeId = $row.data('route-id') || '';
                        const week = $row.data('week') || '';
                        const month = $row.data('month') || '';
                        const year = $row.data('year') || '';

                        // Apply filters
                        if (filterRoute && routeId != filterRoute) {
                            showRow = false;
                        }

                        if (filterWeek && week != filterWeek) {
                            showRow = false;
                        }

                        if (filterMonth && !month.includes(filterMonth)) {
                            showRow = false;
                        }

                        if (filterYear && String(year) != String(filterYear)) {
                            showRow = false;
                        }

                        if (showRow) {
                            // Use data attributes for amounts
                            const amount = parseFloat($row.data('total-amount')) || 0;
                            const deposit = parseFloat($row.data('deposit-amount')) || 0;

                            totalAmount += amount;
                            totalDeposit += deposit;
                        }
                    });

                    $('#admin_total_deposit').text(totalDeposit.toFixed(2));
                }

                // Function to calculate and update totals for staff table
                function updateStaffTotals() {
                    let totalAmount = 0;
                    let totalDeposit = 0;

                    // Get filter values
                    const filterRoute = $('#staff_filter_route').val() || '';
                    const filterWeek = $('#staff_filter_week').val() || '';
                    const filterMonth = $('#staff_filter_month').val() || '';
                    const filterYear = String($('#staff_filter_year').val() || '').trim();

                    // Get DataTable instance if exists
                    let table = null;
                    let isDataTable = false;
                    try {
                        table = $('.myTable').DataTable();
                        isDataTable = table && $.fn.DataTable.isDataTable('.myTable');
                    } catch (e) {
                        isDataTable = false;
                    }

                    // Get all visible rows
                    const rows = isDataTable ? table.rows({
                        search: 'applied'
                    }).nodes() : $('.myTable tbody tr:visible');

                    $(rows).each(function() {
                        const $row = $(this);
                        if ($row.hasClass('d-none') || $row.css('display') === 'none') return;

                        let showRow = true;

                        // Use data attributes for filtering
                        const routeId = $row.data('route-id') || '';
                        const week = $row.data('week') || '';
                        const month = $row.data('month') || '';
                        const year = $row.data('year') || '';

                        // Apply filters
                        if (filterRoute && routeId != filterRoute) {
                            showRow = false;
                        }

                        if (filterWeek && week != filterWeek) {
                            showRow = false;
                        }

                        if (filterMonth && !month.includes(filterMonth)) {
                            showRow = false;
                        }

                        if (filterYear && String(year) != String(filterYear)) {
                            showRow = false;
                        }

                        if (showRow) {
                            // Use data attributes for amounts
                            const amount = parseFloat($row.data('total-amount')) || 0;
                            const deposit = parseFloat($row.data('deposit-amount')) || 0;

                            totalAmount += amount;
                            totalDeposit += deposit;
                        }
                    });

                    $('#staff_total_deposit').text(totalDeposit.toFixed(2));
                }

                // Admin filters
                @if (auth()->user()->hasRole('admin'))
                    $('#filter_route, #filter_week, #filter_month, #filter_year').on('change input', function() {
                        const filterRoute = $('#filter_route').val() || '';
                        const filterWeek = $('#filter_week').val() || '';
                        const filterMonth = $('#filter_month').val() || '';
                        const filterYear = String($('#filter_year').val() || '').trim();

                        // Manual filtering using data attributes
                        $('.myTable tbody tr').each(function() {
                            const $row = $(this);
                            let showRow = true;

                            // Use data attributes for filtering
                            const routeId = $row.data('route-id') || '';
                            const week = $row.data('week') || '';
                            const month = $row.data('month') || '';
                            const year = $row.data('year') || '';

                            // Apply filters
                            if (filterRoute && routeId != filterRoute) {
                                showRow = false;
                            }

                            if (filterWeek && week != filterWeek) {
                                showRow = false;
                            }

                            if (filterMonth && !month.includes(filterMonth)) {
                                showRow = false;
                            }

                            if (filterYear && String(year) != String(filterYear)) {
                                showRow = false;
                            }

                            if (showRow) {
                                $row.show();
                            } else {
                                $row.hide();
                            }
                        });

                        // Update totals
                        updateAdminTotals();
                    });

                    // Admin deposit checkbox update
                    $(document).on('change', '.deposit-checkbox', function() {
                        const depositId = $(this).data('deposit-id');
                        const isChecked = $(this).is(':checked');

                        $.ajax({
                            url: '{{ route('deposits.update-status', ':id') }}'.replace(':id', depositId),
                            method: 'POST',
                            data: {
                                is_deposit: isChecked ? 1 : 0,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Deposit status updated successfully',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                updateAdminTotals();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update deposit status',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                // Revert checkbox
                                $('.deposit-checkbox[data-deposit-id="' + depositId + '"]').prop('checked', !isChecked);
                            }
                        });
                    });

                    // Initialize admin totals
                    updateAdminTotals();
                @endif

                // Staff filters
                @if (auth()->user()->hasRole('staff'))
                    $('#staff_filter_route, #staff_filter_week, #staff_filter_month, #staff_filter_year').on('change input', function() {
                        const filterRoute = $('#staff_filter_route').val() || '';
                        const filterWeek = $('#staff_filter_week').val() || '';
                        const filterMonth = $('#staff_filter_month').val() || '';
                        const filterYear = String($('#staff_filter_year').val() || '').trim();

                        // Manual filtering using data attributes
                        $('.myTable tbody tr').each(function() {
                            const $row = $(this);
                            let showRow = true;

                            // Use data attributes for filtering
                            const routeId = $row.data('route-id') || '';
                            const week = $row.data('week') || '';
                            const month = $row.data('month') || '';
                            const year = $row.data('year') || '';

                            // Apply filters
                            if (filterRoute && routeId != filterRoute) {
                                showRow = false;
                            }

                            if (filterWeek && week != filterWeek) {
                                showRow = false;
                            }

                            if (filterMonth && !month.includes(filterMonth)) {
                                showRow = false;
                            }

                            if (filterYear && String(year) != String(filterYear)) {
                                showRow = false;
                            }

                            if (showRow) {
                                $row.show();
                            } else {
                                $row.hide();
                            }
                        });

                        // Update totals
                        updateStaffTotals();
                    });

                    // Initialize staff totals
                    updateStaffTotals();
                @endif
                let expectedCash = 0;
                let alreadyDeposited = 0;
                let remainingCash = 0;

                // Function to fetch expected cash
                function fetchExpectedCash() {
                    const routeId = $('#route_id').val();
                    const week = $('#week').val();
                    const month = $('#month').val();
                    const year = $('#year').val();

                    console.log('Fetching expected cash with:', {
                        routeId,
                        week,
                        month,
                        year
                    });

                    if (routeId && week && month && year) {
                        const requestUrl = '{{ route('deposits.get-expected-cash') }}';
                        console.log('Request URL:', requestUrl);

                        $.ajax({
                            url: requestUrl,
                            method: 'GET',
                            data: {
                                route_id: routeId,
                                week: week,
                                month: month,
                                year: year
                            },
                            dataType: 'text', // Accept as text first, then parse
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            success: function(response, textStatus, xhr) {
                                console.log('Response received (raw):', response);

                                // Check if response is actually HTML (error page)
                                if (typeof response === 'string' && (response.trim().startsWith('<!') || response.includes('<html') || response.includes('<!DOCTYPE'))) {
                                    console.error('Server returned HTML instead of JSON. This usually indicates a server error.');
                                    console.error('Response preview:', response.substring(0, 1000));
                                    expectedCash = 0;
                                    alreadyDeposited = 0;
                                    remainingCash = 0;
                                    $('#total_amount').val('0.00');
                                    $('#expected_cash_header').hide();
                                    $('#remaining_info').hide();

                                    // Try to extract error message from HTML if possible
                                    const errorMatch = response.match(/<title>(.*?)<\/title>/i) || response.match(/Error[^<]*/i);
                                    const errorMsg = errorMatch ? errorMatch[1] || errorMatch[0] : 'Server returned HTML error page';
                                    console.error('Extracted error:', errorMsg);

                                    return;
                                }

                                // Try to parse JSON from string response
                                let jsonResponse = response;
                                if (typeof response === 'string') {
                                    try {
                                        jsonResponse = JSON.parse(response);
                                    } catch (e) {
                                        console.error('Failed to parse response as JSON:', e);
                                        console.error('Response was:', response.substring(0, 200));
                                        expectedCash = 0;
                                        alreadyDeposited = 0;
                                        remainingCash = 0;
                                        $('#total_amount').val('0.00');
                                        $('#expected_cash_header').hide();
                                        $('#remaining_info').hide();
                                        return;
                                    }
                                }

                                console.log('Parsed JSON response:', jsonResponse);

                                if (jsonResponse && jsonResponse.success === true) {
                                    expectedCash = parseFloat(jsonResponse.expected_cash) || 0;
                                    alreadyDeposited = parseFloat(jsonResponse.already_deposited) || 0;
                                    remainingCash = parseFloat(jsonResponse.remaining) || 0;

                                    console.log('Expected cash calculated:', {
                                        expectedCash,
                                        alreadyDeposited,
                                        remainingCash
                                    });

                                    // Show remaining expected cash (expectedCash - alreadyDeposited) in total_amount field
                                    $('#total_amount').val(remainingCash.toFixed(2));
                                    $('#expected_cash_header_value').text(expectedCash.toFixed(2));
                                    $('#remaining_cash_value').text(remainingCash.toFixed(2));
                                    $('#already_deposited_value').text(alreadyDeposited.toFixed(2));

                                    // Show/hide already deposited info
                                    if (alreadyDeposited > 0) {
                                        $('#already_deposited_info').show();
                                    } else {
                                        $('#already_deposited_info').hide();
                                    }

                                    $('#expected_cash_header').show();
                                    $('#remaining_available').text(remainingCash.toFixed(2));
                                    $('#remaining_info').show();

                                    // Update remaining amount based on current deposit amount input
                                    updateRemainingAmount();
                                    validateDepositAmount();

                                    // Check if form is valid to enable/disable button
                                    checkFormValidity();
                                } else {
                                    const errorMessage = (jsonResponse && jsonResponse.message) ? jsonResponse.message : 'Server returned unsuccessful response';
                                    console.error('Failed to fetch expected cash:', errorMessage, 'Full response:', jsonResponse);
                                    expectedCash = 0;
                                    alreadyDeposited = 0;
                                    remainingCash = 0;
                                    $('#total_amount').val('0.00');
                                    $('#expected_cash_header').hide();
                                    $('#remaining_info').hide();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error Details:', {
                                    status: xhr.status,
                                    statusText: xhr.statusText,
                                    error: error,
                                    responseText: xhr.responseText ? xhr.responseText.substring(0, 200) : 'No response',
                                    responseJSON: xhr.responseJSON
                                });

                                let errorMessage = 'Network error occurred';

                                // Check if response is HTML (likely a redirect or error page)
                                if (xhr.responseText && (xhr.responseText.trim().startsWith('<!') || xhr.responseText.includes('<html'))) {
                                    if (xhr.status === 401 || xhr.status === 403) {
                                        errorMessage = 'Authentication required. Please refresh the page and try again.';
                                    } else if (xhr.status === 404) {
                                        errorMessage = 'Route not found. Please check the URL.';
                                    } else {
                                        errorMessage = 'Server returned HTML instead of JSON. Status: ' + xhr.status;
                                    }
                                } else if (xhr.responseJSON) {
                                    // Try to parse JSON response if available
                                    errorMessage = xhr.responseJSON.message || xhr.responseJSON.error || errorMessage;
                                } else if (xhr.responseText) {
                                    try {
                                        const parsed = JSON.parse(xhr.responseText);
                                        errorMessage = parsed.message || parsed.error || errorMessage;
                                    } catch (e) {
                                        // Not JSON, use status text or first part of response
                                        errorMessage = xhr.statusText || xhr.responseText.substring(0, 100) || errorMessage;
                                    }
                                } else {
                                    errorMessage = xhr.statusText || error || 'Unknown error occurred';
                                }

                                console.error('Error fetching expected cash:', errorMessage);

                                // Only show alert for critical errors, not for missing data
                                if (xhr.status >= 500 || xhr.status === 0) {
                                    alert('Error fetching expected cash: ' + errorMessage + '\nStatus: ' + xhr.status);
                                }

                                expectedCash = 0;
                                alreadyDeposited = 0;
                                remainingCash = 0;
                                $('#total_amount').val('0.00');
                                $('#expected_cash_header').hide();
                                $('#remaining_info').hide();
                            }
                        });
                    } else {
                        console.log('Missing required fields:', {
                            routeId: !!routeId,
                            week: !!week,
                            month: !!month,
                            year: !!year
                        });
                        expectedCash = 0;
                        alreadyDeposited = 0;
                        remainingCash = 0;
                        $('#total_amount').val('0.00');
                        $('#expected_cash_header').hide();
                        $('#remaining_info').hide();
                    }
                }

                // Function to update remaining amount display
                function updateRemainingAmount() {
                    const depositAmount = parseFloat($('#deposit_amount').val()) || 0;
                    const newRemaining = Math.max(0, remainingCash - depositAmount);
                    $('#remaining_available').text(newRemaining.toFixed(2));
                    $('#remaining_cash_value').text(newRemaining.toFixed(2));
                }

                // Function to check if all required fields are filled
                function checkFormValidity() {
                    const depositDate = $('#deposit_date').val();
                    const routeId = $('#route_id').val();
                    const week = $('#week').val();
                    const month = $('#month').val();
                    const year = $('#year').val();
                    const totalAmount = parseFloat($('#total_amount').val()) || 0;
                    const depositAmount = parseFloat($('#deposit_amount').val()) || 0;

                    // Check if all required fields are filled
                    const isFormValid = depositDate && routeId && week && month && year &&
                        totalAmount > 0 && depositAmount > 0 &&
                        validateDepositAmount();

                    // Enable/disable submit button
                    const submitBtn = $('form[action="{{ route('deposits.store') }}"]').find('button[type="submit"]');
                    if (isFormValid) {
                        submitBtn.prop('disabled', false);
                    } else {
                        submitBtn.prop('disabled', true);
                    }

                    return isFormValid;
                }

                // Function to validate deposit amount against remaining cash
                function validateDepositAmount() {
                    const depositAmount = parseFloat($('#deposit_amount').val()) || 0;
                    const errorElement = $('#deposit_amount_error');

                    if (remainingCash > 0 && depositAmount > remainingCash) {
                        errorElement.text('Deposit amount cannot exceed remaining expected cash of $' + remainingCash
                            .toFixed(2) + '. (Total Expected: $' + expectedCash.toFixed(2) +
                            ', Already Deposited: $' + alreadyDeposited.toFixed(2) + ')');
                        errorElement.show();
                        $('#deposit_amount').addClass('is-invalid');
                        return false;
                    } else if (depositAmount < 0) {
                        errorElement.text('Deposit amount cannot be negative');
                        errorElement.show();
                        $('#deposit_amount').addClass('is-invalid');
                        return false;
                    } else {
                        errorElement.hide();
                        $('#deposit_amount').removeClass('is-invalid');
                        return true;
                    }
                }

                // Listen to changes in route, week, month, or year
                $(document).on('change', '#route_id, #week, #month, #year', function() {
                    // console.log('Field changed:', this.id, 'Value:', $(this).val());
                    fetchExpectedCash();
                    checkFormValidity();
                });

                // Listen to changes in all required fields to enable/disable button
                $(document).on('change input blur', '#deposit_date, #route_id, #week, #month, #year, #deposit_amount', function() {
                    checkFormValidity();
                });

                // Validate deposit amount on blur (when user leaves the input field)
                $('#deposit_amount').on('blur', function() {
                    validateDepositAmount();
                    updateRemainingAmount();
                });

                // Update remaining amount and show errors in real-time as user types
                $('#deposit_amount').on('input', function() {
                    const depositAmount = parseFloat($(this).val()) || 0;
                    const errorElement = $('#deposit_amount_error');

                    // Update remaining amount display in real-time
                    updateRemainingAmount();

                    // Show error immediately if amount exceeds remaining cash
                    if (depositAmount < 0) {
                        errorElement.text('Deposit amount cannot be negative');
                        errorElement.show();
                        $(this).addClass('is-invalid');
                    } else if (remainingCash > 0 && depositAmount > remainingCash) {
                        errorElement.text('Deposit amount cannot exceed remaining expected cash of $' + remainingCash
                            .toFixed(2) + '. (Total Expected: $' + expectedCash.toFixed(2) +
                            ', Already Deposited: $' + alreadyDeposited.toFixed(2) + ')');
                        errorElement.show();
                        $(this).addClass('is-invalid');
                    } else {
                        // Valid amount - hide error
                        errorElement.hide();
                        $(this).removeClass('is-invalid');
                    }

                    // Check form validity to enable/disable button
                    checkFormValidity();
                });

                // Function to validate all required fields
                function validateAllFields() {
                    let isValid = true;
                    let missingFields = [];

                    // Check each required field
                    const depositDate = $('#deposit_date').val();
                    const routeId = $('#route_id').val();
                    const week = $('#week').val();
                    const month = $('#month').val();
                    const year = $('#year').val();
                    const depositAmount = parseFloat($('#deposit_amount').val()) || 0;

                    // Remove previous error classes
                    $('.form-control, .form-select').removeClass('is-invalid');
                    $('.field-error').remove();

                    // Validate each field
                    if (!depositDate) {
                        $('#deposit_date').addClass('is-invalid');
                        $('#deposit_date').after('<small class="text-danger field-error d-block">Please select a deposit date</small>');
                        missingFields.push('Deposit Date');
                        isValid = false;
                    }

                    if (!routeId) {
                        $('#route_id').addClass('is-invalid');
                        $('#route_id').after('<small class="text-danger field-error d-block">Please select a route</small>');
                        missingFields.push('Route');
                        isValid = false;
                    }

                    if (!week) {
                        $('#week').addClass('is-invalid');
                        $('#week').after('<small class="text-danger field-error d-block">Please select a week</small>');
                        missingFields.push('Week');
                        isValid = false;
                    }

                    if (!month) {
                        $('#month').addClass('is-invalid');
                        $('#month').after('<small class="text-danger field-error d-block">Please select a month</small>');
                        missingFields.push('Month');
                        isValid = false;
                    }

                    if (!year || year < 2020 || year > 2100) {
                        $('#year').addClass('is-invalid');
                        $('#year').after('<small class="text-danger field-error d-block">Please enter a valid year (2020-2100)</small>');
                        missingFields.push('Year');
                        isValid = false;
                    }

                    if (!depositAmount || depositAmount <= 0) {
                        $('#deposit_amount').addClass('is-invalid');
                        $('#deposit_amount_error').text('Please enter a valid deposit amount').show();
                        missingFields.push('Deposit Amount');
                        isValid = false;
                    }

                    // Validate deposit amount against remaining cash
                    if (!validateDepositAmount()) {
                        isValid = false;
                    }

                    // Show summary error if fields are missing
                    if (missingFields.length > 0) {
                        const errorHtml = '<li>Please fill in the following required fields: <strong>' + missingFields.join(', ') + '</strong></li>';
                        $('#error_list').html(errorHtml);
                        $('#form_errors').show();

                        // Scroll to first error field
                        $('.is-invalid').first().focus();
                        $('.modal-body').animate({
                            scrollTop: $('.is-invalid').first().offset().top - 100
                        }, 300);
                    }

                    return isValid;
                }

                // Handle form submission via AJAX
                $('form[action="{{ route('deposits.store') }}"]').on('submit', function(e) {
                    e.preventDefault();

                    // Hide previous errors
                    $('#form_errors').hide();
                    $('#error_list').empty();
                    $('#form_success').hide();
                    $('.field-error').remove();

                    // Validate all fields
                    if (!validateAllFields()) {
                        return false;
                    }

                    // Show loading state
                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalBtnText = submitBtn.html();
                    submitBtn.prop('disabled', true).html(
                        'Processing... <i class="fa-solid fa-spinner fa-spin"></i>');

                    // Get form data
                    const formData = new FormData(this);
                    const formAction = $(this).attr('action');

                    // Submit via AJAX
                    $.ajax({
                        url: formAction,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            // Keep button disabled during success handling
                            submitBtn.prop('disabled', true);

                            // Update remaining amount by fetching expected cash again
                            const routeId = $('#route_id').val();
                            const week = $('#week').val();
                            const month = $('#month').val();
                            const year = $('#year').val();

                            if (routeId && week && month && year) {
                                // Fetch updated expected cash to refresh remaining amount
                                fetchExpectedCash();
                            }

                            // Success - close modal and reload page
                            $('#add_deposit').modal('hide');

                            // Reset form
                            const form = $('form[action="{{ route('deposits.store') }}"]')[0];
                            if (form) {
                                form.reset();
                            }
                            $('#expected_cash_info').hide();
                            $('#deposit_amount_error').hide();
                            $('#form_errors').hide();

                            // Check if it's update or create
                            const isUpdate = $('#deposit_id').val() && $('#deposit_id').val() !== '';
                            const message = isUpdate ? 'Deposit updated successfully' : 'Deposit created successfully';

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            // Re-enable submit button
                            submitBtn.prop('disabled', false).html(originalBtnText);

                            // IMPORTANT: Modal should NOT close on error
                            // Keep modal open to show errors

                            let errorHtml = [];
                            let hasErrors = false;

                            // Handle validation errors (422)
                            if (xhr.status === 422) {
                                const response = xhr.responseJSON || {};
                                const errors = response.errors || {};

                                // Display general error message if exists
                                if (response.message) {
                                    errorHtml.push('<li>' + response.message + '</li>');
                                    hasErrors = true;
                                }

                                // Display field-specific errors
                                $.each(errors, function(field, messages) {
                                    if (Array.isArray(messages)) {
                                        $.each(messages, function(index, message) {
                                            errorHtml.push('<li>' + message +
                                                '</li>');
                                            hasErrors = true;
                                        });
                                    } else {
                                        errorHtml.push('<li>' + messages + '</li>');
                                        hasErrors = true;
                                    }

                                    // Add error class to field
                                    const fieldElement = $('#' + field + ', [name="' +
                                        field + '"]');
                                    if (fieldElement.length) {
                                        fieldElement.addClass('is-invalid');
                                    }
                                });
                            } else {
                                // Handle other errors (500, etc.)
                                const errorMessage = xhr.responseJSON?.message ||
                                    'An error occurred. Please try again.';
                                errorHtml.push('<li>' + errorMessage + '</li>');
                                hasErrors = true;
                            }

                            // Display errors in modal
                            if (hasErrors && errorHtml.length > 0) {
                                $('#error_list').html(errorHtml.join(''));
                                $('#form_errors').show();

                                // Scroll to top of modal body to show errors
                                $('.modal-body').animate({
                                    scrollTop: 0
                                }, 300);
                            } else {
                                // Fallback error message
                                $('#error_list').html(
                                    '<li>An unexpected error occurred. Please try again.</li>');
                                $('#form_errors').show();
                                $('.modal-body').animate({
                                    scrollTop: 0
                                }, 300);
                            }
                        }
                    });

                    return false;
                });

                // Reset form and errors when modal is opened (only for new deposits)
                $('#add_deposit').on('show.bs.modal', function() {
                    // Check if we're in edit mode - if so, skip reset
                    const isEditMode = $('#deposit_id').val() && $('#deposit_id').val() !== '';

                    if (!isEditMode) {
                        // Clear form - only for new deposits
                        const depositForm = document.getElementById('deposit_form');
                        if (depositForm) {
                            depositForm.reset();
                        }
                        $('#year').val('{{ date('Y') }}');
                    }

                    // Reset expected cash variables
                    expectedCash = 0;
                    alreadyDeposited = 0;
                    remainingCash = 0;

                    // Clear errors and error messages
                    $('.field-error').remove();
                    $('#form_errors').hide();
                    $('#error_list').empty();
                    $('#form_success').hide();
                    $('#deposit_amount_error').hide();
                    $('#expected_cash_header').hide();
                    $('#remaining_info').hide();
                    $('#already_deposited_info').hide();

                    // Reset total amount
                    $('#total_amount').val('0.00');

                    // Remove error classes
                    $('.form-control, .form-select').removeClass('is-invalid');

                    // Disable submit button initially (will be enabled when form is valid)
                    // Only disable if not in edit mode
                    if (!$('#deposit_id').val()) {
                        const submitBtn = $('#submit_btn');
                        submitBtn.prop('disabled', true).html('Add Deposit<i class="fa-solid fa-check"></i>');
                    }

                    // Check form validity after a short delay to ensure all fields are reset
                    setTimeout(function() {
                        checkFormValidity();
                    }, 100);
                });

                // Fetch expected cash on modal open if fields are already filled
                $(document).on('shown.bs.modal', '#add_deposit', function() {
                    // console.log('Modal opened, checking fields...');

                    // Try immediately and also after a small delay to ensure DOM is ready
                    setTimeout(function() {
                        const routeId = $('#route_id').val();
                        const week = $('#week').val();
                        const month = $('#month').val();
                        const year = $('#year').val();

                        // console.log('Modal fields:', { routeId, week, month, year });

                        if (routeId && week && month && year) {
                            // console.log('All fields filled, fetching expected cash...');
                            fetchExpectedCash();
                        }
                    }, 100);
                });

                // Fix DataTables initialization for empty tables
                // Destroy existing DataTable if initialized globally
                setTimeout(function() {
                    if ($.fn.DataTable.isDataTable('.myTable')) {
                        $('.myTable').DataTable().destroy();
                    }

                    // Re-initialize with proper empty table handling
                    $('.myTable').each(function() {
                        var table = $(this);
                        var columnCount = table.find('thead th').length;
                        var hasData = table.find('tbody tr').length > 0;

                        // Initialize DataTable with empty table message
                        var dataTable = table.DataTable({
                            "searching": true,
                            "bLengthChange": false,
                            "paging": hasData, // Only enable paging if there's data
                            "info": hasData, // Only show info if there's data
                            "ordering": false,
                            "language": {
                                "emptyTable": "No deposits found"
                            },
                            "drawCallback": function() {
                                // Update totals after DataTables redraws
                                @if (auth()->user()->hasRole('admin'))
                                    updateAdminTotals();
                                @elseif (auth()->user()->hasRole('staff'))
                                    updateStaffTotals();
                                @endif
                            }
                        });
                    });

                    // Initialize totals after DataTables is ready
                    @if (auth()->user()->hasRole('admin'))
                        updateAdminTotals();
                    @elseif (auth()->user()->hasRole('staff'))
                        updateStaffTotals();
                    @endif
                }, 100);

                // Handle Edit Button Click
                $(document).on('click', '.edit-deposit-btn', function(e) {
                    e.preventDefault();
                    const depositId = $(this).data('deposit-id');

                    // Set deposit_id immediately to prevent form reset
                    $('#deposit_id').val(depositId);

                    // Fetch deposit data
                    $.ajax({
                        url: '{{ route('deposits.get-data', ':id') }}'.replace(':id', depositId),
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                const deposit = response.deposit;

                                // Set form to update mode
                                $('#deposit_id').val(deposit.id);
                                $('#modal_title').text('Edit Deposit');
                                $('#submit_btn').html('Update Deposit<i class="fa-solid fa-check"></i>');
                                $('#deposit_form').attr('action', '{{ route('deposits.update', ':id') }}'.replace(':id', deposit.id));
                                if ($('#deposit_form').find('input[name="_method"]').length === 0) {
                                    $('#deposit_form').append('<input type="hidden" name="_method" value="PUT">');
                                }

                                // Fill form fields
                                $('#deposit_date').val(deposit.deposit_date);
                                $('#route_id').val(deposit.route_id);
                                $('#week').val(deposit.week);
                                $('#month').val(deposit.month);
                                $('#year').val(deposit.year);
                                $('#deposit_amount').val(deposit.deposit_amount);
                                $('#notes').val(deposit.notes || '');

                                // Clear any previous errors
                                $('.field-error').remove();
                                $('#form_errors').hide();
                                $('#error_list').empty();
                                $('#deposit_amount_error').hide();
                                $('.form-control, .form-select').removeClass('is-invalid');

                                // Open modal
                                $('#add_deposit').modal('show');

                                // Fetch expected cash after modal is shown
                                setTimeout(function() {
                                    fetchExpectedCash();
                                    checkFormValidity();
                                }, 300);
                            }
                        },
                        error: function(xhr) {
                            // Clear deposit_id on error
                            $('#deposit_id').val('');
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to load deposit data',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Handle Delete Button Click
                $(document).on('click', '.delete-deposit-btn', function() {
                    const depositId = $(this).data('deposit-id');
                    const routeName = $(this).data('route-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Do you want to delete deposit for route "${routeName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Delete via AJAX to show success message
                            $.ajax({
                                url: '{{ route('deposits.destroy', ':id') }}'.replace(':id', depositId),
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Deposit deleted successfully',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to delete deposit',
                                        icon: 'error',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            });
                        }
                    });
                });

                // Reset form when modal is closed
                $('#add_deposit').on('hidden.bs.modal', function() {
                    // Reset form
                    $('#deposit_id').val('');
                    $('#modal_title').text('Add Deposits');
                    $('#submit_btn').html('Add Deposit<i class="fa-solid fa-check"></i>');
                    $('#deposit_form').attr('action', '{{ route('deposits.store') }}');
                    $('#deposit_form').find('input[name="_method"]').remove();
                    const depositForm = document.getElementById('deposit_form');
                    if (depositForm) {
                        depositForm.reset();
                    }

                    // Reset expected cash
                    expectedCash = 0;
                    alreadyDeposited = 0;
                    remainingCash = 0;
                    $('#expected_cash_header').hide();
                    $('#remaining_info').hide();
                    $('#already_deposited_info').hide();
                    $('#total_amount').val('0.00');
                    $('#deposit_amount_error').hide();
                });
            });
        </script>
    @endpush
@endsection
