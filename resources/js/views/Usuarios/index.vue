<template>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4">
                	<h6 class="card-title mb-0">GESTIÓN DE USUARIOS</h6>
                  	<div class="dropdown">
						<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nuevo Usuario</button>
                	</div>
              	</div>
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead>
						<tr>
							<th class="pt-0">#</th>
							<th class="pt-0">Nombre</th>
							<th class="pt-0">Tipo de usuario</th>                        
							<th class="pt-0">Estado</th>
							<th class="pt-0"></th>
						</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in records" :key="index">
								<td>{{ index + 1}}</td>
								<td>{{ row.name }}</td>
								<td>{{ row.role_name }}</td>
								<td>
									<span v-if="row.status==1" class="badge bg-success">Activo</span>
									<span v-else class="badge bg-danger">Eliminado</span>
								</td>
								<td>
									<a v-show="hasPermissionTo('eliminar-user')" v-if="row.status!=0 && row.id!=1" class="btn text-danger" @click="clickDelete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
										<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
									</a>
									<a v-show="hasPermissionTo('editar-user')" v-if="row.status!=0 && row.id!=1" @click.prevent="clickUpdate(row)" class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
										<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
									</a>
									<a v-show="hasPermissionTo('editar-user')" class="btn text-success" v-if="row.status==0" @click="clickRestore(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restaurar" aria-label="Restaurar">
										<vue-feather type="rotate-cw" class="fs-vue-feather-18"></vue-feather>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<user-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt" @saveUpdate="saveUpdate"/>
</template>

<script>
	import { deletable } from "../../mixins/deletable"
	import UserModal from "../Usuarios/form.vue"
    export default {
		components:{UserModal},
		mixins: [deletable],
		data() {
            return {
                resource: 'usuarios',
				records: [],
				showDialog: false,
				form: {},
				errors: {}
            }
        },
        created() {
            this.emitter.on('reloadData', () => {
				this.getData();
			});
			this.getData();
        },
        methods: {
			initForm(){
				this.form = {
					id: null,
					name : null,
					email: null,
					password: null,
					rol: null
				},
				this.errors = {}
			},
            getData() {
                axios.get(`/${this.resource}/records`)
				.then(response => {
					this.records = response.data.users
				})
			},
			clickCreate(){
				this.showDialog = true;
			},
			clickUpdate(info){
				this.showDialog = true;
				this.getDataModal(info);
			},
			getDataModal(info){
				this.form.id = info.id
				this.form.name = info.name
				this.form.email = info.email
				this.form.password = info.password
				this.form.rol = info.role_name
			},
			closeModal(){
				this.showDialog = false;
				this.initForm();
			},
			saveAppt(form){
				axios.post(`/${this.resource}`, form)
				.then(res => {
					if(res.status == 200) {
						this.$swal({
							icon: 'success',
							title: res.data.message,
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData');
						this.closeModal();
					}
				}).catch(error=> {
					if(error.response.status === 422){
						this.errors = error.response.data.errors
					}else{
						console.log(error);
					}
				})
			},
			saveUpdate(){
				axios.put(`/${this.resource}/update`, this.form)
				.then((response) => {
					if(response.status == 200){
						this.$swal({
							icon: 'success',
							title: 'Datos actualizados',
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData');
						this.closeModal();
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
			clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`)
				.then(() =>
                    this.emitter.emit('reloadData')
                )
			},
			clickRestore(id) {
                this.restore(`/${this.resource}/restore/${id}`).then(() =>
					this.emitter.emit('reloadData')
                )
            },
        }
    }
</script>
