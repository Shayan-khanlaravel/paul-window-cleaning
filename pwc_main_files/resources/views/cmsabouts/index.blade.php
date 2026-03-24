@extends('theme.layout.master')
@push('css')

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
<li class="breadcrumb-item text-muted">cmsabouts</li>
</ul>
</div>
</div>
</div>
@endsection
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content_container" class="app-container container-xxl">
			<div class="card">
				<div class="card-header border-0 pt-6">
					<div class="card-title">
						<div class="d-flex align-items-center position-relative my-1">
							<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
							<input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Customers" />
						</div>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
						@can('cmsabouts-create')
							<a  class="btn btn-primary" href="{{ route('cmsabouts.create') }}">Add</a>
							@endcan
						</div>
					</div>
				</div>
				<div class="card-body pt-0">

					<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
						<thead>
							<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
								<th class="w-10px pe-2">
									<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
										<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
									</div>
								</th>
												<th>section_one_heading</th>
				<th>section_one_description</th>
				<th>section_two_heading</th>
				<th>two_sub_section_one_heading</th>
				<th>two_sub_section_one_description</th>
				<th>two_sub_section_one_link_one</th>
				<th>two_sub_section_one_link_two</th>
				<th>two_sub_section_two_heading</th>
				<th>two_sub_section_two_description</th>
				<th>two_sub_section_two_link_one</th>
				<th>two_sub_section_two_link_two</th>
				<th>two_sub_section_three_heading</th>
				<th>two_sub_section_three_description</th>
				<th>two_sub_section_three_link_one</th>
				<th>two_sub_section_three_link_two</th>
				<th>two_sub_section_four_heading</th>
				<th>two_sub_section_four_description</th>
				<th>two_sub_section_four_link_one</th>
				<th>two_sub_section_four_link_two</th>
				<th>two_sub_section_five_heading</th>
				<th>two_sub_section_five_description</th>
				<th>two_sub_section_five_link_one</th>
				<th>two_sub_section_five_link_two</th>
				<th>section_one_image</th>
				<th>two_sub_section_one_image</th>
				<th>two_sub_section_two_image</th>
				<th>two_sub_section_three_image</th>
				<th>two_sub_section_four_image</th>
				<th>two_sub_section_five_image</th>
				<th>two_sub_section_one_title</th>
				<th>two_sub_section_two_title</th>
				<th>two_sub_section_three_title</th>
				<th>two_sub_section_four_title</th>
				<th>two_sub_section_five_title</th>

								<th class="text-end min-w-70px">Actions</th>
							</tr>
						</thead>
						<tbody class="fw-semibold text-gray-600">
							@foreach($cmsabouts as $cmsabout)
								<tr>
									<td>
										<div class="form-check form-check-sm form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="{{$cmsabout->id}}" />
										</div>
									</td>
														<td>{{ $cmsabout->section_one_heading }}</td>
					<td>{{ $cmsabout->section_one_description }}</td>
					<td>{{ $cmsabout->section_two_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_one_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_one_description }}</td>
					<td>{{ $cmsabout->two_sub_section_one_link_one }}</td>
					<td>{{ $cmsabout->two_sub_section_one_link_two }}</td>
					<td>{{ $cmsabout->two_sub_section_two_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_two_description }}</td>
					<td>{{ $cmsabout->two_sub_section_two_link_one }}</td>
					<td>{{ $cmsabout->two_sub_section_two_link_two }}</td>
					<td>{{ $cmsabout->two_sub_section_three_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_three_description }}</td>
					<td>{{ $cmsabout->two_sub_section_three_link_one }}</td>
					<td>{{ $cmsabout->two_sub_section_three_link_two }}</td>
					<td>{{ $cmsabout->two_sub_section_four_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_four_description }}</td>
					<td>{{ $cmsabout->two_sub_section_four_link_one }}</td>
					<td>{{ $cmsabout->two_sub_section_four_link_two }}</td>
					<td>{{ $cmsabout->two_sub_section_five_heading }}</td>
					<td>{{ $cmsabout->two_sub_section_five_description }}</td>
					<td>{{ $cmsabout->two_sub_section_five_link_one }}</td>
					<td>{{ $cmsabout->two_sub_section_five_link_two }}</td>
					<td>{{ $cmsabout->section_one_image }}</td>
					<td>{{ $cmsabout->two_sub_section_one_image }}</td>
					<td>{{ $cmsabout->two_sub_section_two_image }}</td>
					<td>{{ $cmsabout->two_sub_section_three_image }}</td>
					<td>{{ $cmsabout->two_sub_section_four_image }}</td>
					<td>{{ $cmsabout->two_sub_section_five_image }}</td>
					<td>{{ $cmsabout->two_sub_section_one_title }}</td>
					<td>{{ $cmsabout->two_sub_section_two_title }}</td>
					<td>{{ $cmsabout->two_sub_section_three_title }}</td>
					<td>{{ $cmsabout->two_sub_section_four_title }}</td>
					<td>{{ $cmsabout->two_sub_section_five_title }}</td>
										
									<td class="text-end">
										<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
											<i class="ki-duotone ki-down fs-5 ms-1"></i>
										</a>
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
										@can('cmsabouts-list')
											<div class="menu-item px-3">
												<a href="{{ route('cmsabouts.show', [$cmsabout->id]) }}" class="menu-link px-3">View</a>
											</div>
											@endcan
											@can('cmsabouts-edit')
											<div class="menu-item px-3">
												<a href="{{ route('cmsabouts.edit', [$cmsabout->id]) }}" class="menu-link px-3">Edit</a>
											</div>
											@endcan
											@can('cmsabouts-delete')
											<div class="menu-item px-3">
												{!! Form::open(['method' => 'DELETE', 'route' => ['cmsabouts.destroy', $cmsabout->id], 'class' => 'delete-form']) !!}
                                                    <a class="menu-link px-3" href="javascript:void(0)" onclick="showDeleteConfirmation(this)">Delete</a>
					                            {!! Form::close() !!}
					                            @endcan
											</div>
										</div>
									</td>
								</tr>
							@endforeach								
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
@stop
@push('js')

@endpush