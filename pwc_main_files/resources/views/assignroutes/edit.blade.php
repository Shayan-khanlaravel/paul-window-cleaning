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
<a href="{{url('home')}}" class="text-muted text-hover-primary">Home</a>
</li>
<li class="breadcrumb-item">
<span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">assignroutes</li>
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
<form method="post" action="{{route('assignroutes.update',$assignroute->id)}}" class="form-horizontal" enctype="multipart/form-data">
{{ method_field('PATCH') }}
{{ csrf_field() }}
<div class="row g-7">




                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="required">Route_id</span>
                </label>
                <select name="route_id" required class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a Route_id">
                <option disabled>Choose Route_id</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
                </div>
                <input type="hidden" name="staff_id"  class="" placeholder="" value="{{$assignroute->staff_id??''}}"/>
                </div>

<div class="text-center">
<a href="{{route('assignroutes.index')}}" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</a>
<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
<span class="indicator-label">Update</span>
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