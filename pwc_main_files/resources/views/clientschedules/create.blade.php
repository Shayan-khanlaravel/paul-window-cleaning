@extends('theme.layout.master')
@push('css')
<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"  />
<style>
.image-input-placeholder {
background-image: url("{{asset('website/assets/media/avatars')}}/avatar.svg");
}


</style>
@endpush
@section('content')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ config('app.name') }}</h1>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
<li class="breadcrumb-item text-muted">
<a href="#!" class="text-muted text-hover-primary">Home</a>
</li>
<li class="breadcrumb-item">
<span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">clientschedules</li>
</ul>
</div>
</div>
</div>
@endsection
<div id="" class="app-content flex-column-fluid">
<div id="kt_app_content_container" class="app-container container-xxl">
@if($errors->any())
<div class="alert alert-danger">
@foreach ($errors->all() as $error)
{{ $error }} <br>
@endforeach
</div>
@endif
<div class="card">
<div class="card-body">
<form method="post" action="{{route('clientschedules.store')}}" class="form-horizontal" enctype="multipart/form-data">
@csrf
<div class="row g-7">




                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Client_id</span>
                </label>
                <input type="text" name="client_id"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Month</span>
                </label>
                <input type="text" name="month"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Week</span>
                </label>
                <input type="text" name="week"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Start_date</span>
                </label>
                <input type="text" name="start_date"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">End_date</span>
                </label>
                <input type="text" name="end_date"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Payment_type</span>
                </label>
                <input type="text" name="payment_type"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Note</span>
                </label>
                <input type="text" name="note"  class="form-control form-control-solid" placeholder=""/>
                </div>

<div class="text-center">
<a href="{{route('clientschedules.index')}}" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</a>
<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
<span class="indicator-label">{{ $submitButtonText??'Create' }}</span>
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
{{--@stop--}}
@push('js')
<script src="{{asset('website')}}/assets/js/scripts.bundle.js"></script>
@endpush