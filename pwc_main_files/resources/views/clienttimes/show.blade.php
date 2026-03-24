@extends('theme.layout.master')

@section('content')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{env('APP_NAME')}}</h1>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
<li class="breadcrumb-item text-muted">
<a href="{{url('home')}}" class="text-muted text-hover-primary">Home</a>
</li>
<li class="breadcrumb-item">
<span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">abtests</li>
</ul>
</div>
<div class="d-flex align-items-center gap-2 gap-lg-3">
<a href="javascript:void(0);" class="btn btn-sm fw-bold btn-primary" >Back</a>
</div>
</div>
</div>
@endsection
<div class="app-container container-xxl">
<div class="card card-flush">
<div class="card-body pt-0 pb-5">
<!--begin::Table-->
<table class="table align-middle table-row-dashed gy-5" id="kt_table_customers_payment">
<tbody>
<tr>
<th class="fw-bold">ID</th>
<td >{{ $clienttime->id }}</td>
</tr>
<tr>
<th class="fw-bold">Amount</th>
<td>1495-4289</td>
</tr>
<tr>
<th class="fw-bold">Date</th>
<td>1495-4289</td>
</tr>
<tr>
<th class="fw-bold">Invoice No.</th>
<td>1495-4289</td>
</tr>
</tbody>
<!--end::Table body-->
</table>
<!--end::Table-->
</div>
</div>
</div>

@stop