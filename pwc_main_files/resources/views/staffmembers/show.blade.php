@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="{{ url('staffmembers') }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Assign Route</h2>
    </div>
@endsection
@section('content')
    @if (auth()->user()->hasRole('admin'))
        <section class="create_staff_member_two_sec">
            <div class="container-fluid custom_container">
                <div class="row custom_row">
                    <div class="col-md-8">
                        <div class="staff_member_routes shadow_box_wrapper">
                            <div class="">
                                <img src="{{ asset('website') }}/{{ $staff->profile->pic ?? '' }}" alt="No Image">
                            </div>

                            <div class="">
                                <h3>{{ $staff->name ?? '' }}</h3>
                                <div class="create-staff_mem_discription">
                                    <div>
                                        <label>Email :</label>

                                        <span>{{ $staff->email ?? '' }}</span>
                                    </div>
                                    <div>
                                        <label>Phone :</label>
                                        {{--                                        <span>+ 305 0451 0514</span> --}}
                                        <span>{{ $staff->profile->phone ?? 'Not Available' }}</span>
                                    </div>
                                </div>
                                <div>
                                    <form action="{{ route('staffmembers.toggle-status', $staff->id) }}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                                class="btn_global {{ $staff->status == 1 ? 'btn_dark_blue' : 'btn_grey' }}">
                                            {{ $staff->status == 1 ? 'Deactivate' : 'Activate' }}
                                            <i
                                                class="fa-solid {{ $staff->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    {{--                                    <button type="button" class="btn_global btn_red">Delete<i class="fa-regular fa-trash-can"></i></button> --}}
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['staffmembers.destroy', $staff->id],
                                        'class' => 'delete-form',
                                    ]) !!}
                                    <button type="button" class="btn_global btn_red"
                                            onclick="showDeleteConfirmation(this)">
                                        Delete <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    {!! Form::close() !!}
                                    <button type="button" class="btn_global btn_dark_blue" id="togglePasswordBtn">
                                        <span id="password-hidden-text">Show Password</span>
                                        <span id="password-visible-text"
                                              style="display: none;">{{ $staff->profile->plain_password ?? 'Not Available' }}</span>
                                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="row custom_row">
                            <div class="col-md-12">
                                <div class="jobs_completed_wrapper shadow_box_wrapper">
                                    <h4>Jobs Completed :</h4>
                                    <h3>{{$staff->staff_jobs_count ?? '0'}}</h3>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="jobs_completed_wrapper shadow_box_wrapper">
{{--                                    <h4>In-Progress Project :</h4>--}}
{{--                                    <h3>11</h3>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="tabs_wrapper shadow_box_wrapper custom_row">
                            <div class="create_staff_tabs_btn_wrapper">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                                data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                                aria-selected="true">All</button>
                                    </li> 
                                </ul>
                            </div>
                            <div class="filter_download_dropdown_wrapper"> 
                                <div class="searchbar_download_filter_wrapper ms-auto">
                                    <form class="" role="search">
                                        <div>
                                            <input class="form-control searchInput" type="search" placeholder="Search"
                                                   aria-label="Search">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </div>
                                    </form>
                                    <button type="button" class="btn_global btn_blue" data-bs-target="#assign_routes"
                                            data-bs-toggle="modal">Assign Routes <i class="fa-solid fa-plus"></i></button> 
                                </div>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel"
                                     aria-labelledby="all-tab">
                                    <div class="row">
                                        @forelse($staffRoute as $item)
                                            <div class="col-md-3">
                                                <div class="new_yorks-cards_wrapper tab-content">
                                                    <div>
                                                        <h2>{{ $item->routeStaff->name ?? '' }}</h2>
                                                        <div class="jobs_icon_wrapper">
                                                            <div>
                                                                <div>
                                                                    <label>Jobs Pending</label>
                                                                    <span>0</span>
                                                                </div>
                                                                <div>
                                                                    <label>Jobs Completed:</label>
                                                                    <span>0</span>
                                                                </div>
                                                            </div>
                                                            <a href="{{ url('staffroutes', [$item->route_id]) }}">
                                                                <div>
                                                                    <img
                                                                        src="{{ asset('website') }}/assets/images/Arrow-up-right_white.svg">
                                                                </div>
                                                            </a>

                                                        </div>
                                                    </div>
                                                    <div class="completed_wrapper">
                                                        <i class="fa-solid fa-check"></i>
                                                        <h5>Completed</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div> No Assign Routes Available</div>
                                        @endforelse
                                    </div>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- download pdf modal --}}
        <div class="modal fade new_route download_pdf_modal_sec" id="new_route" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h2 class="modal-title" id="exampleModalLabel1">Download PDF</h2>
                            <p>Select multiple routes to download PDFs</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @forelse($staffRoute as $assigned)
                            <div class="download_modal_pdf_wrapper">
                                <div>
                                    <input type="radio" name="route_id[]" class="route_ids"
                                           value="{{ $assigned->routeStaff->id ?? '' }}"
                                           id="route_{{ $assigned->routeStaff->id ?? '' }}">
                                    <label
                                        for="route_{{ $assigned->routeStaff->id ?? '' }}">{{ $assigned->routeStaff->name ?? '' }}</label>
                                </div>
                                <h4>Clients: {{ count($assigned->getClientCount ?? '') }}</h4>
                                {{--       <h4>Clients: 87</h4> --}}
                            </div>
                        @empty
                            <div>No Assign Route Available</div>
                        @endforelse
                    </div>
                    <div class="modal-footer custom_justify_between">
                        <button type="button" class="btn_global btn_grey " data-bs-dismiss="modal"
                                aria-label="Close">Cancel <i class="fa-solid fa-x"></i> </button>
                        <button type="submit" class="btn_global btn_blue printBtn">Download <i
                                class="fa-solid fa-download"></i> </button>

                    </div>
                </div>
            </div>
        </div>
        {{-- assign routes modal --}}
        <div class="modal fade new_route download_pdf_modal_sec" id="assign_routes" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel2">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form method="post" action="{{ route('assignroutes.store') }}" id="assignStaff"
                          class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <div>
                                <h2 class="modal-title" id="exampleModalLabel1">Assign Routes</h2>
                                <p>Select multiple routes to assign to staff</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @forelse($route as $assigned)
                                <div class="download_modal_pdf_wrapper">
                                    <div>
                                        <input type="checkbox" name="route_id[]"
                                            @if (in_array($assigned->id, $staff->staffRoute->pluck('id')->toArray())) checked @endif
                                            {{ $assigned->status == 0 ? 'disabled' : '' }}
                                            value="{{ $assigned->id }}" id="route_{{ $assigned->id }}">

                                        <label for="route_{{ $assigned->id }}">
                                            {{ $assigned->name }}
                                            @if($assigned->status == 0)
                                                <span style="color: red;">(Inactive)</span>
                                            @endif
                                        </label>
                                    </div>
                                    <h4>Clients: {{ count($assigned->clientRoute ?? '') }}</h4>
                                    {{--                                    <h4>Clients: 87</h4> --}}
                                </div>
                            @empty
                                <div>No Assign Route Available</div>
                            @endforelse
                            <input type="hidden" name="staff_id" value="{{ $staff->id ?? '' }}">
                        </div>
                        <div class="modal-footer custom_justify_between">
                            <button type="button" class="btn_global btn_grey" data-bs-dismiss="modal"
                                    aria-label="Close">Cancel <i class="fa-solid fa-x"></i></button>
                            <button type="submit" class="btn_global btn_blue">Assign Route<i
                                    class="fa-solid fa-download"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_clients_sec_staff">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="row custom_row">
                                <div class="col-md-12">
                                    <div class="create_clients_wrapper_staff shadow_box_wrapper">
                                        <div class="custom_justify_between">
                                            <div class="custom_radio">
                                                <input class="form-check-input" type="checkbox" value=""
                                                       id="muler_honda">
                                                <label class="form-check-label" for="muler_honda">Starbuks</label>
                                                <span>(Cash)</span>
                                            </div>
                                            <h3>$250.00</h3>
                                        </div>
                                        <div class="custom_partially_changed">
                                            <div class="row custom_row">
                                                <div class="col-md-4 custom_no_change">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="com_no_change">
                                                        <label class="form-check-label" for="com_no_change">Completed
                                                            no
                                                            Change</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 custom_date_service">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="date_of_service">
                                                        <label class="form-check-label" for="date_of_service">Date of
                                                            Service</label>
                                                        <input type="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="recievedPayment">
                                                        <label class="form-check-label"
                                                               for="recievedPayment">Completed
                                                            but did not receive payment</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="partiallyCompleted">
                                                        <label class="form-check-label"
                                                               for="partiallyCompleted">Partially
                                                            Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="reason">
                                                        <label class="form-check-label" for="reason">Reason</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="priceCharged">
                                                        <label class="form-check-label" for="priceCharged">Price
                                                            Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="priorDate">
                                                        <label class="form-check-label" for="priorDate">Paid on prior
                                                            date
                                                            of service</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="extraPaid">
                                                        <label class="form-check-label" for="extraPaid">Paid extra
                                                            for<input class="form-check-input" type="number"
                                                                      placeholder="#">dates</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="amount">
                                                        <label class="form-check-label" for="amount">Amount</label>
                                                    </div>
                                                    <p>Please Enter Amount</p>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="workCompleted">
                                                        <label class="form-check-label" for="workCompleted">Extra Work
                                                            Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="workScope">
                                                        <label class="form-check-label" for="workScope">Scope</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="extraPriceCharged">
                                                        <label class="form-check-label" for="extraPriceCharged">Price
                                                            Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="omit">
                                                        <label class="form-check-label" for="omit">Omit</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="" id="omitReason">
                                                        <label class="form-check-label"
                                                               for="omitReason">Reason</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="shadow_box_wrapper cash_flow">
                                        <div class="row">
                                            <div class="col-md-3 custom_column">
                                                <div class="custom_cash_check">
                                                    <div class="cash_received">
                                                        <h4>Total Cash Received</h4>
                                                    </div>
                                                    <div class="multiple_select_field">
                                                        <div class="custom_radio">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="" id="selectA">
                                                            <label class="form-check-label" for="selectA">A</label>
                                                        </div>
                                                        <div class="custom_radio">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="" id="depositDate">
                                                            <label class="form-check-label" for="depositDate">Date of
                                                                Deposit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 custom_column">
                                                <div class="custom_cash_check">
                                                    <div class="cash_received">
                                                        <h4>Total Billed</h4>
                                                    </div>
                                                    <div class="multiple_select_field">
                                                        <div class="custom_radio">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="" id="selectB">
                                                            <label class="form-check-label" for="selectB">B</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 custom_column">
                                                <div class="custom_cash_check">
                                                    <div class="cash_received">
                                                        <h4>Total Gros Sale</h4>
                                                    </div>
                                                    <div class="multiple_select_field">
                                                        <div class="custom_radio">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="" id="selectC">
                                                            <label class="form-check-label" for="selectC">C</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 custom_column"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom_justify_between">
                                        <button type="button" class="btn_global btn_grey">Cancel<i
                                                class="fa-solid fa-close"></i></button>
                                        <button type="submit" class="btn_global btn_blue">Create<i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('js')
    {{-- searchbar functionality --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.searchInput').on('input', function() {
                var filter = $(this).val().toLowerCase();

                $('.tab-content').each(function() {
                    var h2Text = $(this).find('h2').text().toLowerCase();
                    if (h2Text.includes(filter)) {
                        $(this).show(); // Show the matching element
                    } else {
                        $(this).hide(); // Hide the non-matching element
                    }
                });
            });

            // Toggle Password Visibility
            $('#togglePasswordBtn').on('click', function() {
                var passwordHiddenText = $('#password-hidden-text');
                var passwordVisibleText = $('#password-visible-text');
                var eyeIcon = $('#eyeIcon');

                if (passwordVisibleText.is(':visible')) {
                    passwordVisibleText.hide();
                    passwordHiddenText.show();
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    passwordVisibleText.show();
                    passwordHiddenText.hide();
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#assignStaff").validate({
                rules: {
                    'route_id[]': {
                        required: true,
                        minlength: 1
                    }
                },
                errorPlacement: function(error, element) {
                    return false;
                },
                invalidHandler: function(event, validator) {
                    if (validator.errorList.length) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Please Assign Atleast One Route!!!',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.printBtn', function() {
            var selected_month = $('.selected_month_ajax').attr('selected-month');
            var staff_route_id = [];

            $(document).find('.route_ids:checked').each(function() {
                staff_route_id.push($(this).val());
            });
            console.log(staff_route_id)

            if (selected_month && staff_route_id) {
                var downloadUrl = '{{ url('route-details-pdf') }}?selected_month=' + encodeURIComponent(
                    selected_month) + '&id=' + encodeURIComponent(staff_route_id);
                window.location.href = downloadUrl;
            } else {
                alert("Please select a valid month and at least one route.");
            }
        });
    </script>
@endpush
