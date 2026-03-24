@extends('theme.layout.master')
@push('css')

@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Staff Management </h2>
    </div>

    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="routes_section staff_manag">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        @can('staffmembers-create')
                        <div class="custom_justify_between">
                                <a href="{{ route('staffmembers.create') }}" class="btn_global btn_blue">Create Staff <i class="fa-solid fa-plus"></i></a>
                        </div>
                        @endcan
                        <div class="custom_table">
                            <div class="table-responsive">
                                <table  class="table myTable datatable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date Created</th>
                                        <th>Jobs Completed</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($staffs as $staffmember)
                                        <tr>
                                            <td>
                                                <div class="td_img_wrapper">
                                                    <img src="{{ asset('website') }}/{{ $staffmember->profile->pic ?? '/assets/images/user_logo.svg' }}" alt="">

                                                </div>
                                                {{$staffmember->name??''}}</td>
                                            <td>{{$staffmember->email??''}}</td>
                                           <td>{{ $staffmember->profile?->hiring_date }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $staffmember->profile?->hiring_date)->format('m-d-y') ?? '' }}</td> --}}

                                            <td>{{$staffmember->staff_jobs_count??''}}</td>
                                            <td>
                                                @if($staffmember->status == 1)
                                                    <span class="green_success">Active</span>
                                                @else
                                                    <span class="brown_color_td_span">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                                        @can('staffmembers-list')
                                                        <li><a class="dropdown-item" href="{{ route('staffmembers.show', [$staffmember->id]) }}" >View</a></li>
                                                        @endcan
                                                        <li>
                                                            <form action="{{ route('staffmembers.toggle-status', $staffmember->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                                                                    {{ $staffmember->status == 1 ? 'Deactivate' : 'Activate' }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li><a class="dropdown-item" href="{{ route('staffmembers.edit', [$staffmember->id]) }}" >Edit</a></li>
                                                        @can('staffmembers-delete')
                                                            <li class="menu-item px-3">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['staffmembers.destroy', $staffmember->id], 'class' => 'delete-form']) !!}
                                                                <a class="menu-link px-3" href="javascript:void(0)" onclick="showDeleteConfirmation(this)">Delete</a>
                                                            {!! Form::close() !!}
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No staff members available</td>
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
@endsection
@push('js')

@endpush
