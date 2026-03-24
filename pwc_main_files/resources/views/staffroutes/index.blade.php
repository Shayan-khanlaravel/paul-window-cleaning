@extends('theme.layout.master')

@push('css')
    <style>
        button.toggle-status-btn.btn_grey {
            border: none;
            background: none
        }

        button.toggle-status-btn.btn_grey i {
            font-size: 20px;
            width: 20px;
            height: 20px;
            color: gray
        }

        .custom_icon_wrapperss {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .new_yorks-cards_wrapper .jobs_icon_wrapper div:has(img) {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 30px;
            height: 30px
        }

        .toggle-status-btn.btn_dark_blue {
            background: none;
            border: none
        }

        .toggle-status-btn.btn_dark_blue i {
            font-size: 20px;
            color: #32346A
        }

        .new_yorks-cards_wrapper div h2 {
            font-size: 22px
        }
    </style>
@endpush
@section('navbar-title')
    <div class="custom_justify_between custom_search_wrapper">
        @if (auth()->user()->hasRole('admin'))
            <h2 class="navbar_PageTitle">Routes </h2>
        @elseif(auth()->user()->hasRole('staff'))
            <h2 class="navbar_PageTitle">Assigned Routes </h2>
        @endif
        <div class="custom_search">
            <form>
                <input type="search" placeholder="Search" class="search_input">
                <i class="fa-solid fa-magnifying-glass search_icon"></i>
            </form>

        </div>
    </div>
@endsection
@section('content')
    @if (auth()->user()->hasRole('admin'))
        <section class="routes_section">
            <div class="container-fluid custom-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="custom_justify_between">
                                <div class="dropdown">
                                    <button class="btn_global btn_dark_blue dropdown-toggle" type="button" id="sortButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="sortButton">
                                        <li><a class="dropdown-item" href="#" id="sortAtoZ">A to Z</a></li>
                                        <li><a class="dropdown-item" href="#" id="sortMostRecent">Most Recent</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn_global btn_blue" data-bs-target="#new_route " data-bs-toggle="modal">Create Route <i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="row custom_row">
                                @forelse($staffroutes as $route)
                                    <div class="col-md-3 route-card" data-route-name="{{ $route->name ?? 'Not Available' }}" data-date="{{ $route->created_at ?? now() }}" style="width: 24%;">
                                        <div class="new_yorks-cards_wrapper tab-content">
                                            <div class="share_routes_box_container" style="position: relative">
                                                <div class="routes_delete_wrapper">
                                                    <h2>{{ $route->name ?? 'Not Available' }}</h2>
                                                </div>
                                                <div class="jobs_icon_wrapper">
                                                    <div>
                                                        <div>
                                                            <label>Jobs Pending</label>
                                                            <span>{{ $route->jobs_pending ?? 0 }}</span>
                                                        </div>
                                                        <div>
                                                            <label>Jobs Completed:</label>
                                                            <span>{{ $route->jobs_completed ?? 0 }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('staffroutes.show', [$route->id]) }}">
                                                        <div class="share_route_box">
                                                            <img src="{{ asset('website') }}/assets/images/Arrow-up-right_white.svg">
                                                        </div>
                                                    </a>
                                                </div>
                                                <!-- Toggle Status Button -->
                                                <div class="custom_icon_wrapperss ">
                                                    <div class="mt-1">
                                                        <button type="button" class=" toggle-status-btn {{ $route->status == 1 ? 'btn_dark_blue' : 'btn_grey' }}" data-route-id="{{ $route->id }}" data-status="{{ $route->status }}" title="{{ $route->status == 1 ? 'Active' : 'Inactive' }}">

                                                            <i class="fa-solid {{ $route->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                        </button>
                                                    </div>
                                                    <div class="icons_custom_wrapper">
                                                        @can('staffroutes-edit')
                                                            <i class="fa-solid fa-pen-to-square text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit_route_{{ $route->id }}" title="Edit Route"></i>
                                                        @endcan
                                                    </div>
                                                    <div>

                                                        @can('staffroutes-delete')
                                                            <div class="">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['staffroutes.destroy', $route->id], 'class' => 'delete-form']) !!}
                                                                <i class="fa-solid fa-trash text-danger" href="javascript:void(0)" onclick="showDeleteConfirmation(this)"></i>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $totalJobs = ($route->jobs_pending ?? 0) + ($route->jobs_completed ?? 0);
                                                $completedPercentage = $totalJobs > 0 ? round(($route->jobs_completed / $totalJobs) * 100) : 0;

                                                // Determine color, icon and background based on percentage
                                                if ($completedPercentage <= 20) {
                                                    $progressColor = '#f53b11'; // Red
                                                    $progressBg = '#fbf2ec'; // Light red
                                                    $progressIcon = 'fa-hourglass-start';
                                                    $progressText = 'Starting';
                                                } elseif ($completedPercentage <= 50) {
                                                    $progressColor = '#ff9800'; // Orange
                                                    $progressBg = '#FFF3E0'; // Light orange
                                                    $progressIcon = 'fa-spinner';
                                                    $progressText = 'In Progress';
                                                } elseif ($completedPercentage <= 80) {
                                                    $progressColor = '#ff9800'; // Orange
                                                    $progressBg = '#FFF3E0'; // Light orange
                                                    $progressIcon = 'fa-hourglass-half';
                                                    $progressText = 'Nearly';
                                                } elseif ($completedPercentage <= 90) {
                                                    $progressColor = '#4b195e'; // Orange
                                                    $progressBg = '#bf81d6'; // Light orange
                                                    $progressIcon = 'fa-check-circle';
                                                    $progressText = 'Almost Done';
                                                } else {
                                                    $progressColor = '#166936'; // Green
                                                    $progressBg = '#b5fbd0'; // Light green
                                                    $progressIcon = 'fa-check-circle';
                                                    $progressText = 'Completed';
                                                }
                                            @endphp
                                            <div style="background: {{ $progressBg }}; border-radius: 10px; padding: 6px 7px;">
                                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                                    <i class="fa-solid {{ $progressIcon }}" style="color: {{ $progressColor }}; font-size: 14px;"></i>
                                                    <h5 style="color: {{ $progressColor }}; margin: 0; font-size: 14px;">
                                                        {{ $progressText }} {{ $completedPercentage }}%</h5>
                                                </div>
                                                <div style="width: 100%; background-color: #e0e0e0; border-radius: 10px; height: 8px; overflow: hidden; margin-bottom: 5px;">
                                                    <div style="width: {{ $completedPercentage }}%; background-color: {{ $progressColor }}; height: 100%; transition: width 0.3s ease, background-color 0.3s ease;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div> No Routes Available</div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Create New Route Modal -->
        <div class="modal fade new_route" id="new_route" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel1">New Route</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="routeValidate" action="{{ route('staffroutes.store') }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="txt_field">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Route Name">
                            </div>
                            <p>Please Enter Route Name</p>
                            <div class="modal-footer custom_justify_between">
                                <button type="button" class="btn_global btn_grey " data-bs-dismiss="modal">Cancel <i class="fa-solid fa-x"></i> </button>
                                <button type="submit" class="btn_global btn_blue ">Create <i class="fa-solid fa-check"></i>
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Route Modals - One for each route -->
        @foreach ($staffroutes as $route)
            <div class="modal fade new_route" id="edit_route_{{ $route->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $route->id }}">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="editModalLabel{{ $route->id }}">Edit Route</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('staffroutes.update', $route->id) }}" class="form-horizontal edit-route-form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="txt_field">
                                    <input type="text" class="form-control" name="name" value="{{ $route->name }}" placeholder="Route Name" required>
                                </div>
                                <p>Please Enter Route Name</p>
                                <input type="hidden" name="status" value="{{ $route->status }}">
                                <div class="modal-footer custom_justify_between">
                                    <button type="button" class="btn_global btn_grey" data-bs-dismiss="modal">Cancel <i class="fa-solid fa-x"></i></button>
                                    <button type="submit" class="btn_global btn_blue">Update <i class="fa-solid fa-check"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_staff_member_two_sec">
            <div class="container-fluid custom_container">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="row custom_row routes_custom_row shadow_box_wrapper">
                            @forelse($staffroutes as $staffroute)
                                <div class="col-md-3">
                                    <div class="new_yorks-cards_wrapper tab-content">
                                        <div style="position:relative;">
                                            <h2>{{ $staffroute->name ?? 'Not Available' }}</h2>
                                            <div class="jobs_icon_wrapper">
                                                <div>
                                                    <div>
                                                        <label>Jobs Pending</label>
                                                        <span>{{ $staffroute->jobs_pending ?? 0 }}</span>
                                                    </div>
                                                    <div>
                                                        <label>Jobs Completed:</label>
                                                        <span>{{ $staffroute->jobs_completed ?? 0 }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('staffroutes.show', [$staffroute->id]) }}">
                                                    <div class="share_route_btn">
                                                        <img src="{{ asset('website/assets/images/Arrow-up-right_white.svg') }}" alt="View Details">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @php
                                            $totalJobs = ($staffroute->jobs_pending ?? 0) + ($staffroute->jobs_completed ?? 0);
                                            $completedPercentage = $totalJobs > 0 ? round(($staffroute->jobs_completed / $totalJobs) * 100) : 0;

                                            // Determine color, icon and background based on percentage
                                            if ($completedPercentage <= 20) {
                                                $progressColor = '#f53b11'; // Red
                                                $progressBg = '#fbf2ec'; // Light red
                                                $progressIcon = 'fa-hourglass-start';
                                                $progressText = 'Starting';
                                            } elseif ($completedPercentage <= 50) {
                                                $progressColor = '#ff9800'; // Orange
                                                $progressBg = '#FFF3E0'; // Light orange
                                                $progressIcon = 'fa-spinner';
                                                $progressText = 'In Progress';
                                            } elseif ($completedPercentage <= 80) {
                                                $progressColor = '#ff9800'; // Orange
                                                $progressBg = '#FFF3E0'; // Light orange
                                                $progressIcon = 'fa-hourglass-half';
                                                $progressText = 'Nearly';
                                            } elseif ($completedPercentage <= 90) {
                                                $progressColor = '#4b195e'; // Orange
                                                $progressBg = '#bf81d6'; // Light orange
                                                $progressIcon = 'fa-check-circle';
                                                $progressText = 'Almost Done';
                                            } else {
                                                $progressColor = '#166936'; // Green
                                                $progressBg = '#b5fbd0'; // Light green
                                                $progressIcon = 'fa-check-circle';
                                                $progressText = 'Completed';
                                            }
                                        @endphp
                                        <div style="background: {{ $progressBg }}; border-radius: 10px; padding: 6px 7px;">
                                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                                <i class="fa-solid {{ $progressIcon }}" style="color: {{ $progressColor }}; font-size: 14px;"></i>
                                                <h5 style="color: {{ $progressColor }}; margin: 0; font-size: 14px;">
                                                    {{ $progressText }} {{ $completedPercentage }}%</h5>
                                            </div>
                                            <div style="width: 100%; background-color: #e0e0e0; border-radius: 10px; height: 8px; overflow: hidden; margin-bottom: 5px;">
                                                <div style="width: {{ $completedPercentage }}%; background-color: {{ $progressColor }}; height: 100%; transition: width 0.3s ease, background-color 0.3s ease;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>No Routes Available</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('js')
    {{-- searchbar functionality --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.search_input').on('input', function() {
                var filter = $(this).val().toLowerCase();
                var $routes = $('.route-card');

                $routes.each(function() {
                    var routeName = $(this).data('route-name').toLowerCase();

                    if (routeName.indexOf(filter) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                rearrangeRoutes();
            });

            function rearrangeRoutes() {
                var $container = $('.custom_row');

                $container.append($('.route-card:visible'));
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("routeExists", function(value, element) {
                let isValid = false;

                $.ajax({
                    url: "route_name_check",
                    type: "GET",
                    data: {
                        name: value
                    },
                    async: false,
                    success: function(response) {
                        isValid = !response.exists;
                    }
                });

                return isValid;
            }, "This Route is already Exist.");
            $.validator.addMethod(
                "alphabetic",
                function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9]+( [a-zA-Z0-9]+)*$/.test(value.trim());
                },
                "Only alphabetic characters, numbers, and single spaces between words are allowed."
            );

            $("#routeValidate").validate({
                rules: {
                    name: {
                        required: true,
                        alphabetic: true,
                        routeExists: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your Route Name."
                    }
                },
                errorElement: "span",
                errorClass: "text-danger",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sortAtoZ').on('click', function() {
                let routes = $('.route-card').get();
                routes.sort(function(a, b) {
                    let nameA = $(a).data('route-name').toUpperCase();
                    let nameB = $(b).data('route-name').toUpperCase();
                    return nameA < nameB ? -1 : nameA > nameB ? 1 : 0;
                });

                $('.custom_row').empty().append(routes);
            });

            $('#sortMostRecent').on('click', function() {
                let routes = $('.route-card').get();
                routes.sort(function(a, b) {
                    let dateA = new Date($(a).data('date'));
                    let dateB = new Date($(b).data('date'));
                    return dateB - dateA;
                });

                $('.custom_row').empty().append(routes);
            });
        });
    </script>

    {{-- Toggle Status Script --}}
    <script>
        $(document).ready(function() {
            $('.toggle-status-btn').on('click', function() {
                const button = $(this);
                const routeId = button.data('route-id');
                const currentStatus = button.data('status');

                // Disable button during request
                button.prop('disabled', true);

                $.ajax({
                    url: "{{ url('staffroutes') }}/" + routeId + "/toggle-status",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button appearance
                            const newStatus = response.status;
                            button.data('status', newStatus);

                            if (newStatus == 1) {
                                button.removeClass('btn_grey').addClass('btn_dark_blue');
                                button.find('.status-text').text('Active');
                                button.find('i').removeClass('fa-toggle-off').addClass(
                                    'fa-toggle-on');
                            } else {
                                button.removeClass('btn_dark_blue').addClass('btn_grey');
                                button.find('.status-text').text('Inactive');
                                button.find('i').removeClass('fa-toggle-on').addClass(
                                    'fa-toggle-off');
                            }

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                button: false
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        alert('Failed to update status. Please try again.');
                    },
                    complete: function() {
                        // Re-enable button
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
