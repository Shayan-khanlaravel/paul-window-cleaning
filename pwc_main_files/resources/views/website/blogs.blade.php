@extends('website.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css"  />
@endpush
@section('content')
    {{--hero sec--}}
    <section class="hero_sec about_us_sec services_hero_sec">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero_sec_details">
                        <h1>BLOGS</h1>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{--    our team--}}
    <section class="blogs_sec blog_details">
        <div class="container custom_container">
            <div class="row custom_row_blogs">
                <div class="col-md-12 custom_col_blogs">
                    <div class="blogs_cards_grid_wrapper">
                        @forelse($cmsBlog as $blog)
                            <div class="blog_cards_wrapper_sec">
                                <div class="blog_card-img_wrap">
                                    <div class="swiper blog_swiper">
                                        <div class="swiper-wrapper">
                                            @if($blog && $blog->blogImage && $blog->blogImage->count() > 0)
                                                @foreach($blog->blogImage as $image)
                                                    <div class="swiper-slide">
                                                        <div class="post_img">
                                                            <img src="{{ asset('website') }}/{{ $image->image ?? 'assets/images/service_img1.png' }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="swiper-slide">
                                                    <div class="post_img">
                                                        <img src="{{ asset('website/assets/images/service_img1.png') }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                                <div class="custom_col_blogs_cards">
                                    <div class="post_details_wrapper">
                                        <h6>{{ $blog->created_at ? $blog->created_at->format('d M Y') : '' }}</h6>
                                        <h3>{{$blog->heading??''}}</h3>
                                        <h5 class="blog_dis_limit">{{$blog->description??''}}</h5>
                                        <a href="{{url('blogs',$blog->id)}}">Read Now   <img src="{{ asset('website') }}/assets/images/arrow_up_right_tick_post.svg"></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div>
                            There's no any blog available.
                        </div>
                        @endforelse


                    </div>
                </div>
                <div class="col-md-12 upload_more_cust_col">
                    <div class="btn_wrapper load_more_blog_page">
                        <a href="javascript:void(0)" class="btn_global  load_more_blog_page_anker" >Load More
                            <div class="btn_img_icon">
                                <img src="{{ asset('website') }}/assets/images/arrow-up-right_down.svg ">
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper('.blog_swiper', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            spaceBetween: 10,
            slidesPerView: 1,
        });
    </script>

    <script>
//    load more functionality
    $(document).ready(function() {

        $('.blog_cards_wrapper_sec').hide();
        $('.blog_cards_wrapper_sec').slice(0, 4).show();
        $('.load_more_blog_page_anker').click(function() {
            var visibleReviews = $('.blog_cards_wrapper_sec:visible').length;
            var totalReviews = $('.blog_cards_wrapper_sec').length;
            if (visibleReviews < totalReviews) {
                $('.blog_cards_wrapper_sec').slice(visibleReviews, visibleReviews + 4).show();
                if ($('.blog_cards_wrapper_sec:visible').length === totalReviews) {
                    $('.load_more_blog_page_anker').hide();
                }
            } else {
                $('.blog_cards_wrapper_sec').slice(4).hide();
                $(this).text("Load More");
            }
        });
    });
</script>
@endpush
