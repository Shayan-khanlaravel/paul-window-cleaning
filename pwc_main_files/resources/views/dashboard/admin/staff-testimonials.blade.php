@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Staff Testimonials</h2>
    </div>

    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input form-control searchInput">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="client_management staff_manag ">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="clients_tab custom_justify_between">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="true">Request</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-potential_clients-tab" data-bs-toggle="pill" data-bs-target="#pills-potential_clients" type="button" role="tab" aria-controls="pills-potential_clients" aria-selected="false">Accepted</button>
                                </li>
                            </ul>
                            {{--<div class="create_btn custom_flex">--}}
                            {{--<a href="{{url('create_client')}}" class="btn_global btn_blue">Create Client <i class="fa-solid fa-user-group"></i></a>--}}
                            {{--<button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>--}}
                            {{--</div>--}}
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab" tabindex="0">
                                <div class="staff_req_card_grid">
                                    @for($i=0;$i<9;$i++)
                                        <a data-bs-target="#new_route " data-bs-toggle="modal" class="shadow_box_wrapper_staff_request">
                                            <div >
                                                <div class="staff_request_img_details_wrap">
                                                    <div class="">
                                                        <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                    </div>
                                                    <div class="staff_request_dis tab-content">
                                                        <h5>Michael Jones</h5>
                                                        <div class="email_date_wrap">
                                                            <div>
                                                                <i class="fa-solid fa-calendar"></i>
                                                                <span>12-03-2024</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="request_items_wrap">
                                                    <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-potential_clients" role="tabpanel" aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                <div class="staff_req_card_grid">
                                    @for($i=0;$i<6;$i++)
                                        <a  class="shadow_box_wrapper_staff_request">
                                            <div >
                                                <div class="staff_request_img_details_wrap">
                                                    <div class="">
                                                        <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                    </div>
                                                    <div class="staff_request_dis tab-content">
                                                        <h5>Michael Jones</h5>
                                                        <div class="email_date_wrap">
                                                            <div>
                                                                <i class="fa-solid fa-calendar"></i>
                                                                <span>12-03-2024</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="request_items_wrap">
                                                    <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--modal--}}
    <div class="modal fade new_route download_pdf_modal_sec staff_request_modal staff_testimonial_modal" id="new_route" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="staff_testimonial_wrapper_modal">
                            <div class="staff_request_img_details_wrap">
                                <div class="">
                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                </div>
                                <div class="staff_request_dis ">
                                    <h5>Michael Jones</h5>
                                    <div class="email_date_wrap">
                                        <div>
                                            <i class="fa-solid fa-calendar"></i>
                                            <span>12-03-2024</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="request_items_wrap">
                                <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                            </div>
                            <div class="modal-footer custom_justify_between">
                                <button type="button" class="btn_global btn_grey " data-bs-dismiss="modal" aria-label="Close">Reject <i class="fa-solid fa-x"></i> </button>
                                <button type="submit" class="btn_global btn_blue ">Mark Complete<i class="fa-solid fa-check"></i> </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
{{--searchbar functionality--}}
<script>
    $(document).ready(function() {
        $('.searchInput').on('input', function() {
            var filter = $(this).val().toLowerCase();

            $('.tab-content').each(function() {
                var h2Text = $(this).find('h5').text().toLowerCase();
                if (h2Text.includes(filter)) {
                    $(this).show(); // Show the matching element
                } else {
                    $(this).hide(); // Hide the non-matching element
                }
            });
        });
    });
</script>
@endpush
