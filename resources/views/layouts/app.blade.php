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
    <link rel="stylesheet" href="{{asset('assets/vendors/core/core.css')}}">
    <!-- endinject -->
	
	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="{{asset('assets/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendors/dropify/dist/dropify.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">

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
                    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
						<div>
							<h4 class="mb-3 mb-md-0">Bienvenido {{ optional(Auth::user())->name }}!</h4>
						</div>
						<div class="d-flex align-items-center flex-wrap text-nowrap">
							<div class="input-group date datepicker wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
								<span class="input-group-text input-group-addon bg-transparent border-primary">
									<vue-feather type="calendar" class="fs-vue-feather-18 text-primary"></vue-feather>
								</span>
								<input type="text" class="form-control border-primary bg-transparent">
							</div>
						</div>
					</div>
                    @yield('content')
                </div>
            </div>
			@include('layouts.footer')
        </div>
    </div>
    <script src="{{asset('assets/vendors/core/core.js')}}"></script>
    <!-- endinject -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Plugin js for this page -->
	<script src="{{asset('assets/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{asset('assets/vendors/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{asset('assets/vendors/jquery.flot/jquery.flot.resize.js')}}"></script>
	<script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendors/dropify/dist/dropify.min.js')}}"></script>
	<script src="{{asset('assets/vendors/select2/select2.min.js')}}"></script>
	<script src="{{asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
	<script src="{{asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>

	<script src="{{asset('assets/js/template.js')}}"></script>

    <script src="{{asset('assets/vendors/inputmask/jquery.inputmask.min.js')}}"></script>

    <script src="{{asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
    <script src="{{asset('assets/vendors/dropzone/dropzone.min.js')}}"></script>
    
    <script src="{{asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    
    <script src="{{asset('assets/vendors/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js')}}"></script>
    

    <script src="{{asset('assets/vendors/prismjs/prism.js')}}"></script>
    <script src="{{asset('assets/vendors/clipboard/clipboard.min.js')}}"></script>
    
    
    <script src="{{asset('assets/vendors/dropzone/dropzone.min.js')}}"></script>
    <!-- End plugin js for this page -->

    <!-- Custom js for this page -->
    <script src="{{asset('assets/js/dashboard-dark.js')}}"></script>
	<script src="{{asset('assets/js/datepicker.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>
</body>
</html>