<form id="kt_modal_update_role_form" class="form" method="post"
    action="{{ route('roles.update', ['role' => $role->id]) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    <!--begin::Scroll-->
    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
        data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="fs-5 fw-bold form-label mb-2">
                <span class="required">Role name</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control form-control-solid" placeholder="Enter a role name" name="name"
                value="{{ $role->name ?? '' }}" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Permissions-->
        <div class="fv-row">
            <!--begin::Label-->
            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
            <!--end::Label-->
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                        <!--begin::Table row-->
                        <tr>
                            <td class="text-gray-800">Administrator Access
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="Allows a full access to the system">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </td>
                            <td>
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="kt_roles_select_all" />
                                    <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                </label>
                                <!--end::Checkbox-->
                            </td>
                        </tr>
                        <!--end::Table row-->
                        <!--begin::Table row-->
                        @foreach ($allpermissions as $value)
                            <tr>
                                <!--begin::Label-->
                                <td class="text-gray-800">{{ $value->name }}</td>
                                <!--end::Label-->
                                <!--begin::Input group-->
                                <td>
                                    <!--begin::Wrapper-->
                                    <div class="d-flex">
                                        <!--begin::Checkbox-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                            <input class="form-check-input" type="checkbox" value="{{ $value->id }}"
                                                name="permission[]" @if (in_array($value->id, $rolepermissions)) checked @endif />
                                            <span
                                                class="form-check-label">{{ ucwords(str_replace('-', ' ', $value->name)) }}</span>
                                        </label>
                                        {{-- <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                        <input class="form-check-input" type="checkbox" value="{{$value->id}}" name="permission[]" />
                                        <span class="form-check-label">{{ucwords(str_replace('-',' ',$value->name))}}</span>
                                    </label> --}}
                                        <!--end::Checkbox-->
                                        <!--end::Checkbox-->
                                    </div>
                                    <!--end::Wrapper-->
                                </td>
                                <!--end::Input group-->
                           
                        @endforeach
                         </tr>
                        <!--end::Table row-->
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Permissions-->
    </div>
    <!--end::Scroll-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
