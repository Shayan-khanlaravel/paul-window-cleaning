<section class="client_management staff_manag complete_jobs_section">
    <div class="container-fluid custom_container">
        @php
            $totalUndepositedAmount = collect($cashPayments ?? [])->sum(fn($payment) => (float) ($payment->final_price ?? 0));
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="custom_div">
                    <div class="undeposited-page-header">
                        <div class="undeposited-page-header__left">
                            <h3>Total Undeposited Cash</h3>
                            <div class="undeposited-total-badge">
                                <div class="undeposited-total-badge__icon">
                                    <i class="fa-solid fa-sack-dollar"></i>
                                </div>
                                <div class="undeposited-total-badge__content">
                                    <span class="undeposited-total-badge__label">Total Amount</span>
                                    <span class="undeposited-total-badge__amount">$<span id="staff_total_undeposited_front">{{ number_format($totalUndepositedAmount, 2) }}</span></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn_global btn_blue" id="mark_selected_deposited" disabled>
                            Mark Selected as Deposited<i class="fa-solid fa-check"></i>
                        </button>
                    </div>

                    <div class="row mb-3 undeposited-filter-row">
                        <div class="col-md-4">
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
                    </div>

                    <div class="custom_table">
                        <div class="table-responsive">
                            <table class="table undeposited-cash-table" id="undeposited_cash_table">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="select_all_payments" title="Select all">
                                        </th>
                                        <th>Client</th>
                                        <th>Amount</th>
                                        <th>Date Serviced</th>
                                        <th>Payment Receive Date</th>
                                        <th>Route</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cashPayments ?? [] as $payment)
                                        <tr data-route-id="{{ $payment->route_id_display ?? '' }}" data-amount="{{ $payment->final_price ?? 0 }}">
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input payment-checkbox"
                                                    value="{{ $payment->id }}"
                                                    data-payment-id="{{ $payment->id }}"
                                                >
                                            </td>
                                            <td>{{ $payment->client?->name ?? 'N/A' }}</td>
                                            <td>${{ number_format($payment->final_price ?? 0, 2) }}</td>
                                            <td>
                                                @php
                                                    $serviceDate = $payment->clientSchedule?->service_date
                                                        ?? $payment->clientSchedule?->start_date;
                                                @endphp
                                                {{ $serviceDate ? \Carbon\Carbon::parse($serviceDate)->format('m-d-Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                @php
                                                    $paymentReceiveDate = $payment->payment_date ?? $payment->created_at;
                                                @endphp
                                                {{ $paymentReceiveDate ? \Carbon\Carbon::parse($paymentReceiveDate)->format('m-d-Y') : '-' }}
                                            </td>
                                            <td>{{ $payment->route_name ?? 'N/A' }}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-primary mark-single-deposited-btn"
                                                    data-payment-id="{{ $payment->id }}"
                                                >
                                                    Mark Deposited
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="no-data-row">
                                            <td colspan="7" class="text-center text-muted py-4">No undeposited cash payments found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
    .undeposited-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .undeposited-page-header__left {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .undeposited-page-header h3 {
        margin: 0;
        white-space: nowrap;
    }

    .undeposited-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #e8f7fd 0%, #cceffc 100%);
        border: 1px solid rgba(0, 173, 238, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 173, 238, 0.12);
    }

    .undeposited-total-badge__icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #00ADEE;
        border-radius: 10px;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
    }

    .undeposited-total-badge__content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .undeposited-total-badge__label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: #5a6a7a;
    }

    .undeposited-total-badge__amount {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.1;
        color: #32346A;
        font-family: 'Hellix-SemiBold', sans-serif;
    }

    .undeposited-filter-row {
        margin-top: 0 !important;
    }

    @media (max-width: 767px) {
        .undeposited-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .undeposited-page-header__left {
            flex-direction: column;
            align-items: flex-start;
        }

        .undeposited-page-header .btn_global {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".selectRoute").select2({
            allowClear: true,
        });

        function updateStaffTotals() {
            let total = 0;
            $('#undeposited_cash_table tbody tr:visible').each(function() {
                const $row = $(this);
                if ($row.hasClass('no-data-row')) return;
                total += parseFloat($row.data('amount')) || 0;
            });
            $('#staff_total_undeposited_front').text(total.toFixed(2));
        }

        function updateBulkButtonState() {
            const checkedCount = $('.payment-checkbox:checked').length;
            $('#mark_selected_deposited').prop('disabled', checkedCount === 0);
        }

        function markDeposited(paymentIds, $buttons) {
            if (!paymentIds.length) return;

            $buttons.prop('disabled', true);

            $.ajax({
                url: '{{ route('deposits.mark-deposited') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_ids: paymentIds,
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(function() {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to mark payments as deposited.';
                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error',
                    });
                    $buttons.prop('disabled', false);
                },
            });
        }

        $('#staff_filter_route').on('change', function() {
            const filterRoute = $(this).val() || '';

            $('#undeposited_cash_table tbody tr').each(function() {
                const $row = $(this);
                if ($row.hasClass('no-data-row')) return;

                const routeId = String($row.data('route-id') || '');
                if (!filterRoute || routeId == filterRoute) {
                    $row.show();
                } else {
                    $row.hide();
                    $row.find('.payment-checkbox').prop('checked', false);
                }
            });

            $('#select_all_payments').prop('checked', false);
            updateStaffTotals();
            updateBulkButtonState();
        });

        $('#select_all_payments').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#undeposited_cash_table tbody tr:visible .payment-checkbox').prop('checked', isChecked);
            updateBulkButtonState();
        });

        $(document).on('change', '.payment-checkbox', function() {
            const visibleCheckboxes = $('#undeposited_cash_table tbody tr:visible .payment-checkbox');
            const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.filter(':checked').length === visibleCheckboxes.length;
            $('#select_all_payments').prop('checked', allChecked);
            updateBulkButtonState();
        });

        $('#mark_selected_deposited').on('click', function() {
            const paymentIds = $('.payment-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (!paymentIds.length) return;

            Swal.fire({
                title: 'Mark as deposited?',
                text: 'Mark ' + paymentIds.length + ' payment(s) as deposited?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, mark deposited',
                cancelButtonText: 'Cancel',
            }).then(function(result) {
                if (result.isConfirmed) {
                    markDeposited(paymentIds, $('#mark_selected_deposited, .mark-single-deposited-btn'));
                }
            });
        });

        $(document).on('click', '.mark-single-deposited-btn', function() {
            const paymentId = $(this).data('payment-id');
            const $btn = $(this);

            Swal.fire({
                title: 'Mark as deposited?',
                text: 'Confirm this cash payment has been deposited.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, mark deposited',
                cancelButtonText: 'Cancel',
            }).then(function(result) {
                if (result.isConfirmed) {
                    markDeposited([paymentId], $btn);
                }
            });
        });

        const $undepositedTable = $('#undeposited_cash_table');
        let undepositedDataTable = null;

        if ($undepositedTable.length && !$undepositedTable.find('tbody tr.no-data-row').length) {
            undepositedDataTable = $undepositedTable.DataTable({
                searching: true,
                bLengthChange: false,
                paging: true,
                info: true,
                ordering: false,
                drawCallback: function() {
                    updateStaffTotals();
                    updateBulkButtonState();
                },
            });

            $(document).on('input', '.custom_search_box', function() {
                if (undepositedDataTable) {
                    undepositedDataTable.search($(this).val()).draw();
                }
            });
        }

        updateStaffTotals();
        updateBulkButtonState();
    });
</script>
@endpush
