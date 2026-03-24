<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paul (Window Cleaning)</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="{{asset('website')}}/assets/images/header_logo.svg" />
    <link rel="shortcut icon" href="{{asset('website')}}/assets/images/header_logo.svg" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{asset('website')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('website')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('website')}}/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body { background-image: url("{{asset('website/assets/media/auth')}}/bg4-dark.jpg"); }
        </style>
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
