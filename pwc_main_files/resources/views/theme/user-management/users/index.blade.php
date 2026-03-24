@extends('theme.layout.master')
@section('breadcrumb')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                {{--                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ config('app.name') }}</h1>--}}
                {{--                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">--}}
                {{--                    <li class="breadcrumb-item text-muted">--}}
                {{--                        <a href="{{url('home')}}" class="text-muted text-hover-primary">Home</a>--}}
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
@section('content')

    @if(auth()->user()->hasRole('developer'))
        <div id="kt_app_content" class="app-content developers_user_management flex-column-fluid">
            <div id="kt_app_content_container" class="app-container ">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                {{--                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">--}}
                                {{--                                <span class="path1"></span>--}}
                                {{--                                <span class="path2"></span>--}}
                                {{--                            </i>--}}
                                {{--                            <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Customers" />--}}
                                <h2>User Management</h2>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Filter-->
                                {{--                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">--}}
                                {{--                                <i class="ki-duotone ki-filter fs-2">--}}
                                {{--                                    <span class="path1"></span>--}}
                                {{--                                    <span class="path2"></span>--}}
                                {{--                                </i>Filter</button>--}}
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                    <div class="px-7 py-5">
                                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>
                                    <div class="px-7 py-5">
                                        <div class="mb-10">
                                            <label class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                                <option></option>
                                                <option value="aug">August</option>
                                                <option value="sep">September</option>
                                                <option value="oct">October</option>
                                                <option value="nov">November</option>
                                                <option value="dec">December</option>
                                            </select>
                                        </div>
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                            <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="payment_type">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" />
                                                    <span class="form-check-label text-gray-600">All</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                                    <span class="form-check-label text-gray-600">Visa</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="mastercard" />
                                                    <span class="form-check-label text-gray-600">Mastercard</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="american_express" />
                                                    <span class="form-check-label text-gray-600">American Express</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                {{--                            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">--}}
                                {{--                                <i class="ki-duotone ki-exit-up fs-2">--}}
                                {{--                                    <span class="path1"></span>--}}
                                {{--                                    <span class="path2"></span>--}}
                                {{--                                </i>Export</button>--}}
                                @can(\Illuminate\Support\Str::slug('user').'-create')
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">Add Users</a>
                                @endcan
                            </div>
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                                <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                            </div>
                        </div>
                    </div>

                    <!--end::Card header-->
                    <div class="card-body custom_table scroll_X">
                        <table class="table align-middle  without_pagination_tbl datatable " id="kt_customers_table">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-125px">No</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Email</th>
                                <th class="min-w-125px">Roles</th>
                                <th class="min-w-125px">Created Date</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="../../demo1/dist/apps/customers/view.html" class="text-gray-500 text-hover-primary mb-1">{{ $user->name??'' }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-gray-500 text-hover-primary mb-1">{{ $user->email??'' }}</a>
                                    </td>
                                    <td data-filter="mastercard">
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                    <td>{{ $user->created_at->format('d M Y, g:i a')??'' }}</td>
                                    <td class="text-center">
                                        <a href="#" class=" btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="fa-solid fa-ellipsis"></i>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                @can('user-list')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('users.show',$user->id) }}" class="menu-link px-3">View</a>
                                                    </div>
                                                @endcan
                                                @can('user-edit')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('users.edit',$user->id) }}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                @endcan
                                                <div class="menu-item px-3">
                                                    @can(\Illuminate\Support\Str::slug('user').'-delete')
                                                        <form method="POST"
                                                              action="{{ route('users.destroy', [$user->id]) }}"
                                                              accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="menu-link px-3 user_mng_delete_btn" data-kt-customer-table-filter="delete_row"
                                                                    title="Delete {{ preg_replace('/(?<=[a-z])[A-Z]|[A-Z](?=[a-z])/', ' $0', 'User') }}"
                                                                    onclick="return confirm(&quot;Confirm delete?&quot;)"> Delete
                                                            </button>
                                                        </form>
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
    @elseif(auth()->user()->hasRole('paul'))
        <div id="kt_app_content" class="app-content developers_user_management flex-column-fluid developer_staff_management">
            <div id="kt_app_content_container" class="app-container ">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                {{--                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">--}}
                                {{--                                <span class="path1"></span>--}}
                                {{--                                <span class="path2"></span>--}}
                                {{--                            </i>--}}
                                {{--                            <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Customers" />--}}
                             <a href="{{url('users/create')}}" class="btn_global btn_blue">Create Staff <i class="fa-solid fa-user-group"></i></a>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Filter-->
                                {{--                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">--}}
                                {{--                                <i class="ki-duotone ki-filter fs-2">--}}
                                {{--                                    <span class="path1"></span>--}}
                                {{--                                    <span class="path2"></span>--}}
                                {{--                                </i>Filter</button>--}}
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                    <div class="px-7 py-5">
                                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>
                                    <div class="px-7 py-5">
                                        <div class="mb-10">
                                            <label class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                                <option></option>
                                                <option value="aug">August</option>
                                                <option value="sep">September</option>
                                                <option value="oct">October</option>
                                                <option value="nov">November</option>
                                                <option value="dec">December</option>
                                            </select>
                                        </div>
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                            <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="payment_type">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" />
                                                    <span class="form-check-label text-gray-600">All</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                                    <span class="form-check-label text-gray-600">Visa</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="mastercard" />
                                                    <span class="form-check-label text-gray-600">Mastercard</span>
                                                </label>
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="payment_type" value="american_express" />
                                                    <span class="form-check-label text-gray-600">American Express</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                {{--                            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">--}}
                                {{--                                <i class="ki-duotone ki-exit-up fs-2">--}}
                                {{--                                    <span class="path1"></span>--}}
                                {{--                                    <span class="path2"></span>--}}
                                {{--                                </i>Export</button>--}}
                                @can(\Illuminate\Support\Str::slug('user').'-create')
                                    <button type="button" class="btn btn_black">Filter<i class="fa-solid fa-filter"></i></button>
                                @if(auth()->user()->hasRole('developer'))
                                    <a href="{{ route('users.create') }}" class="btn btn_blue">Add Users</a>
                                    @endif

                                @endcan
                            </div>
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                                <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <div class="card-body custom_table scroll_X">
                        <table class="table align-middle  without_pagination_tbl datatable " id="kt_customers_table">
                            <thead>
                            <tr >
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Created</th>
                                <th>Jobs Completed </th>
                                <th>Status </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach ($data as $key => $user)
                                <tr>

                                    <td>
                                      <div class="custom_flex">
                                          <div class="table_image">
                                              <img src="{{ asset('website') }}/assets/images/user.png" alt="">
                                          </div>
                                          <a href="#!">Michael Jones</a>

                                      </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);">{{ $user->email??'' }}</a>
                                    </td>
                                    <td>12-04-2024</td>
                                    <td>13</td>
                                    <td><span class="success">Assigned</span></td>
{{--                                    "DANGER " CLASS FOR UNASSIGNED--}}
                                    <td class="text-center">
                                        <a href="#" class=" " data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="fa-solid fa-ellipsis"></i>
                                            <!--begin::Menu-->

                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                @can('user-list')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('users.show',$user->id) }}" class="menu-link px-3">View</a>
                                                    </div>
                                                @endcan
                                                @can('user-edit')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('users.edit',$user->id) }}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                @endcan

                                                <div class="menu-item px-3">
                                                    @can(\Illuminate\Support\Str::slug('user').'-delete')
                                                        <form method="POST"
                                                              action="{{ route('users.destroy', [$user->id]) }}"
                                                              accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn_delete" data-kt-customer-table-filter="delete_row"
                                                                    title="Delete {{ preg_replace('/(?<=[a-z])[A-Z]|[A-Z](?=[a-z])/', ' $0', 'User') }}"
                                                                    onclick="return confirm(&quot;Confirm delete?&quot;)"> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('plugins/components/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click','.delete',function (e) {
                if(confirm('Are you sure want to delete?'))
                {
                }
                else
                {
                    return false;
                }
            });
            @if(\Session::has('message'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('message')}}',
                loaderBg: '#ff6849',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            @endif
        })

        $(function() {
            // $('#kt_customers_table').DataTable({
            //     "columns": [
            //         null, null,null, {"orderable": false}
            //     ]
            // });

        });
    </script>

@endpush
