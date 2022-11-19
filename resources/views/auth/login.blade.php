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
  	<link rel="stylesheet" href="assets/vendors/core/core.css">
	<!-- endcore:css -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
	<link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="assets/vendors/dropify/dist/dropify.min.css">
	<link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
	<!-- End plugin css for this page -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
	<!-- End plugin css for this page -->

    <!-- End layout styles -->

    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="page-wrapper full-page">
                <div class="page-content d-flex align-items-center justify-content-center">

                    <div class="row w-100 mx-0 auth-page">
                        <div class="col-md-8 col-xl-6 mx-auto">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4 pe-md-0">
                                        <div class="auth-side-wrapper">

                                        </div>
                                    </div>
                                    <div class="col-md-8 ps-md-0">
                                        <div class="auth-form-wrapper px-4 py-5">

                                            <h5 class="text-muted fw-normal mb-4">¡Bienvenido! Ingrese a su cuenta</h5>
                                            <form id="loginForm" method="POST" action="{{ route('login') }}">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="userEmail" class="form-label">Correo electrónico</label>
                                                    <input type="email" class="form-control" name="email" id="useremail" placeholder="correo electrónico">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="userPassword" class="form-label">Constraseña</label>
                                                    <input type="password" class="form-control" name="password" id="userpassword" autocomplete="current-password" placeholder="contraseña">
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="authCheck">
                                                    <label class="form-check-label" for="authCheck">
                                                        Recordarme
                                                    </label>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label" for="termsCheck">
                                                            Estoy de acuerdo con <a data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable" href="."> los términos y condiciones de uso </a>
                                                        </label>
                                                        <input type="checkbox" class="form-check-input" name="terms_agree" id="termsCheck">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                                                    <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                        <i class="btn-icon-prepend" data-feather="key"></i>
                                                        Recuperar cuenta
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->

	<script src="assets/vendors/jquery-validation/jquery.validate.min.js"></script>
	<script src="assets/vendors/chartjs/Chart.min.js"></script>
	<script src="assets/vendors/jquery.flot/jquery.flot.js"></script>
	<script src="assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
	<script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
	
	<script src="assets/vendors/dropify/dist/dropify.min.js"></script>
	<script src="assets/vendors/select2/select2.min.js"></script>


	<script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
	<script src="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
	<script src="assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	{{-- <script src="assets/js/dashboard-dark.js"></script> --}}
	<script src="assets/js/datepicker.js"></script>
    <script src="assets/js/select2.js"></script>

</body>
</html>
