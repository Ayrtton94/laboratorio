<nav class="navbar top-navbar">
	<div class="container">
		<div class="navbar-content">
			<a href="{{route('home')}}" class="navbar-brand">
				<img class="img-fluid" style="height:47px" src="{{asset('assets/images/logo_1.png')}}">
			</a>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i data-feather="grid"></i>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
					</a>
					<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
						<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
							<div class="mb-3">
								<img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80" alt="">
							</div>
							<div class="text-center">
								<p class="tx-16 fw-bolder">{{ optional(Auth::user())->name }}</p>
								<p class="tx-12 text-muted">{{ optional(Auth::user())->email }}</p>
							</div>
						</div>
						<ul class="list-unstyled p-1">
							<li class="dropdown-item py-2">
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<a onclick="event.preventDefault(); this.closest('form').submit();" class="text-body ms-0" style="cursor: pointer; text-decoration: none;">
										<vue-feather type="log-out" class="fs-vue-feather-14" style="vertical-align: text-bottom !important;"></vue-feather>
										<span class="ml-2"> Cerrar Sesión</span>
									</a>
								</form>
							</li>
						</ul>
					</div>
				</li>
			</ul>
			<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
				<vue-feather type="menu"></vue-feather>					
			</button>
		</div>
	</div>
</nav>