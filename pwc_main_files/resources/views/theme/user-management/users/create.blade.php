@extends('theme.layout.master')
@push('css')
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        .image-input-placeholder {
            background-image: url("{{ asset('website/assets/media/avatars') }}/avatar.svg");
        }
    </style>
@endpush
@section('content')
@section('breadcrumb')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
{{--                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">--}}
{{--                    {{ config('app.name') }}</h1>--}}
{{--                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">--}}
{{--                    <li class="breadcrumb-item text-muted">--}}
{{--                        <a href="{{ url('home') }}" class="text-muted text-hover-primary">Home</a>--}}
{{--                    </li>--}}
{{--                    <li class="breadcrumb-item">--}}
{{--                        <span class="bullet bg-gray-400 w-5px h-2px"></span>--}}
{{--                    </li>--}}
{{--                    <li class="breadcrumb-item text-muted">Users</li>--}}
{{--                </ul>--}}
            </div>
        </div>
    </div>
@endsection
@if(auth()->user()->hasRole('developer'))
<div id="" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('users.store') }}" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-7">
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="">Name</span>
                        </label>
                        <input type="text" name="name" class="form-control form-control-solid"
                            placeholder="Name" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Email</span>
                        </label>
                        <input type="email" name="email" required class="form-control form-control-solid"
                            placeholder="Email" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Password</span>
                        </label>
                        <input type="password" name="password" required class="form-control form-control-solid"
                            placeholder="password" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Confirm Password</span>
                        </label>
                        <input type="password" name="confirm-password" required class="form-control form-control-solid"
                            placeholder="Confirm Password" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Roles</span>
                        </label>
                        {!! Form::select('roles[]', $roles, [], ['class' => 'form-select form-select-solid']) !!}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="">Picture</span>
                        </label>
                        <!--begin::Image input-->
                        <div>
                            <div class="image-input image-input-placeholder image-input-empty"
                                data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-125px h-125px"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="pic" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" required name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Cancel avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Remove avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('users.index') }}" id="kt_modal_new_target_cancel"
                            class="btn btn-light me-3">Cancel</a>
                        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                            <span class="indicator-label">Create User</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>

            </div>
        </div>
        </form>
    </div>
</div>

@elseif(auth()->user()->hasRole('paul'))
    <div id="" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('users.store') }}" class="form-horizontal"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row g-7">
                            <div class="col-md-12">
                                <div class="profile_settings_wrapper ">
                                    <div class="profile_image">
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-circle" data-kt-image-input="true">
                                            <!--begin::Image preview wrapper-->
                                            <div class="image-input-wrapper">
                                                <img class="input_image_field" src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg" data-original-src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
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
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" class="myinput custom_file_input"/>
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field">
                                    <input type="text" class="form-control" id="floatingInput" placeholder=""/>
                                    <label for="floatingInput">Name</label>
                                </div>
                                <p>Please Enter Name</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field">
                                    <input type="email" class="form-control" id="floatingInput" placeholder=""/>
                                    <label for="floatingInput">Email</label>
                                </div>
                                <p>Please Enter Email</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field">
                                    <input type="text" class="form-control" id="floatingInput" placeholder=""/>
                                    <label for="floatingInput">Address</label>
                                </div>
                                <p>Please Enter Address</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field">
                                    <input type="date" class="form-control" id="floatingInput" placeholder=""/>
                                    <label for="floatingInput">Date Of Birth</label>
                                </div>
                                <p>Please Enter Date of Birth</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field ">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="" required/>
                                    <label for="floatingPassword">Password*</label>
                                </div>
                                <p>Please Enter Password should be atleast 8 characters long,alphanumeric and contain atleast one capital letter.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating txt_field">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="" required/>
                                    <label for="floatingPassword">Confirm Password* </label>
                                </div>
                                <p>Please Enter Password for confirmation</p>
                            </div>
                            <div class="col-md-12">

                                <div class="custom_justify_between">
                                    <button type="button" class="btn_global btn_grey">Cancel <i class="fa-solid fa-xmark"></i></button>
                                    <button type="button" class="btn_global btn_blue">Create <i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            </form>
        </div>
    </div>
@endif
</div>
</div>
@endsection
@push('js')
<script src="assets/js/scripts.bundle.js"></script>
@endpush
