@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{url('contacts')}}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Quote Detail</h2>

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
                                            <h2>{{$contact->name??'Not Available'}}</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Email :</label>
                                            <span>{{$contact->email??'Not Available'}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Phone :</label>
                                            <span>{{ substr_replace(substr_replace( '+' . $contact->phone ??'', '-', 4, 0), '-', 8, 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Date Created :</label>
                                            <span>{{$contact->created_at->format('m-d-Y')??'Not Available'}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="client_location">
                                <div class="row custom_row">
                                    <div class="col-md-12">
                                        <h3>Location</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Address :</label>
                                            <span>{{$contact->address??'Not Available'}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>City :</label>
                                            <span>{{$contact->city??'Not Available'}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Street Number :</label>
                                            <span>{{$contact->street_number??'Not Available'}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="txt_field_wrapper">
                                            <label>Zip Code :</label>
                                            <span>{{$contact->zip_code??'Not Available'}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 card_alignment">
                                        <h3>Message</h3>
                                        <div class="txt_field_wrapper">
{{--                                            <label>Address :</label>--}}
                                            <label>{{$contact->message??'Not Available'}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="client_service_detail">
                                <div class="row custom_row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <h3>Window Cleaning</h3>
                                            @foreach($contact->contactSiding as $cleaning)
                                                <span class="primary">{{$cleaning->cleaning_side??'Not Available'}}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <h3>Property Status</h3>
                                            <span class="primary">{{$contact->property_status??''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="">
                                            <h3>Pressure Washing</h3>
                                            @foreach($contact->contactWashing as $washing)
                                                <span class="primary">{{$washing->type??'Not Available'}}</span>
                                            @endforeach
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
                                    @foreach($contact->contactImage as $image)
                                        <div class="custom_images">
                                            <img src="{{ asset('website') }}/{{ $image->image ?? 'assets/images/customer_reviews_img.jpg' }}">
                                        </div>
                                    @endforeach
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
