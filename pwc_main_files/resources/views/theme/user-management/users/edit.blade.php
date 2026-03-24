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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ config('app.name') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('home') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit Users</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
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
                <form method="post" action="{{ route('users.update', $user->id) }}" class="form-horizontal"
                    enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="row g-7">
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="">Name</span>
                        </label>
                        <input type="text" name="name" class="form-control form-control-solid" placeholder="Name"
                            value="{{ $user->name ?? '' }}" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Email</span>
                        </label>
                        <input type="email" name="email" required class="form-control form-control-solid"
                            placeholder="Email" value="{{ $user->email ?? '' }}" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Password</span>
                        </label>
                        <input type="password" name="password" class="form-control form-control-solid"
                            placeholder="password" value="" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Confirm Password</span>
                        </label>
                        <input type="password" name="confirm-password" class="form-control form-control-solid"
                            placeholder="Confirm Password" value="" />
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="form-label">
                            <span class="required">Roles</span>
                        </label>
                        {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-select form-select-solid']) !!}
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
                                @if ($user->profile->pic != null)
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url('{{ asset('website'}}/{{$user->profile->pic }}');">
                                    </div>
                                @else
                                    <div class="image-input-wrapper w-125px h-125px"></div>
                                @endif

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
                                    <input type="hidden" name="avatar_remove" />
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
                            <span class="indicator-label">Update User</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>

            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
@push('js')
<script src="assets/js/scripts.bundle.js"></script>
@endpush
