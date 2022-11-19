<template>
	<div class="row">
		<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-line">
			<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="index.php">Administración ERP</a></li>
			<li class="breadcrumb-item active" aria-current="page">Nuevo usuario</li>
		</ol>
		</nav>
	</div> <!-- row -->
  	<div class="row"> 
	<div class="col-xl-12 grid-margin stretch-card">
				<div class="card">
				<div class="card-body">
						<p class="text-muted mb-3">Ingresar los datos del formulario</p>

						<div class="row">
						<form id="signupForm" @submit.prevent="submit">
						<div class="col-lg-6 p-3" style="background-color:#f9fafb;">
							<h6 class="card-title">Información General</h6>

							<div class="row">
								<div class=" p-2">
									<div class="mb-3">
									<label for="ageSelect" class="form-label">Tipo de Usuario</label>
									<select class="form-select" name="age_select" id="ageSelect">
										<option selected>Seleccionar Tipo de usuario</option>
										<option>Doctor</option>
										<option>Técnico</option>
										<option>Gestor de ERP</option>
										<option>Comercial</option>
										</select>
									</div>
									<div class="mb-3">                            
									<input id="name" class="form-control" type="text" placeholder="Nombres">
								</div>
								<div class="mb-3">                            
									<input id="name" class="form-control" name="last_name" type="text" placeholder="Apellidos">
								</div>
								<div class="mb-3">                            
									<input id="name" class="form-control" name="numero_documento" type="text" placeholder="DNI">
								</div>
								<div class="mb-3">                            
								<label class="form-label">Fecha nacimiento:</label>
						<input class="form-control mb-4 mb-md-0" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy"/>
								</div>
								
								
								<div class="mb-3">                            
									<select class="form-select" name="age_select" id="ageSelect">
										<option selected>Seleccionar Especialidad</option>
										<option>Especialidad 1</option>
										<option>Especialidad 2</option>
										<option>Especialidad 3</option>
										
										</select>
								</div>

								</div>
								</div>
							

						</div>
						<div class="col-lg-6 p-3  text-light" style="background-color:#b5d6e5">
							<h6 class="card-title">Información de contacto</h6>
							
							<div class="mb-3">                            
									<input id="name" class="form-control" type="text" placeholder="Correo">
								</div>
								<div class="mb-3">                            
									<input id="name" class="form-control" type="text" placeholder="Teléfono">
								</div>
								<div class="mb-3">                            
									<input id="name" class="form-control" type="text" placeholder="Dirección">
								</div>
								
								
							<h6 class="card-title">Información de Seguridad</h6>
							<div class="mb-3">                            
									<input id="name" class="form-control" type="Password" placeholder="Password">
								</div>
								<div class="mb-3">                            
									<input id="name" class="form-control" type="Password" placeholder="Repetir Password">
								</div>
									
						</div>
							<div class="col-lg-6 p-3 "></div>
							<div class="col-lg-6 p-3 text-end">
							<button type="button" class="btn btn-primary btn-icon-text">
								<i class="btn-icon-prepend" data-feather="check-square"></i>
							Limpiar formulario
							</button>
							<button type="button" class="btn btn-icon-text text-light mx-1" style="background-color: #ce9d20">
								<i class="btn-icon-append" data-feather="box"></i>
							Crear usuario
							</button>
							</div>
							</form>
						</div>
				</div>
				</div>
		</div>      
	</div>
</template>

<script>
export default {
	data() {
		return {
				resource:'usuarios',
				form:{}
			}
		},	
        mounted() {
            console.log('Component mounted.')
	},
		created() {
				this.initForm()
	},
	methods: {
		submit() {
			axios.post(`${this.resource}`, this.form)
				.then(response => {
					console.log(response)
				})
				.catch(error => console.log(error))
			},	
			initForm() {
				this.form = {
					id: null,
					name: null,
					last_name: null,
					document: null,
					birth_date: null,
				}
			}
		},
		
		
    }
</script>
