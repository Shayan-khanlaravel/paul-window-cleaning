@extends('theme.layout.master')

@push('css')
    <!-- Include Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{url('clients')}}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Create Client</h2>
    </div>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
        <section class="create_clients_sec">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="create_clients_wrapper shadow_box_wrapper">
                            <form>
{{--                            <form method="post" action="{{route('clients.store')}}" class="form-horizontal" id="clientValidate" enctype="multipart/form-data">--}}
{{--                                @csrf--}}
                                <div class="row create_client_cus_row">
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="name" id="client_name" placeholder="" required>
                                            <label for="client_name">Client Name *</label>
                                            <p>Please Enter Client Name</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="number" class="form-control" name="phone" id="phone_number" placeholder="" required>
                                            <label for="phone_number">Phone Number *</label>
                                            <p>Please Enter Phone Number</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                                            <label for="phone_number">Email Address *</label>
                                            <p>Please Enter Email Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Location</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="street_number" id="street_number" placeholder="" required>
                                            <label for="street_number">Street Number *</label>
                                            <p>Please Enter Street Number</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="" required>
                                            <label for="address">Address *</label>
                                            <p>Please Enter Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="city" id="city" placeholder="" required>
                                            <label for="city">City *</label>
                                            <p>Please Enter City</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="" required>
                                            <label for="zip_code">Zip Code</label>
                                            <p>Please Enter Zip Code</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Client Type</h4>
                                        <div class="radio_btn_wrapper">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" value="commercial" name="client_type" id="commercial" checked>
                                                <label class="form-check-label" for="commercial">Commercial</label>
                                            </div>
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" value="residential" name="client_type" id="residential">
                                                <label class="form-check-label" for="residential">Residential</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-6">--}}
                                    {{--                                        <h4>Payment Type</h4>--}}
                                    {{--                                        <div class="radio_btn_wrapper">--}}
                                    {{--                                            <div class="form-check ">--}}
                                    {{--                                                <input class="form-check-input" type="radio" value="cash" name="payment_type" id="cash" checked>--}}
                                    {{--                                                <label class="form-check-label" for="cash">Cash</label>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="form-check ">--}}
                                    {{--                                                <input class="form-check-input" type="radio" value="invoice" name="payment_type" id="invoice">--}}
                                    {{--                                                <label class="form-check-label" for="invoice">Invoice</label>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-md-12">
                                        <h4>Frequency of Service</h4>
                                        <div class="cycle_frequency_wrapper">
                                            <div class="row create_client_cus_row">
                                                <div class="col-md-6">
                                                    <div class="radio_btn_wrapper">
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio" value="quarterly" name="service_frequency" id="quarterly" checked>
                                                            <label class="form-check-label" for="quarterly">4-week cycle</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio" value="eightWeek" name="service_frequency" id="eightWeek" checked>
                                                            <label class="form-check-label" for="eightWeek">8-week cycle</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio"  value="biweekly" name="service_frequency" id="bi_annually">
                                                            <label class="form-check-label" for="bi_annually">Bi- weekly</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio"  value="monthly" name="service_frequency" id="annually">
                                                            <label class="form-check-label" for="annually">Monthly</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="date" class="form-control" name="start_date" id="startDate" placeholder="">
                                                        <label for="startDate">Starting Date</label>
                                                        <p>Please Select Starting Date</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-12">
                                                    <h4>Please Select Best time to service</h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="time" class="form-control" name="start_hour" id="startDate" placeholder="">
                                                        <label for="startDate">Starting Hour</label>
                                                        <p>Please Select Starting Hour</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="time" class="form-control" name="end_hour" id="endDate" placeholder="">
                                                        <label for="endDate">Ending Hour</label>
                                                        <p>Please Select Ending Hour</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 append_service_time">
                                                    <div class="appended_items"></div>
                                                </div>
                                            </div>
                                            <div class="add_more_time">
                                                <button type="button" class="btn_global btn_grey">Add<i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Assign Week</h4>
                                        <div class="custom_checkbox_wrapper assign_week">
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="one" name="assign_week[0][week]" type="checkbox" data-id="0" id="week1">
                                                <label class="form-check-label" for="week1">Week 1</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="two" name="assign_week[1][week]" type="checkbox" data-id="1" id="week2">
                                                <label class="form-check-label" for="week2">Week 2</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="three" name="assign_week[2][week]" type="checkbox" data-id="2" id="week3">
                                                <label class="form-check-label" for="week3">Week 3</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="four" name="assign_week[3][week]" type="checkbox" data-id="3" id="week4">
                                                <label class="form-check-label" for="week4">Week 4</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="five" name="assign_week[4][week]" type="checkbox" data-id="4" id="week5">
                                                <label class="form-check-label" for="week5">Week 5</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="six" name="assign_week[5][week]" type="checkbox" data-id="5" id="week6">
                                                <label class="form-check-label" for="week6">Week 6</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="seven" name="assign_week[6][week]" type="checkbox" data-id="6" id="week7">
                                                <label class="form-check-label" for="week7">Week 7</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="eight" name="assign_week[7][week]" type="checkbox" data-id="7" id="week8">
                                                <label class="form-check-label" for="week8">Week 8</label>
                                            </div>
                                        </div>
                                        <div class="add_frequency_week_note"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="unbelivable_sec">
                                            <h4>Unavailable Days</h4>
                                            <div class="custom_checkbox_wrapper unavailable_days">
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="monday" name="unavail_day[]" id="mon">
                                                    <label for="mon">Monday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="tuesday" name="unavail_day[]" id="tue">
                                                    <label for="tue">Tuesday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="wednesday" name="unavail_day[]" id="wed">
                                                    <label for="wed">Wednesday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="thursday" name="unavail_day[]" id="thu">
                                                    <label for="thu">Thursday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="friday" name="unavail_day[]" id="fri">
                                                    <label for="fri">Friday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="saturday" name="unavail_day[]" id="sat">
                                                    <label for="sat">Saturday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="sunday" name="unavail_day[]" id="sun" disabled>
                                                    <label for="sun">Sunday</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-12">--}}
                                    {{--                                        <h4>Price</h4>--}}
                                    {{--                                        <div class="custom_cost_content">--}}
                                    {{--                                            <div class="row">--}}
                                    {{--                                                <div class="col-md-6">--}}
                                    {{--                                                    <div class="radio_btn_wrapper">--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="inside" name="price_type" id="inside" checked>--}}
                                    {{--                                                            <label class="form-check-label" for="inside">Inside</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="outside" name="price_type" id="outside">--}}
                                    {{--                                                            <label class="form-check-label" for="outside">Outside</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="both" name="price_type" id="both">--}}
                                    {{--                                                            <label class="form-check-label" for="both">Both</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="custom" name="price_type" id="partial">--}}
                                    {{--                                                            <label class="form-check-label" for="partial">Custom</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="form-floating txt_field">--}}
                                    {{--                                                        <input type="number" class="form-control" name="cost" id="Cost_sec" placeholder="" required>--}}
                                    {{--                                                        <label for="Cost_sec" disabled>Inside Cost</label>--}}
                                    {{--                                                        <p>Please Enter Inside Cost</p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="col-md-6"></div>--}}
                                    {{--                                                <div class="col-md-12">--}}
                                    {{--                                                    <div class="custom_add_description">--}}
                                    {{--                                                        <div class="txt_field">--}}
                                    {{--                                                            <textarea class="form-control" rows="5" name="description" id="" placeholder="Description"></textarea>--}}
                                    {{--                                                            <p>Please Enter Description</p>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-md-6">
                                        <h4>Assign Route</h4>
                                        <div class="select_dropdown_create_client txt_field">
                                            <select class="form-select select2-multiple" name="route_id[]" multiple="multiple" aria-label="Default select">
{{--                                                @foreach($route as $item)--}}
{{--                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                                @endforeach--}}
                                            </select>
                                            <label>Please Select Route</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-12">
                                        <div class="client_upload_img">
                                            <div class="dropzone dz-clickable" id="client_dropzone_image">
                                                <div class="dz-default dz-message">
                                                    <button class="dz-button" type="button">
                                                        <i class="fa-solid fa-image"></i>
                                                        <h6>Upload Images</h6>
                                                        <p>Drag & drop or click to upload</p>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="image[]" id="image[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="client_upload_img custom_img_margin">
                                            <div class="image-input" data-kt-image-input="true">
                                                <!--begin::Image preview wrapper-->

                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label class="btn btn-active-color-primary shadow edit_icon custom_append_img"
                                                       data-kt-image-input-action="change"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-dismiss="click"
                                                >
                                                    {{--<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>--}}

                                                    {{-- Add Image --}}
                                                    <div class="image-input-wrapper">
                                                        <img class="input_image_field" src="">
                                                    </div>

                                                    {{-- Image Content--}}

                                                    <div class="custom_upload_content">
                                                        <span><i class="fa-solid fa-image"></i></span>
                                                        <h4>Business Card Front</h4>
                                                        <p>Image of the front of your business card</p>
                                                    </div>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="front_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                      data-kt-image-input-action="cancel"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-dismiss="click"
                                                      title="Cancel avatar">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                                <!--end::Cancel button-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="client_upload_img custom_img_margin">
                                            <div class="image-input" data-kt-image-input="true">
                                                <!--begin::Image preview wrapper-->
                                                <label class="btn btn-active-color-primary shadow edit_icon custom_append_img"
                                                       data-kt-image-input-action="change"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-dismiss="click">
                                                    {{--<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>--}}

                                                    {{-- Add Image --}}
                                                    <div class="image-input-wrapper">
                                                        <img class="input_image_field" src="" data-original-src="{{ asset('website') }}/assets/images/create_client_img_plus_sign.png">
                                                    </div>

                                                    {{-- Image Content--}}

                                                    <div class="custom_upload_content">
                                                        <span><i class="fa-solid fa-image"></i></span>
                                                        <h4>Business Card Back</h4>
                                                        <p>Image of the back of your business card</p>
                                                    </div>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="back_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                      data-kt-image-input-action="cancel"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-dismiss="click"
                                                      title="Cancel avatar">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                                <!--end::Cancel button-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class=" txt_field text_area_field_wrapper custom_img_margin">
                                            <textarea rows="5" class="form-control" name="additional_note" placeholder="Additional Notes"></textarea>
                                            <p>Please Enter Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_justify_between">
                                            <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-close"></i></button>
                                            <button type="submit" class="btn_global btn_blue submitButton">Create<i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_clients_sec">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="create_clients_wrapper shadow_box_wrapper">
                            <form>
{{--                            <form method="post" action="{{route('clients.store')}}" id="clientValidate" class="form-horizontal" enctype="multipart/form-data">--}}
{{--                                @csrf--}}
                                <div class="row create_client_cus_row">
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="name" id="client_name" placeholder="" required>
                                            <label for="client_name">Client Name *</label>
                                            <p>Please Enter Client Name</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="number" class="form-control" name="phone" id="phone_number" placeholder="">
                                            <label for="phone_number">Phone Number *</label>
                                            <p>Please Enter Phone Number</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                                            <label for="phone_number">Email Address *</label>
                                            <p>Please Enter Email Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Location</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="street_number" id="street_number" placeholder="">
                                            <label for="street_number">Street Number *</label>
                                            <p>Please Enter Street Number</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="" required>
                                            <label for="address">Address *</label>
                                            <p>Please Enter Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="city" id="city" placeholder="">
                                            <label for="city">City *</label>
                                            <p>Please Enter City</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field">
                                            <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="">
                                            <label for="zip_code">Zip Code</label>
                                            <p>Please Enter Zip Code</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Client Type</h4>
                                        <div class="radio_btn_wrapper">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" value="commercial" name="client_type" id="commercial" checked>
                                                <label class="form-check-label" for="commercial">Commercial</label>
                                            </div>
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" value="residential" name="client_type" id="residential">
                                                <label class="form-check-label" for="residential">Residential</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-6">--}}
                                    {{--                                        <h4>Payment Type</h4>--}}
                                    {{--                                        <div class="radio_btn_wrapper">--}}
                                    {{--                                            <div class="form-check ">--}}
                                    {{--                                                <input class="form-check-input" type="radio" value="cash" name="payment_type" id="cash" checked>--}}
                                    {{--                                                <label class="form-check-label" for="cash">Cash</label>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="form-check ">--}}
                                    {{--                                                <input class="form-check-input" type="radio" value="invoice" name="payment_type" id="invoice">--}}
                                    {{--                                                <label class="form-check-label" for="invoice">Invoice</label>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-md-12">
                                        <h4>Frequency of Service</h4>
                                        <div class="cycle_frequency_wrapper">
                                            <div class="row create_client_cus_row">
                                                <div class="col-md-6">
                                                    <div class="radio_btn_wrapper">
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio" value="quarterly" name="service_frequency" id="quarterly" checked>
                                                            <label class="form-check-label" for="quarterly">4-week cycle</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio" value="eightWeek" name="service_frequency" id="eightWeek" checked>
                                                            <label class="form-check-label" for="eightWeek">8-week cycle</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio"  value="biweekly" name="service_frequency" id="bi_annually">
                                                            <label class="form-check-label" for="bi_annually">Bi- weekly</label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input" type="radio"  value="monthly" name="service_frequency" id="annually">
                                                            <label class="form-check-label" for="annually">Monthly</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="date" class="form-control" name="start_date" id="startDate" placeholder="" required>
                                                        <label for="startDate">Starting Date</label>
                                                        <p>Please Select Starting Date</p>
                                                    </div>
                                                </div>
                                                <h4>Please Select Best time to service</h4>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="time" class="form-control" name="start_hour" id="startDate" placeholder="">
                                                        <label for="startDate">Starting Hour</label>
                                                        <p>Please Select Starting Hour</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating txt_field custom_dates">
                                                        <input type="time" class="form-control" name="end_hour" id="endDate" placeholder="">
                                                        <label for="endDate">Ending Hour</label>
                                                        <p>Please Select Ending Hour</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Assign Week</h4>
                                        <div class="custom_checkbox_wrapper assign_week">
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="one" name="assign_week[0][week]" type="checkbox" data-id="0" id="week1">
                                                <label class="form-check-label" for="week1">Week 1</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="two" name="assign_week[1][week]" type="checkbox" data-id="1" id="week2">
                                                <label class="form-check-label" for="week2">Week 2</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="three" name="assign_week[2][week]" type="checkbox" data-id="2" id="week3">
                                                <label class="form-check-label" for="week3">Week 3</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="four" name="assign_week[3][week]" type="checkbox" data-id="3" id="week4">
                                                <label class="form-check-label" for="week4">Week 4</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="five" name="assign_week[4][week]" type="checkbox" data-id="4" id="week5">
                                                <label class="form-check-label" for="week5">Week 5</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="six" name="assign_week[5][week]" type="checkbox" data-id="5" id="week6">
                                                <label class="form-check-label" for="week6">Week 6</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="seven" name="assign_week[6][week]" type="checkbox" data-id="6" id="week7">
                                                <label class="form-check-label" for="week7">Week 7</label>
                                            </div>
                                            <div class="custom_radio">
                                                <input class="form-check-input" value="eight" name="assign_week[7][week]" type="checkbox" data-id="7" id="week8">
                                                <label class="form-check-label" for="week8">Week 8</label>
                                            </div>
                                        </div>
                                        <div class="add_frequency_week_note"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="unbelivable_sec">
                                            <h4>Unavailable Days</h4>
                                            <div class="custom_checkbox_wrapper unavailable_days">
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="monday" name="unavail_day[]" id="mon">
                                                    <label for="mon">Monday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="tuesday" name="unavail_day[]" id="tue">
                                                    <label for="tue">Tuesday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="wednesday" name="unavail_day[]" id="wed">
                                                    <label for="wed">Wednesday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="thursday" name="unavail_day[]" id="thu">
                                                    <label for="thu">Thursday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="friday" name="unavail_day[]" id="fri">
                                                    <label for="fri">Friday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="saturday" name="unavail_day[]" id="sat">
                                                    <label for="sat">Saturday</label>
                                                </div>
                                                <div class="custom_radio">
                                                    <input class="form-check-input" type="checkbox" value="sunday" name="unavail_day[]" id="sun" disabled>
                                                    <label for="sun">Sunday</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-12">--}}
                                    {{--                                        <h4>Price</h4>--}}
                                    {{--                                        <div class="custom_cost_content">--}}
                                    {{--                                            <div class="row">--}}
                                    {{--                                                <div class="col-md-6">--}}
                                    {{--                                                    <div class="radio_btn_wrapper">--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="inside" name="price_type" id="inside" checked>--}}
                                    {{--                                                            <label class="form-check-label" for="inside">Inside</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="outside" name="price_type" id="outside">--}}
                                    {{--                                                            <label class="form-check-label" for="outside">Outside</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="both" name="price_type" id="both">--}}
                                    {{--                                                            <label class="form-check-label" for="both">Both</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="form-check ">--}}
                                    {{--                                                            <input class="form-check-input" type="radio" value="custom" name="price_type" id="partial">--}}
                                    {{--                                                            <label class="form-check-label" for="partial">Custom</label>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="form-floating txt_field">--}}
                                    {{--                                                        <input type="number" class="form-control" name="cost" id="Cost_sec" placeholder="" required>--}}
                                    {{--                                                        <label for="Cost_sec" disabled>Inside Cost</label>--}}
                                    {{--                                                        <p>Please Enter Inside Cost</p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="col-md-6"></div>--}}
                                    {{--                                                <div class="col-md-12">--}}
                                    {{--                                                    <div class="custom_add_description">--}}
                                    {{--                                                        <div class="txt_field">--}}
                                    {{--                                                            <textarea class="form-control" rows="5" name="description" id="" placeholder="Description"></textarea>--}}
                                    {{--                                                            <p>Please Enter Description</p>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-md-6">
                                        <h4>Assign Route</h4>
                                        <div class="select_dropdown_create_client txt_field">
                                            <select class="form-select select2-multiple" name="route_id[]" multiple="multiple" aria-label="Default select">
{{--                                                @foreach($route as $item)--}}
{{--                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                                @endforeach--}}
                                            </select>
                                            <label>Please Select Route</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-12">
                                        <div class="client_upload_img">
                                            <div class="dropzone dz-clickable" id="client_dropzone_image">
                                                <div class="dz-default dz-message">
                                                    <button class="dz-button" type="button">
                                                        <i class="fa-solid fa-image"></i>
                                                        <h6>Upload Images</h6>
                                                        <p>Drag & drop or click to upload</p>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="image[]" id="image[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="client_upload_img custom_img_margin">
                                            <div class="image-input" data-kt-image-input="true">
                                                <!--begin::Image preview wrapper-->

                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label class="btn btn-active-color-primary shadow edit_icon custom_append_img"
                                                       data-kt-image-input-action="change"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-dismiss="click"
                                                >
                                                    {{--<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>--}}

                                                    {{-- Add Image --}}
                                                    <div class="image-input-wrapper">
                                                        <img class="input_image_field" src="">
                                                    </div>

                                                    {{-- Image Content--}}

                                                    <div class="custom_upload_content">
                                                        <span><i class="fa-solid fa-image"></i></span>
                                                        <h4>Business Card Front</h4>
                                                        <p>Image of the front of your business card</p>
                                                    </div>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="front_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                      data-kt-image-input-action="cancel"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-dismiss="click"
                                                      title="Cancel avatar">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                                <!--end::Cancel button-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="client_upload_img custom_img_margin">
                                            <div class="image-input" data-kt-image-input="true">
                                                <!--begin::Image preview wrapper-->
                                                <label class="btn btn-active-color-primary shadow edit_icon custom_append_img"
                                                       data-kt-image-input-action="change"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-dismiss="click">
                                                    {{--<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>--}}

                                                    {{-- Add Image --}}
                                                    <div class="image-input-wrapper">
                                                        <img class="input_image_field" src="" data-original-src="{{ asset('website') }}/assets/images/create_client_img_plus_sign.png">
                                                    </div>

                                                    {{-- Image Content--}}

                                                    <div class="custom_upload_content">
                                                        <span><i class="fa-solid fa-image"></i></span>
                                                        <h4>Business Card Back</h4>
                                                        <p>Image of the back of your business card</p>
                                                    </div>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="back_image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                                      data-kt-image-input-action="cancel"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-dismiss="click"
                                                      title="Cancel avatar">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                                <!--end::Cancel button-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class=" txt_field text_area_field_wrapper custom_img_margin">
                                            <textarea rows="5" class="form-control" name="additional_note" placeholder="Additional Notes"></textarea>
                                            <p>Please Enter Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_justify_between">
                                            <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-close"></i></button>
                                            <button type="submit" class="btn_global btn_blue submitButton">Create<i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "Select Route",
                allowClear: true
            });
        });
    </script>
    {{--    picture upload jquery--}}
    <script>
        $(document).ready(function() {
            // File Uploading Jquery
            // When the file input changes, update the corresponding image preview
            $('.custom_file_input').on('change', function() {
                // Get the file input and its corresponding image
                var input = $(this);
                var img = input.closest('.image-input').find('.input_image_field');

                // Update the image source
                var file = this.files[0];
                if (file) {
                    img.attr('src', URL.createObjectURL(file));
                }
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            // Radio button checked value to show Frequency Service Date

            // Initially disable the date input fields
            $('.cycle_frequency_wrapper .custom_dates input[type="date"]').attr('disabled', true);

            $('.cycle_frequency_wrapper .radio_btn_wrapper input[type=radio]').change(function() {
                var selectedValue = $('input[name="service_frequency"]:checked').val();
                if (selectedValue === "monthly" || selectedValue === "biweekly") {

                    $(".cycle_frequency_wrapper .custom_dates input[type='date']").attr("disabled", false);
                    console.log(selectedValue);
                } else {
                    $(".cycle_frequency_wrapper .custom_dates input[type='date']").attr("disabled", true);
                }
            });

            $(document).on("change", ".assign_week input[type='checkbox']", function () {
                var id = $(this).data("id");
                var isChecked = $(this).is(":checked");

                if (isChecked)
                {
                    $(".add_frequency_week_note").append(`
                    <div class="custom_cost_content" id="week_note_${id}">
                        <h4>Details for Week ${id + 1}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="appended_radio">
                                    <h4>Price Type:</h4>
                                    <div class="radio_btn_wrapper">
                                        <label>
                                            <input type="radio" name="assign_week[${id}][price_type]" value="inside" checked> Inside
                                        </label>
                                        <label>
                                            <input type="radio" name="assign_week[${id}][price_type]" value="outside"> Outside
                                        </label>
                                        <label>
                                            <input type="radio" name="assign_week[${id}][price_type]" value="both"> Both
                                        </label>
                                        <label>
                                            <input type="radio" name="assign_week[${id}][price_type]" value="custom"> Custom
                                        </label>
                                    </div>
                                    <div class="txt_field">
                                        <label>Cost:</label>
                                        <input type="number" name="assign_week[${id}][cost]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="appended_radio">
                                    <h4>Payment Type:</h4>
                                    <div class="radio_btn_wrapper">
                                        <label>
                                            <input type="radio" name="assign_week[${id}][payment_type]" value="cash" checked> Cash
                                        </label>
                                        <label>
                                            <input type="radio" name="assign_week[${id}][payment_type]" value="invoice"> Invoice
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom_week_notes">
                                    <div class="txt_field">
                                        <label>Note:</label>
                                        <textarea name="assign_week[${id}][note]" placeholder="Notes For Week" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom_description" style="display: none;">
                                    <div class="txt_field">
                                        <label>Description (for custom):</label>
                                        <textarea name="assign_week[${id}][description]" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                } else {
                    $("#week_note_" + id).remove();
                }
            });

            // Show description if "custom" price type is selected
            $(document).on("change", "input[name*='[price_type]']", function () {
                var parent = $(this).closest(".custom_cost_content");
                if ($(this).val() === "custom") {
                    parent.find(".custom_description").show();
                } else {
                    parent.find(".custom_description").hide();
                }
            });

//          Append Time
            var append_limit = 0;
            $(document).on("click",".cycle_frequency_wrapper .add_more_time button",function () {
                if(append_limit < 2){
                    append_limit++;
                    $(this).closest(".cycle_frequency_wrapper").find(".append_service_time .appended_items").append('<div class="row appended_row_time custom_row"><div class="col-md-12">' +
                        '<div class="remove_append_time"> <button type="button" class="btn_global btn_red"><i class="fa-solid fa-trash"></i></button></div> </div> <div class="col-md-6">'+
                        '<div class="form-floating txt_field custom_dates">'+
                        '<input type="time" class="form-control" name="start_hour" id="" placeholder="">'+
                        '<label for="startDate">Starting Hour</label>'+
                        '<p>Please Select Starting Hour</p></div></div>'+
                        '<div class="col-md-6"><div class="form-floating txt_field custom_dates">'+
                        '<input type="time" class="form-control" name="end_hour" id="" placeholder="">'+
                        '<label for="endDate">Ending Hour</label>'+
                        '<p>Please Select Ending Hour</p></div></div></div>')
                }
                else{
                    alert("You Don't append More Than 2 Times");
                }

            });

            $(document).on("click",".cycle_frequency_wrapper .remove_append_time button",function (){
                $(this).closest(".appended_row_time").remove();
                append_limit--;
            })


        });</script>

    <!-- Include Dropzone JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" referrerpolicy="no-referrer"></script>
    <!-- Initialize Dropzone -->
    {{--    //for dropzone--}}
    <script>
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#client_dropzone_image", {
            url                 : "#",
            paramName           : "file",
            maxFilesize         : 2,
            acceptedFiles       : ".jpg,.jpeg,.png,.gif",
            dictDefaultMessage  : '<i class="fa-solid fa-image"></i><h6>Upload Images</h6><p>Drag & drop or click to upload</p>',
            addRemoveLinks      : true,
            dictRemoveFile      : "Remove",
            init: function () {
                this.on("addedfile", function (file) {
                    convertToBase64(file);
                });
                this.on("removedfile", function (file) {
                    updateHiddenField();
                });
                this.on("error", function (file, message) {
                    if (message === "You can't upload files of this type.") {
                        alert("Invalid file type! Please upload a .jpg, .jpeg, .png, or .gif file.");
                        this.removeFile(file);
                    }
                });
            }
        });

        function convertToBase64(file) {
            const reader = new FileReader();
            reader.onloadend = function () {
                const base64String = reader.result;
                file.base64 = base64String;
                updateHiddenField();
            };
            reader.readAsDataURL(file);
        }

        function updateHiddenField() {
            const form = document.querySelector('form');
            const existingInputs = form.querySelectorAll('input[type="hidden"][name="image[]"]');
            existingInputs.forEach(input => input.remove());

            myDropzone.files.forEach(function (file) {
                if (file.base64) {
                    const input     = document.createElement('input');
                    input.type      = 'hidden';
                    input.name      = 'image[]';
                    input.value     = file.base64;
                    form.appendChild(input);
                }
            });
        }
    </script>
    {{--    // Validation--}}
    <script>
        $(document).ready(function () {
            $("#clientValidate").validate({
                rules: {
                    name: {
                        required: true
                    },
                    // phone: {
                    //     required: true
                    // },
                    email: {
                        required: true,
                        email: true,
                    },
                    address: {
                        required: true
                    },
                    // street_number: {
                    //     required: true
                    // },
                    // city: {
                    //     required: true
                    // },
                    start_hour: {
                        required: true
                    },
                    end_hour: {
                        required: true
                    },
                    // cost: {
                    //     required: true
                    // },
                    'route_id[]': {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter client name."
                    },
                    // phone: {
                    //     required: "Please enter phone number."
                    // },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    address: {
                        required: "Please enter your address."
                    },
                    // street_number: {
                    //     required: "Please enter street number."
                    // },
                    // city: {
                    //     required: "Please enter city name."
                    // },
                    start_hour: {
                        required: "Please enter start hour."
                    },
                    end_hour: {
                        required: "Please enter end hour."
                    },
                    // cost: {
                    //     required: "Please enter cost."
                    // },
                    'route_id[]': {
                        required: "Please select assign route."
                    }
                },
                errorElement: "span",
                errorClass: "text-danger",


                invalidHandler: function (event, validator) {
                    if (validator.numberOfInvalids()) {
                        $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top - 100
                        }, 800);
                    }
                },

                submitHandler: function (form) {
                    const email = $('#email').val();
                    const emailInput = $('#email');
                    const emailErrorSpan = $('#email-error');

                    if (emailErrorSpan.length) {
                        emailErrorSpan.remove();
                    }

                    const isAssignWeekChecked = $('.assign_week input[type="checkbox"]').is(':checked');
                    const isUnavailableDayChecked = $('.unavailable_days input[type="checkbox"]').is(':checked');

                    if (!isAssignWeekChecked) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Week Not Assigned',
                            text: 'Please select at least one week to assign.',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            $('html, body').animate({
                                scrollTop: $('.assign_week').offset().top - 100
                            }, 800);
                        });
                        return;
                    }

                    if (!isUnavailableDayChecked) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Unavailable Day Not Selected',
                            text: 'Please select at least one unavailable day.',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            $('html, body').animate({
                                scrollTop: $('.unavailable_days').offset().top - 100
                            }, 800);
                        });
                        return;
                    }

                    $.ajax({
                        url: "{{url('check_email')}}",
                        type: "GET",
                        data: { email: email },
                        success: function (response) {
                            if (!response.exists) {
                                form.submit();
                            } else {
                                emailInput.after('<span id="`email`-error" class="text-danger">This email is already registered.</span>');
                                emailInput.addClass("is-invalid");
                                $('html, body').animate({
                                    scrollTop: emailInput.offset().top - 100
                                }, 800);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
