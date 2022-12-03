<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lavetsur</title>
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
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
										<div class="auth-side-wrapper"></div>
									</div>
									<div class="col-md-8 ps-md-0">
										<div class="auth-form-wrapper px-4 py-5">
											<h5 class="text-muted fw-normal mb-4">¡Bienvenido! Ingrese a su cuenta</h5>
											<form id="loginForm" method="POST" action="{{ route('login') }}">
                                                @csrf
												<div class="mb-3">
													<label for="useremail" class="form-label">Usuario</label>
													<input type="email" class="form-control" name="email" id="useremail" placeholder="Usuario">
												</div>
												<div class="mb-3">
													<label for="userpassword" class="form-label">Constraseña</label>
													<input type="password" class="form-control" name="password" id="userpassword" autocomplete="current-password" placeholder="Contraseña">
												</div>
												<div class="form-check mb-3">
													<input type="checkbox" class="form-check-input" id="authCheck">
													<label class="form-check-label" for="authCheck">Recordarme</label>
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
													<button type="submit" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
														Ingresar
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
</body>
</html>