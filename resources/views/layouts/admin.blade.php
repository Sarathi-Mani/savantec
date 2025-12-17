<!DOCTYPE html>
@php
    use App\Models\Utility;
    //$logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $company_favicon=Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $company_logo = \App\Models\Utility::GetLogo();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    $lang = \App::getLocale('lang');
    if($lang == 'ar' || $lang == 'he')
    {
        $SITE_RTL= 'on';
    }
    $getseo= App\Models\Utility::getSeoSetting();
    $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
    $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';
    $get_cookie = \App\Models\Utility::getCookieSetting();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$SITE_RTL == 'on' ? 'rtl' : '' }}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<head>
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'SellfizERP')}} - @yield('page-title')</title>

    <!-- Meta tags -->
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

    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="url" content="{{ url('').'/'.config('chatify.path') }}" data-user="{{ Auth::check() ? Auth::user()->id : '' }}">
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <!-- Calendar-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.6.0/css/searchBuilder.bootstrap5.min.css">
    
    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif

    @if($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    
    <!-- Custom CSS for DataTables -->
<style>
    /* DataTables Custom Styles */
    .dataTables_wrapper {
        padding: 0;
        margin: 0;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        color: #6c757d;
        margin: 15px;
    }
    
    /* Center align the info text */
    .dataTables_wrapper .dataTables_info {
        
        display: block;
        margin: 15px 15px;
        padding: 8px 0;
    }
    
    .dataTables_wrapper .dataTables_paginate {
        margin: 15px 15px;
        padding: 10px 0;
        display: flex;
        justify-content: flex-end; 
        align-items: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0 3px;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        display: inline-block;
        min-width: 26px;
        text-align: center;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f5f5f5;
        border-color: #999;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #6c63ff;
        color: white;
        border-color: #6c63ff;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px 8px;
        background-color: #fff;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
    }
    
    .dataTables_wrapper table.dataTable {
        border-collapse: collapse !important;
        margin: 0;
        width: 100% !important;
    }
    
    .dataTables_wrapper table.dataTable thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        vertical-align: middle;
    }
    
    .dataTables_wrapper table.dataTable tbody td {
        vertical-align: middle;
    }
    
    /* Dark mode support */
    @if($setting['cust_darklayout'] == 'on')
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: #2d2d2d;
            border-color: #444;
            color: #fff;
        }
        
        .dataTables_wrapper table.dataTable thead th {
            background-color: #343a40;
            color: #fff;
        }
        
        .dataTables_wrapper table.dataTable tbody tr {
            background-color: #2d2d2d;
            color: #fff;
        }
        
        .dataTables_wrapper table.dataTable tbody tr:nth-child(even) {
            background-color: #343a40;
        }
        
        .dataTables_wrapper .paginate_button {
            color: #ddd !important;
            background-color: #444 !important;
            border-color: #555 !important;
        }
        
        .dataTables_wrapper .paginate_button:hover {
            background-color: #555 !important;
            border-color: #666 !important;
        }
        
        .dataTables_wrapper .paginate_button.current {
            background-color: #6c63ff !important;
            border-color: #6c63ff !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_info {
            color: #ddd !important;
        }
    @endif
</style>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/custom-dark.css') }}">
    @endif

    @stack('css-page')
</head>

<body class="{{ $color }}">


<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

@include('partials.admin.menu')
<!-- [ navigation menu ] end -->
<!-- [ Header ] start -->
@include('partials.admin.header')

<!-- Modal -->
<div class="modal notification-modal fade"
     id="notification-modal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button
                    type="button"
                    class="btn-close float-end"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
                <h6 class="mt-2">
                    <i data-feather="monitor" class="me-2"></i>Desktop settings
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="pcsetting1"
                        checked
                    />
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting1"
                    >Allow desktop notification</label
                    >
                </div>
                <p class="text-muted ms-5">
                    you get lettest content at a time when data will updated
                </p>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting2"/>
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting2"
                    >Store Cookie</label
                    >
                </div>
                <h6 class="mb-0 mt-5">
                    <i data-feather="save" class="me-2"></i>Application settings
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting3"/>
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting3"
                    >Backup Storage</label
                    >
                </div>
                <p class="text-muted mb-4 ms-5">
                    Automaticaly take backup as par schedule
                </p>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting4"/>
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting4"
                    >Allow guest to print file</label
                    >
                </div>
                <h6 class="mb-0 mt-5">
                    <i data-feather="cpu" class="me-2"></i>System settings
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="pcsetting5"
                        checked
                    />
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting5"
                    >View other user chat</label
                    >
                </div>
                <p class="text-muted ms-5">Allow to show public user message</p>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light-danger btn-sm"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
                <button type="button" class="btn btn-light-primary btn-sm">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
<div class="dash-container">
    <div class="dash-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="page-header-title">
                            <h4 class="m-b-10">@yield('page-title')</h4>
                        </div>
                        <ul class="breadcrumb">
                            @yield('breadcrumb')
                        </ul>
                    </div>
                    <div class="col">
                        @yield('action-btn')
                    </div>
                </div>
            </div>
        </div>
    @yield('content')
    <!-- [ Main Content ] end -->
    </div>
</div>
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commonModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
        </div>
    </div>
</div>
@include('partials.admin.footer')
@include('Chatify::layouts.footerLinks')

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables + Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>



<script src="{{ asset('js/select2.min.js') }}"></script>
@stack('scripts')
</body>
</html>
