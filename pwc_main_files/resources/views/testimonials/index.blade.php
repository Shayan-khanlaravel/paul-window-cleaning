@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Testimonials</h2>
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
                                    <button class="nav-link @if (session('key') == null || session('key') != 'accepted') active @endif" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="true">Request</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if (session('key') == 'accepted') active @endif" id="pills-potential_clients-tab" data-bs-toggle="pill" data-bs-target="#pills-potential_clients" type="button" role="tab" aria-controls="pills-potential_clients" aria-selected="false">Accepted</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if (session('key') == null || session('key') != 'accepted') active show @endif" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab" tabindex="0">
                                <div class="staff_req_card_grid_testimonial">
                                    <div class="delete_testimonial_cards_button d-flex align-items-center justify-content-between mb-3">
                                        @can('testimonials-delete')
                                            <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                                <input type="checkbox" class="select_all_checkbox" data-target="#pills-clients">
                                                <span>Select All</span>
                                                <br />
                                                <br />
                                                <br />
                                            </label>
                                        @endcan
                                        <button type="button" class="btn btn-danger delete_testimonial_btn" style="display: none">Delete <i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                    <div class="row testimonial_custom_row">
                                        @forelse($testimonials->where('status','pending') as $reviews)
                                            <div class="col-md-3">
                                                <div class="testimonial_card_wrapper">
                                                    @can('testimonials-delete')
                                                        <div class="testimonial_trash testimonial_checkbox">
                                                            <input type="checkbox" class="delete_checkbox" data-id="{{ $reviews->id }}">
                                                        </div>
                                                    @endcan
                                                    <a data-bs-target="#new_route" data-bs-toggle="modal" class="shadow_box_wrapper_staff_request new_route_modal" data-user-id="{{ $reviews->id }}" data-name="{{ $reviews->name }}" data-date="{{ $reviews->created_at->format('m-d-Y') }}" data-message="{{ $reviews->message }}">
                                                        <div class="">

                                                            <div class="staff_request_img_details_wrap">
                                                                <div>
                                                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                                </div>
                                                                <div class="staff_request_dis tab-content">
                                                                    <h5>{{ ucfirst($reviews->name ?? '') }}</h5>
                                                                    <div class="email_date_wrap">
                                                                        <div>
                                                                            <i class="fa-solid fa-calendar"></i>
                                                                            <span>{{ $reviews->created_at->format('m-d-Y') ?? '' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="request_items_wrap">
                                                                <p>{{ $reviews->message ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div>
                                                No Testimonial Available.
                                            </div>
                                        @endforelse
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade @if (session('key') == 'accepted') active show @endif" id="pills-potential_clients" role="tabpanel" aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                <div class="staff_req_card_grid_testimonial">
                                    <div class="delete_testimonial_cards_button d-flex align-items-center justify-content-between mb-3">
                                        @can('testimonials-delete')
                                            <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                                <input type="checkbox" class="select_all_checkbox" data-target="#pills-potential_clients">
                                                <span>Select All</span>
                                                <br />
                                                <br />
                                                <br />
                                            </label>
                                        @endcan
                                        <button type="button" class="btn btn-danger delete_testimonial_btn" style="display: none">Delete <i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                    <div class="row testimonial_custom_row">
                                        @forelse($testimonials->where('status','accepted') as $reviews)
                                            <div class="col-md-3">
                                                <div class="testimonial_card_wrapper">
                                                    @can('testimonials-delete')
                                                        <div class="testimonial_trash testimonial_checkbox">
                                                            <input type="checkbox" class="delete_checkbox" data-id="{{ $reviews->id }}">
                                                        </div>
                                                    @endcan
                                                    <a class="shadow_box_wrapper_staff_request">
                                                        <div>
                                                            {{--                                                <div class=" testimonial_trash"> --}}
                                                            {{--                                                    <i class="fa-solid fa-trash"></i> --}}
                                                            {{--                                                </div> --}}


                                                            <div class="staff_request_img_details_wrap">
                                                                <div>
                                                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                                </div>
                                                                <div class="staff_request_dis tab-content">
                                                                    <h5>{{ ucfirst($reviews->name ?? '') }}</h5>
                                                                    <div class="email_date_wrap">
                                                                        <div>
                                                                            <i class="fa-solid fa-calendar"></i>
                                                                            <span>{{ $reviews->created_at->format('m-d-Y') ?? '' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="request_items_wrap">
                                                                <p>{{ $reviews->message ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div>
                                                No Testimonials Available.
                                            </div>
                                        @endforelse
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- modal --}}
    <div class="modal fade new_route download_pdf_modal_sec staff_request_modal staff_testimonial_modal" id="new_route" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('testimonial_status') }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id">
                        <div class="staff_testimonial_wrapper_modal">
                            <div class="staff_request_img_details_wrap">
                                <div>
                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                </div>
                                <div class="staff_request_dis ">
                                    <h5></h5>
                                    <div class="email_date_wrap">
                                        <div>
                                            <i class="fa-solid fa-calendar"></i>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="request_items_wrap">
                                <p></p>
                            </div>
                            <div class="modal-footer custom_justify_between">
                                <button type="button" class="btn_global btn_grey " data-bs-dismiss="modal" aria-label="Close">Reject <i class="fa-solid fa-x"></i> </button>
                                <button type="submit" class="btn_global btn_blue ">Accept<i class="fa-solid fa-check"></i> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- searchbar functionality --}}
    <script>
        $(document).ready(function() {
            $('.searchInput').on('input', function() {
                var filter = $(this).val().toLowerCase();

                $('.tab-content').each(function() {
                    var h2Text = $(this).find('h5').text().toLowerCase();
                    if (h2Text.includes(filter)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var testimonialLinks = document.querySelectorAll('[data-bs-toggle="modal"]');

            testimonialLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    var userId = link.getAttribute('data-user-id');
                    var name = link.getAttribute('data-name');
                    var date = link.getAttribute('data-date');
                    var message = link.getAttribute('data-message');

                    var modal = document.getElementById('new_route');
                    modal.querySelector('input[name="user_id"]').value = userId;
                    modal.querySelector('.staff_request_dis h5').textContent = name;
                    modal.querySelector('.email_date_wrap span').textContent = date;
                    modal.querySelector('.request_items_wrap p').textContent = message;
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Select All checkbox functionality
            $('.select_all_checkbox').change(function() {
                var targetTab = $(this).data('target');
                var isChecked = $(this).is(':checked');
                $(targetTab).find('.delete_checkbox').prop('checked', isChecked).trigger('change');
            });

            // Update Select All checkbox when individual checkboxes change
            $('.delete_checkbox').change(function() {
                var tabPane = $(this).closest('.tab-pane');
                var totalCheckboxes = tabPane.find('.delete_checkbox').length;
                var checkedCheckboxes = tabPane.find('.delete_checkbox:checked').length;
                tabPane.closest('.tab-content').prev().find('.select_all_checkbox[data-target="#' + tabPane
                    .attr('id') + '"]').prop('checked', totalCheckboxes === checkedCheckboxes &&
                    totalCheckboxes > 0);
            });

            // Show delete button when at least one checkbox is selected
            $('.delete_checkbox').change(function() {
                var tabPane = $(this).closest('.tab-pane');
                if (tabPane.find('.delete_checkbox:checked').length > 0) {
                    tabPane.find('.delete_testimonial_btn').show();
                } else {
                    tabPane.find('.delete_testimonial_btn').hide();
                }
            });

            // Handle the click event on the delete button
            $('.delete_testimonial_btn').click(function() {
                var tabPane = $(this).closest('.tab-pane');
                // SweetAlert2 confirmation before deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Collect IDs of selected testimonials
                        var selectedIds = [];
                        tabPane.find('.delete_checkbox:checked').each(function() {
                            selectedIds.push($(this).data('id'));
                        });

                        // Send AJAX request to delete
                        $.ajax({
                            url: '{{ route('testimonials.bulkDelete') }}',
                            type: 'POST',
                            data: {
                                ids: selectedIds,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Remove cards from DOM
                                tabPane.find('.delete_checkbox:checked').each(function() {
                                    $(this).closest('.col-md-3').remove();
                                });

                                // Hide delete button and uncheck Select All
                                tabPane.find('.delete_testimonial_btn').hide();
                                $('.select_all_checkbox').prop('checked', false);

                                // Check if any testimonials are left in this tab
                                var remainingCards = tabPane.find('.testimonial_card_wrapper').length;
                                if (remainingCards === 0) {
                                    // Show "No Testimonial Available" message
                                    tabPane.find('.testimonial_custom_row').html('<div>No Testimonial Available.</div>');
                                }

                                // Show success message
                                Swal.fire('Deleted!', response.message, 'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Failed to delete testimonials.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
