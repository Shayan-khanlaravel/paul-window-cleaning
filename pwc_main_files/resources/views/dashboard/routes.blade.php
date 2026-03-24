@extends('theme.layout.master')

@push('css')

@endpush
@section('navbar-title')
    <div class="custom_justify_between custom_search_wrapper">
        @if(auth()->user()->hasRole('admin'))
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
    @if(auth()->user()->hasRole('admin'))
        <section class="routes_section">
            <div class="container-fluid custom-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom_div">
                            <div class="custom_justify_between">
                                <button type="button" class="btn_global btn_blue" data-bs-target="#new_route " data-bs-toggle="modal">Create Route <i class="fa-solid fa-plus"></i></button>
                                {{--<button type="button" class="btn_global btn_black">Filter <i class="fa-solid fa-filter"></i></button>--}}
                            </div>
                            <div class="row custom_row">
                                @for($i=0;$i<=19;$i++)
                                    <div class="col-md-3">
                                        <div class="new_yorks-cards_wrapper tab-content">
                                            <div >
                                                <h2>New York</h2>
                                                <div class="jobs_icon_wrapper">
                                                    <div>
                                                        <div>
                                                            <label>Jobs Pending</label>
                                                            <span>87</span>
                                                        </div>
                                                        <div>
                                                            <label>Jobs Completed:</label>
                                                            <span>87</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{url('route-details')}}">
                                                        <div>
                                                            <img src="{{ asset('website') }}/assets/images/Arrow-up-right_white.svg">
                                                        </div>
                                                    </a>

                                                </div>
                                            </div>
                                            {{--IN -progress comment below--}}
                                            {{--completed section class"completed_wrapper" --}}
                                            {{--completed section class"in_progress_wrapper"--}}
                                            <div class="completed_wrapper">
                                                <i class="fa-solid fa-check"></i>
                                                <h5>Completed</h5>
                                            </div>
                                            {{--completed section class"in_progress_wrapper"--}}
                                            {{--<div class="in_progress_wrapper">--}}
                                            {{--<i class="fa-regular fa-hourglass"></i>--}}
                                            {{--<h5>In-Progress</h5>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                @endfor
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade new_route" id="new_route" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel1">New Route</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="txt_field">
                                <input type="text" class="form-control" placeholder="Route Name">
                            </div>
                            <p>Please Enter Route Name</p>
                        </form>

                    </div>
                    <div class="modal-footer custom_justify_between">
                        <button type="button" class="btn_global btn_grey " data-bs-dismiss="modal">Cancel <i class="fa-solid fa-x"></i> </button>
                        <button type="submit" class="btn_global btn_blue ">Create <i class="fa-solid fa-check"></i> </button>

                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_staff_member_two_sec">
            <div class="container-fluid custom_container">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="row custom_row routes_custom_row shadow_box_wrapper">
                            @for($i=0;$i<=19;$i++)
                                <div class="col-md-3">
                                    <div class="new_yorks-cards_wrapper tab-content">
                                        <div >
                                            <h2>New York</h2>
                                            <div class="jobs_icon_wrapper">
                                                <div>
                                                    <div>
                                                        <label>Jobs Pending</label>
                                                        <span>87</span>
                                                    </div>
                                                    <div>
                                                        <label>Jobs Completed:</label>
                                                        <span>87</span>
                                                    </div>
                                                </div>
                                                <a href="{{url('route-details')}}">
                                                <div>
                                                    <img src="{{ asset('website') }}/assets/images/Arrow-up-right_white.svg">
                                                </div>
                                                </a>
                                            </div>
                                        </div>
                                        {{--IN -progress comment below--}}
                                        {{--completed section class"completed_wrapper" --}}
                                        {{--completed section class"in_progress_wrapper"--}}
                                        <div class="completed_wrapper">
                                            <i class="fa-solid fa-check"></i>
                                            <h5>Completed</h5>
                                        </div>
                                        {{--completed section class"in_progress_wrapper"--}}
                                        {{--<div class="in_progress_wrapper">--}}
                                        {{--<i class="fa-regular fa-hourglass"></i>--}}
                                        {{--<h5>In-Progress</h5>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('js')
{{--searchbar functionality--}}

<script>
    $(document).ready(function() {
        $('.search_input').on('input', function() {
            var filter = $(this).val().toLowerCase();

            $('.tab-content').each(function() {
                var h2Text = $(this).find('h2').text().toLowerCase();
                if (h2Text.includes(filter)) {
                    $(this).show(); // Show the matching element
                } else {
                    $(this).hide(); // Hide the non-matching element
                }
            });
        });
    });
</script>
@endpush
