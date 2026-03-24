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
<li class="breadcrumb-item text-muted">cmshomes</li>
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
<form method="post" action="{{route('cmshomes.store')}}" class="form-horizontal" enctype="multipart/form-data">
@csrf
<div class="row g-7">




                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_one_heading</span>
                </label>
                <input type="text" name="section_one_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_one_description</span>
                </label>
                <input type="text" name="section_one_description"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_two_heading</span>
                </label>
                <input type="text" name="section_two_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_one_heading</span>
                </label>
                <input type="text" name="two_sub_section_one_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_one_title</span>
                </label>
                <input type="text" name="two_sub_section_one_title"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_two_heading</span>
                </label>
                <input type="text" name="two_sub_section_two_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_two_title</span>
                </label>
                <input type="text" name="two_sub_section_two_title"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_three_heading</span>
                </label>
                <input type="text" name="section_three_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_three_description</span>
                </label>
                <input type="text" name="section_three_description"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Three_sub_section_one_heading</span>
                </label>
                <input type="text" name="three_sub_section_one_heading"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Three_sub_section_one_description</span>
                </label>
                <input type="text" name="three_sub_section_one_description"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Three_sub_section_one_link</span>
                </label>
                <input type="text" name="three_sub_section_one_link"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_two_image_one</span>
                </label>
                <input type="text" name="section_two_image_one"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Section_two_image_two</span>
                </label>
                <input type="text" name="section_two_image_two"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_one_icon</span>
                </label>
                <input type="text" name="two_sub_section_one_icon"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Two_sub_section_two_icon</span>
                </label>
                <input type="text" name="two_sub_section_two_icon"  class="form-control form-control-solid" placeholder=""/>
                </div>
                <div class="col-md-12 fv-row">
                <label class="form-label">
                <span class="">Three_sub_section_one_image</span>
                </label>
                <input type="text" name="three_sub_section_one_image"  class="form-control form-control-solid" placeholder=""/>
                </div>

<div class="text-center">
<a href="{{route('cmshomes.index')}}" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</a>
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