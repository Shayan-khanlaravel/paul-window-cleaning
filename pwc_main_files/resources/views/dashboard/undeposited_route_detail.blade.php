@extends('theme.layout.master')

@push('css')
<style>
    /* ===========================
       Route Detail Page Styles
       =========================== */

    .udrd-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }
    .udrd-header__left {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .udrd-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #8a9ab5;
    }
    .udrd-breadcrumb a {
        color: #00ADEE;
        text-decoration: none;
        font-weight: 600;
    }
    .udrd-breadcrumb a:hover { text-decoration: underline; }
    .udrd-breadcrumb i { font-size: 10px; }

    .udrd-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .udrd-title .udrd-route-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #00ADEE 0%, #0082b3 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 173, 238, 0.35);
    }

    .udrd-summary-pills {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .udrd-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 16px;
        border-radius: 10px;
        min-width: 140px;
    }
    .udrd-pill--blue {
        background: linear-gradient(135deg, #e8f7fd 0%, #cceffc 100%);
        border: 1px solid rgba(0, 173, 238, 0.25);
    }
    .udrd-pill--orange {
        background: linear-gradient(135deg, #fff5e8 0%, #ffe4c0 100%);
        border: 1px solid rgba(255, 150, 30, 0.25);
    }
    .udrd-pill__icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        color: #fff;
    }
    .udrd-pill--blue .udrd-pill__icon { background: #00ADEE; }
    .udrd-pill--orange .udrd-pill__icon { background: #f0830a; }
    .udrd-pill__body { display: flex; flex-direction: column; gap: 1px; }
    .udrd-pill__label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #5a6a7a;
    }
    .udrd-pill__value {
        font-size: 18px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        line-height: 1.1;
    }

    .udrd-header__right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .udrd-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f4f6fb;
        color: #32346A;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none !important;
        border: 1px solid #e0e3ef;
        transition: background 0.2s ease;
        font-family: 'Hellix-SemiBold', sans-serif;
    }
    .udrd-back-btn:hover { background: #e8eaf0; color: #32346A !important; }

    .udrd-deposit-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: linear-gradient(135deg, #00ADEE 0%, #0082b3 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s ease, transform 0.15s ease;
        box-shadow: 0 4px 14px rgba(0, 173, 238, 0.35);
        font-family: 'Hellix-SemiBold', sans-serif;
    }
    .udrd-deposit-btn:hover:not(:disabled) {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .udrd-deposit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    .udrd-deposit-btn.loading {
        pointer-events: none;
        opacity: 0.75;
    }

    /* Transaction Table Wrapper */
    .udrd-table-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e8eaf0;
        box-shadow: 0 2px 12px rgba(50, 52, 106, 0.06);
    }
    .udrd-table-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f3fb 100%);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e8eaf0;
    }
    .udrd-table-header__title {
        font-size: 15px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .udrd-table-header__title i {
        color: #00ADEE;
        font-size: 14px;
    }

    /* Empty state */
    .udrd-empty {
        text-align: center;
        padding: 60px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .udrd-empty__icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #edfdf4 0%, #c8f5e0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #27ae60;
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.2);
        margin-bottom: 8px;
    }
    .udrd-empty h4 {
        font-size: 18px;
        font-weight: 700;
        color: #32346A;
        margin: 0;
    }
    .udrd-empty p { font-size: 14px; color: #8a9ab5; margin: 0; }

    /* Responsive */
    @media (max-width: 767px) {
        .udrd-header { flex-direction: column; align-items: stretch; }
        .udrd-header__right { justify-content: stretch; }
        .udrd-back-btn, .udrd-deposit-btn { flex: 1; justify-content: center; }
        .udrd-summary-pills { flex-direction: column; }
        .udrd-pill { min-width: unset; width: 100%; }
    }
</style>
@endpush

@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Undeposited Cash — Route Details</h2>
    </div>
@endsection

@section('content')
<section class="client_management staff_manag complete_jobs_section">
    <div class="container-fluid custom_container">
        <div class="row">
            <div class="col-md-12">
                <div class="custom_div">

                    {{-- Header --}}
                    <div class="udrd-header">
                        <div class="udrd-header__left">
                            <div class="udrd-breadcrumb">
                                <a href="{{ route('deposits.index') }}"><i class="fa-solid fa-wallet"></i> Undeposited Cash</a>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span>{{ $route->name ?? 'Route' }}</span>
                            </div>
                            <h2 class="udrd-title">
                                <span class="udrd-route-icon"><i class="fa-solid fa-route"></i></span>
                                {{ $route->name ?? 'Route' }}
                            </h2>
                            <div class="udrd-summary-pills">
                                <div class="udrd-pill udrd-pill--blue">
                                    <div class="udrd-pill__icon"><i class="fa-solid fa-sack-dollar"></i></div>
                                    <div class="udrd-pill__body">
                                        <span class="udrd-pill__label">Total Undeposited</span>
                                        <span class="udrd-pill__value">${{ number_format($totalAmount ?? 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="udrd-pill udrd-pill--orange">
                                    <div class="udrd-pill__icon"><i class="fa-solid fa-receipt"></i></div>
                                    <div class="udrd-pill__body">
                                        <span class="udrd-pill__label">Transactions</span>
                                        <span class="udrd-pill__value">{{ count($cashPayments ?? []) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="udrd-header__right">
                            <a href="{{ route('deposits.index') }}" class="udrd-back-btn">
                                <i class="fa-solid fa-arrow-left"></i> Back to Routes
                            </a>
                            <button type="button"
                                    class="udrd-deposit-btn"
                                    id="mark_route_deposited_btn"
                                    {{ empty($cashPayments) ? 'disabled' : '' }}
                                    data-route-id="{{ $route->id }}"
                                    data-route-name="{{ $route->name ?? 'Route' }}"
                                    data-record-count="{{ count($cashPayments ?? []) }}"
                                    data-total-amount="{{ number_format($totalAmount ?? 0, 2) }}">
                                <i class="fa-solid fa-check-circle"></i>
                                Mark All as Deposited
                            </button>
                        </div>
                    </div>

                    {{-- Transaction Table --}}
                    <div class="udrd-table-card">
                        <div class="udrd-table-header">
                            <h5 class="udrd-table-header__title">
                                <i class="fa-solid fa-list-ul"></i>
                                Individual Transactions
                            </h5>
                        </div>

                        @if(($cashPayments ?? collect())->isEmpty())
                            <div class="udrd-empty">
                                <div class="udrd-empty__icon"><i class="fa-solid fa-circle-check"></i></div>
                                <h4>No Records Found</h4>
                                <p>There are no undeposited cash payments for this route.</p>
                            </div>
                        @else
                            <div class="custom_table">
                                <div class="table-responsive">
                                    <table class="table myTable" id="route_detail_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client</th>
                                                <th>Amount</th>
                                                <th>Date Serviced</th>
                                                <th>Payment Received</th>
                                                <th>Route</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cashPayments ?? [] as $index => $payment)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $payment->client?->name ?? 'N/A' }}</strong>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight:700; color:#00ADEE; font-size:15px;">
                                                            ${{ number_format($payment->final_price ?? 0, 2) }}
                                                        </span>
                                                    </td>
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
                                                    <td>{{ $payment->route_name ?? ($route->name ?? 'N/A') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">No records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        // Mark All as Deposited
        $('#mark_route_deposited_btn').on('click', function() {
            const $btn = $(this);
            const routeId    = $btn.data('route-id');
            const routeName  = $btn.data('route-name');
            const recordCount = $btn.data('record-count');
            const totalAmount = $btn.data('total-amount');

            Swal.fire({
                title: 'Mark all as deposited?',
                html: `<p style="margin:0;font-size:15px;">Deposit <strong>${recordCount}</strong> ${recordCount === 1 ? 'record' : 'records'} totaling <strong>$${totalAmount}</strong> for <strong>${routeName}</strong>?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-check-circle"></i> Yes, mark all deposited',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#00ADEE',
                cancelButtonColor: '#6c757d',
                reverseButtons: false,
            }).then(function(result) {
                if (!result.isConfirmed) return;

                $btn.prop('disabled', true).addClass('loading')
                    .html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

                $.ajax({
                    url: '{{ route('deposits.mark-route-deposited', ':routeId') }}'.replace(':routeId', routeId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Deposited!',
                            text: response.message || 'All records marked as deposited successfully.',
                            icon: 'success',
                            timer: 2500,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        }).then(function() {
                            window.location.href = '{{ route('deposits.index') }}';
                        });
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Failed to mark records as deposited.';
                        Swal.fire({
                            title: 'Error',
                            text: message,
                            icon: 'error',
                            confirmButtonColor: '#00ADEE',
                        });
                        $btn.prop('disabled', false).removeClass('loading')
                            .html('<i class="fa-solid fa-check-circle"></i> Mark All as Deposited');
                    }
                });
            });
        });
    });
</script>
@endpush
