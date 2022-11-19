{{-- <nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('home')}}" class="sidebar-brand">
            <img style="width: 100px" src="{{asset('assets/images/logoiderma.png')}}">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{route('home')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Panel Principal</span>
                </a>
            </li>
            <li class="nav-item nav-category">Administración ERP</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="users">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Usuarios</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav sub-menu">
                        @verifypermissions('crear-user')
                        <li class="nav-item">
                            <a href="{{route('usuarioscreate')}}" class="nav-link {{ Route::is('usuarioscreate')?'active':''}}">Nuevo Usuario</a>
                        </li>
                        @endverifypermissions
                        <li class="nav-item">
                            <a href="{{route('searchuser')}}" class="nav-link {{ Route::is('searchuser')?'active':''}}">Buscar</a>
                        </li>
                        @verifypermissions('ver-user')
                        <li class="nav-item">
                            <a href="{{route('usuarios')}}" class="nav-link {{ Route::is('usuarios')?'active':''}}">Usuarios</a>
                        </li>
                        @endverifypermissions

                        <li class="nav-item">
                            <a href="{{route('rolescreate')}}" class="nav-link  {{ Route::is('rolescreate')?'active':''}}">Nuevo Rol</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles')}}" class="nav-link">Roles</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item nav-category">Gestión Comercial</li>
            <li class="nav-item">
                <a class="nav-link {{Route::is('patients')?'active':''}}" href="{{route('patients')}}">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Buscar pacientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Route::is('patients-create')?'active':''}}" href="{{route('patients-create')}}">
                    <i class="link-icon" data-feather="plus-circle"></i>
                    <span class="link-title">Nuevo paciente</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="agendar-cita.php" class="nav-link">
                    <i class="link-icon" data-feather="message-square"></i>
                    <span class="link-title">Agendar cita</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/apps/calendar.html" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Vitrina</span>
                </a>
            </li>


            </li>
            <li class="nav-item nav-category">Gestión Doctor</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Atenciones</span>

                </a>

            </li>
            <li class="nav-item nav-category">Historial clínico</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Buscar</span>

                </a>

            </li>

            <li class="nav-item nav-category">Facturación y Contabilidad</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                    <i class="link-icon" data-feather="feather"></i>
                    <span class="link-title">órdenes de compra</span>

                </a>

            </li>


            <li class="nav-item nav-category">Productos</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" role="button" aria-expanded="false" aria-controls="general-pages">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Almacen</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="general-pages">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/general/blank-page.html" class="nav-link">Catálogo de vitrina</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/general/faq.html" class="nav-link">Productos de servicios</a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav> --}}


<nav class="bottom-navbar">
	<div class="container">
		<ul class="nav page-navigation">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('home') }}">
					<i class="link-icon"><vue-feather type="box" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="#"  class="nav-link">
					<i class="link-icon"><vue-feather type="hash" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">RRHH</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Personal</li>
						<li class="nav-item"><a class="nav-link" href="">Gestión de usuarios</a></li>
						<li class="nav-item"><a class="nav-link" href="">Control de Asistencia</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="link-icon"><vue-feather type="database" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Mantenimientos</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Lavetsur</li>
						{{-- <li class="nav-item">
                            <a href="{{route('rolescreate')}}" class="nav-link  {{ Route::is('rolescreate')?'active':''}}">Nuevo Rol</a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('roles')}}" class="nav-link">Perfil</a>
                        </li>
						<li class="nav-item"><a class="nav-link" href="">Área</a></li>
						<li class="nav-item "><a class="nav-link" href="">Personal</a></li>
						@verifypermissions('ver-user')
                        <li class="nav-item">
                            <a href="{{route('usuarios')}}" class="nav-link {{ Route::is('usuarios')?'active':''}}">Usuario</a>
                        </li>
                        @endverifypermissions
						<li class="nav-item"><a class="nav-link" href="">Cliente</a></li>
						<li class="nav-item"><a class="nav-link" href="">Tipo de Órden</a></li>
						<li class="nav-item"><a class="nav-link" href="">Presentación</a></li>
						<li class="nav-item"><a class="nav-link" href="">Especie</a></li>
						<li class="nav-item"><a class="nav-link" href="">Sub Especie</a></li>
						<li class="nav-item"><a class="nav-link" href="">Matríz</a></li>
						<li class="nav-item"><a class="nav-link" href="">Muestra</a></li>
						<li class="nav-item"><a class="nav-link" href="">Prueba</a></li>
						<li class="category-heading">Empresas y Proveedores<li>
						<li class="nav-item"><a class="nav-link" href="gestion-empresas-acopiadoras.php">Empresas acopiadoras de leche</a></li>
						<li class="nav-item"><a class="nav-link" href="gestion-clientes.php">Clientes</a></li>

					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="link-icon"><vue-feather type="feather" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Recepción</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Gestión excel Padrón Brucella</li>
						<li class="nav-item"><a class="nav-link" href="">Preparar Padrón programa Brucellas</a></li>
						<li class="category-heading">Laboratorio<li>
						
						<li class="nav-item"><a class="nav-link" href="">Generar Orden de Laboratorio</a></li>
						<li class="nav-item"><a class="nav-link" href="">Listar órdenes</a></li>
						<li class="nav-item"><a class="nav-link" href="recepcion-generar-campana-brucella.php">Generar orden de Campaña Brucella</a></li>
						<li class="nav-item"><a class="nav-link" href="recepcion-comprobante-de-venta.php">Comprobante de venta</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="link-icon"><vue-feather type="alert-triangle" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Área de Laboratorio</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Órdenes de laboratorio</li>
							<li class="nav-item"><a class="nav-link" href="">Listar órdenes</a></li>
						<li class="nav-item"><a class="nav-link" href="">Registrar resultados</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="link-icon"><vue-feather type="aperture" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Programa Brucella</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Órdenes de laboratorio</li>
						<li class="nav-item"><a class="nav-link" href="">Resumen</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="link-icon"><vue-feather type="archive" class="fs-vue-feather-18"> </vue-feather></i>
					<span class="menu-title">Área de contabilidad</span>
					<i class="link-arrow"></i>
				</a>
				<div class="submenu">
					<ul class="submenu-item">
						<li class="category-heading">Órdenes de laboratorio</li>
						<li class="nav-item"><a class="nav-link" href="">Listar órdenes</a></li>
						<li class="nav-item"><a class="nav-link" href="">Generar ordenes de descuento</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>