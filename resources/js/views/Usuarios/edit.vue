<template>
	<div class="row">
		<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-line">
			<li class="breadcrumb-item"><a :href="`/${home}/`">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="index.php">Administración ERP</a></li>
			<li class="breadcrumb-item active" aria-current="page">Editar usuario</li>
		</ol>
		</nav>
	</div>
	<div class="row"> 
		<div class="col-xl-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<p class="text-muted mb-3">Ingresar los datos del formulario</p>
					<div class="row">
						<h6 class="card-title">Información General</h6>
						<form autocomplete="off" @submit.prevent="submit">
							<div class="row">
								<div class="col-md-6" style="background-color:#f9fafb;">
									<div class=" p-2">
										<div class="mb-3">
											<label for="type_use" class="form-label">Tipo de Usuario</label>
											<select class="form-select" v-model="form.rol">
												<option selected value="0">Seleccionar Tipo de usuario</option>
												<option v-for="option in roles" :key="option.id" :value="option.name" :label="option.name"></option>
											</select>
											<small class="form-control-feedback text-danger" v-if="errors.rol" v-text="errors.rol[0]"></small>
										</div>
										<div class="mb-3">                            
											<input id="name" v-model="form.name" class="form-control" name="name" type="text" placeholder="Nombres">
											<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
										</div>
										<div class="mb-3">                            
											<input id="last_name" v-model="form.last_name" class="form-control" name="last_name" type="text" placeholder="Apellidos">
										</div>
										<div class="mb-3">                            
											<input id="document" v-model="form.document" class="form-control" name="document" type="text" placeholder="DNI">
											<small class="form-control-feedback text-danger" v-if="errors.document" v-text="errors.document[0]"></small>
										</div>
										<div class="mb-3">                            
											<label class="form-label">Fecha nacimiento:</label>
											<input class="form-control mb-4 mb-md-0" v-model="form.birth_date" name="birth_date" data-inputmask-inputformat="dd/mm/yyyy"/>
										</div>
										<div class="mb-3">                            
											<select class="form-select" name="specialty_id" id="specialty_id" v-model="form.specialty_id">
												<option selected value="0">Seleccionar Especialidad</option>
												<option v-for="option in specialties" :key="option.id" :value="option.id" :label="option.name"></option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="col-lg-12 p-3  text-light" style="background-color:#b5d6e5">
										<h6 class="card-title">Información de contacto</h6>
										<div class="mb-3">                            
											<input type="email" class="form-control" placeholder="Correo" v-model="form.email" name="email" tabindex="1" >
											<small class="form-control-feedback text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
										</div>
										<div class="mb-3">                            
											<input id="phone" v-model="form.phone" class="form-control" name="phone" type="text" placeholder="Teléfono">
										</div>
										<div class="mb-3">                            
											<input id="address"  v-model="form.address" class="form-control" name="address" type="text" placeholder="Dirección">
										</div>
										<h6 class="card-title">Información de Seguridad</h6>
										<div class="mb-3">                            
											<input id="password" v-model="form.password"  class="form-control" name="password" type="Password" placeholder="Password">
											<small class="form-control-feedback text-danger" v-if="errors.password" v-text="errors.password[0]"></small>
										</div>
										<div class="mb-3">                            
											<input id="confirm-password" class="form-control" name="confirm-password" type="Password" placeholder="Repetir Password">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12 p-3 text-end">
								<button type="submit" class="btn btn-icon-text text-light mx-1" style="background-color: #ce9d20">
									<i class="btn-icon-append" data-feather="box" native-type="submit"></i> Actualizar usuario
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
	import axios from "axios"
    export default {
		props: ['usuarios'],
		data(){
			return {
				resource: 'usuarios',
				home: 'home',
				records: [],
				errors: {},
				form: {},
				roles: [],
				specialties: []
			}
		},
        created(){
			this.initForm()
			this.getRoles()
			this.getSpecialties()
			// console.log(this.usuarios.roles[0].id);
		},
		methods: {
			initForm(){
				this.errors = {}
				this.form = {
					id: this.usuarios.id,
					name: this.usuarios.name,
					last_name: this.usuarios.last_name,
					document: this.usuarios.document,
					email: this.usuarios.email,
					password: '',
					rol: this.usuarios.roles[0].name,
					phone: this.usuarios.phone,
					specialty_id: this.usuarios.specialty_id,
					birth_date: this.usuarios.birth_date,
					address: this.usuarios.address
				}
			},
			getRoles(){
				axios.get(`/roles/records`)
				.then(response => {
					this.roles = response.data.roles
				})
			},
			getSpecialties(){
				axios.get(`/specialties/specialtiesrecords`)
				.then(response => {
					this.specialties = response.data.specialties
				})
			},
			submit(){
				axios.put(`/${this.resource}/update`, this.form)
				.then((response) => {
					if(response.status == 200){
						this.$swal({
							icon: 'success',
							title: 'Datos actualizados',
							showConfirmButton: false,
							timer: 1500
						})
						this.location.href = `/${this.resource}`;
					}else{
						this.$swal({icon: 'error',title: 'Ocurrio un error',showConfirmButton: false,timer: 1500})
					}
				})
				.catch(error=> {
					if(error.response.status === 422){
						this.errors = error.response.data.errors
					}else{
						console.log(error);
					}
				})
			},
			resetForm(){
				this.initForm();
			}
		}
    }
</script>
