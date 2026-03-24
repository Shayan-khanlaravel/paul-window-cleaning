@extends('website.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css"  />
@endpush
@section('content')
    {{--hero sec--}}
    <section class="hero_sec about_us_sec services_hero_sec blog_details">
        <div class="container custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero_sec_details">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="{{url('/blogs')}}">Blogs</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ucwords($blog->heading)}}</li>
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
                        <div class="blog_cards_wrapper_sec">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="blog_card-img_wrap">
                                        <div class="swiper">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="custom_col_blogs_cards">
                                        <div class="post_details_wrapper">
                                            <h6>{{ $blog->created_at ? $blog->created_at->format('d M Y') : '' }}</h6>
                                            <h3>{{$blog->heading??''}}</h3>
                                            <h5 class="">{{$blog->description??''}}</h5>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

</script>

@endpush
