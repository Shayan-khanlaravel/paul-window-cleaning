@extends('theme.layout.master')

@push('css')
@endpush
@section('navbar-title')
    <div class="back_btn_navbar back_btn_navbar_create_staff">
        <a href="{{url('routes')}}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">New York</h2>
    </div>
    <div class="custom_search txt_field custom_search">
        <input type="search" placeholder="Search" class="search_input">
        <i class="fa-solid fa-magnifying-glass search_icon"></i>
    </div>

@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
        <section class="create_staff_member_two_sec routes_detail_sec">
            <div class="container-fluid custom_container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabs_wrapper shadow_box_wrapper">
                            <div class="filter_download_dropdown_wrapper">
                                <div class="dropdown dropdown_months_wrapper">
                                    <button class="btn  dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false" >
                                        <i class="fa-regular fa-calendar"></i> July 2024
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>  <a class="dropdown-item" href="#">June</a></li>
                                        <li> <a class="dropdown-item" href="#">July</a></li>
                                        <li><a class="dropdown-item" href="#">November</a></li>
                                    </ul>
                                </div>
                                <div class="searchbar_download_filter_wrapper">
                                    <button type="button" class="btn_global btn_dark_blue printBtn" >Print <i class="fa-solid fa-print"></i></button>
                                </div>
                            </div>
                            <div class="row sectionToPrint">
                                @for($i = 0; $i <= 3; $i++)
                                <div class="col-md-3">
                                    <div class="details_routes_wrapper">
                                        <div class="week_wrapper">
                                            <div>
                                                <h4>Week 1</h4>
                                                <h4>1 - 7, July</h4>
                                            </div>
                                            <div class="week_details_wrapper">
                                                <div>
                                                    <label>Cash Total :</label>
                                                    <span>$234.00</span>
                                                </div>
                                                <div>
                                                    <label>Invoice Total :</label>
                                                    <span>$438.00</span>
                                                </div>
                                                <div class="week_details_wrapper_total">
                                                    <label>Total :</label>
                                                    <span>$672.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        @for($j = 1; $j <= 3; $j++)
                                        <div class="muller_honda_wrapper">
                                            <div>
                                                <h2>Muller Honda</h2>
                                                <div class="muller_honda_details">
                                                    <div>
                                                        <label>Invoice</label>
                                                        <span>$250.0.</span>
                                                    </div>
                                                    <div>
                                                        <label>Address:</label>
                                                        <span>7000 Grand Ave</span>
                                                    </div>
                                                    <div>
                                                        <h5>Additional Notes:</h5>
                                                        <h5>3hr. 20 min</h5>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="completed_wrapper">
                                                <i class="fa-solid fa-check"></i>
                                                <h5>Completed</h5>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_staff_member_two_sec">
            <div class="container-fluid custom_container">
                <div class="row custom_row">

                    <div class="col-md-12">
                        <div class="tabs_wrapper shadow_box_wrapper custom_row">
                            <div class="create_staff_tabs_btn_wrapper">
                                <ul class="nav nav-tabs" id="myTab_staff" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="all-tab_staff" data-bs-toggle="tab" data-bs-target="#all_staff" type="button" role="tab" aria-controls="all_staff" aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="inprogress-tab_staff" data-bs-toggle="tab" data-bs-target="#inprogress_staff" type="button" role="tab" aria-controls="inprogress_staff" aria-selected="false">In-Progress</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="completed-tab_staff" data-bs-toggle="tab" data-bs-target="#completed_staff" type="button" role="tab" aria-controls="completed_staff" aria-selected="false">Completed</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="filter_download_dropdown_wrapper">
                                <div class="dropdown dropdown_months_wrapper">
                                    <button class="btn  dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false" >
                                        <i class="fa-regular fa-calendar"></i> July 2024
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>  <a class="dropdown-item" href="#">June</a></li>
                                        <li> <a class="dropdown-item" href="#">July</a></li>
                                        <li><a class="dropdown-item" href="#">November</a></li>
                                    </ul>
                                </div>
                                {{--<div class="searchbar_download_filter_wrapper">--}}
                                    {{--<button type="button" class="btn_global btn_dark_blue" >Filter <i class="fa-solid fa-filter"></i></button>--}}
                                {{--</div>--}}
                            </div>
                            <div class="tab-content" id="myTabContent_staff">
                                <div class="tab-pane fade show active" id="all_staff" role="tabpanel" aria-labelledby="all-tab_staff">
                                    <div class="row">
                                        @for($i = 0; $i <= 3; $i++)
                                            <div class="col-md-3">
                                                <div class="details_routes_wrapper">
                                                    <div class="week_wrapper">
                                                        <div>
                                                            <h4>Week 1</h4>
                                                            <h4>1 - 7, July</h4>
                                                        </div>
                                                        <div class="week_details_wrapper">
                                                            <div>
                                                                <label>Cash Total :</label>
                                                                <span>$234.00</span>
                                                            </div>
                                                            <div>
                                                                <label>Invoice Total :</label>
                                                                <span>$438.00</span>
                                                            </div>
                                                            <div class="week_details_wrapper_total">
                                                                <label>Total :</label>
                                                                <span>$672.00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @for($j = 1; $j <= 3; $j++)
                                                        {{--<div class="muller_honda_wrapper">--}}
                                                            {{--<div>--}}
                                                                {{--<h2>Muller Honda</h2>--}}
                                                                {{--<div class="muller_honda_details">--}}
                                                                    {{--<div>--}}
                                                                        {{--<label>Invoice</label>--}}
                                                                        {{--<span>$250.0.</span>--}}
                                                                    {{--</div>--}}
                                                                    {{--<div>--}}
                                                                        {{--<label>Address:</label>--}}
                                                                        {{--<span>7000 Grand Ave</span>--}}
                                                                    {{--</div>--}}
                                                                    {{--<div>--}}
                                                                        {{--<h5>Additional Notes:</h5>--}}
                                                                        {{--<h5>3hr. 20 min</h5>--}}
                                                                    {{--</div>--}}

                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="completed_wrapper">--}}
                                                                {{--<i class="fa-solid fa-check"></i>--}}
                                                                {{--<h5>Completed</h5>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}

                                                    {{--mark as complete--}}
                                                        <div class="muller_honda_wrapper">
                                                            <div>
                                                                <h2>Muller Honda</h2>
                                                                <div class="muller_honda_details">
                                                                    <div>
                                                                        <label>Invoice</label>
                                                                        <span>$250.0.</span>
                                                                    </div>
                                                                    <div>
                                                                        <label>Address:</label>
                                                                        <span>7000 Grand Ave</span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>Additional Notes:</h5>
                                                                        <h5>3hr. 20 min</h5>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="mark_as_complete_wrapper">
                                                              <input type="checkbox" onclick="showDeleteConfirmation(this) "   aria-label=" SweetAlert2"  id="checkbox_input_{{$i}}_{{$j}}">
                                                                <label  for="checkbox_input_{{$i}}_{{$j}}">Report Status</label>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="inprogress_staff" role="tabpanel" aria-labelledby="inprogress-tab_staff">
                                    <div class="row">
                                        @for($i = 0; $i <= 3; $i++)
                                            <div class="col-md-3">
                                                <div class="details_routes_wrapper">
                                                    <div class="week_wrapper">
                                                        <div>
                                                            <h4>Week 1</h4>
                                                            <h4>1 - 7, July</h4>
                                                        </div>
                                                        <div class="week_details_wrapper">
                                                            <div>
                                                                <label>Cash Total :</label>
                                                                <span>$234.00</span>
                                                            </div>
                                                            <div>
                                                                <label>Invoice Total :</label>
                                                                <span>$438.00</span>
                                                            </div>
                                                            <div class="week_details_wrapper_total">
                                                                <label>Total :</label>
                                                                <span>$672.00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @for($j = 1; $j <= 3; $j++)
                                                        <div class="muller_honda_wrapper">
                                                            <div>
                                                                <h2>Muller Honda</h2>
                                                                <div class="muller_honda_details">
                                                                    <div>
                                                                        <label>Invoice</label>
                                                                        <span>$250.0.</span>
                                                                    </div>
                                                                    <div>
                                                                        <label>Address:</label>
                                                                        <span>7000 Grand Ave</span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>Additional Notes:</h5>
                                                                        <h5>3hr. 20 min</h5>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="completed_wrapper">
                                                                <i class="fa-solid fa-check"></i>
                                                                <h5>Completed</h5>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="completed_staff" role="tabpanel" aria-labelledby="completed-tab_staff">
                                    <div class="row">
                                        @for($i = 0; $i <= 3; $i++)
                                            <div class="col-md-3">
                                                <div class="details_routes_wrapper">
                                                    <div class="week_wrapper">
                                                        <div>
                                                            <h4>Week 1</h4>
                                                            <h4>1 - 7, July</h4>
                                                        </div>
                                                        <div class="week_details_wrapper">
                                                            <div>
                                                                <label>Cash Total :</label>
                                                                <span>$234.00</span>
                                                            </div>
                                                            <div>
                                                                <label>Invoice Total :</label>
                                                                <span>$438.00</span>
                                                            </div>
                                                            <div class="week_details_wrapper_total">
                                                                <label>Total :</label>
                                                                <span>$672.00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @for($j = 1; $j <= 3; $j++)
                                                        <div class="muller_honda_wrapper">
                                                            <div>
                                                                <h2>Muller Honda</h2>
                                                                <div class="muller_honda_details">
                                                                    <div>
                                                                        <label>Invoice</label>
                                                                        <span>$250.0.</span>
                                                                    </div>
                                                                    <div>
                                                                        <label>Address:</label>
                                                                        <span>7000 Grand Ave</span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>Additional Notes:</h5>
                                                                        <h5>3hr. 20 min</h5>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="completed_wrapper">
                                                                <i class="fa-solid fa-check"></i>
                                                                <h5>Completed</h5>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endfor
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
@push('js')
{{--searchbar functionality--}}


{{--print functionality--}}
{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--$('.printBtn').click(function() {--}}
            {{--var printContent = $('.sectionToPrint').html();--}}
            {{--var printWindow = window.open('', '');--}}

            {{--// Write the content to the new window--}}
            {{--printWindow.document.write('<html><head><title>Print</title></head><body>');--}}
            {{--printWindow.document.write(printContent);--}}
            {{--printWindow.document.write('</body></html>');--}}

            {{--// Close the document and trigger the print dialog--}}
            {{--printWindow.document.close();--}}
            {{--printWindow.print();--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
@endpush
