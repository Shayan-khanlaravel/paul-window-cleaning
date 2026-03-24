@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Staff Requests</h2>
    </div>

    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input form-control searchInput">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="client_management staff_manag ">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="clients_tab custom_justify_between">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == null||session('key') != 'completed') active @endif" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="true">Request</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('key') == 'completed') active @endif" id="pills-potential_clients-tab" data-bs-toggle="pill" data-bs-target="#pills-potential_clients" type="button" role="tab" aria-controls="pills-potential_clients" aria-selected="false">Completed</button>
                                </li>
                            </ul>

                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('key') == null||session('key') != 'completed') active show @endif" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab" tabindex="0">
                                <div class="staff_req_card_grid">
                                    @php
                                        $filteredStaffRequests = $staffRequest->filter(function ($requirementsByTimestamp) {
                                            return $requirementsByTimestamp->contains(function ($requirement) {
                                                return $requirement->status === 'pending';
                                            });
                                        });
                                    @endphp

                                    @forelse($filteredStaffRequests as $groupKey => $requirementsByTimestamp)
                                        @php
                                            list($staffId, $timestamp) = explode('-', $groupKey);
                                            $firstRequirement = $requirementsByTimestamp->first();
                                        @endphp
                                        <a data-bs-target="#new_route" data-bs-toggle="modal" class="shadow_box_wrapper_staff_request"
                                           data-staff-pic="{{ asset('website') }}/{{$firstRequirement->staffRequirement->profile?->pic ?? 'users/no_avatar.jpg'}}"
                                           data-staff-name="{{$firstRequirement->staffRequirement->profile?->user?->name ?? 'N/A'}}"
                                           data-staff-email="{{$firstRequirement->staffRequirement->email ?? 'N/A'}}"
                                           data-staff-date="{{ $requirementsByTimestamp->first()->created_at->format('m-d-Y') ?? 'N/A' }}"
                                           data-request-items='@json($requirementsByTimestamp)'
                                           data-total-quantity="{{$requirementsByTimestamp->sum('quantity')}}"
                                           staff-id="{{$firstRequirement->staff_id??''}}"
                                           time-stamp="{{$firstRequirement->timestamp??''}}">                                            <div>
                                                <div class="staff_request_img_details_wrap">
                                                    <div class="">
                                                        {{-- <img src="{{ asset('website') }}/{{$firstRequirement->staffRequirement->profile->pic ?? ''}}"> --}}
                                                        <img src="{{ asset(optional(optional($firstRequirement->staffRequirement)->profile)->pic ? 'website/' . $firstRequirement->staffRequirement->profile->pic : 'website/users/no_avatar.jpg' ) }}"
                                                            alt="Profile Picture">
                                                    </div>
                                                    <div class="staff_request_dis tab-content">
                                                        <h5>{{$firstRequirement->staffRequirement->name??''}}</h5>
                                                        <div class="email_date_wrap">
                                                            <div>
                                                                <i class="fa-solid fa-envelope"></i>
                                                                <span>{{$firstRequirement->staffRequirement->email??''}}</span>
                                                            </div>
                                                            <div>
                                                                <i class="fa-solid fa-calendar"></i>
                                                                <span>{{ $requirementsByTimestamp->first()->created_at->format('m-d-Y') ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="request_items_wrap">
                                                    <div class="modal_justify_centerd">
                                                        <label>Requested Items</label>
                                                        <span>{{$requirementsByTimestamp->sum('quantity')}}x</span>
                                                    </div>
                                                    @foreach($requirementsByTimestamp as $requirement)
                                                        <div class="modal_justify_centerd">
                                                            <label>{{ ucfirst($requirement->name) }}s</label>
                                                            <span>{{$requirement->quantity ?? ''}}x</span>
                                                        </div>
                                                        @if($requirement->name == 'other' && $requirement->description)
                                                            <p>{{$requirement->description}}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div>There's No Pending Staff Requests Available.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="tab-pane fade @if(session('key') == 'completed') active show @endif" id="pills-potential_clients" role="tabpanel" aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                <div class="staff_req_card_grid">
                                    @php
                                        $filteredStaffRequests = $staffRequest->filter(function ($requirementsByTimestamp) {
                                            return $requirementsByTimestamp->contains(function ($requirement) {
                                                return $requirement->status === 'completed';
                                            });
                                        });
                                    @endphp

                                    @forelse($filteredStaffRequests as $groupKey => $requirementsByTimestamp)
                                        @php
                                            list($staffId, $timestamp) = explode('-', $groupKey);
                                            $firstRequirement = $requirementsByTimestamp->first();
                                        @endphp
                                        <a  class="shadow_box_wrapper_staff_request">
                                            <div>
                                                <div class="staff_request_img_details_wrap">
                                                    <div class="">
                                                        {{-- <img src="{{ asset('website') }}/{{$firstRequirement->staffRequirement->profile->pic ?? ''}}"> --}}
                                                       <img src="{{ asset(
                                                            $firstRequirement->staffRequirement?->profile?->pic
                                                                ? 'website/' . $firstRequirement->staffRequirement->profile->pic
                                                                : 'website/users/no_avatar.jpg'
                                                        ) }}"
                                                        alt="Profile Picture">
                                                    </div>
                                                    <div class="staff_request_dis tab-content">
                                                        <h5>{{$firstRequirement->staffRequirement->name??''}}</h5>
                                                        <div class="email_date_wrap">
                                                            <div>
                                                                <i class="fa-solid fa-envelope"></i>
                                                                <span>{{$firstRequirement->staffRequirement->email??''}}</span>
                                                            </div>
                                                            <div>
                                                                <i class="fa-solid fa-calendar"></i>
                                                                <span>{{ $requirementsByTimestamp->first()->created_at->format('m-d-Y') ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="request_items_wrap">
                                                    <div class="modal_justify_centerd">
                                                        <label>Requested Items</label>
                                                        <span>{{$requirementsByTimestamp->sum('quantity')}}x</span>
                                                    </div>
                                                    @foreach($requirementsByTimestamp as $requirement)
                                                        <div class="modal_justify_centerd">
                                                            <label>{{ ucfirst($requirement->name) }}s</label>
                                                            <span>{{$requirement->quantity ?? ''}}x</span>
                                                        </div>
                                                        @if($requirement->name == 'other' && $requirement->description)
                                                            <p>{{$requirement->description}}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div>There's No Completed Staff Requests Available.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--modal--}}
    <div class="modal fade new_route download_pdf_modal_sec staff_request_modal" id="new_route" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <form method="post" action="{{route('requirement_status')}}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
            <div class="modal-content">
                <input type="hidden" name="staff_id">
                <input type="hidden" name="timestamp">
                <div class="modal-header">
                    <div class="staff_request_img_details_wrap">
                        <div>
                            <img id="staff-pic" src="" alt="Staff Image">
                        </div>
                        <div class="staff_request_dis">
                            <h5 id="staff-name">N/A</h5>
                            <div class="email_date_wrap">
                                <div>
                                    <i class="fa-solid fa-envelope"></i>
                                    <span id="staff-email">N/A</span>
                                </div>
                                <div>
                                    <i class="fa-solid fa-calendar"></i>
                                    <span id="staff-date">N/A</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="request_items_wrap">
                        <div class="modal_justify_centerd">
                            <label>Requested Items</label>
                            <span id="total-quantity">0x</span>
                        </div>
                        <div id="request-items" class="request_items_wrap_parent"></div>
                    </div>
                </div>
                <div class="modal-footer custom_justify_between">
                    <button type="button" class="btn_global btn_grey" data-bs-dismiss="modal">Reject <i class="fa-solid fa-x"></i></button>
                    <button type="submit" class="btn_global btn_blue">Mark Complete <i class="fa-solid fa-check"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
{{--searchbar functionality--}}

<script>
    $(document).ready(function() {
        $('.searchInput').on('input', function() {
            var filter = $(this).val().toLowerCase();

            $('.tab-content').each(function() {
                var h2Text = $(this).find('h5').text().toLowerCase();
                if (h2Text.includes(filter)) {
                    $(this).show(); // Show the matching element
                } else {
                    $(this).hide(); // Hide the non-matching element
                }
            });
        });
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('new_route');
            const modalImage = modal.querySelector('#staff-pic');
            const modalStaffId = modal.querySelector('input[name="staff_id"]');
            const modalTimeStamp = modal.querySelector('input[name="timestamp"]');
            const modalName = modal.querySelector('#staff-name');
            const modalEmail = modal.querySelector('#staff-email');
            const modalDate = modal.querySelector('#staff-date');
            const modalTotalQuantity = modal.querySelector('#total-quantity');
            const modalItems = modal.querySelector('#request-items');

            document.querySelectorAll('.shadow_box_wrapper_staff_request').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    modalImage.src = this.getAttribute('data-staff-pic') || '';
                    modalName.textContent = this.getAttribute('data-staff-name') || 'N/A';
                    modalStaffId.value = this.getAttribute('staff-id') || 'N/A';
                    modalTimeStamp.value = this.getAttribute('time-stamp') || 'N/A';
                    modalEmail.textContent = this.getAttribute('data-staff-email') || 'N/A';
                    modalDate.textContent = this.getAttribute('data-staff-date') || 'N/A';
                    modalTotalQuantity.textContent = `${this.getAttribute('data-total-quantity')}x`;

                    const requestItems = JSON.parse(this.getAttribute('data-request-items'));
                    modalItems.innerHTML = '';
                    requestItems.forEach(function (item) {
                        const itemHTML = `
                     <div class="request_items_wrap">
                    <div class="modal_justify_centerd">
                        <label>${item.name.charAt(0).toUpperCase() + item.name.slice(1)}s</label>
                        <span>${item.quantity ?? ''}x</span>
                    </div>
                        <div class="modal_justify_centerd"> ${item.name === 'other' && item.description ? `<p>${item.description}</p>` : ''}</div>
                    </div>

                `;
                        modalItems.insertAdjacentHTML('beforeend', itemHTML);
                    });
                });
            });
        });

    </script>
@endpush
