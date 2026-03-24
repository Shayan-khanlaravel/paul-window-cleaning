@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Quote</h2>
        {{--        <div class="custom_search">--}}
        {{--            <input type="search" placeholder="Search" class="search_input">--}}
        {{--            <i class="fa-solid fa-magnifying-glass search_icon"></i>--}}
        {{--        </div>--}}
    </div>
@endsection
@section('content')
        <section class="client_management staff_manag clients_quits_wrapper">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="custom_table">
                                        <div class="table-responsive">
                                            <table  class="table myTable datatable">
                                                <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Phone</th>
                                                    <th>Payment Type</th>
                                                    <th>No. of  Routes Assigned  </th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i=0;$i<10;$i++)
                                                    <tr>
                                                        <td>Lou Malnati’s</td>
                                                        <td>+ 301 3155 5487</td>
                                                        {{--for invoice use this class please "grey_color_td_span" --}}
                                                        <td><span class="blue_color_td_span">Cash</span></td>
                                                        <td>45 </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton11{{$i}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11{{$i}}">
                                                                    <li><a class="dropdown-item" href="{{url('quote-details')}}" >View</a></li>
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
