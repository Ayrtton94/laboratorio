<template>
<div class="row">
	<h6 class="card-title">USUARIOS</h6>
</div>
<div class="row"> 
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead>
						<tr>
							<th class="pt-0">#</th>
							<th class="pt-0">Perfil</th>
							<th class="pt-0">Nombre</th>
							<th class="pt-0">Área de empresa</th>
							<th class="pt-0">Tipo de usuario</th>                        
							<th class="pt-0">Estado</th>
							<th class="pt-0"></th>
						</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in records.data" :key="index">
							<td>{{ index + 1}}</td>
							<td>
								<div class="me-3">
									<img class="wd-30 ht-30 rounded-circle" src="assets/images/face1.jpg" alt="userr">
								</div>
								</td>
								<td>{{ row.name }}</td>
								<td>{{ row.especialidad }}</td>
								<td>{{ row.role_name }}</td>
								<td>
									<span class="badge bg-success">Activo</span>
								</td>
								<td>
									<a v-show="hasPermissionTo('eliminar-user')" class="text-danger" v-if="row.id!=1" @click="Delete(row.id)"><vue-feather type="trash-2"></vue-feather></a>
									<a v-show="hasPermissionTo('editar-user')"  class="text-primary" title="Editar" :href="`/${this.resource}/edit/${row.id}`"><vue-feather type="edit"></vue-feather></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<Pagination class="my-2" :data="records" @pagination-change-page="getUsers" />
			</div>
		</div>
	</div>
</div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
    export default {
		components:{'Pagination': LaravelVuePagination},
		data() {
            return {
                resource: 'usuarios',
                records: [],
            }
        },
        created() {
            this.getData()
        },
        methods: {
            getData() {
                axios.get(`/${this.resource}/records`)
                    .then(response => {
                        this.records = response.data.users
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
								this.getData();
							}
						})
					}				
				})
			}
        }
    }
</script>
