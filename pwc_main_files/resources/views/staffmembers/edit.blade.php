@extends('theme.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="{{ url('staffmembers') }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Edit Staff Member</h2>
    </div>
@endsection
@section('content')
    @if (auth()->user()->hasRole('admin'))
        <section class="create_clients_sec">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="create_clients_wrapper shadow_box_wrapper">
                            <form method="post" action="{{ route('staffmembers.update', $staff->id) }}" id="staffValidate"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="profile_image">
                                    <div class="image-input image-input-circle" data-kt-image-input="true">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper">
                                            <img class="input_image_field"
                                                src="{{ $staff->profile && $staff->profile->pic ? asset('website/' . $staff->profile->pic) : asset('website') . '/assets/images/create_client_img_plus_sign.png' }}"
                                                data-original-src="{{ $staff->profile && $staff->profile->pic ? asset('storage/' . $staff->profile->pic) : asset('website') . '/assets/images/create_client_img_plus_sign.png' }}">
                                        </div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                                    class="path2"></span></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg"
                                                class="myinput custom_file_input" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit button-->

                                        <!--begin::Cancel button-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary shadow edit_icon"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Cancel avatar">
                                            <i class="ki-outline ki-cross fs-3"></i>
                                        </span>
                                        <!--end::Cancel button-->
                                    </div>
                                </div>

                                <div class="row create_client_cus_row">
                                    <div class="col-md-6">
                                        <div class="txt_field form-floating">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="" value="{{ $staff->name }}">
                                            <label for="name">Name *</label>
                                            <p>Please Enter Name</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field form-floating">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="" value="{{ $staff->email }}" readonly>
                                            <label for="email">Email *</label>
                                            <p>Please Enter Email</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field form-floating">
                                            <input type="text" class="form-control" name="address" id="address"
                                                placeholder="" value="{{ $staff->profile->address ?? '' }}">
                                            <label for="address">Address *</label>
                                            <p>Please Enter Address</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="txt_field form-floating">
                                            <input type="text" class="form-control" id="hiring_date" name="hiring_date"
                                                placeholder="Date of Hiring"
                                                value="{{ $staff->profile->hiring_date ?? '' }}">
                                            <label for="address">Date of Hiring *</label>
                                            <p>Please Enter Date of Hiring</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field input_wrapper">
                                            <input type="password" class="form-control pass_log" name="password"
                                                id="password" placeholder="">
                                            <label for="password">New Password (Leave blank to keep current)</label>
                                            <i class="fa-solid input_icon fa-eye"></i>
                                            <i class="fa-solid input_icon fa-eye-slash"></i>
                                            <p>Please Enter Password should be atleast 8 characters long,alphanumeric and
                                                contain atleast one capital letter.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating txt_field input_wrapper">
                                            <input type="password" class="form-control pass_log" name="confirm_password"
                                                id="confirm_password" placeholder="">
                                            <label for="con_password">Confirm Password</label>
                                            <i class="fa-solid input_icon fa-eye"></i>
                                            <i class="fa-solid input_icon fa-eye-slash"></i>
                                            <p>Please Enter Password for confirmation</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn_global btn_dark_blue"
                                            id="toggleOldPasswordBtn">
                                            <span id="old-password-hidden-text">Show Password</span>
                                            <span id="old-password-visible-text"
                                                style="display: none;">{{ $staff->profile->plain_password ?? 'Not Available' }}</span>
                                            <i class="fa-regular fa-eye" id="oldEyeIcon"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom_justify_between">
                                            <button type="button" class="btn_global btn_grey cancel_btn_funct">Cancel <i
                                                    class="fa-solid fa-xmark"></i></button>
                                            <button type="submit" class="btn_global btn_blue">Update <i
                                                    class="fa-solid fa-check"></i></button>
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
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="muler_honda">
                                                <label class="form-check-label" for="muler_honda">Muler Honda</label>
                                                <span>(Invoice)</span>
                                            </div>
                                            <h3>$250.00</h3>
                                        </div>
                                        <div class="custom_partially_changed">
                                            <div class="row custom_row">
                                                <div class="col-md-4 custom_no_change">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="com_no_change">
                                                        <label class="form-check-label" for="com_no_change">Completed no
                                                            Change</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 custom_date_service">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="date_of_service">
                                                        <label class="form-check-label" for="date_of_service">Date of
                                                            Service</label>
                                                        <input type="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="partiallyCompleted">
                                                        <label class="form-check-label" for="partiallyCompleted">Partially
                                                            Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="reason">
                                                        <label class="form-check-label" for="reason">Reason</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="priceCharged">
                                                        <label class="form-check-label" for="priceCharged">Price
                                                            Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="workCompleted">
                                                        <label class="form-check-label" for="workCompleted">Extra Work
                                                            Completed</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="workScope">
                                                        <label class="form-check-label" for="workScope">Scope</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="extraPriceCharged">
                                                        <label class="form-check-label" for="extraPriceCharged">Price
                                                            Charged</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="logTime">
                                                        <label class="form-check-label" for="logTime">Log time</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="startTime">
                                                        <label class="form-check-label" for="startTime">Start Time</label>
                                                    </div>
                                                    <p>Please Enter Reason</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="endTime">
                                                        <label class="form-check-label" for="endTime">End Time</label>
                                                    </div>
                                                    <p>Please Enter Price Charged</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="custom_radio">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="omit">
                                                        <label class="form-check-label" for="omit">Omit</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom_radio custom_border_check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="omitReason">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    {{--    picture upload jquery --}}
    <script>
        $(document).ready(function() {
            $(".cancel_btn_funct").click(function () {
                window.location.href = "{{url('staffmembers')}}";
            });
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
    {{--    password show hide icon functionality --}}
    <script>
        $(document).ready(function() {
            $(".fa-eye").hide();
            $(".fa-eye-slash").show();
            $(".input_icon").click(function() {
                $(this).closest(".input_wrapper").find(".input_icon").toggleClass("fa-eye fa-eye-slash")
                var input = $(this).siblings(".pass_log");
                input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type',
                    'password')
            });
        });
    </script>

    {{-- Toggle Old Password Visibility --}}
    <script>
        $(document).ready(function() {
            $('#toggleOldPasswordBtn').on('click', function() {
                var passwordHiddenText = $('#old-password-hidden-text');
                var passwordVisibleText = $('#old-password-visible-text');
                var eyeIcon = $('#oldEyeIcon');

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

            $.validator.addMethod("strongPassword", function(value, element) {
                    return this.optional(element) ||
                        /^(?!.*\s)(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/.test(value);
                },
                "Password must be at least 8 characters long, alphanumeric, contain at least one capital letter, one special character, and must not include spaces."
            );

            $("#staffValidate").validate({
                rules: {
                    name: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    hiring_date: {
                        required: true
                    },
                    password: {
                        required: false,
                        strongPassword: true
                    },
                    confirm_password: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name."
                    },
                    address: {
                        required: "Please enter your address."
                    },
                    hiring_date: {
                        required: "Please enter your date of hiring."
                    },
                    password: {
                        minlength: "Your password must be at least 8 characters long and contain at least one capital letter."
                    },
                    confirm_password: {
                        equalTo: "Passwords do not match."
                    }
                },
                errorElement: "span",
                errorClass: "text-danger",

                submitHandler: function(form) {
                    Swal.fire({
                        title: 'Please wait',
                        text: 'Processing request, this may take a few seconds...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });
    </script>


    <script>
        document.querySelector('.custom_file_input').addEventListener('change', function(event) {
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            let startDateSecondPicker = flatpickr("#hiring_date", {
                dateFormat: "d/m/Y"
                // minDate: "today"
            });
        });
    </script>
@endpush
