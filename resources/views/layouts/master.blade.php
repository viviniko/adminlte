<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JollyHers') }}</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @stack('css')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue-light sidebar-collapse sidebar-mini fixed">
    <div id="content-loader">
        <img src="{{ asset('assets/images/logo-icon.png') }}" alt="Content Loader">
    </div>

    <div class="wrapper">
    @include('includes.header')
    @include('includes.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>
            <!-- /.Content Header -->
            <!-- Main content -->
            <section class="content">
            @include('includes.messages')
            <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('includes.control')
        @include('includes.footer')
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('js')
</body>
</html>
