@extends('website.layout.master')

@push('css')

@endpush
@section('content')
    {{--hero sec--}}
    <section class="hero_sec about_us_sec services_hero_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero_sec_details">
                        <h1>SERVICES</h1>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Services</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{--    our team--}}
    <section class="services_commercial_sec">
        <div class="container custom_container">
            <div class="row custom_row_services">
                <div class="col-md-4">
                    <div class="services_commercial_img">
                        <img src="{{ asset('website') }}/{{$cmsService->section_one_image??'about_us_hero_img.png'}}">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="services_commercial_details">
                        {!!$cmsService->section_one_heading??''!!}
                        <p>{!!$cmsService->section_one_description??''!!}</p>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="services_commercial_details">
                        {!!$cmsService->section_two_heading??''!!}
                        <p>{!!$cmsService->section_two_description??''!!}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services_commercial_img">
                        <img src="{{ asset('website') }}/{{$cmsService->section_two_image??'about_us_hero_img.png'}}">
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('js')

@endpush
