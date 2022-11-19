<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">{{ this.titleDialog }}</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
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
								<div class="col-auto my-1" v-for="permission in permissionsAll" :key="permission">
									<div class="custom-control custom-checkbox mr-sm-2">
										<input class="form-check-input" type="checkbox" :id="permission.id" :value="permission.id" v-model="form.permissions">
										<label class="custom-check-label" :for="permission.id" style="font-size: 0.79rem;">{{ permission.description }}</label>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button @click.prevent="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-sm btn-success">Registrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				resource: 'roles',
				titleDialog: 'Registrar Perfil',
                records: [],
				form: {},
				permissionsAll: [],
			}
		},
		created(){
			this.getPermission()
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
			getPermission(){
				axios.get(`/${this.resource}/getpermission`)
				.then(response => {
					this.permissionsAll = response.data.permissions
				})
			},
			submit(){
				axios.post(`/${this.resource}`, this.form)
					.then((response) => {
						if(response.status == 200){
                            this.$swal({
								icon: 'success',
								title: 'Registrado',
								showConfirmButton: false,
								timer: 1500
                            })
							this.emitter.emit('reloadData');
							this.closeModal();
						}
				})
			},
			closeModal(){
				this.$emit('closeModal');
			}
		}
		
	}
</script>