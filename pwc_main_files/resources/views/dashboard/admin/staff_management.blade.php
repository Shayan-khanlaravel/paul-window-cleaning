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
{{--    <div class="txt_field custom_search">--}}
{{--        <i class="fa-solid fa-magnifying-glass search_icon"></i>--}}
{{--        <input type="text" placeholder="Search" class="custom_search_box">--}}
{{--    </div>--}}
@endsection
@section('content')
    <section class="routes_section staff_manag">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="custom_justify_between">
                            <a href="{{url('create_staff_member')}}" class="btn_global btn_blue"  >Create Staff <i class="fa-solid fa-plus"></i></a>
                            {{--<button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>--}}
                        </div>
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($i=0;$i<10;$i++)
                                        <tr>
                                            <td>
                                                <div class="td_img_wrapper">
                                                    <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                </div>
                                                Michael Jones</td>
                                            <td>michaeljones@gmail.com</td>
                                            <td>12-04-2024</td>
                                            <td>13</td>
{{--                                            for Unassigned use this class please "brown_color_td_span" --}}
                                            <td><span class="green_success">Assigned</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton11{{$i}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11{{$i}}">
                                                        <li><a class="dropdown-item" href="{{url('create_staff_member_two')}}" >View</a></li>
                                                        <li><a class="dropdown-item" href="{{url('#!')}}" >Activate/Deactivate</a></li>
                                                        <li><a class="dropdown-item" href="{{url('#!')}}" >Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
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
