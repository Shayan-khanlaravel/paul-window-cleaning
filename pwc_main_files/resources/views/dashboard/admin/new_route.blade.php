@extends('theme.layout.master')

@push('css')

@endpush
@section('navbar-title')
    <div class="custom_justify_between">
        <h2 class="navbar_PageTitle">New Route Name Here</h2>
    </div>

    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input custom_search_box">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>
@endsection
@section('content')
    <section class="routes_section new_routes">
        <div class="container-fluid custom-container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="shadow_box_wrapper">
                        <div class="custom_justify_between">
{{--                            <button type="button" class="btn_global btn_blue" data-bs-target="#new_route " data-bs-toggle="modal">Create Route <i class="fa-solid fa-plus"></i></button>--}}
                            <div class="new_route_select">
                                <select class="form-select " aria-label="Default select ">
                                    <option selected>July 2024</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="assign_staff_filter">
                                <a href="#!" class="btn_global btn_blue" >Assign staff<i class="fa-solid fa-plus"></i></a>
                                <button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>
                            </div>

                        </div>
                        <div class="row custom_row_new_routes">
                            @for($i=0;$i<4;$i++)
                            <div class="col-md-3 custom_col_routes">
                               <div class="weeks_wrapper">
                                   <div class="weeks_date">
                                     <label>Week1</label>
                                       <span>1-7,July</span>
                                   </div>
                                   <div class="weeks_details_wrap">
                                       <div>
                                           <label>Cash Total :</label>
                                           <span>0</span>
                                       </div>
                                       <div>
                                           <label>Invoice Total :</label>
                                           <span>0</span>
                                       </div>
                                       <div class="weeks_wrapper_total">
                                           <label>Total :</label>
                                           <span>0</span>
                                       </div>
                                   </div>
                               </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
