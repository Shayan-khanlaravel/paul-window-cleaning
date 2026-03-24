@extends('theme.layout.master')

@push('css')
    <style>
        .custom_row {
            row-gap: 8px !important;
        }
    </style>
@endpush

@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="javascript:void(0);" id="goBackBtn">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Invoice Details</h2>
    </div>
@endsection

@section('content')
    <section class="create_clients_sec_staff">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row custom_row">
                        <!-- Client Information -->
                        <div class="col-md-6">
                            <div class="create_clients_wrapper_staff shadow_box_wrapper">
                                <div class="custom_justify_between mb-3" style="padding-bottom: 13px; padding-top: 8px">
                                    <h4 class="text-primary">Client Information</h4>
                                </div>
                                <div class="client_info_details">
                                    <div class="row custom_row">
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Name:</strong></label>
                                                <span>{{ $client->name ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Email:</strong></label>
                                                <span>{{ $client->contact_email ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Phone:</strong></label>
                                                <span>{{ $client->contact_phone ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="custom_justify_between mb-3" style="padding-bottom: 0px">
                                            <h6 class="text-primary">Service Location</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Name:</strong></label>
                                                <span>{{ $client->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Address:</strong></label>
                                                @php
                                                    $parts = array_filter([$client->address ?? null, $client->city ?? null, $client->state ?? null, $client->zip_code ?? null]);
                                                @endphp

                                                <span><strong>{{ $parts ? implode(', ', $parts) : 'Not Available' }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="col-md-6">
                            <div class="create_clients_wrapper_staff shadow_box_wrapper">
                                <div class="custom_justify_between mb-3" style="padding-bottom: 5px;">
                                    <h4 class="text-primary">Payment Information</h4>
                                    <div class="d-flex gap-2">
                                        @if ($payment->payment_status == 'paid')
                                            {{-- Payment already completed --}}
                                        @else
                                            {{-- QuickBooks Invoice Button (Original) --}}
                                            @if ($client->quickbooks_customer_id)
                                                @if ($payment->quickbooks_synced ?? false)
                                                    <button type="button" class="btn btn-success btn-sm" disabled>
                                                        <i class="fas fa-check-circle"></i> QB Invoice Created
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-info btn-sm"
                                                        id="create-qb-invoice-btn">
                                                        <i class="fab fa-quickbooks"></i> Create Again
                                                    </button> --}}
                                                @else
                                                    <button type="button" class="btn btn-info btn-sm" id="create-qb-invoice-btn">
                                                        <i class="fab fa-quickbooks"></i> Create QB Invoice
                                                    </button>
                                                @endif
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled title="Client not synced to QuickBooks">
                                                    <i class="fab fa-quickbooks"></i> QB Invoice
                                                </button>
                                            @endif

                                            {{-- @if ($canSendInvoice)
                                                <form id="send-invoice-form" action="{{ route('send.invoice.email') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-envelope"></i> Send System Invoice
                                                    </button>
                                                </form>
                                            @else
                                                <div class="d-flex gap-2 align-items-center">
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Send
                                                        Invoice</button>
                                                    @if ($isBranch && $parentClient)
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="showConfigureOptions('{{ route('clients.edit', $parentClient->id) }}', '{{ route('clients.edit', $client->id) }}')">
                                                            Configure Invoice Email
                                                        </button>
                                                    @else
                                                        <a href="{{ route('clients.edit', $client->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            Configure Invoice Email
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif --}}
                                        @endif
                                    </div>
                                </div>
                                <div class="payment_info_details">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Payment Type:</strong></label>
                                                <span class="badge badge-primary">{{ ucfirst($payment->payment_type) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Status:</strong></label>
                                                <span class="badge badge-info">{{ ucfirst($payment->option ?? 'pending') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Payment Status:</strong></label>
                                                <span class="badge badge-info">{{ ucfirst($payment->payment_status ?? 'pending') }}</span>
                                            </div>
                                        </div> 
                                        {{-- QuickBooks Synced --}}
                                        @if ($payment->quickbooks_synced ?? false)
                                            <div class="col-md-12">
                                                <div class="txt_field_wrapper">
                                                    <label><strong>QuickBooks Invoice:</strong></label>
                                                    <span class="badge badge-success">
                                                        <i class="fab fa-quickbooks"></i> Synced
                                                    </span>
                                                </div>
                                            </div>
                                            @if ($payment->quickbooks_invoice_number)
                                                <div class="col-md-12">
                                                    <div class="txt_field_wrapper">
                                                        <label><strong>QB Invoice Number:</strong></label>
                                                        <span class="text-primary font-weight-bold">
                                                            #{{ $payment->quickbooks_invoice_number }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($payment->quickbooks_synced_at)
                                                <div class="col-md-12">
                                                    <div class="txt_field_wrapper">
                                                        <label><strong>QB Synced At:</strong></label>
                                                        <span>{{ \Carbon\Carbon::parse($payment->quickbooks_synced_at)->format('F d, Y h:i A') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Service Date:</strong></label>
                                                <span>{{ $payment->created_at->format('F d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <h2 class="pricePlus text-success" style="font-size: 3.5rem">
                                                    ${{ number_format($payment->final_price, 2, '.', ',') }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="col-md-12 mt-3">
                            <div class="create_clients_wrapper_staff shadow_box_wrapper">
                                <div class="custom_justify_between mb-3">
                                    <h4 class="text-primary">Schedule Information</h4>
                                </div>
                                <div class="schedule_info_details">
                                    <div class="row custom_row">
                                        <div class="col-md-3">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Scope:</strong></label>
                                                <span>
                                                    {{ collect($clientSchedule->clientSchedulePrice ?? [])->pluck('clientPaymentPrice.name')->filter()->when(!empty($clientSchedule->extra_work), fn($c) => $c->push($clientSchedule->extra_work))->implode(', ') ?:
                                                        'Not Available' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Note:</strong></label>
                                                <span>{{ $clientSchedule->note ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Best Time:</strong></label>
                                                <span>
                                                    {{ collect($clientSchedule->clientHour ?? [])->map(fn($hour) => trim(($hour->start_hour ?? '') . ' - ' . ($hour->end_hour ?? '')))->filter()->implode(', ') ?:
                                                        '-' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="txt_field_wrapper">
                                                <label><strong>Status:</strong></label>
                                                <span class="badge badge-success">{{ ucfirst($clientSchedule->status) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details Section -->
                        @if ($payment->option || $payment->option_two || $payment->option_three || $payment->option_four || $payment->reason || $payment->scope || $payment->partial_completed_scope)
                            <div class="col-md-12 mt-3">
                                <div class="create_clients_wrapper_staff shadow_box_wrapper">
                                    <div class="custom_justify_between mb-3">
                                        <h4 class="text-primary">Payment Details</h4>
                                    </div>
                                    <div class="additional_details">
                                        <div class="row custom_row">

                                            <!-- Partially Completed Details -->
                                            @if ($payment->option == 'partially' && ($payment->partial_completed_scope || $payment->reason || $payment->price_charge_one))
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-info mb-2">Partially Completed Work</h5>
                                                        <div class="row">
                                                            @if ($payment->partial_completed_scope)
                                                                <div class="col-md-4">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Scope:</strong></label>
                                                                        <span>{{ $payment->partial_completed_scope }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($payment->reason)
                                                                <div class="col-md-4">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Reason:</strong></label>
                                                                        <span>{{ $payment->reason }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($payment->price_charge_one)
                                                                <div class="col-md-4">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Price:</strong></label>
                                                                        <span class="text-success">${{ number_format($payment->price_charge_one, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Extra Work Completed Details -->
                                            @if ($payment->option_two == 'extraWork' && ($payment->scope || $payment->price_charge_two))
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-success mb-2">Extra Work Completed</h5>
                                                        <div class="row">
                                                            @if ($payment->scope)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Scope:</strong></label>
                                                                        <span>{{ $payment->scope }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($payment->price_charge_two)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Price:</strong></label>
                                                                        <span class="text-success">${{ number_format($payment->price_charge_two, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($payment->option_three == 'logTime')
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-success mb-2">Log Time</h5>
                                                        <div class="row">
                                                            @if ($payment->start_time)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Start Time:</strong></label>
                                                                        <span>{{ $payment->start_time }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($payment->end_time)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>End Time:</strong></label>
                                                                        <span class="text-success">{{ $payment->end_time }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Omit Details -->
                                            @if ($payment->option == 'omit' && $payment->reason)
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-warning mb-2">Omitted Service</h5>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="txt_field_wrapper">
                                                                    <label><strong>Reason:</strong></label>
                                                                    <span>{{ $payment->reason }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- No Payment Received Details -->
                                            @if ($payment->option == 'no_payment' && $payment->reason)
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-danger mb-2">Payment Not Received</h5>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="txt_field_wrapper">
                                                                    <label><strong>Reason:</strong></label>
                                                                    <span>{{ $payment->reason }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Extra Payment for Dates -->
                                            @if ($payment->option_three == 'extra_paid_for_date' && ($payment->day_number || $payment->amount))
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-primary mb-2">Extra Payment for Dates</h5>
                                                        <div class="row">
                                                            @if ($payment->day_number)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Number of Days:</strong></label>
                                                                        <span>{{ $payment->day_number }} days</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($payment->amount)
                                                                <div class="col-md-6">
                                                                    <div class="txt_field_wrapper">
                                                                        <label><strong>Extra Amount:</strong></label>
                                                                        <span class="text-success">${{ number_format($payment->amount, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Prior Date Payment -->
                                            @if ($payment->option_two == 'paid_on_prior')
                                                <div class="col-md-12 mb-3">
                                                    <div class="payment_detail_row">
                                                        <h5 class="text-secondary mb-2">Prior Date Payment</h5>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="txt_field_wrapper">
                                                                    <span class="badge badge-secondary">Paid on prior date
                                                                        of service</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#goBackBtn').on('click', function(e) {
                e.preventDefault();
                window.history.back();
            });

            // QuickBooks Invoice Creation
            $('#create-qb-invoice-btn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Create QuickBooks Invoice?',
                    html: 'This will create an invoice in QuickBooks.<br><strong>QuickBooks will automatically send the invoice to the customer.</strong>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Create Invoice!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Creating Invoice...',
                            text: 'Please wait while we create the invoice in QuickBooks...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '{{ route('create.quickbooks.invoice') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                payment_id: '{{ $payment->id }}'
                            },
                            success: function(response) {
                                // Build success message
                                let successMessage =
                                    '<strong>Invoice created successfully in QuickBooks!</strong><br><br>' +
                                    'Invoice Number: <strong>#' + (response
                                        .invoice_number || 'N/A') + '</strong><br>' +
                                    'Amount: <strong>$' + (response.total_amount ||
                                        '0.00') + '</strong><br>';

                                // Add email status
                                if (response.email_sent) {
                                    successMessage +=
                                        '<br><span class="text-success"><i class="fas fa-check-circle"></i> Email sent to: <strong>' +
                                        (response.customer_email || 'customer') +
                                        '</strong></span>';
                                } else {
                                    successMessage +=
                                        '<br><span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Email could not be sent automatically.</span>';
                                    if (response.message && response.message.includes(
                                            'Error:')) {
                                        successMessage +=
                                            '<br><small class="text-muted">' + response
                                            .message.split('Error:')[1] + '</small>';
                                    }
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    html: successMessage,
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON && xhr.responseJSON
                                        .message ? xhr.responseJSON.message : 'Failed to create QuickBooks invoice. Please try again.'
                                });
                            }
                        });
                    }
                });
            });

            // SweetAlert for invoice send
            $('#send-invoice-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Processing...',
                    text: 'The invoice is being sent, please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'The invoice has been sent to all configured invoice emails along with the Stripe payment link!',
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON && xhr.responseJSON.message ? xhr
                                .responseJSON.message : 'Kuch masla hogaya hai, dobara koshish karein.'
                        });
                    }
                });
            });

        });

        // Configure Invoice Email SweetAlert - for Branch with 2 options
        function showConfigureOptions(parentUrl, branchUrl) {
            Swal.fire({
                title: 'Configure Invoice Email',
                text: 'Please choose which account to configure invoice email for:',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Configure Parent Account',
                denyButtonText: 'Configure Branch Account',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f0ad4e',
                denyButtonColor: '#17a2b8',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = parentUrl;
                } else if (result.isDenied) {
                    window.location.href = branchUrl;
                }
            });
        }
    </script>
@endpush
