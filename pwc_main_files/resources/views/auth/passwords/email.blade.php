@extends('layouts.app')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Reset Password') }}</div>--}}

                {{--<div class="card-body">--}}
                    {{--@if (session('status'))--}}
                        {{--<div class="alert alert-success" role="alert">--}}
                            {{--{{ session('status') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--<form method="POST" action="{{ route('password.email') }}">--}}
                        {{--@csrf--}}

                        {{--<div class="row mb-3">--}}
                            {{--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

                                {{--@error('email')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="row mb-0">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Send Password Reset Link') }}--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

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
                            <form class="form" novalidate="novalidate" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <!--begin::Heading-->
                                <div class="sign_in_heading">
                                    <h3>Reset Password</h3>
                                </div>
                                <!--begin::Heading-->


                                <!--begin::Input group=-->
                                <div class="input_filed_wrapper_sign form-floating">
                                    <!--begin::Email-->
                                    <input id="email" type="email" placeholder="" class="form-control bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="email">Email*</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <!--begin::Submit button-->
                                <div class="btn_wrapper btn_wrapper_reset_pass_pg">
                                    <button type="submit" id="kt_sign_in_submit" class="btn_global">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Send</span>
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
</section>


    <!--end::Body-->

@endsection
