<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE PERFIL</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nuevo Perfil</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"></div>
              </div>  
              <div class="table-responsive">
              	<table class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="pt-0">#</th>
                      <th class="pt-0">Nombre</th>
					  <th class="pt-0">Estado</th>
					  <th class="pt-0">Registro</th>
                      <th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ index + 1 }}</td>
						<td>{{ row.description }}</td>
						<td>Activo</td>
						<td>{{ (row.created_at).split('T')[0] }}</td>
						<td>
							<a v-show="hasPermissionTo('eliminar-rol')" class="btn text-danger" v-if="row.id!=1" @click="Delete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
								<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
							</a>
							<a v-show="hasPermissionTo('editar-rol')" @click.prevent="clickUpdate(row.id)" class="btn text-primary" v-if="row.id!=1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
								<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
							</a>
						</td>
					</tr>
                  </tbody>
                </table>
              </div>
            </div> 
          </div>
		  <modal-rol v-if="showDialog" @closeModal="closeModal"/>
		  <edit-modal v-if="showDialogEdit" @closeModal2="closeModal2" :modalId="modalId" :permissionsall="permissionsall"/>
        </div>
    </div>
</template>
<script>
	import axios from "axios"
	import ModalRol from "../Roles/modalRol.vue"
	import EditModal from "../Roles/editModal.vue"
	
    export default {
		props: ['permissionsall'],
		components: {
			ModalRol,
			EditModal
		},
        data() {
            return {
				showDialog: false,
				showDialogEdit: false,
                resource: 'roles',
                records: [],
				modalId: null
            }
        },
        created() {
			this.emitter.on('reloadData', () => {
				this.getData()
			})
            this.getData()
        },
        methods: {
			clickCreate(){
				this.$data.showDialog = true;
			},
			clickUpdate(modalId){
				this.modalId = modalId;
				this.$data.showDialogEdit = true;
			},
			closeModal(){
				this.$data.showDialog = false;
			},
			closeModal2(){
				this.$data.showDialogEdit = false;
			},
            getData() {
                axios.get(`/${this.resource}/records`)
				.then(response => {
					this.records = response.data.roles
				})
            },
			Delete(id){
				this.$swal.fire({
					title: '¿Eliminar registro?',
					text: "Eliminando Perfil Seleccionado!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Si!',
					cancelButtonText: 'No!',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						axios.delete(`/${this.resource}/eliminar/${id}`)
						.then(res => {
							if(res.status) {
								this.$swal({
									icon: 'success',
									title: 'Eliminado',
									showConfirmButton: false,
									timer: 1500
								})					
								this.emitter.emit('reloadData');
							}
						})
					}				
				})
			}
        }
    }
</script>