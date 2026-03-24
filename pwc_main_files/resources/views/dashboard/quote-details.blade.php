@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{url('quote')}}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Quote Details</h2>

    </div>
@endsection
@section('content')
        <section class="client_details">
            <div class="container-fluid custom_container">
                <div class="row custom_row">
                    <div class="col-md-12">
                        <div class="shadow_box_wrapper">
                            <div class="custom_details_wrapper">
                                <div class="client_info">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <div class="custom_justify_between">
                                                <h2>Muller Honda</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label>Email :</label>
                                                <span>mhonda@gmail.com</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label>Phone :</label>
                                                <span>+ 305 0451 0514</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="txt_field_wrapper">
                                                <label>Date Created :</label>
                                                <span>12-04-2024</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="client_location">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <h3>Location</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field_wrapper">
                                                <label>Address :</label>
                                                <span>It is a long established fact that a reader will be distracted by the readable content of a page</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Street Number :</label>
                                                <span>04</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>City :</label>
                                                <span>New York</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Zip Code :</label>
                                                <span>10054</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 card_alignment">
                                            <h3>Message</h3>
                                            <div class="txt_field_wrapper">
                                                <label>Address :</label>
                                                <span>It is a long established fact that a reader will be distracted by the readable content of a page</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="client_service_detail">
                                    <div class="row custom_row">
                                        <div class="col-md-6">
                                            <div class="">
                                                <h3>Window Cleaning</h3>
                                                <span class="primary">Exterior</span>
                                                <span class="primary">Interior</span>
                                            </div>

                                            {{--<div class="custom_justify_between">--}}
                                                {{--<div class="txt_field_wrapper">--}}
                                                    {{--<label>Cost :</label>--}}
                                                    {{--<span>$451.51</span>--}}
                                                {{--</div>--}}
                                                {{--<div class="txt_field_wrapper">--}}
                                                    {{--<label>Bonus :</label>--}}
                                                    {{--<span>$50.00</span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom_justify_between">
                                                <h3>Property Status</h3>
                                                <span class="primary">Cash</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">
                                                <h3>Pressure Washing</h3>
                                                <span class="primary">house</span>
                                                <span class="primary">Driveway</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="clients_tab">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-images-tab" data-bs-toggle="pill" data-bs-target="#pills-images" type="button" role="tab" aria-controls="pills-images" aria-selected="false">Images</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab" tabindex="0">
                                    <div class="clients_detail_images">
                                        <div class="custom_images">
                                            <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                        </div>
                                        <div class="custom_images">
                                            <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                        </div>
                                        <div class="custom_images">
                                            <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                        </div>
                                        <div class="custom_images">
                                            <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('js')

@endpush
