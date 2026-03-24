@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">Clients Management </h2>
        {{--        <div class="custom_search">--}}
        {{--            <input type="search" placeholder="Search" class="search_input">--}}
        {{--            <i class="fa-solid fa-magnifying-glass search_icon"></i>--}}
        {{--        </div>--}}
    </div>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
    <section class="client_management staff_manag">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_div">
                        <div class="clients_tab custom_justify_between">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="true">Clients</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-potential_clients-tab" data-bs-toggle="pill" data-bs-target="#pills-potential_clients" type="button" role="tab" aria-controls="pills-potential_clients" aria-selected="false">Potential Clients</button>
                                </li>
                            </ul>
                            <div class="create_btn custom_flex">
                                <a href="{{url('create_client')}}" class="btn_global btn_blue">Create Client <i class="fa-solid fa-user-group"></i></a>
                                {{--<button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>--}}
                            </div>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab" tabindex="0">
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
                                                                <li><a class="dropdown-item" href="{{url('client-details')}}" >View</a></li>
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
                            <div class="tab-pane fade" id="pills-potential_clients" role="tabpanel" aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                <div class="custom_table">
                                    <div class="table-responsive">
                                        <table  class="table myTable datatable">
                                            <thead>
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Client Name</th>
                                                <th>Phone</th>
                                                <th>Payment Type</th>
                                                <th>Assigned Route</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i=0;$i<10;$i++)
                                                <tr>
                                                    <td>
                                                        <div class="td_img_wrapper">
                                                            <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                        </div>
                                                        John Doe</td>
                                                    <td>Muller Honda</td>
                                                    <td>+ 301 3155 5487</td>
                                                    {{--for invoice use this class please "grey_color_td_span" --}}
                                                    <td><span class="blue_color_td_span">Cash</span></td>
                                                    <td>New York</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton12{{$i}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton12{{$i}}">
                                                                <li><a class="dropdown-item" href="{{url('client-details')}}">View</a></li>
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
            </div>
        </div>
    </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="client_management staff_manag ">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="clients_tab custom_justify_between">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="true">Clients</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-potential_clients-tab" data-bs-toggle="pill" data-bs-target="#pills-potential_clients" type="button" role="tab" aria-controls="pills-potential_clients" aria-selected="false">Potential Clients</button>
                                    </li>
                                </ul>
                                <div class="create_btn custom_flex">
                                    <a href="{{url('create_client')}}" class="btn_global btn_blue">Create Client <i class="fa-solid fa-user-group"></i></a>
                                    {{--<button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>--}}
                                </div>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab" tabindex="0">
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
                                                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                    <li><a class="dropdown-item" href="{{url('client-details')}}" >View</a></li>
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
                                <div class="tab-pane fade" id="pills-potential_clients" role="tabpanel" aria-labelledby="pills-potential_clients-tab" tabindex="0">
                                    <div class="custom_table">
                                        <div class="table-responsive">
                                            <table  class="table myTable datatable">
                                                <thead>
                                                <tr>
                                                    <th>Staff Name</th>
                                                    <th>Client Name</th>
                                                    <th>Phone</th>
                                                    <th>Payment Type</th>
                                                    <th>Assigned Route</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i=0;$i<10;$i++)
                                                    <tr>
                                                        <td>
                                                            <div class="td_img_wrapper">
                                                                <img src="{{ asset('website') }}/assets/images/customer_reviews_img.jpg">
                                                            </div>
                                                            John Doe</td>
                                                        <td>Muller Honda</td>
                                                        <td>+ 301 3155 5487</td>
                                                        {{--for invoice use this class please "grey_color_td_span" --}}
                                                        <td><span class="blue_color_td_span">Cash</span></td>
                                                        <td>New York</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton12" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton12">
                                                                    <li><a class="dropdown-item" href="{{url('client-details')}}">View</a></li>
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
                </div>
            </div>
        </section>
    @endif
@endsection
