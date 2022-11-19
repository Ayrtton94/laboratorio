<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">{{ this.titleDialog }}</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal2">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Nombre</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="name" v-model="form.name" class="form-control" name="name" type="text" placeholder="Nombre Perfil">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Descripción</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="name" v-model="form.description" class="form-control" name="description" type="text" placeholder="Descripción">
							</div>
						</div>
						<div class="form-group mr-3 ml-3">
							<div class="form-row align-items-center">
								<label class="control-label col-md-12 col-sm-12 col-xs-12">PERMISOS</label>
								<div class="col-auto my-1" v-for="permission in permissionsall" :key="permission">
									<div class="custom-control custom-checkbox mr-sm-2">
										<input class="form-check-input" type="checkbox" :id="permission.id" :value="permission.id" v-model="form.permissions" :checked="inArray(permission.id,this.permissionId)">
										<label class="custom-check-label" :for="permission.id" style="font-size: 0.79rem;">{{ permission.description }}</label>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button @click.prevent="closeModal2" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-sm btn-success">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['modalId','permissionsall'],
		data(){
			return {
				resource: 'roles',
				titleDialog: 'Actualizar Perfil',
                records: [],
				form: {},
				// permissionsAll: [],
				permissionId: []
			}
		},
		created(){
			this.allpermissions()
			this.getDatRoles();
			this.initForm()
		},
		methods:{
			initForm(){
				this.form = {
					id: null,
					name: '',
					description: '',
					guard_name: 'web',
					permissions: []
				}
			},
			inArray(a, b) {
				var length = b.length;
				for(var i = 0; i < length; i++) {
					if(b[i] == a) return true;
				}
				return false;
			},
			getDatRoles(){
				axios.get(`/${this.resource}/editroles/${this.modalId}`)
				.then(res => {
					this.form = res.data.roledata;
				})
			},
			allpermissions(){
				axios.get(`/${this.resource}/hasroles/${this.modalId}`)
				.then(res => {
					const arreglo = Object.values(res.data);
					const resultado = arreglo[0].map(el => el.permission_id);
					this.form.permissions = resultado
					this.permissionId = resultado;
				})
			},
			submit(){
				axios.put(`/${this.resource}/update`, this.form)
					.then((response) => {
						if(response.status == 200){
                            this.$swal({
								icon: 'success',
								title: 'Permisos actualizados',
								showConfirmButton: false,
								timer: 1500
                            })
							this.emitter.emit('reloadData');
							this.closeModal2();
						}
				})
			},
			closeModal2(){
				this.$emit('closeModal2');
			}
		}
		
	}
</script>