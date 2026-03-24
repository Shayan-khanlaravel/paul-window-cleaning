@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Quotes</h2>
    </div>
    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="client_management staff_manag clients_quits_wrapper">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="delete_rows" style="display: none;">
                            <form action="{{ route('contacts.bulkDelete') }}" method="POST" id="bulk-delete-form">
                                @csrf
                                @method('POST')
                                <button type="button" class="btn_global btn_red remove_row" id="bulk-delete-btn">Delete</button>
                                <div id="selected-ids-container"></div>
                            </form>
                        </div>

                        <div class="custom_table">
                            <div class="table-responsive">
                                <table class="table myTable datatable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select-all" />
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts as $quote)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input select-item" type="checkbox" name="ids[]" value="{{$quote->id}}" />
                                                </div>
                                            </td>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$quote->name ?? ''}}</td>
                                            <td>{{$quote->email ?? ''}}</td>
                                            <td>{{ substr_replace(substr_replace('+' . $quote->phone ?? '', '-', 4, 0), '-', 8, 0) }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>

                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                                        @can('contacts-list')
                                                            <li><a class="dropdown-item" href="{{ route('contacts.show', [$quote->id]) }}">View</a></li>
                                                        @endcan
{{--                                                        @can('contacts-delete')--}}
{{--                                                            <li>--}}
{{--                                                                <a class="dropdown-item delete-single" href="javascript:void(0)" data-id="{{ $quote->id }}" data-name="{{ $quote->name }}">Delete</a>--}}
{{--                                                            </li>--}}
{{--                                                        @endcan--}}
                                                    </ul>
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
            </div>
        </div>
    </section>
@endsection

@push("js")
    <script>
        $(document).ready(function() {
            $('#select-all').on('click', function() {
                const isChecked = $(this).prop('checked');
                $('.select-item').prop('checked', isChecked);
                toggleDeleteButton();
            });

            $(document).on('click', '.select-item', function() {
                $('#select-all').prop('checked', $('.select-item:checked').length === $('.select-item').length);
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                if ($('.select-item:checked').length > 0) {
                    $(".delete_rows").show();
                    const selectedIds = $('.select-item:checked').map(function() {
                        return $(this).val();
                    }).get();

                    $('#selected-ids-container').empty();

                    selectedIds.forEach(function(id) {
                        $('#selected-ids-container').append('<input type="hidden" name="ids[]" value="' + id + '">');
                    });
                } else {
                    $(".delete_rows").hide();
                }
            }

            $('#bulk-delete-btn').on('click', function() {
                const selectedCount = $('.select-item:checked').length;

                if (selectedCount > 0) {
                    Swal.fire({
                        title: `Are you sure you want to delete ${selectedCount} quotes?`,
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete them!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#bulk-delete-form').submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
