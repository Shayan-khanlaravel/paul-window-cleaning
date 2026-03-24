@extends('website.layout.master')

@push('css')

@endpush
@section('content')
    {{--hero sec--}}
    <section class="hero_sec about_us_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero_sec_details">
                        <h1>ABOUT <span>US</span></h1>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">About Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="hero_sec_about_us">
                        <div class="hero_sec_img_about">
                            <img src="{{ asset('website') }}/{{$cmsAbout->section_one_image ?? 'about_us_hero_img.png'}}">
                        </div>
                        <div class="hero_sec_img_about_blue">
                            <img src="{{ asset('website') }}/assets/images/blue_img_hero_sec.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{--pauls window cleaning--}}
    <section class="window_cleanig_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="window_cleanig_wrapper">
                        {!!$cmsAbout->section_one_heading??''!!}

                        {!!$cmsAbout->section_one_description??''!!}
{{--                        <p>Along the way I have met many wonderful people. The greatest reward for me is making someone's windows or siding look great and to see satisfaction written on their face.</p>--}}
{{--                        <p>One unexpected outcome has been the way this business has blessed and united my family. Through out their high school and college years my two daughters have worked with me, earning money for school and hopefully adopting the same values I learned when I was their age.</p>--}}
                    </div>
                </div>
            </div>
        </div>


    </section>

    {{--    our team--}}
    <section class="our_team_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{!!$cmsAbout->section_two_heading??''!!}</h2>
                    <div class="row custom_row_cards">
                        {{--@for($i=0;$i<5;$i++)--}}
                        <div class="col-md-4">
                            <div class="our_team_wrapper">
                                <div class="card" >
                                    <div class="card_img_about">
                                        <img src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_one_image?? 'lance_ward.jpg'}}">
                                    </div>
                                    <div class="card-body card_body_wrapper">
                                        <h3 class="">{!!$cmsAbout->two_sub_section_one_heading??''!!}</h3>
                                        <h6>{{$cmsAbout->two_sub_section_one_title??''}}</h6>
                                        <h5 class="card-text card-text_about_us_overflow">{!!$cmsAbout->two_sub_section_one_description??''!!}</h5>
                                        <div class="view_all_about_us">
                                            <a href="javascript:void(0)" class="view_all_show_txt">View All</a>
                                        </div>
                                        <div class="cards_social_icons">
                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_one_link_one ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>

                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_one_link_two ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="our_team_wrapper">
                                <div class="card" >
                                    <div class="card_img_about">
                                        <img src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_two_image?? 'lance_ward.jpg'}}">
                                    </div>
                                    <div class="card-body card_body_wrapper">
                                        <h3 class="">{!!$cmsAbout->two_sub_section_two_heading??''!!}</h3>
                                        <h6>{{$cmsAbout->two_sub_section_two_title??''}}</h6>
                                        <h5 class="card-text card-text_about_us_overflow">{!!$cmsAbout->two_sub_section_two_description??''!!}</h5>
                                        <div class="view_all_about_us">
                                            <a href="javascript:void(0)" class="view_all_show_txt">View All</a>
                                        </div>
                                        <div class="cards_social_icons">
                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_two_link_one ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>

                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_two_link_two ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="our_team_wrapper">

                                <div class="card" >
                                    <div class="card_img_about">
                                        <img src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_three_image?? 'lance_ward.jpg'}}">
                                    </div>
                                    <div class="card-body card_body_wrapper">
                                        <h3 class="">{!!$cmsAbout->two_sub_section_three_heading??''!!}</h3>
                                        <h6>{{$cmsAbout->two_sub_section_three_title??''}}</h6>
                                        <h5 class="card-text card-text_about_us_overflow">{!!$cmsAbout->two_sub_section_three_description??''!!}</h5>
                                        <div class="view_all_about_us">
                                            <a href="javascript:void(0)" class="view_all_show_txt">View All</a>
                                        </div>
                                        <div class="cards_social_icons">
                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_three_link_one ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>

                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_three_link_two ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="our_team_wrapper">
                                <div class="card" >
                                    <div class="card_img_about">
                                        <img src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_four_image?? 'lance_ward.jpg'}}">
                                    </div>
                                    <div class="card-body card_body_wrapper">
                                        <h3 class="">{!!$cmsAbout->two_sub_section_four_heading??''!!}</h3>
                                        <h6>{{$cmsAbout->two_sub_section_four_title??''}}</h6>
                                        <h5 class="card-text card-text_about_us_overflow">{!!$cmsAbout->two_sub_section_four_description??''!!}</h5>
                                        <div class="view_all_about_us">
                                            <a href="javascript:void(0)" class="view_all_show_txt">View All</a>
                                        </div>
                                        <div class="cards_social_icons">
                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_four_link_one ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>

                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_four_link_two ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="our_team_wrapper">
                                <div class="card" >
                                    <div class="card_img_about">
                                        <img src="{{ asset('website') }}/{{$cmsAbout->two_sub_section_five_image?? 'lance_ward.jpg'}}">
                                    </div>
                                    <div class="card-body card_body_wrapper">
                                        <h3 class="">{!!$cmsAbout->two_sub_section_five_heading??''!!}</h3>
                                        <h6>{{$cmsAbout->two_sub_section_five_title??''}}</h6>
                                        <h5 class="card-text card-text_about_us_overflow">{!!$cmsAbout->two_sub_section_five_description??''!!}</h5>
                                        <div class="view_all_about_us">
                                            <a href="javascript:void(0)" class="view_all_show_txt">View All</a>
                                        </div>
                                        <div class="cards_social_icons">
                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_five_link_one ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>

                                            <a href="https://{{ ltrim($cmsAbout->two_sub_section_five_link_two ?? '', 'https://') }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
@push('js')
<script>
//    view all show hide text
$(document).ready(function(){
    $('.card-text_about_us_overflow').each(function(){
        var fullText = $(this).html();
        var shortText = fullText.substring(0, 150);
        $(this).html(shortText + '...');
        // Store full text as data attribute to be revealed on "View All"
        $(this).data('full-text', fullText);
    });
    // Toggle full text on "View All" click
    $('.view_all_show_txt').click(function(){
        var cardTextElement = $(this).closest('.card-body').find('.card-text_about_us_overflow');
        // Toggle between full and short text
        if ($(this).text() === "View All") {
            cardTextElement.html(cardTextElement.data('full-text'));
            $(this).text("View Less");
        } else {
            var shortText = cardTextElement.data('full-text').substring(0, 150);
            cardTextElement.html(shortText + '...');
            $(this).text("View All");
        }
    });
});
</script>

@endpush
