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
						<li class="nav-item">
							<a href="{{route('presentaciones')}}" class="nav-link {{ Route::is('presentaciones')?'active':''}}">Presentación</a>
						</li>
						<li class="nav-item"><a class="nav-link" href="{{route('especies')}}">Especie</a></li>
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