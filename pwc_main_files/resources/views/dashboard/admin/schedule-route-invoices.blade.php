@extends('theme.layout.master')
@push('css')
@endpush

@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="{{ url()->previous() }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">{{ $route->name }} - Client Invoices</h2>
    </div>
@endsection

@section('content')
    <section class="client_management staff_manag">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="clients_tab custom_justify_between pb-3">
                            <h4>Invoice Period: {{ \Carbon\Carbon::parse($start_date)->format('M d, Y') }}
                                - {{ \Carbon\Carbon::parse($end_date)->format('M d, Y') }}</h4>
                            <h4 class="text-primary">Total Route Amount:
                                ${{ number_format($totalInvoiceAmount, 2) }}</h4>
                        </div>

                        <div class="custom_table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Service Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($allPayments as $payment)
                                        <tr>
                                            <td>{{ $payment['client_name'] }}</td>
                                            <td>{{ $payment['service_date'] }}</td>
                                            <td>${{ number_format($payment['payment_amount'], 2) }}</td>
                                            <td>{{ $payment['status'] }}</td>
                                            <td>
                                                <a href="{{ route('client.invoices', $payment['invoice_id']) }}?start_date={{ $payment['start_date'] }}&end_date={{ $payment['end_date'] }}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye" style="padding-right: 0px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No client invoices found for this
                                                period.
                                            </td>
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
@endsection

@push('js')
    <script>
    </script>
@endpush
