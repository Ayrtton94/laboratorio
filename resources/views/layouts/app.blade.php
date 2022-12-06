<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{asset('assets/css/core.css')}}">
    <!-- endinject -->

	<link rel="stylesheet" href="{{asset('assets/fonts/feather-font/css/iconfont.css')}}">
    <!-- End plugin css for this page -->

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
	@auth
		<meta name="global_data" content="{{ json_encode(session('permissions_roles')) }}">
	@endauth
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
    <div id="app">
        <div class="main-wrapper">
			<div class="horizontal-menu">
				@include('layouts.navbar')
				@include('layouts.sidebar')
			</div>
            <div class="page-wrapper">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
			@include('layouts.footer')
        </div>
    </div>
    <script src="{{asset('assets/js/core.js')}}"></script>
   
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Plugin js for this page -->
    <script src="{{asset('assets/js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/apexcharts.min.js')}}"></script>
	
	<script src="{{asset('assets/js/template.js')}}"></script>
    <!-- Custom js for this page -->
    <script src="{{asset('assets/js/dashboard-dark.js')}}"></script>
</body>
</html>