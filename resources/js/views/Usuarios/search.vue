<template>
<div class="row">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-line">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="index.php">Administración ERP</a></li>
		<li class="breadcrumb-item active" aria-current="page">Buscar usuarios</li>
		</ol>
	</nav>
</div>
<div class="row"> 
	<div class="col-xl-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			  <h6 class="card-title">Buscar USUARIO</h6>
				<p class="text-muted mb-3">FILTRAR</p>
				<form id="signupForm" @submit.prevent="searchUsers">
					<div class="row">
						<div class="col-lg-3 p-2">
							<div class="mb-3">
								<label for="ageSelect" class="form-label">Por especialidad</label>
								<select class="form-select" v-model="form.specialty_id">
									<option selected value="0">Seleccionar especialidad</option>
									<option v-for="option in specialties" :key="option.id" :value="option.id" :label="option.name"></option>
								</select>
							</div>                      
						</div>
						<div class="col-lg-3 p-2">
							<div class="mb-3">
							<label for="ageSelect" class="form-label">Por Tipo de Usuario</label>
								<select class="form-select" v-model="form.rol">
									<option selected value="0">Seleccionar Tipo de usuario</option>
									<option v-for="option in roles" :key="option.id" :value="option.id" :label="option.name"></option>
								</select>
							</div>
						</div>
						<div class="col-lg-3 p-2">
							<div class="mb-3">
								<label for="nombres" class="form-label">Por nombres</label>
								<input id="name" class="form-control" name="name" type="text" v-model="form.names">
							</div>
						</div>
						<div class="col-lg-3 p-2">
							<div class="mb-3">
								<label for="email" class="form-label">Por correo electrónico</label>
								<input id="email" class="form-control" name="email" type="email" v-model="form.email">
							</div>
							<div class="mb-3 text-end">
								<input class="btn btn-primary" type="submit" value="BUSCAR"> 
							</div>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
	<div class="row"> 
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
				<h6 class="card-title">Resultado de búsqueda</h6>
					<div class="table-responsive">
						<table class="table table-hover mb-0">
						<thead>
							<tr>
							<th class="pt-0">#</th>
							<th class="pt-0">Perfil</th>
							<th class="pt-0">Nombre</th>
							<th class="pt-0">Área de empresa</th>
							<!-- <th class="pt-0">Tipo de usuario</th>                         -->
							<th class="pt-0">Estado</th>
							<th class="pt-0"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in users.data" :key="index">
								<td>{{ index + 1}}</td>
								<td>
									<div class="me-3">
										<img class="wd-30 ht-30 rounded-circle" src="assets/images/face1.jpg" alt="userr">
									</div>
								</td>
								<td>{{ row.name }}</td>
								<td>{{ row.especialidad }}</td>
								<td>{{ row.role_name }}</td>
								<td><span class="badge bg-success">Activo</span></td>
								<td>
									<a v-show="hasPermissionTo('eliminar-user')" class="btn btn-sm btn-danger p-1" v-if="row.id!=1" @click="Delete(row.id)">Eliminar</a>
									<a v-show="hasPermissionTo('editar-user')"  class="btn btn-sm btn-primary p-1" title="Editar" :href="`/${this.resource}/edit/${row.id}`">Editar</a>
								</td>
							</tr>
						</tbody>
						</table>
					</div>
					<Pagination class="my-2" :data="users" @pagination-change-page="getUsers" />
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
  export default {
	components:{'Pagination': LaravelVuePagination},
	props: ['roles','specialties'],
	  data() {
		return {
			resource: 'usuarios',
			form: {},
			users: []
		}
	  },
	  created(){
		
	  },
	  mounted() {
        this.getUsers();
      },
	  methods: {
		getUsers(page = 1){
            axios.get(`/${this.resource}/records?page=` + page)
            .then(response =>{
                if (response.status === 200) {
                    this.users = response.data.users
                }
            })
            .catch(error => console.log(error))
        },
        searchUsers(){
            axios.post(`/${this.resource}/search`, this.form)
            .then(response => {
                this.users = response.data.users
            })
        },
		Delete(id){
			this.$swal.fire({
				title: 'Eliminar registro?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si!',
				cancelButtonText: 'No!'
			}).then((result) => {
				if (result.isConfirmed) {
					axios.delete(`/${this.resource}/eliminar/${id}`)
					.then(res => {
						if(res.status) {
							// this.$swal(title: 'Registro eliminado',icon: 'warning');
							this.searchUsers();
						}
					})
				}				
			})
		}
	  }
  }
</script>