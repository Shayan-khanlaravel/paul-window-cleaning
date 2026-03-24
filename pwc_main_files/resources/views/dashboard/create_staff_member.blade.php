@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="{{url('staffmembers')}}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Create Staff Member</h2>
    </div>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
    <section class="create_clients_sec">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="create_clients_wrapper shadow_box_wrapper">
                        <form method="post" action="{{route('staffmembers.store')}}" id="staffValidate" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="profile_image">
                                <div class="image-input image-input-circle" data-kt-image-input="true">
                                    <!--begin::Image preview wrapper-->
                                    <div class="image-input-wrapper">
                                        <img class="input_image_field" src="{{ asset('website') }}/assets/images/create_client_img_plus_sign.png" data-original-src="{{ asset('website') }}/assets/images/create_client_img_plus_sign.png">
                                    </div>
                                    <!--end::Image preview wrapper-->

                                    <!--begin::Edit button-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                           data-kt-image-input-action="change"
                                           data-bs-toggle="tooltip"
                                           data-bs-dismiss="click"
                                           title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                        <!--begin::Inputs-->
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
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

                            <div class="row create_client_cus_row">
                                <div class="col-md-6">
                                    <div class="txt_field form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="" >
                                        <label for="name">Name</label>
                                        <p>Please Enter Name</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="txt_field form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="" >
                                        <label for="email">Email</label>
                                        <p>Please Enter Email</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="txt_field form-floating">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="" >
                                        <label for="address">Address</label>
                                        <p>Please Enter Address</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="txt_field">
                                        <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" >
                                        <p>Please Enter Date of Birth</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating txt_field input_wrapper">
                                        <input type="password" class="form-control pass_log" name="password" id="password" placeholder="" required>
                                        <label for="password">Password *</label>
                                        <i class="fa-solid input_icon fa-eye"></i>
                                        <i class="fa-solid input_icon fa-eye-slash"></i>
                                        <p>Please Enter Password should be atleast 8 characters long,alphanumeric and contain atleast one capital letter.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating txt_field input_wrapper">
                                        <input type="password" class="form-control pass_log" name="confirm_password" id="confirm_password" placeholder="" required>
                                        <label for="con_password">Confirm Password *</label>
                                        <i class="fa-solid input_icon fa-eye"></i>
                                        <i class="fa-solid input_icon fa-eye-slash"></i>
                                        <p>Please Enter Password for confirmation</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom_justify_between" >
                                        <button type="button" class="btn_global btn_grey cancel_btn_funct">Cancel <i class="fa-solid fa-xmark"></i></button>
                                        <button type="submit" class="btn_global btn_blue">create <i class="fa-solid fa-plus"></i></button>
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
                                                <input class="form-check-input" type="checkbox" value="" id="muler_honda">
                                                <label class="form-check-label" for="muler_honda">Muler Honda</label>
                                                <span>(Invoice)</span>
                                            </div>
                                            <h3>$250.00</h3>
                                        </div>
                                        <div class="custom_partially_changed">
                                            <div class="row custom_row">
                                                <div class="col-md-4 custom_no_change">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="com_no_change">
                                                        <label class="form-check-label" for="com_no_change">Completed no Change</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 custom_date_service">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="date_of_service">
                                                        <label class="form-check-label" for="date_of_service">Date of Service</label>
                                                        <input type="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="partiallyCompleted">
                                                        <label class="form-check-label" for="partiallyCompleted">Partially Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="reason">
                                                        <label class="form-check-label" for="reason">Reason</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="priceCharged">
                                                        <label class="form-check-label" for="priceCharged">Price Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="workCompleted">
                                                        <label class="form-check-label" for="workCompleted">Extra Work Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="workScope">
                                                        <label class="form-check-label" for="workScope">Scope</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="extraPriceCharged">
                                                        <label class="form-check-label" for="extraPriceCharged">Price Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="logTime">
                                                        <label class="form-check-label" for="logTime">Log time</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="startTime">
                                                        <label class="form-check-label" for="startTime">Start Time</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="endTime">
                                                        <label class="form-check-label" for="endTime">End Time</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value="" id="omit">
                                                        <label class="form-check-label" for="omit">Omit</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value="" id="omitReason">
                                                        <label class="form-check-label" for="omitReason">Reason</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom_justify_between">
                                        <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-close"></i></button>
                                        <button type="submit" class="btn_global btn_blue">Create<i class="fa-solid fa-plus"></i></button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

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

            // When the cancel button is clicked, reset the image to its original source
            $('[data-kt-image-input-action="cancel"]').on('click', function() {
                // Get the corresponding image and reset the source
                var img = $(this).closest('.image-input').find('.input_image_field');
                var originalSrc = img.attr('data-original-src');
                img.attr('src', originalSrc);
            });
        });
    </script>
    {{--    password show hide icon functionality--}}
    <script>
        $(document).ready(function() {
            $(".fa-eye").hide();
            $(".fa-eye-slash").show();
            $(".input_icon").click(function(){
                $(this).closest(".input_wrapper").find(".input_icon").toggleClass("fa-eye fa-eye-slash")
                var input = $(this).siblings(".pass_log");
                input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $.validator.addMethod("strongPassword", function (value, element) {
                return this.optional(element) ||
                    /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value);
            }, "Password must be at least 8 characters long, alphanumeric, and contain at least one capital letter.");

            // Custom method for date validation (DOB: no future dates)
            $.validator.addMethod("pastDate", function (value, element) {
                const inputDate = new Date(value);
                const today = new Date();
                return this.optional(element) || inputDate < today;
            }, "Date of birth must be a date before today.");

            $("#staffValidate").validate({
                rules: {
                    image: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                        // emailExists: true
                    },
                    address: {
                        required: true
                    },
                    dob: {
                        required: true,
                        pastDate: true
                    },
                    password: {
                        required: true,
                        strongPassword: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    image: {
                        required: "Please upload an image."
                    },
                    name: {
                        required: "Please enter your name."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    address: {
                        required: "Please enter your address."
                    },
                    dob: {
                        required: "Please enter your date of birth.",
                        date: "Please enter a valid date."
                    },
                    password: {
                        required: "Please provide a password.",
                        minlength: "Your password must be at least 8 characters long and  contain atleast one capital letter."
                    },
                    confirm_password: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match."
                    }
                },
                errorElement: "span",
                errorClass: "text-danger",
                // highlight: function (element) {
                //     $(element).addClass("is-invalid");
                // },
                // unhighlight: function (element) {
                //     $(element).removeClass("is-invalid").addClass("is-valid");
                // },
                submitHandler: function (form) {
                    const email = $('#email').val();
                    const emailInput = $('#email');
                    const emailErrorSpan = $('#email-error');

                    if (emailErrorSpan.length) {
                        emailErrorSpan.remove();
                    }

                    $.ajax({
                        url: "check_email",
                        type: "GET",
                        data: { email: email },
                        success: function (response) {
                            if (!response.exists) {
                                form.submit();
                            } else {

                                emailInput.after('<span id="`email`-error" class="text-danger">This email is already registered.</span>');
                                emailInput.addClass("is-invalid");
                            }
                        }
                    });
                }
            });

            $('#dob').attr('max', new Date().toISOString().split('T')[0]);
        });
    </script>


    <script>
        document.querySelector('.custom_file_input').addEventListener('change', function (event) {
            const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
            const file = event.target.files[0];

            if (file && !allowedExtensions.includes(file.type)) {
                swal.fire({
                    icon: 'warning',
                    title: 'Invalid File Type',
                    text: 'Only .png, .jpg, and .jpeg files are allowed.',
                    confirmButtonText: 'OK'
                });
                event.target.value = '';
            }

        });
    </script>
@endpush
