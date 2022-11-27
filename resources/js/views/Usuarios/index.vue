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
									<span class="badge bg-success">Activo</span>
								</td>
								<td>
									<!-- <a v-show="hasPermissionTo('eliminar-user')" class="text-danger" v-if="row.id!=1" @click="Delete(row.id)"><vue-feather type="trash-2"></vue-feather></a> -->
									<!-- <a v-show="hasPermissionTo('editar-user')"  class="text-primary" title="Editar" :href="`/${this.resource}/edit/${row.id}`"><vue-feather type="edit"></vue-feather></a> -->
									<a v-show="hasPermissionTo('editar-user')"  class="text-primary" title="Editar" @click.prevent="clickUpdate(row)"><vue-feather type="edit"></vue-feather></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<modal-form v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt" @saveUpdate="saveUpdate"/>
</template>

<script>
	import { deletable } from "../../mixins/deletable"
	import ModalForm from "../Usuarios/modalForm.vue"
    export default {
		components:{ModalForm},
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
					this.records = response.data.users.data
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
				console.log(info);
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
        }
    }
</script>
