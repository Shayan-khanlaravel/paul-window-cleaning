@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{url('client_management')}}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Client Details</h2>

    </div>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
    <section class="client_details">
        <div class="container-fluid custom_container">
            <div class="row custom_row">
                <div class="col-md-8">
                    <div class="shadow_box_wrapper">
                        <div class="custom_details_wrapper">
                            <div class="client_info">
                                <div class="row custom_row">
                                    <div class="col-md-12">
                                        <div class="potential_clients custom_justify_between">
                                            <div class="potential_info custom_flex">
                                                <div class="client_img">
                                                    <img src="{{asset("website")}}/assets/images/customer_reviews_img.jpg">
                                                </div>
                                                <div class="custom_detail">
                                                    <h5>Michael Jones</h5>
                                                    <div class="client_contacts custom_flex">
                                                        <span><i class="fa-solid fa-envelope"></i>michaeljones@gmail.com</span>
                                                        <span><i class="fa-solid fa-phone"></i>+ 305 0451 0514</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accept_reject_btn custom_flex">
                                                <button class="btn_global btn_green" type="button">Accept<i class="fa-solid fa-check"></i></button>
                                                <button class="btn_global btn_red" type="button">Reject<i class="fa-solid fa-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_justify_between">
                                            <h2>Muller Honda</h2>
                                            <div class="edit_btn">
                                                <button class="btn_global btn_dark_blue" type="button">Activate/Deactivate<i class="fa-solid fa-eye"></i></button>
                                                <a class="btn_global btn_sky_blue" href="{{url('create_client')}}">Edit<i class="fa-solid fa-pen-to-square"></i></a>
                                            </div>
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
                                            <span>04-12-2024</span>
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
                                </div>
                            </div>
                            <div class="client_service_detail">
                                <div class="row custom_row">
                                    <div class="col-md-6">
                                        <div class="custom_justify_between">
                                            <h3>Payment Type</h3>
                                            <span class="primary">Cash</span>
                                        </div>
                                        <div class="custom_justify_between">
                                            <div class="txt_field_wrapper">
                                                <label>Cost :</label>
                                                <span>$451.51</span>
                                            </div>
                                            <div class="txt_field_wrapper">
                                                <label>Bonus :</label>
                                                <span>$50.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom_justify_between">
                                            <h3>Frequency of Service</h3>
                                            <span class="secondary">4-week cycle</span>
                                        </div>
                                        <div class="txt_field_wrapper">
                                            <label>Month of Service :</label>
                                            <span>July</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Best time to service</h3>
                                        <div class="custom_service_time">
                                            <span class="secondary">21:20 - 23:00</span>
                                            <span class="secondary">21:20 - 23:00</span>
                                            <span class="secondary">21:20 - 23:00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom_justify_between">
                                            <h3>Window Cleaning</h3>
                                            <span class="primary">Inside</span>
                                        </div>
                                        <div class="txt_field_wrapper">
                                            <label>Custom Cost :</label>
                                            <span>$0000</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Assigned Route</h3>
                                        <span>Gurnee</span>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Client Type</h3>
                                        <span>Commercial</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow_box_wrapper custom_assigned_wrapper">
                        <div class="weeks_assigned">
                            <div class="custom_justify_between">
                                <h3>Weeks Assigned</h3>
                                <div class="assigned_date">
                                    <span><i class="fa-solid fa-calendar"></i>July 2024</span>
                                </div>
                            </div>
                            <div class="custom_checkbox_wrapper assign_week">
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" name="" id="week1" disabled>
                                    <label class="form-check-label" for="week1">Week 1</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" name="" id="week2" checked disabled>
                                    <label class="form-check-label" for="week2">Week 2</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" name="" id="week3" checked disabled>
                                    <label class="form-check-label" for="week3">Week 3</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" name="" id="week4" disabled>
                                    <label class="form-check-label" for="week4">Week 4</label>
                                </div>
                            </div>
                        </div>
                        <div class="days_assigned">
                            <h3>Days Assigned</h3>
                            <div class="custom_checkbox_wrapper unavailable_days">
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="mon" checked disabled>
                                    <label for="mon">Monday</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="tue" disabled>
                                    <label for="tue">Tuesday</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="wed" disabled>
                                    <label for="wed">Wednesday</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="thu" checked disabled>
                                    <label for="thu">Thursday</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="fri" disabled>
                                    <label for="fri">Friday</label>
                                </div>
                                <div class="custom_radio">
                                    <input class="form-check-input" type="checkbox" value="" name="" id="sat" checked disabled>
                                    <label for="sat">Saturday</label>
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
                                    <button class="nav-link active" id="pills-additionalNotes-tab" data-bs-toggle="pill" data-bs-target="#pills-additionalNotes" type="button" role="tab" aria-controls="pills-additionalNotes" aria-selected="true">Additional Notes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-weeklyNotes-tab" data-bs-toggle="pill" data-bs-target="#pills-weeklyNotes" type="button" role="tab" aria-controls="pills-weeklyNotes" aria-selected="false">Weekly Notes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-images-tab" data-bs-toggle="pill" data-bs-target="#pills-images" type="button" role="tab" aria-controls="pills-images" aria-selected="false">Images</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-businessCard-tab" data-bs-toggle="pill" data-bs-target="#pills-businessCard" type="button" role="tab" aria-controls="pills-businessCard" aria-selected="false">Business Card</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-additionalNotes" role="tabpanel" aria-labelledby="pills-additionalNotes-tab" tabindex="0">
                                <div class="additional_notes">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    <p>Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-weeklyNotes" role="tabpanel" aria-labelledby="pills-weeklyNotes-tab" tabindex="0">
                                <div class="custom_notes">
                                    <div class="weekly_notes">
                                        <h4>Week 1</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    </div>
                                    <div class="weekly_notes">
                                        <h4>Week 2</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    </div>
                                    <div class="weekly_notes">
                                        <h4>Week 3</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    </div>
                                    <div class="weekly_notes">
                                        <h4>Week 4</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab" tabindex="0">
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
                            <div class="tab-pane fade" id="pills-businessCard" role="tabpanel" aria-labelledby="pills-businessCard-tab" tabindex="0">
                                <div class="business_card">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="business_card_images">
                                                <h4>Business Card Front</h4>
                                                <div class="custom_images">
                                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="business_card_images">
                                                <h4>Business Card Back</h4>
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
                </div>
            </div>
        </div>
    </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="client_details">
            <div class="container-fluid custom_container">
                <div class="row custom_row">
                    <div class="col-md-8">
                        <div class="shadow_box_wrapper">
                            <div class="custom_details_wrapper">
                                <div class="client_info">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <div class="potential_clients custom_justify_between">
                                                <div class="potential_info custom_flex">
                                                    <div class="client_img">
                                                        <img src="{{asset("website")}}/assets/images/customer_reviews_img.jpg">
                                                    </div>
                                                    <div class="custom_detail">
                                                        <h5>Michael Jones</h5>
                                                        <div class="client_contacts custom_flex">
                                                            <span><i class="fa-solid fa-envelope"></i>michaeljones@gmail.com</span>
                                                            <span><i class="fa-solid fa-phone"></i>+ 305 0451 0514</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accept_reject_btn custom_flex">
                                                    <button class="btn_global btn_green" type="button">Accept<i class="fa-solid fa-check"></i></button>
                                                    <button class="btn_global btn_red" type="button">Reject<i class="fa-solid fa-close"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="custom_justify_between">
                                                <h2>Muller Honda</h2>
                                                <div class="edit_btn">
                                                    <button class="btn_global btn_dark_blue" type="button">Activate/Deactivate<i class="fa-solid fa-eye"></i></button>
                                                    <a class="btn_global btn_sky_blue" href="{{url('create_client')}}">Edit<i class="fa-solid fa-pen-to-square"></i></a>
                                                </div>
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
                                                <span>04-12-2024</span>
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
                                    </div>
                                </div>
                                <div class="client_service_detail">
                                    <div class="row custom_row">
                                        <div class="col-md-6">
                                            <div class="custom_justify_between">
                                                <h3>Payment Type</h3>
                                                <span class="primary">Cash</span>
                                            </div>
                                            <div class="custom_justify_between">
                                                <div class="txt_field_wrapper">
                                                    <label>Cost :</label>
                                                    <span>$451.51</span>
                                                </div>
                                                <div class="txt_field_wrapper">
                                                    <label>Bonus :</label>
                                                    <span>$50.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom_justify_between">
                                                <h3>Frequency of Service</h3>
                                                <span class="secondary">4-week cycle</span>
                                            </div>
                                            <div class="txt_field_wrapper">
                                                <label>Month of Service :</label>
                                                <span>July</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Best time to service</h3>
                                            <div class="custom_service_time">
                                                <span class="secondary">21:20 - 23:00</span>
                                                <span class="secondary">21:20 - 23:00</span>
                                                <span class="secondary">21:20 - 23:00</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom_justify_between">
                                                <h3>Window Cleaning</h3>
                                                <span class="primary">Inside</span>
                                            </div>
                                            <div class="txt_field_wrapper">
                                                <label>Custom Cost :</label>
                                                <span>$0000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Assigned Route</h3>
                                            <span>Gurnee</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Client Type</h3>
                                            <span>Commercial</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="shadow_box_wrapper custom_assigned_wrapper">
                            <div class="weeks_assigned">
                                <div class="custom_justify_between">
                                    <h3>Weeks Assigned</h3>
                                    <div class="assigned_date">
                                        <span><i class="fa-solid fa-calendar"></i>July 2024</span>
                                    </div>
                                </div>
                                <div class="custom_checkbox_wrapper assign_week">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" name="" id="week1" disabled>
                                        <label class="form-check-label" for="week1">Week 1</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" name="" id="week2" checked disabled>
                                        <label class="form-check-label" for="week2">Week 2</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" name="" id="week3" checked disabled>
                                        <label class="form-check-label" for="week3">Week 3</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" name="" id="week4" disabled>
                                        <label class="form-check-label" for="week4">Week 4</label>
                                    </div>
                                </div>
                            </div>
                            <div class="days_assigned">
                                <h3>Days Assigned</h3>
                                <div class="custom_checkbox_wrapper unavailable_days">
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="mon" checked disabled>
                                        <label for="mon">Monday</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="tue" disabled>
                                        <label for="tue">Tuesday</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="wed" disabled>
                                        <label for="wed">Wednesday</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="thu" checked disabled>
                                        <label for="thu">Thursday</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="fri" disabled>
                                        <label for="fri">Friday</label>
                                    </div>
                                    <div class="custom_radio">
                                        <input class="form-check-input" type="checkbox" value="" name="" id="sat" checked disabled>
                                        <label for="sat">Saturday</label>
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
                                        <button class="nav-link active" id="pills-additionalNotes-tab" data-bs-toggle="pill" data-bs-target="#pills-additionalNotes" type="button" role="tab" aria-controls="pills-additionalNotes" aria-selected="true">Additional Notes</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-weeklyNotes-tab" data-bs-toggle="pill" data-bs-target="#pills-weeklyNotes" type="button" role="tab" aria-controls="pills-weeklyNotes" aria-selected="false">Weekly Notes</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-images-tab" data-bs-toggle="pill" data-bs-target="#pills-images" type="button" role="tab" aria-controls="pills-images" aria-selected="false">Images</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-businessCard-tab" data-bs-toggle="pill" data-bs-target="#pills-businessCard" type="button" role="tab" aria-controls="pills-businessCard" aria-selected="false">Business Card</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-additionalNotes" role="tabpanel" aria-labelledby="pills-additionalNotes-tab" tabindex="0">
                                    <div class="additional_notes">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        <p>Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-weeklyNotes" role="tabpanel" aria-labelledby="pills-weeklyNotes-tab" tabindex="0">
                                    <div class="custom_notes">
                                        <div class="weekly_notes">
                                            <h4>Week 1</h4>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        </div>
                                        <div class="weekly_notes">
                                            <h4>Week 2</h4>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        </div>
                                        <div class="weekly_notes">
                                            <h4>Week 3</h4>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        </div>
                                        <div class="weekly_notes">
                                            <h4>Week 4</h4>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab" tabindex="0">
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
                                <div class="tab-pane fade" id="pills-businessCard" role="tabpanel" aria-labelledby="pills-businessCard-tab" tabindex="0">
                                    <div class="business_card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="business_card_images">
                                                    <h4>Business Card Front</h4>
                                                    <div class="custom_images">
                                                        <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="business_card_images">
                                                    <h4>Business Card Back</h4>
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
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('js')

@endpush
