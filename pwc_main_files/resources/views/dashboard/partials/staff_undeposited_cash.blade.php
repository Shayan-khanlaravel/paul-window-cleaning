<section class="client_management staff_manag complete_jobs_section">
    <div class="container-fluid custom_container">
        @php
            $grandTotal = collect($undepositedRoutes ?? [])->sum('total_amount');
            $grandCount = collect($undepositedRoutes ?? [])->sum('record_count');
        @endphp

        <div class="row">
            <div class="col-md-12">
                <div class="custom_div">

                    {{-- Page Header --}}
                    <div class="udc-header">
                        <div class="udc-header__left">
                            <h3 class="udc-header__title">Undeposited Cash</h3>
                            <div class="udc-summary-pills">
                                <div class="udc-pill udc-pill--blue">
                                    <div class="udc-pill__icon"><i class="fa-solid fa-sack-dollar"></i></div>
                                    <div class="udc-pill__body">
                                        <span class="udc-pill__label">Total Amount</span>
                                        <span class="udc-pill__value">${{ number_format($grandTotal, 2) }}</span>
                                    </div>
                                </div>
                                <div class="udc-pill udc-pill--purple">
                                    <div class="udc-pill__icon"><i class="fa-solid fa-layer-group"></i></div>
                                    <div class="udc-pill__body">
                                        <span class="udc-pill__label">Routes</span>
                                        <span class="udc-pill__value">{{ count($undepositedRoutes ?? []) }}</span>
                                    </div>
                                </div>
                                <div class="udc-pill udc-pill--green">
                                    <div class="udc-pill__icon"><i class="fa-solid fa-receipt"></i></div>
                                    <div class="udc-pill__body">
                                        <span class="udc-pill__label">Transactions</span>
                                        <span class="udc-pill__value">{{ $grandCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Route Cards Grid --}}
                    @if(($undepositedRoutes ?? collect())->isEmpty())
                        <div class="udc-empty">
                            <div class="udc-empty__icon"><i class="fa-solid fa-circle-check"></i></div>
                            <h4>All Caught Up!</h4>
                            <p>You have no undeposited cash payments at this time.</p>
                        </div>
                    @else
                        <div class="udc-routes-grid">
                            @foreach($undepositedRoutes ?? [] as $routeData)
                                <div class="udc-route-card">
                                    <div class="udc-route-card__header">
                                        <div class="udc-route-card__icon">
                                            <i class="fa-solid fa-route"></i>
                                        </div>
                                        <div class="udc-route-card__title-wrap">
                                            <h4 class="udc-route-card__title">{{ $routeData['route_name'] }}</h4>
                                            <span class="udc-route-card__badge">
                                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                                {{ $routeData['record_count'] }} {{ Str::plural('record', $routeData['record_count']) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="udc-route-card__body">
                                        <div class="udc-route-card__amount-label">Total Undeposited</div>
                                        <div class="udc-route-card__amount">${{ number_format($routeData['total_amount'], 2) }}</div>
                                    </div>

                                    <div class="udc-route-card__footer">
                                        <a href="{{ route('deposits.route-detail', $routeData['route_id']) }}"
                                           class="udc-route-card__btn">
                                            <span>View Details</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
    /* ===========================
       UDC = Undeposited Cash
       =========================== */

    /* Header */
    .udc-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 32px;
    }
    .udc-header__left {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .udc-header__title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
    }

    /* Summary Pills */
    .udc-summary-pills {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .udc-pill {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 10px 18px;
        border-radius: 12px;
        min-width: 160px;
    }
    .udc-pill--blue {
        background: linear-gradient(135deg, #e8f7fd 0%, #cceffc 100%);
        border: 1px solid rgba(0, 173, 238, 0.25);
        box-shadow: 0 4px 14px rgba(0, 173, 238, 0.1);
    }
    .udc-pill--purple {
        background: linear-gradient(135deg, #f0eeff 0%, #ddd8ff 100%);
        border: 1px solid rgba(100, 80, 220, 0.2);
        box-shadow: 0 4px 14px rgba(100, 80, 220, 0.08);
    }
    .udc-pill--green {
        background: linear-gradient(135deg, #edfdf4 0%, #c8f5e0 100%);
        border: 1px solid rgba(39, 174, 96, 0.2);
        box-shadow: 0 4px 14px rgba(39, 174, 96, 0.08);
    }
    .udc-pill__icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        color: #fff;
    }
    .udc-pill--blue .udc-pill__icon { background: #00ADEE; }
    .udc-pill--purple .udc-pill__icon { background: #6450dc; }
    .udc-pill--green .udc-pill__icon { background: #27ae60; }
    .udc-pill__body {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }
    .udc-pill__label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #5a6a7a;
    }
    .udc-pill__value {
        font-size: 20px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        line-height: 1.1;
    }

    /* Route Cards Grid */
    .udc-routes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 20px;
    }

    /* Route Card */
    .udc-route-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8eaf0;
        box-shadow: 0 4px 18px rgba(50, 52, 106, 0.07);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .udc-route-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #00ADEE, #32346A);
        border-radius: 16px 16px 0 0;
    }
    .udc-route-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(50, 52, 106, 0.13);
    }

    .udc-route-card__header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 20px 20px 12px 20px;
    }
    .udc-route-card__icon {
        width: 46px;
        height: 46px;
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
    .udc-route-card__title-wrap {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 0;
    }
    .udc-route-card__title {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .udc-route-card__badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(0, 173, 238, 0.1);
        color: #007DAC;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        width: fit-content;
    }
    .udc-route-card__badge i { font-size: 10px; }

    .udc-route-card__body {
        padding: 12px 20px 20px 20px;
        flex: 1;
        background: linear-gradient(180deg, #fafbff 0%, #f4f6fb 100%);
        border-top: 1px solid #eef0f6;
        border-bottom: 1px solid #eef0f6;
        text-align: center;
    }
    .udc-route-card__amount-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #8a9ab5;
        margin-bottom: 4px;
    }
    .udc-route-card__amount {
        font-size: 30px;
        font-weight: 700;
        color: #32346A;
        font-family: 'Hellix-Bold', sans-serif;
        letter-spacing: -0.5px;
    }

    .udc-route-card__footer {
        padding: 14px 20px;
    }
    .udc-route-card__btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px 20px;
        background: linear-gradient(135deg, #00ADEE 0%, #0082b3 100%);
        color: #fff !important;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none !important;
        transition: opacity 0.2s ease, transform 0.15s ease;
        box-shadow: 0 4px 12px rgba(0, 173, 238, 0.3);
        font-family: 'Hellix-SemiBold', sans-serif;
    }
    .udc-route-card__btn:hover {
        opacity: 0.92;
        transform: translateY(-1px);
    }
    .udc-route-card__btn i {
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    .udc-route-card:hover .udc-route-card__btn i {
        transform: translateX(3px);
    }

    /* Empty state */
    .udc-empty {
        text-align: center;
        padding: 60px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .udc-empty__icon {
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
    .udc-empty h4 {
        font-size: 20px;
        font-weight: 700;
        color: #32346A;
        margin: 0;
    }
    .udc-empty p {
        font-size: 14px;
        color: #8a9ab5;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .udc-summary-pills { flex-direction: column; }
        .udc-pill { min-width: unset; width: 100%; }
        .udc-routes-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
