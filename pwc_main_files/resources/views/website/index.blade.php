@extends('website.layout.master')
@section('content')

    {{-- hero sec --}}
    <section class="hero_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero_sec_details">
                        {{--                        <h1>Welcome to <span> Paul's window cleaning</span></h1> --}}
                        {{--                        <h3>Care + Integrity + Experience + Hard work = High quality results</h3> --}}
                        {!! $cmsHome->section_one_heading ?? '' !!}


                        <h3>{!! $cmsHome->section_one_description ?? '' !!}</h3>
                        <div class="btn_wrapper">
                            <a href="{{ url('contact_us') }}" class="btn_global  ">Request a Quote
                                <div class="btn_img_icon">
                                    <img src="{{ asset('website') }}/assets/images/arrow-right.svg ">
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="hero_sec_img">
                        <img src="{{ asset('website') }}/assets/images/wiper_hero_img.png">
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{-- our services --}}
    <section class="service_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-5">
                    <div class="service_sec_img">
                        <div class="service_wrapper_img">
                            <img src="{{ asset('website') }}/{{ $cmsHome->section_two_image_one ?? '' }}">
                        </div>
                        <div class="service_wrapper_img">
                            <img src="{{ asset('website') }}/{{ $cmsHome->section_two_image_two ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="service_details_wrapper">
                        <h2 class="bottom_line_global">{!! $cmsHome->section_two_heading ?? '' !!}</h2>
                        <div class="service_list_cont">
                            <div class="list_sec_wrapper">
                                <div class="list_sec">
                                    <div class="telephone_icon">
                                        <img src="{{ asset('website') }}/{{ $cmsHome->two_sub_section_one_icon ?? '' }} ">
                                    </div>
                                    <h3>{!! $cmsHome->two_sub_section_one_heading ?? '' !!}</h3>
                                </div>
                                @php
                                    $titles = json_decode($cmsHome->two_sub_section_one_title, true) ?? [];
                                    $titles2 = json_decode($cmsHome->two_sub_section_two_title, true) ?? [];
                                @endphp

                                <ul>
                                    @if (!empty($titles))
                                        @foreach ($titles as $title)
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                <p>{{ $title }}</p>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>No titles available</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="list_sec_wrapper">
                                <div class="list_sec">
                                    <div class="telephone_icon">
                                        <img src="{{ asset('website') }}/{{ $cmsHome->two_sub_section_two_icon ?? '' }} ">
                                    </div>
                                    <h3>{!! $cmsHome->two_sub_section_two_heading ?? '' !!}</h3>
                                </div>
                                <ul>
                                    @foreach ($titles2 as $title)
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            <p>{{ $title }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
    {{-- testimonails --}}
    <section class="testimonails_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="testoimanils_wrap">
                        <h2>{!! $cmsHome->section_three_heading ?? '' !!}</h2>
                        <p>{!! $cmsHome->section_three_description ?? '' !!}</p>
                        <div class="testimonials_reviews">
                            @forelse($testimonial as $reviwes)
                                <div class="reviews_wrapper">
                                    <div class="reviews_img_name">
                                        <div class="rev_img_fb">
                                            <div class="customer_img">
                                                <img src="{{ asset('website') }}/assets/images/user_logo.svg">
                                            </div>
                                            <div class="customer_name">
                                                <h3>{{ ucfirst($reviwes->name ?? '') }}</h3>
                                                <h6>{{ '@' . $reviwes->name ?? '' }}</h6>
                                            </div>
                                        </div>
                                        <i class="fa-brands fa-facebook"></i>
                                    </div>
                                    <h5>{{ $reviwes->message ?? '' }}</h5>
                                </div>
                            @empty
                                <div>
                                    There's No Testimonial Available
                                </div>
                            @endforelse

                        </div>
                        <div class="view_all_about_us view_all_about_us_homepg">
                            <a href="javascript:void(0)" class="view_all_show_txt">View More</a>
                        </div>

                    </div>
                    <div class="btn_wrapper">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#testimonial_modal"
                            class="btn_global  ">Submit Testimonial
                            <div class="btn_img_icon">
                                <img src="{{ asset('website') }}/assets/images/arrow-right.svg ">
                            </div>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- testimonial modal --}}
    <div class="modal fade" id="testimonial_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="testimonial_modal_body">
                        <form method="post" action="{{ route('save_testimonial') }}" class="form-horizontal"
                            id="testimonialForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row custom_flex">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Your Name Here.">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea rows="5" name="message" placeholder="Your Message Here." class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input_field_wrapper">
                                        <div class="g-recaptcha" data-sitekey="6LcnJxgsAAAAACFOBcaFkHSpC0aJJmWqXpCW3QfR">
                                        </div>
                                        <!-- jQuery Validate will inject the error message here -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="btn_wrapper">
                                        <a href="javascript:void(0)" class="btn_global submitButton">Submit
                                            <div class="btn_img_icon">
                                                <img src="{{ asset('website') }}/assets/images/arrow-right.svg ">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function() {

            $('.reviews_wrapper').hide();
            $('.reviews_wrapper').slice(0, 6).show();
            $('.view_all_show_txt').click(function() {
                var visibleReviews = $('.reviews_wrapper:visible').length;
                var totalReviews = $('.reviews_wrapper').length;
                if (visibleReviews < totalReviews) {
                    $('.reviews_wrapper').slice(visibleReviews, visibleReviews + 6).show();
                    if ($('.reviews_wrapper:visible').length === totalReviews) {
                        $(this).text("View Less");
                    }
                } else {
                    $('.reviews_wrapper').slice(6).hide();
                    $(this).text("View More");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add custom reCAPTCHA validation method
            $.validator.addMethod("recaptchaRequired", function(value, element, param) {
                return grecaptcha.getResponse().length > 0;
            }, "Please verify that you are not a robot.");

            // Add style for red border
            if ($('style#recaptcha-style').length === 0) {
                $("<style id='recaptcha-style'>.g-recaptcha.is-invalid { border: 1.5px solid #ff4d4f !important; border-radius: 6px; padding: 6px; display: inline-block; }</style>")
                    .appendTo("head");
            }

            $("#testimonialForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                    recaptcha: {
                        recaptchaRequired: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name."
                    },
                    message: {
                        required: "Please enter your message."
                    },
                    recaptcha: {
                        recaptchaRequired: "Please verify that you are not a robot."
                    }
                },
                errorElement: "span",
                errorClass: "text-danger",
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    if (element.name === 'recaptcha') {
                        $('.g-recaptcha').addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    if (element.name === 'recaptcha') {
                        $('.g-recaptcha').removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr('name') === 'recaptcha') {
                        error.insertAfter('.g-recaptcha');
                    } else {
                        error.insertAfter(element);
                    }
                },
                invalidHandler: function(event, validator) {
                    if (validator.errorList.length && validator.errorList[0].element) {
                        $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top - 100
                        }, 500);
                    }
                }
            });

            $('.submitButton').on('click', function(e) {
                e.preventDefault();

                // Always set or update the hidden dummy field for recaptcha validation
                if ($('#recaptcha-dummy').length === 0) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'recaptcha-dummy',
                        name: 'recaptcha'
                    }).appendTo('#testimonialForm');
                }
                // Set value to trigger validation
                var recaptchaValue = (typeof grecaptcha !== 'undefined') ? grecaptcha.getResponse() : '';
                $('#recaptcha-dummy').val(recaptchaValue);

                // Force validation
                var valid = $("#testimonialForm").valid();
                if (!valid || recaptchaValue.length === 0) {
                    $('.g-recaptcha').addClass('is-invalid');
                    // Prevent submit if recaptcha is empty
                    return false;
                } else {
                    $('.g-recaptcha').removeClass('is-invalid');
                    $("#testimonialForm").submit();
                }
            });

            // reCAPTCHA callback for manual trigger
            window.recaptchaCallbackTestimonial = function() {
                $('#recaptcha-dummy').val(grecaptcha.getResponse());
                $("#testimonialForm").valid();
                if (grecaptcha.getResponse().length > 0) {
                    $('.g-recaptcha').removeClass('is-invalid');
                }
            };
        });
    </script>
@endpush
