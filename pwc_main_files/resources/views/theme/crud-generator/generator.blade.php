@extends('theme.layout.master')

@push('css')
<link href="{{asset('website')}}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"  />
@endpush

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
	<div id="kt_app_content_container" class="app-container container-xxl">
		<div class="d-flex flex-column flex-lg-row">
			<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
				<form class="form form-horizontal" method="post" action="{{url('crud_generator_process')}}" id="kt_subscriptions_create_new">
					@csrf
					<div class="card card-flush pt-3 mb-5 mb-lg-10">
						<div class="card-header">
							<div class="card-title">
								<h2 class="fw-bold">CRUD Generator</h2>
							</div>
						</div>
						<div class="card-body pt-0">
							<div class="d-flex flex-column mb-15 fv-row">
								<div class="row">
									<div class="col-sm-12">
										<div class="fs-5 fw-bold form-label mb-3">Model Name</div>
										<input type="text" class="form-control" name="model_name" id="model_name" placeholder="Eg. Book, Category, Author" required>
										<span>Provide a class name (singular and first letter caps) for the CRUD Model</span>
									</div>
									
								</div>
								<hr>
								<div class="table-responsive">
									<table id="kt_create_new_custom_fields" class="table align-middle table-row-dashed fw-semibold fs-6 gy-5">
										<thead>
											<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
												<th class="pt-0">Field Name</th>
												<th class="pt-0">Data Type</th>
												<th class="pt-0">Field Type</th>
												<th class="pt-0">Required</th>
												<th class="pt-0 text-end">Remove</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<input type="text" class="form-control form-control-solid column_name" name="column_name[]" placeholder="Eg. first_name, last_name, email" required="" />
												</td>
												<td>
													<select name="data_type[]" class="form-control" required="">
														<option value="string">varchar</option>
														 {{--<option value="password">password</option> --}}
														 {{--<option value="email">email</option> --}}
														<option value="text">text</option>
														 <option value="integer">number</option>
													</select>
												</td>																
												<td>
													<select name="input_type[]" class="form-control" required="">
														<option value="text">Text Field</option>
														<option value="number">Number</option>
														<option value="textarea">Text Area</option>
														<option value="email">Email</option>
														<option value="switch">Switch</option>
														<option value="select">Select</option>
														 <option value="file">File</option>
														 <option value="checkbox">checkbox</option>
														  <option value="hidden">Hidden</option>
														 <option value="radio">radio</option>
														
													</select>
												</td>
												<td>
													<select name="is_required[]" class="form-control" required="">
														<option value="false">No</option>
														<option value="true">Yes</option>
														
													</select>
												</td>
												<td class="text-end">
													<button type="button" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-3" data-kt-action="field_remove">
														<i class="ki-duotone ki-trash fs-3">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
									<button type="button" class="btn btn-light-primary me-auto" style="float: right;" id="kt_create_new_custom_fields_add">Add More</button>	
								</div>
								<div class="row"><hr>
									<div class="col-sm-5"></div>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary me-auto">Submit</button>	
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
@endsection

@push('js')
<script>
	$(document).ready(function() {
		$("#kt_create_new_custom_fields_add").on("click", function() {
			var newRow = $("#kt_create_new_custom_fields tbody tr:last").clone();
			newRow.find("input").val("");
			$("#kt_create_new_custom_fields tbody").append(newRow);
		});

		$("#kt_create_new_custom_fields").on("click", '[data-kt-action="field_remove"]', function() {
			var rowCount = $("#kt_create_new_custom_fields tbody tr").length;
			if (rowCount === 1) {
				Swal.fire({
					title: "OOPS!",
					html: "At least one complete row is required.",
					icon: "warning",
					timer: 5000,
					buttons: false,
				});
			} else {
				$(this).closest("tr").remove();
			}
		});
	});

	$("#model_name").on("change keyup paste click", function(event){
		if (this.value.match(/[^a-zA-Z áéíóúÁÉÍÓÚüÜ]/g))
		{
			this.value = this.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚüÜ]/g, '');
		}

		var input = $(this).val();
		input = input.replace(/\s/g, '');
		input = input.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
		$(this).val(upperCase(input));
	})
	function upperCase(str) {
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			return $1.toUpperCase();
		});
	}
	function lowerCase(str) {
		return (str + '').replace(/^([A-Z])|\s+([A-Z])/g, function ($1) {
			return $1.toLowerCase();
		});
	}
	$(document).on('keypress',".column_name",function(event) {
		var inputValue = event.key;
		var currentValue = $(this).val();
		    var regex = /^[a-z_]+$/; // Only lowercase letters and underscore

		    // Allow backspace, delete, and arrow keys
		    if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 37 || event.keyCode === 39) {
		    	return true;
		    }

		    // Check if the input is a valid character
		    if (!regex.test(inputValue)) {
		    	event.preventDefault();
		    	return false;
		    }

		    // Check for consecutive underscores
		    if (inputValue === '_' && currentValue.endsWith('_')) {
		    	event.preventDefault();
		    	return false;
		    }
		});
	</script>
	@endpush
