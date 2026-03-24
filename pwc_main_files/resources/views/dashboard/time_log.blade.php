@extends('theme.layout.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Time Logs</h2>
    </div>
    <div class="txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="client_management staff_manag time_log_management">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="custom_justify_between">
                            <h3>Time Logs</h3>
                            @if (!$isAdmin)
                                <button type="button" class="btn_global btn_blue" data-bs-target="#add_timelog"
                                    data-bs-toggle="modal">Add Time Log<i class="fa-solid fa-plus"></i></button>
                            @endif
                        </div>
                        <div class="row mt-3 mb-3">
                            @if ($isAdmin)
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <div class="txt_field custom_select_route">
                                    <label for="staffFilter">Filter by Staff</label>
                                        <select class="form-select selectRoute" id="staffFilter" data-placeholder="Select a Staff">
                                        <option value="">All Staff</option>
                                        @foreach ($allStaff as $staff)
                                            <option value="{{ $staff->name }}">{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            @else
                                <div class="col-md-4"></div>
                            @endif
                            <div class="col-md-4">
                                <div class="txt_field custom_select_route">
                                <label for="routeFilter">Filter by Route</label>
                                    <select class="form-select selectRoute" id="routeFilter" data-placeholder="Select a Route">
                                    <option value="">All Routes</option>
                                    @if ($isAdmin)
                                        @foreach ($allRoutes as $route)
                                            <option value="{{ $route->name }}">{{ $route->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($routes as $route)
                                            <option value="{{ $route->name }}">{{ $route->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="custom_table">
                            <div class="table-responsive">
                                <table class="table" id="timelogsTable">
                                    <thead>
                                        <tr>
                                            @if ($isAdmin)
                                                <th>Staff Name</th>
                                            @endif
                                            <th>Route</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Total Hours</th>
                                            <th>Notes</th>
                                            @if (!$isAdmin)
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($timelogs as $timelog)
                                            <tr>
                                                @if ($isAdmin)
                                                    <td>{{ $timelog->staff->name ?? 'N/A' }}</td>
                                                @endif
                                                <td>{{ $timelog->route->name ?? 'N/A' }}</td>
                                                <td> {{ \Carbon\Carbon::parse($timelog->service_date)->format('d-m-Y') }}
                                                </td>
                                                <td><span
                                                        class="badge bg-primary">{{ \Carbon\Carbon::parse($timelog->start_time)->format('h:i A') }}
                                                </td></span>
                                                <td>
                                                    @if ($timelog->end_time)
                                                        <span
                                                            class="badge bg-success">{{ \Carbon\Carbon::parse($timelog->end_time)->format('h:i A') }}</span>
                                                    @else
                                                        @if (!$isAdmin)
                                                            <button type="button"
                                                                class="btn_global btn_red btn-sm end_time_btn"
                                                                data-timelog-id="{{ $timelog->id }}">
                                                                End Time
                                                            </button>
                                                        @else
                                                            <span class="badge bg-warning">In Progress</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($timelog->total_hours)
                                                        {{ number_format($timelog->total_hours, 2) }} hrs
                                                    @else
                                                        <span class="badge bg-warning">In Progress</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($timelog->notes, 30) ?? '-' }}</td>
                                                @if (!$isAdmin)
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="dropdown-toggle" type="button"
                                                                id="dropdownMenuButton{{ $timelog->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $timelog->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="deleteTimeLog('{{ route('timelogs.destroy', $timelog->id) }}')">
                                                                        Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $isAdmin ? '7' : '8' }}" class="text-center">No time logs
                                                    found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="add_timelog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('timelogs.store') }}" id="" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <div>
                            <h2 class="modal-title" id="exampleModalLabel1">Add Time Log</h2>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="txt_field custom_select_route">
                            <label for="routeSelect">Select Route</label>
                            <select class="form-select selectRouteModal" name="route_id" required data-placeholder="Select a Route">
                                <option value="" selected disabled>Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="txt_field">
                            <label for="notes">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="start_time" id="currentTime">
                    </div>
                    <div class="modal-footer custom_justify_between">
                        <button type="button" class="btn_global btn_grey" data-bs-dismiss="modal" aria-label="Close">Cancel
                            <i class="fa-solid fa-x"></i></button>
                        <button type="submit" class="btn_global btn_blue">Assign Time Log<i
                                class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $(".selectRoute").select2({
                allowClear: true,
            });
            $(".selectRouteModal").select2({
                allowClear: true,
                dropdownParent: $('#add_timelog')
            });


            // Initialize DataTables only if data exists
            @if ($timelogs->count() > 0)
                var timelogsTable = $('#timelogsTable').DataTable({
                    "order": [
                        [{{ $isAdmin ? '2' : '1' }}, "desc"]
                    ], // Sort by date column (Admin has extra column)
                    "pageLength": 10,
                    "responsive": true,
                    "searching": true,
                    "bLengthChange": false,
                    "paging": true,
                    "info": true,
                    "ordering": true
                });

                // Custom search box
                $(document).on("input", '.custom_search_box', function() {
                    var searchValue = $(this).val();
                    timelogsTable.search(searchValue).draw();
                });

                @if ($isAdmin)
                    // Staff filter (Admin only)
                    $('#staffFilter').on('change', function() {
                        var staffName = $(this).val();
                        timelogsTable.column(0).search(staffName).draw();
                    });

                    // Route filter (Admin - column 1)
                    $('#routeFilter').on('change', function() {
                        var routeName = $(this).val();
                        timelogsTable.column(1).search(routeName).draw();
                    });
                @else
                    // Route filter (Staff - column 0)
                    $('#routeFilter').on('change', function() {
                        var routeName = $(this).val();
                        timelogsTable.column(0).search(routeName).draw();
                    });
                @endif
            @endif

            // Set current time when modal opens
            $('#add_timelog').on('show.bs.modal', function() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const currentTime = `${hours}:${minutes}`;
                $('#currentTime').val(currentTime);
            });

            // End Time button click
            $('.end_time_btn').on('click', function() {
                const timelogId = $(this).data('timelog-id');
                const button = $(this);

                Swal.fire({
                    title: 'End Time Log?',
                    text: "Are you sure you want to end this time log?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, End it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('timelogs.end', ':id') }}'.replace(':id',
                                timelogId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to end time log'
                                });
                            }
                        });
                    }
                });
            });
        });

        // Delete time log confirmation function
        function deleteTimeLog(deleteUrl) {
            Swal.fire({
                title: 'Delete Time Log?',
                text: "Are you sure you want to delete this time log? This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    // Add DELETE method
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endpush
