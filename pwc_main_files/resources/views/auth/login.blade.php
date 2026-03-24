{{--
<script>
    window.location.href = "https://paulswindowcleaning.org/";
</script>
<?php die; ?>
--}}

@extends('layouts.app')
@push("css")
    {{--<style>--}}
        {{--nav.navbar_header_sec,footer{display:none;}--}}
    {{--</style>--}}
@endpush

@section('content')
<!--begin::Authentication - Sign-in -->

<section class="login_pg_sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class=" login_pg_img_sec">
                    <!--begin::Aside-->
                    <div class="">
                        <img src="{{ asset('website') }}/assets/images/service_img1.png ">
                        <!--begin::Logo-->
                    {{--            <a href="{{url('login')}}" class="mb-7">--}}
                    {{--                <img alt="Logo" src="{{asset('')}}{{ App\Models\Setting::first()->logo??'' }}" />--}}
                    {{--            </a>--}}
                    {{--            <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>--}}
                    <!--end::Title-->
                    </div>
                    <!--begin::Aside-->
                </div>
            </div>
            <div class="col-md-6">
                <div class="sign_in_fields">
                    <!--begin::Card-->
                    <div class="bg-body  custom_background">
                        <!--begin::Wrapper-->
                        <div class="login_form_upper_wrapper">
                            <form class="form " novalidate="novalidate" method="POST" action="{{ route('login') }}">
                            @csrf
                            <!--begin::Heading-->
                            {{--                    <div class="text-center mb-11">--}}
                            {{--                        <!--begin::Title-->--}}
                            {{--                        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>--}}
                            {{--                        <!--end::Title-->--}}
                            {{--                        <!--begin::Subtitle-->--}}
                            {{--                        <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>--}}
                            {{--                        <!--end::Subtitle=-->--}}
                            {{--                    </div>--}}
                            <!--begin::Heading-->
                                <!--begin::Login options-->
                            {{--                    <div class="row g-3 mb-9">--}}
                            {{--                        <!--begin::Col-->--}}
                            {{--                        <div class="col-md-6">--}}
                            {{--                            <!--begin::Google link=-->--}}
                            {{--                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">--}}
                            {{--                                <img alt="Logo" src="{{asset('website/assets/media/svg')}}/brand-logos/google-icon.svg" class="h-15px me-3" />Sign in with Google</a>--}}
                            {{--                            <!--end::Google link=-->--}}
                            {{--                        </div>--}}
                            {{--                        <!--end::Col-->--}}
                            {{--                        <!--begin::Col-->--}}
                            {{--                        <div class="col-md-6">--}}
                            {{--                            <!--begin::Google link=-->--}}
                            {{--                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">--}}
                            {{--                                <img alt="Logo" src="{{asset('website/assets/media/svg')}}/brand-logos/apple-black.svg" class="theme-light-show h-15px me-3" />--}}
                            {{--                                <img alt="Logo" src="{{asset('website/assets/media/svg')}}/brand-logos/apple-black-dark.svg" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>--}}
                            {{--                            <!--end::Google link=-->--}}
                            {{--                        </div>--}}
                            {{--                        <!--end::Col-->--}}
                            {{--                    </div>--}}
                            <!--end::Login options-->
                                <!--begin::Separator-->
                            {{--                    <div class="separator separator-content my-14">--}}
                            {{--                        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>--}}
                            {{--                    </div>--}}
                            <!--end::Separator-->
                                <!--begin::Input group=-->
                                <div class="sign_in_heading">
                                    <h3>Sign In</h3>
                                </div>
                                <div class="input_filed_wrapper_sign form-floating">
                                    <!--begin::Email-->
                                    <input id="email floatingInput" type="email"  placeholder=""   class="form-control  bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="floatingInput">Email*</label>
                                    <p>  Please Enter Email</p>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>

                                @enderror

                                <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <div class=" input_filed_wrapper_sign form-floating input_wrapper">
                                    <!--begin::Password-->
                                    <input id="password" type="password" placeholder="" class="pass_log form-control bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label for="">Password*</label>
                                    <i class="fa-solid input_icon fa-eye"></i>
                                    <i class="fa-solid input_icon fa-eye-slash"></i>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>


                                @enderror
                                <!--end::Password-->
                                </div>
                                <!--end::Input group=-->
                                <!--begin::Wrapper-->
                                <div class="input_field_belwo_wapper">
                                    <div></div>
                                    <!--begin::Link-->

                                    <p>Please Enter Password should be atleast 8 characters long,alphanumeric and contain atleast one capital letter.</p>
                                    <div class="forget_checkbox_wrapper">
                                        <div>
                                            <input type="checkbox">
                                            <label>Remember Me</label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                                    </div>
                                    <!--end::Link-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Submit button-->
                                {{--                    <div class="btn_wrapper">--}}
                                {{--                        <a href="javascript:void(0)" class="btn_global  " >Submit Testimonial--}}
                                {{--                            <div class="btn_img_icon">--}}
                                {{--                                <img src="{{ asset('website') }}/assets/images/arrow-right.svg ">--}}
                                {{--                            </div>--}}
                                {{--                        </a>--}}

                                {{--                    </div>--}}
                                <div class="  btn_wrapper">
                                    <button type="submit" id="kt_sign_in_submit" class=" btn_global">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Sign In</span>

                                        <div class="btn_img_icon">--}}
                                            <img src="{{ asset('website') }}/assets/images/arrow-right.svg ">--}}
                                        </div>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                                <!--begin::Sign up-->
                            {{--                    <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?--}}
                            {{--                        <a href="{{ route('register') }}" class="link-primary">Sign up</a></div>--}}
                            <!--end::Sign up-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
    </div>
    <!--begin::Aside-->

    <!--begin::Aside-->
    <!--begin::Body-->

    <!--end::Body-->
</section>
<!--end::Authentication - Sign-in-->
@endsection

@push('js')
    {{--    password icon show hide --}}
    <script>
        // $(document).on('click','.password_field_wrapper .toggle_password',function(){
        //     $(this).toggleClass("fa-eye fa-eye-slash");
        //
        //     var input = $(this).closest('.password_field_wrapper').find('input').attr("type");
        //
        //     if ($(this).closest('.password_field_wrapper').find('input').attr("type") === "password") {
        //         $(this).closest('.password_field_wrapper').find('input').attr("type", "text");
        //     } else {
        //         $(this).closest('.password_field_wrapper').find('input').attr("type", "password");
        //     }
        // });
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
@endpush
