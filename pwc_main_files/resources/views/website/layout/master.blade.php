<html lang="en">
<!--begin::Head-->
<head><base href=""/>
    <title>Paul (Window Cleaning)</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="{{asset('website')}}/assets/images/header_logo.svg" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('website')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('website')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('website')}}/assets/css/style.css" rel="stylesheet" type="text/css" />
    @stack('css')
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-body position-relative app-blank">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Header Section-->
    {{--			<div class="mb-0" id="home">--}}
    <!--begin::Wrapper-->
    {{--				<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url({{asset('website')}}/assets/media/svg/illustrations/landing.svg)">--}}
    <!--begin::Header-->
    {{--                    header--}}
    <div class="preloader">
        <div class="cssload-speeding-wheel">
            <div class="loader_img">
                <img src="{{ asset('website') }}/assets/images/header_logo.svg">
            </div>
            <div class="loading_icon">
                <span><i class="fa-solid fa-circle"></i> </span>
                <span><i class="fa-solid fa-circle"></i> </span>
                <span><i class="fa-solid fa-circle"></i> </span>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar_header_sec ">
        <div class="container custom_container">
            <a class="navbar-brand header_logo_wrapper" href="{{url('/')}}">
                <img alt="Logo" src="{{asset('website')}}/assets/images/header_logo.svg" class="logo-default" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse header_menus_wrapper" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item @if(request()->is('/')) active @endif">
                        <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item @if(request()->route()->getName() == "about_us") active @endif">
                        <a class="nav-link " href="{{url('about_us')}}">About Us</a>
                    </li>
                    <li class="nav-item @if(request()->route()->getName() == "services") active @endif">
                        <a class="nav-link" href="{{url('services')}}">Services</a>
                    </li>
                    <li class="nav-item @if(request()->route()->getName() == "blogs") active @endif">
                        <a class="nav-link" href="{{url('blogs')}}">Blogs</a>
                    </li>
                </ul>
                <div class="login_btn_wrapper">
                    <div class="btn_wrapper">
                        <a href="{{url('contact_us')}}" class="btn_global  " >Contact Us
                            <div class="btn_img_icon">
                                <img src="{{ asset('website') }}/assets/images/arrow-up-right.svg ">
                            </div>
                        </a>
                    </div>
                    <div class="btn_wrapper">
                        @if(Auth::user())
                            <a href="{{url('dashboard_index')}}" class="btn_global  " >Dashboard
                                <div class="btn_img_icon">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </div> 
                            </a>
 
                        @else 
                            <a href="{{url('login')}}" class="btn_global  " >Login
                                <div class="btn_img_icon">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                </div> 
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </nav>



    <!--end::Header-->
    <!--begin::Landing hero-->
    @yield('content')
    <!--end::Footer Section-->
    <footer>
        <section class="footer_sec">
            <div class="container custom_container">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="footer_sec_wrapper">
                            <div class="row">
                                <div class="col-md-4 custom_col_footer" >
                                    <a href="{{url('/')}}">
                                        <div class="footer_logo">
                                            <img src="{{ asset('website') }}/assets/images/footer_logo.svg">
                                        </div>
                                    </a>

                                    <div class="contact_info">
                                        <i class="fa-solid fa-phone"></i>
                                        <a href="tel:224-572-1783">224-572-1783</a>
                                    </div>
                                    <div class="contact_info">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <a href="#">Paul Varnum 2116 Old Elm Rd Lindenhurst, IL 60046</a>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="footer_menus">
                                        <a href="{{url('about_us')}}"><h4>About Us</h4></a>
                                        <a href="{{url('services')}}"><h4>Services</h4></a>
                                        <a href="{{url('contact_us')}}"><h4>Contacts</h4></a>
                                        <a href="#"><h4>FAQ's</h4></a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="footer_menus">
                                        <a href="#"><h4>Window Cleaning</h4></a>
                                        <a href="#"><h4>Power Washing</h4></a>
                                    </div>
                                </div>
                                <div class="col-md-3 custom_col_footer">
                                    <div class="social_icons">
                                        <a href="#">
                                            <i class="fa-brands fa-facebook"></i>
                                        </a>
                                        {{--
                                                                               <i class="fa-brands fa-square-x-twitter"></i>--}}
                                        <a href="#">
                                            <i class="fa-brands fa-google"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </div>
                                    <form>
                                        <div class="email_subs">
                                            <input class="form-control" type="email" id="" name="" value="" placeholder="Email...">
                                            <button type="submit">Subscribe</button>
                                        </div>
                                    </form>
                                    <h6 class="sign_up_news">Sign up to our Newsletter</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="terms_policy">
                            <h6>© 2024 Paulswindowcleaning.org</h6>
                            <div >
                                <a href="#">Terms & Conditions </a>
                                <a href="#">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </footer>
    <!--begin::Scrolltop-->
    {{--			<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">--}}
    {{--				<i class="ki-duotone ki-arrow-up">--}}
    {{--					<span class="path1"></span>--}}
    {{--					<span class="path2"></span>--}}
    {{--				</i>--}}
    {{--			</div>--}}
    <!--end::Scrolltop-->
</div>
<!--end::Root-->
<!--begin::Scrolltop-->
{{--		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">--}}
{{--			<i class="ki-duotone ki-arrow-up">--}}
{{--				<span class="path1"></span>--}}
{{--				<span class="path2"></span>--}}
{{--			</i>--}}
{{--		</div>--}}
<!--end::Scrolltop-->
<!--begin::Javascript-->

{{--jquery cdn--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"  referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    @if (session()->has('message'))
    Swal.fire({
        title: "{{ session()->get('title') ?? 'success!' }}",
        html: "{{ @ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', session()->get('message'))) }}",
        icon: "{{ session()->get('type') ?? 'success' }}",
        timer: 5000,
        buttons: false,
    });
    @endif
    @if (session()->has('flash_message'))
    Swal.fire({
        title: "{{ @ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', session()->get('flash_message'))) }}",
        icon: "{{ session()->get('type') ?? 'success' }}",
        timer: 5000,
        buttons: false,
    });
    @endif
</script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"  referrerpolicy="no-referrer"></script>--}}
<script>var hostUrl = "{{asset('website')}}/assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('website')}}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{asset('website')}}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('website')}}/assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
<script src="{{asset('website')}}/assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('website')}}/assets/js/custom/landing.js"></script>
<script src="{{asset('website')}}/assets/js/custom/pages/pricing/general.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!--end::Custom Javascript-->
<!--end::Javascript-->
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            $('.preloader').css('visibility', 'hidden');
            $('#kt_app_body').css('display', 'inline');
        }, 200);
    });

    //form submit with sweetalert waiting message.
    $('form').on('submit', function(e) {
        e.preventDefault();
        $('button[type="submit"]').attr('disabled', true);
        Swal.fire({
            title: 'Please wait',
            text: 'Processing request, this may take a few seconds...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        this.submit();
    });

</script>
@stack('js')
</body>
<!--end::Body-->
</html>
