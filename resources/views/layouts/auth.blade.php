<!DOCTYPE html>
@php
    use App\Models\Utility;

        // $logo=asset(Storage::url('uploads/logo/'));
        $logo=\App\Models\Utility::get_file('uploads/logo/');
        $company_logo=Utility::getValByName('company_logo_dark');
        $company_logos=Utility::getValByName('company_logo_light');
        $company_favicon=Utility::getValByName('company_favicon');
        $setting = \App\Models\Utility::colorset();
        $mode_setting = \App\Models\Utility::mode_layout();
        $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
        $company_logo = \App\Models\Utility::GetLogo();
        $SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';
        $lang = \App::getLocale('lang');
        if($lang == 'ar' || $lang == 'he')
        {
               $setting['SITE_RTL']= 'on';
        }
        else
        {
            $setting['SITE_RTL']= 'off';
        }



        $getseo= App\Models\Utility::getSeoSetting();
        $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
        $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
        $meta_image = \App\Models\Utility::get_file('uploads/meta/');
        $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';
        $get_cookie = \App\Models\Utility::getCookieSetting();

@endphp

{{--<html lang="en" dir="{{$SITE_RTL == 'on' ? 'rtl' : '' }}">--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'SellfizERP')}} - @yield('page-title')</title>

    <meta name="title" content="{{$metatitle}}">
    <meta name="description" content="{{$metsdesc}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{$metatitle}}">
    <meta property="og:description" content="{{$metsdesc}}">
    <meta property="og:image" content="{{$meta_image.$meta_logo}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{$metatitle}}">
    <meta property="twitter:description" content="{{$metsdesc}}">
    <meta property="twitter:image" content="{{$meta_image.$meta_logo}}">


    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Dashboard Template Description"/>
    <meta name="keywords" content="Dashboard Template"/>
    <meta name="author" content="Rajodiya Infotech"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image/x-icon"/>

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->

@if ($setting['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css')}}" id="main-style-link">
    @endif
    @if($setting['cust_darklayout']=='on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css')}}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link">
    @endif


{{--    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">--}}
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

@php
    $appName = Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'SellfizERP');
    $isDarkMode = isset($mode_setting['cust_darklayout']) && $mode_setting['cust_darklayout'] == 'on';
    $bgColor = $isDarkMode ? '#1a1a1a' : '#f5f5f5';
    $cardBg = $isDarkMode ? '#2d2d2d' : '#ffffff';
    $textColor = $isDarkMode ? '#ffffff' : '#333333';
@endphp
<body class="{{ $color }}" style="background: {{ $bgColor }}; transition: background 0.3s ease;">
<div class="auth-wrapper" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: {{ $bgColor }}; transition: background 0.3s ease;">
    <div class="auth-content" style="width: 100%; max-width: 450px; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="#" style="display: inline-block; text-decoration: none;">
                @if($isDarkMode)
                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                         alt="{{ $appName }}" class="logo" style="max-width: 80px; height: auto; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto;">
                @else
                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                         alt="{{ $appName }}" class="logo" style="max-width: 80px; height: auto; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto;">
                @endif
                <h3 style="margin: 0 0 20px 0; color: {{ $textColor }}; font-weight: 600; font-size: 24px; letter-spacing: 0.5px;">{{ $appName }}</h3>
            </a>
        </div>
        <div class="card" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,{{ $isDarkMode ? '0.3' : '0.1' }}); background: {{ $cardBg }}; border-radius: 12px; transition: all 0.3s ease;">
            <div class="card-body" style="padding: 40px;">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="{{ asset('assets/js/vendor-all.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script>
    feather.replace();
</script>

@if (\App\Models\Utility::getValByName('cust_darklayout') == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
        .auth-wrapper .form-label {
            color: #ffffff !important;
        }
        .auth-wrapper .form-control {
            background-color: #3d3d3d !important;
            border-color: #4d4d4d !important;
            color: #ffffff !important;
        }
        .auth-wrapper .form-control:focus {
            background-color: #3d3d3d !important;
            border-color: #6c63ff !important;
            color: #ffffff !important;
        }
        .auth-wrapper .text-xs {
            color: #b0b0b0 !important;
        }
        .auth-wrapper .text-xs:hover {
            color: #ffffff !important;
        }
    </style>
@else
    <style>
        .auth-wrapper .form-label {
            color: #333333 !important;
        }
        .auth-wrapper .form-control {
            background-color: #ffffff !important;
            border-color: #ddd !important;
            color: #333333 !important;
        }
        .auth-wrapper .form-control:focus {
            background-color: #ffffff !important;
            border-color: #6c63ff !important;
            color: #333333 !important;
        }
        .auth-wrapper .text-xs {
            color: #6c757d !important;
        }
        .auth-wrapper .text-xs:hover {
            color: #6c63ff !important;
        }
    </style>
@endif



<script>
    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }



    var custthemebg = document.querySelector("#cust-theme-bg");
    if (custthemebg) {
        custthemebg.addEventListener("click", function () {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });
    }

    {{--var custdarklayout = document.querySelector("#cust-darklayout");--}}
    {{--custdarklayout.addEventListener("click", function () {--}}
    {{--    if (custdarklayout.checked) {--}}
    {{--        document--}}
    {{--            .querySelector(".m-header > .b-brand > .logo-lg")--}}
    {{--            .setAttribute("src", "{{ asset('assets/images/logo.svg') }}");--}}
    {{--        document--}}
    {{--            .querySelector("#main-style-link")--}}
    {{--            .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");--}}
    {{--    } else {--}}
    {{--        document--}}
    {{--            .querySelector(".m-header > .b-brand > .logo-lg")--}}
    {{--            .setAttribute("src", "{{ asset('assets/images/logo-dark.png') }}");--}}
    {{--        document--}}
    {{--            .querySelector("#main-style-link")--}}
    {{--            .setAttribute("href", "{{ asset('assets/css/style.css') }}");--}}
    {{--    }--}}
    {{--});--}}

    var custdarklayout = document.querySelector("#cust_darklayout");
    if (custdarklayout) {
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-light.png') }}");
            } else {
                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "{{ asset('assets/css/style.css') }}");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-dark.png') }}");
            }
        });
    }


    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
@stack('custom-scripts')


@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
</body>
</html>
