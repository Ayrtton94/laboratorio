<template>
	<div class="modal fade show" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Nueva Usuario</span>
						<span v-else>Actualizar Datos</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="row">
							<table class="table">
								<tbody>
									<tr>
										<td align="center">
											<input type="radio" id="1" value="Personal" v-model="form.person"  class="form-check-input"/>
											<label for="one">Personal</label>
										</td>
										<td align="center">
											<input type="radio" id="2" value="Invitado" v-model="form.person"  class="form-check-input"/>
									<label for="two">Invitado</label>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table">
								<tbody>
									<tr>
										<td>
											<label class="control-label">Tipo Usuario</label>
											<div class="form-group">
												<el-select v-model="form.rol" placeholder="Tipo usuario">
													<el-option v-for="option in roles" :value="option.name" :key="option.id" :label="option.name"/>
												</el-select>
												<small class="form-control-feedback text-danger" v-if="errors.rol" v-text="errors.rol[0]"></small>
											</div>
										</td>
										<td>
											<label class="control-label">(*)Nombre</label>
											<div class="form-group">
												<input v-model="form.name" class="form-control" type="text" placeholder="Nombre Usuario">
												<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table">
								<tbody>
									<tr>
										<td>										
											<label class="control-label">Usuario</label>
											<div class="form-group">
												<input id="email" v-model="form.email"  class="form-control" name="email" type="email" placeholder="Email">
												<small class="form-control-feedback text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
											</div>
										</td>
										<td>											
											<label class="control-label">Contraseña</label>
											<div class="form-group">
												<input id="password" v-model="form.password"  class="form-control" name="password" type="Password" placeholder="Password">
												<small class="form-control-feedback text-danger" v-if="errors.password" v-text="errors.password[0]"></small>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button @click.prevent="closeModal"  type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button @click.prevent="store(form)" v-if="!form.id" type="submit" class="btn btn-sm btn-success">
								Registrar
							</button>
							<button v-else @click.prevent="updateAppt(form)" type="submit" class="btn btn-sm btn-success">
								Actualizar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
			form: {
				type: Object,
				default: () => {}
			},
			errors: {}
		},
		data(){
			return {
				resource: 'usuarios',
				records: [],
				roles: []
			}
		},
		created(){
			this.getRoles();
		},
		methods: {
			getRoles(){
				axios.get(`/roles/records`)
				.then(response => {
					this.roles = response.data.roles
				})
			},
			store(form){
				this.$emit('saveAppt',form);
			},
			closeModal(){
				this.$emit('closeModal');
			},
			updateAppt(form){
				this.$emit('saveUpdate',form);
			}
		}
	}
</script>
<style scoped>
    .table th, .table td { 
        border-top: none !important;
        border-left: none !important;

		border-right: none !important;
		border-block: none !important;

    }
</style>