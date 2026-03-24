    <style>
        /* Highlight reCAPTCHA like other invalid fields */
        .g-recaptcha.is-invalid {
            border: 1.5px solid #ff4d4f !important;
            border-radius: 6px;
            padding: 6px;
            display: inline-block;
        }
    </style>
@extends('website.layout.master')

@push('css')
    <!-- Include Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.css" />
@endpush
@section('content')
    {{-- hero sec --}}
    <section class="hero_sec about_us_sec contact_us">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero_sec_details">
                        <h1>CONTACT <span>US</span></h1>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="contact_us_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact_us_wrapper">
                        <a href="javascript:void(0)">
                            <div class="image_txt_contact_wrapper">
                                <div>
                                    <img
                                        src="{{ asset('website') }}/{{ $cmsContact->section_one_icon ?? 'location_addressssvg.svg' }}">
                                </div>
                                <h3>{!! $cmsContact->section_one_heading ?? '' !!}</h3>
                            </div>
                            <h4>{!! $cmsContact->section_one_description ?? '' !!}</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact_us_wrapper">
                        <a href="tel:224-572-1783">
                            <div class="image_txt_contact_wrapper">
                                <div>
                                    <img
                                        src="{{ asset('website') }}/{{ $cmsContact->section_two_icon ?? 'phone_number_ssvg.svg' }}">
                                </div>
                                <h3>{!! $cmsContact->section_two_heading ?? '' !!}</h3>
                            </div>
                            <h4>
                                @if (!empty($cmsContact->section_two_phone))
                                    {{ substr($cmsContact->section_two_phone, 0, 3) . '-' . substr($cmsContact->section_two_phone, 3, 3) . '-' . substr($cmsContact->section_two_phone, 6, 4) }}
                                @else
                                    {{ '' }}
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact_us_form_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact_us_form_wrapper">
                        <h2>GET A <span> FREE QUOTE!</span></h2> 
                        <form method="post" action="{{ route('save_contact_us') }}" class="form-horizontal"
                            id="contactForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row custom_row_form">
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Full Name</label>
                                        <input class="form-control" name="name" type="text" placeholder="Type Here">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Email</label>
                                        <input class="form-control" name="email" id="email" type="email"
                                            placeholder="Type Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Phone</label>
                                        <input class="form-control" name="phone" id="phone" type="tel"
                                            placeholder="Type Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Subject</label>
                                        <input class="form-control" name="subject" type="text"
                                            placeholder="Type Subject">
                                    </div>
                                </div>
                                {{-- lattest update --}}
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Window Cleaning</label>
                                        <div class="contact_us_window_cleaning_wrap">
                                            <div>
                                                <input type="checkbox" id="exterior" value="exterior"
                                                    name="cleaning_side[]">
                                                <label for="exterior">Exterior</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="interior" value="interior"
                                                    name="cleaning_side[]">
                                                <label for="interior">Interior</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="screens_cleaned" value="screen"
                                                    name="cleaning_side[]">
                                                <label for="screens_cleaned">Screens Cleaned</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="sills_cleaned" value="sills"
                                                    name="cleaning_side[]">
                                                <label for="sills_cleaned">Sills Cleaned</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="additional_instructions" value="additional"
                                                    name="cleaning_side[]">
                                                <label for="additional_instructions">Additional Instructions</label>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Property Status</label>
                                        <div class="contact_us_window_cleaning_wrap">
                                            <div>
                                                <input type="radio" id="commercial_property" value="commercial"
                                                    name="property_status">
                                                <label for="commercial_property">Commercial Property</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="residential_property" value="residential"
                                                    name="property_status">
                                                <label for="residential_property">Residential Property</label>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input_field_wrapper">
                                        <label>Pressure Washing</label>
                                        <div class="contact_us_window_cleaning_wrap">
                                            <div>
                                                <input type="checkbox" id="house" name="type[]" value="house">
                                                <label for="house">house</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="driveway" name="type[]" value="driveway">
                                                <label for="driveway">Driveway</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="patio" name="type[]" value="patio">
                                                <label for="patio">Patio</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="deck" name="type[]" value="deck">
                                                <label for="deck">Deck</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="other" name="type[]" value="other">
                                                <label for="other">Other</label>
                                            </div>
                                        </div>


                                    </div>
                                </div>
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
                                    <div class="input_field_wrapper">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address"
                                            placeholder="Type Here">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Street No.</label>
                                        <input class="form-control" type="text" name="street_number"
                                            placeholder="Type Here">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>City</label>
                                        <input class="form-control" type="text" name="city"
                                            placeholder="Type Here">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input_field_wrapper">
                                        <label>Zip Code</label>
                                        <input class="form-control" type="text" name="zip_code"
                                            placeholder="Type Here">
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-12">
                                    <div class="input_field_wrapper">
                                        <label>Message</label>
                                        <textarea class="form-control" rows="3" name="message" placeholder="Tell us what you like"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input_field_wrapper">
                                        <div class="g-recaptcha" data-sitekey="6LcnJxgsAAAAACFOBcaFkHSpC0aJJmWqXpCW3QfR"></div>
                                        <!-- jQuery Validate will inject the error message here -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="btn_wrapper">
                                        <a href="javascript:void(0)" class="btn_global submitButton ">Get a Free Quote!
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
    </section>
@endsection
@push('js')
    <!-- Include Dropzone JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" referrerpolicy="no-referrer">
    </script>
    <!-- Initialize Dropzone -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        // Get a reference to your form
        const contactForm = document.getElementById('contactForm');
        // Get a reference to your custom submit button
        const submitButton = document.querySelector('.submitButton');

        // Attach click listener to the custom submit button
        submitButton.addEventListener('click', function(e) {
            e.preventDefault(); // Stop the default action

            // Check if reCAPTCHA is solved
            // grecaptcha.getResponse() V2 keys ke liye kaam karta hai
            const recaptchaResponse = grecaptcha.getResponse();

            if (recaptchaResponse.length === 0) {
                // reCAPTCHA is not checked, show an alert or error message
                // alert("Please complete the 'I'm not a robot' challenge.");
                return false;
            } else {
                // reCAPTCHA is checked, submit the form
                contactForm.submit();
            }
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#client_dropzone_image", {
            url: "#",
            paramName: "file",
            maxFilesize: 2,
            acceptedFiles: ".jpg,.jpeg,.png,.gif",
            dictDefaultMessage: '<i class="fa-solid fa-image"></i><h6>Upload Images</h6><p>Drag & drop or click to upload</p>',
            addRemoveLinks: true,
            dictRemoveFile: "Remove",
            init: function() {
                this.on("addedfile", function(file) {
                    convertToBase64(file);
                });
                this.on("removedfile", function(file) {
                    updateHiddenField();
                });
                this.on("error", function(file, message) {
                    if (message === "You can't upload files of this type.") {
                        swal.fire(
                            "Invalid file type! Please upload a .jpg, .jpeg, .png, or .gif file.");
                        this.removeFile(file);
                    }
                });
            }
        });

        function convertToBase64(file) {
            const reader = new FileReader();
            reader.onloadend = function() {
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

            myDropzone.files.forEach(function(file) {
                if (file.base64) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'image[]';
                    input.value = file.base64;
                    form.appendChild(input);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#phone').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 3 && value.length <= 6) {
                    value = value.replace(/(\d{3})(\d+)/, '$1-$2');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
                }
                $(this).val(value);
            });

            $.validator.addMethod("phonePattern", function(value, element) {
                const rawValue = value.replace(/-/g, '');
                return this.optional(element) || /^[+]?\d{10,15}$/.test(rawValue);
            }, "Phone number must be valid (10-15 digits).");

            // Add reCAPTCHA validation method
            $.validator.addMethod("recaptchaRequired", function(value, element, param) {
                return grecaptcha.getResponse().length > 0;
            }, "Please complete the 'I'm not a robot' challenge.");

            $("#contactForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    phone: {
                        minlength: 10,
                        maxlength: 15,
                        phonePattern: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    // Add dummy field for recaptcha
                    recaptcha: {
                        recaptchaRequired: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter client name."
                    },
                    phone: {
                        minlength: "Phone number must be at least 10 characters.",
                        maxlength: "Phone number cannot exceed 15 characters."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    recaptcha: {
                        recaptchaRequired: "Please complete the 'I'm not a robot' challenge."
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
                        // Place error after the reCAPTCHA widget
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

                // Add a hidden dummy field for recaptcha validation
                if ($('#recaptcha-dummy').length === 0) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'recaptcha-dummy',
                        name: 'recaptcha'
                    }).appendTo('#contactForm');
                }
                // Set value to trigger validation
                $('#recaptcha-dummy').val(grecaptcha.getResponse());

                // Manually trigger validation for recaptcha
                var valid = $("#contactForm").valid();
                if (!valid) {
                    // If recaptcha is invalid, add red border
                    if (grecaptcha.getResponse().length === 0) {
                        $('.g-recaptcha').addClass('is-invalid');
                    }
                } else {
                    $('.g-recaptcha').removeClass('is-invalid');
                    $("#contactForm").submit();
                }
            });

            // Reset recaptcha validation on successful completion
            window.recaptchaCallback = function() {
                $('#recaptcha-dummy').val(grecaptcha.getResponse());
                $("#contactForm").valid();
                if (grecaptcha.getResponse().length > 0) {
                    $('.g-recaptcha').removeClass('is-invalid');
                }
            };
        });
    </script>
@endpush
