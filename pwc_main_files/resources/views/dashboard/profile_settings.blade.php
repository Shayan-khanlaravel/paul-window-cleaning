@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <h2 class="navbar_PageTitle">Profile Settings</h2>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
    <section class="profile_settings_sec ">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12 Only_show_filed">
                                  <div class="shadow_box_wrapper">
                                      <div class=" profile_settings_wrapper">
                                          <div class="profile_settings_only_img">
                                              <img class="input_image_field"
                                                   src="{{ asset('website/' .
                                                     (auth()->user() && auth()->user()->profile
                                                         ? auth()->user()->profile->pic
                                                         : 'users/no_avatar.jpg')
                                                ) }}">
                                          </div>

                                          <div class="profile_settings_edit_changePass">
                                              <button class="btn_global  btn_black edit_btn_fun" type="button">Edit<i class="fa-regular fa-pen-to-square"></i></button>
                                              <button class="btn_global btn_blue change_pass_btn_fun" type="button">Change Password<i class="fa-regular fa-eye"></i></button>
                                          </div>
                                      </div>
                                      <div class="user_details">
                                          <h3>{{auth()->user()->name??''}}</h3>
                                          <div class="first_name_user">
                                              <label>First Name: </label>
                                              <span>{{auth()->user()->first_name??''}}</span>
                                          </div>
                                          <div class="first_name_user">
                                              <label>Last Name: </label>
                                              <span>{{auth()->user()->last_name??''}}</span>
                                          </div>
                                          <div class="first_name_user">
                                              <label>Email:</label>
                                              <span>{{auth()->user()->email??''}}</span>
                                          </div>
                                          <div class="first_name_user">
                                              <label>Phone :</label>
                                              <span>{{auth()->user()->profile->phone??''}}</span>
                                          </div>
                                      </div>
                                  </div>
                          </div>
                          <div class="col-md-12 editable_filed">
                              <form id="profileEdit" action="{{url('profile_setting')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                  <div class="shadow_box_wrapper">
                                      <div class=" editable_sec_profile">
                                          <div class="profile_settings_wrapper ">
                                              <div class="profile_image">
                                                  <!--begin::Image input-->
                                                  <div class="image-input image-input-circle" data-kt-image-input="true">
                                                      <!--begin::Image preview wrapper-->
                                                    <div class="image-input-wrapper">
                                                        <?php 
                                                            // Default Image Path jo aapke 'website/' asset ke andar hai
                                                            $defaultImage = 'users/no_avatar.jpg'; 
                                                        ?>
                                                        
                                                        <img class="input_image_field" 
                                                            src="{{ asset('website/') . '/' . (auth()->user()?->profile?->pic ?? $defaultImage) }}" 
                                                            data-original-src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                            
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
                                              {{--                            <div class="profile_settings_edit_changePass">--}}
                                              {{--                                <button class="btn_global btn_blue" type="button">Edit<i class="fa-regular fa-pen-to-square"></i></button>--}}
                                              {{--                                <button class="btn_global btn_black" type="button">Change Password<i class="fa-regular fa-eye"></i></button>--}}
                                              {{--                            </div>--}}
                                          </div>
                                          <div class="user_details">
                                              <div class="row custom_row">
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field">
                                                          <input type="text" class="form-control" name="first_name" id="floatingInput" value="{{auth()->user()->first_name??''}}" placeholder="">
                                                          <label for="floatingInput">First Name</label>
                                                          <p>Please Enter First Name.</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field">
                                                          <input type="text" class="form-control" name="last_name" id="floatingInput_lst_name" value="{{auth()->user()->last_name??''}}" placeholder="">
                                                          <label for="floatingInput_lst_name">Last Name</label>
                                                          <p>Please Enter Last Name.</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field">
                                                          <input type="email" class="form-control" name="email" id="floatingInput_email" value="{{auth()->user()->email??''}}" readonly placeholder="">
                                                          <label for="floatingInput_email">Email</label>
{{--                                                          <p>Please Enter Email</p>--}}
                                                          <p>The Email Address is not Editable.</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field">
                                                          <input type="tel" class="form-control" name="phone" id="floatingInput_tel" value="{{auth()->user()->profile->phone??''}}" placeholder="">
                                                          <label for="floatingInput_tel">Phone</label>
                                                          <p>Please Enter Phone Number.</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-12">
                                                      <div class="custom_justify_between">
                                                          <button type="button" class="btn_global btn_grey cancel_btn_funct">Cancel <i class="fa-solid fa-xmark"></i></button>
                                                          <button type="submit" class="btn_global btn_blue">Save <i class="fa-solid fa-check"></i></button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                          <div class="col-md-12 change_password_field">
                              <form id="changePassword" action="{{url('update_password')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                  <div class="shadow_box_wrapper change_password_wrapper">
                                      <div class=" editable_sec_profile">
                                          <div class="user_details">
                                              <h3>Change Password</h3>
                                              <div class="row custom_row">
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field input_wrapper">
                                                          <input required type="password" name="old_password" class="form-control pass_log" id="floatingInput_current_password" placeholder="">
                                                          <i class="fa-solid input_icon fa-eye-slash"></i>
                                                          <i class="fa-solid input_icon fa-eye"></i>
                                                          <label for="floatingInput_current_password">Current Password *</label>
                                                          <p>Please Enter Current Password</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6"></div>
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field input_wrapper">
                                                          <input required type="password" name="password" class="form-control pass_log" id="floatingInput_change_password" placeholder="">
                                                          <i class="fa-solid input_icon fa-eye"></i>
                                                          <i class="fa-solid input_icon fa-eye-slash"></i>
                                                          <label for="floatingInput_change_password">Password *</label>
                                                          <p>Please Enter Password should be atleast 8 characters long,alphanumeric and contain atleast one capital letter.</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6"></div>
                                                  <div class="col-md-6">
                                                      <div class="form-floating txt_field input_wrapper">
                                                          <input required type="password" name="confirm_password" class="form-control pass_log" id="floatingInput_confirm_password" placeholder="">
                                                          <i class="fa-solid input_icon fa-eye"></i>
                                                          <i class="fa-solid input_icon fa-eye-slash"></i>
                                                          <label for="floatingInput_confirm_password">Confirm Password *</label>
                                                          <p>Please Enter Password for confirmation</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6"></div>
                                                  <div class="col-md-12">
                                                      <div class="custom_justify_between">
                                                          <button type="button" class="cancel_btn_funct btn_global btn_grey">Cancel <i class="fa-solid fa-xmark"></i></button>
                                                          <button type="submit" class="btn_global btn_blue">Save <i class="fa-solid fa-check"></i></button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                </div>
            </div>
        </div>
    </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="profile_settings_sec ">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="shadow_box_wrapper">
                                        <div class=" profile_settings_wrapper">
                                            <div class="profile_settings_only_img">
                                                <img class="input_image_field" src="{{ asset("website") }}/{{ auth()->user()->profile->pic ?? "users/no_avatar.jpg" }}">
                                            </div>
                                        </div>
                                        <div class="user_details">
                                            <h3>{{auth()->user()->name??''}}</h3>
                                            <div class="first_name_user">
                                                <label>First Name: </label>
{{--                                                <span>{{auth()->user()->first_name??''}}</span>--}}
                                                <span>{{ strtok(auth()->user()->name ?? '', ' ') }}</span>
                                            </div>
                                            <div class="first_name_user">
                                                <label>Last Name: </label>
{{--                                                <span>{{auth()->user()->last_name??''}}</span>--}}
                                                <span>{{ trim(strrchr(auth()->user()->name ?? '', ' ')) }}</span>
                                            </div>
                                            <div class="first_name_user">
                                                <label>Email:</label>
                                                <span>{{auth()->user()->email??''}}</span>
                                            </div>
                                            <div class="first_name_user">
                                                <label>Phone :</label>
                                                <span>{{auth()->user()->profile->phone??''}}</span>
                                            </div>
                                        </div>
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
{{--    picture upload jquery--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

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
{{--show hide functionality--}}
<script>
        $(document).ready(function() {
            $(".editable_filed").hide();
            $(".change_password_field").hide();
            $(".Only_show_filed").show();
            $(".edit_btn_fun").click(function() {
                $(".editable_filed").show();
                $(".Only_show_filed").hide();
            });
            $(".change_pass_btn_fun").click(function() {
                $(".change_password_field").show();
                $(".Only_show_filed").hide();
            });
            $(".cancel_btn_funct").click(function() {
                $(".Only_show_filed").show();
                $(".editable_filed").hide();
                $(".change_password_field").hide();
            });
        });

    </script>
<script>
    $(document).ready(function () {
        $("#profileEdit").validate({
            rules: {

                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    maxlength: 11
                }

            },
            messages: {

                first_name: {
                    required: "Please enter your First Name."
                },
                last_name: {
                    required: "Please enter your Last Name."
                },
                phone: {
                    required: "Please enter your Phone Number.",
                    digits: "Please enter only digits in the Phone Number.",
                    maxlength: "The Phone Number must not exceed 11 digits."
                }
            },
            errorElement: "span",
            errorClass: "text-danger",

            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $.validator.addMethod(
            "strongPassword",
            function (value, element) {
                return (
                    this.optional(element) ||
                    /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value)
                );
            },
            "Password must be at least 8 characters long, alphanumeric, and contain at least one capital letter."
        );

        $("#changePassword").validate({
            rules: {
                old_password: {
                    required: true
                },
                password: {
                    required: true,
                    strongPassword: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#floatingInput_change_password"
                }
            },
            messages: {
                old_password: {
                    required: "Please enter your current password."
                },
                password: {
                    required: "Please provide a new password.",
                    minlength:
                        "Your password must be at least 8 characters long and contain at least one capital letter."
                },
                confirm_password: {
                    required: "Please confirm your new password.",
                    equalTo: "Passwords do not match."
                }
            },
            errorElement: "span",
            errorClass: "text-danger",
            submitHandler: function (form) {
                const oldPassword = $("#floatingInput_current_password").val();
                $.ajax({
                    url: "check_password",
                    type: "GET",
                    data: { password: oldPassword },
                    success: function (response) {
                        if (response.isValid) {
                            form.submit();
                        } else {
                            const oldPasswordInput = $("#floatingInput_current_password");
                            oldPasswordInput.after(
                                '<span id="floatingInput_current_password-error" class="text-danger">Your current password is incorrect.</span>'
                            );
                            oldPasswordInput.addClass("is-invalid");
                        }
                    },
                    error: function () {
                        swal.fire("An error occurred while checking your password.");
                    }
                });
            }
        });
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
