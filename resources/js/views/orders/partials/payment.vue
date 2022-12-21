<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span>MODALIDAD DE PAGO</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">

						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)ESTADO</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<el-select v-model="form.status_paid" class="w-100" dusk="status_paid" filterable>
										<el-option v-for="option in status_paid" :key="option.id" :label="option.nombre"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.status_paid" v-text="errors.status_paid[0]"></small>
								</div>
							</div>
						</div>
						

						<div class="modal-footer">
							<button @click.prevent="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button @click.prevent="store(form)" type="submit" class="btn btn-sm btn-success">
								<span v-if="!form.id">Registrar</span>
								<span v-else>Actualizar</span>
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
				default: ()=>{}
			},
			errors: {}
		},
		data(){
			return {
				resource: 'pruebas',
				status_paid: [
                    {"id": "1", "nombre": "EFECTIVO"},
                    {"id": "2", "nombre": "DEPOSITO"},
                ],
	
			}
		},
		created(){
			this.tables();
		},
		methods:{
			store(form){
				this.$emit('saveAppt', form);
			},
			closeModal(){
				this.$emit('closeModal');
			},
			tables(){
				axios.get(`/${this.resource}/tables`)
				.then(res => {
					this.matrices = res.data.matrices
					this.muestras = res.data.muestras
					this.laboratorios = res.data.laboratorios
					this.metodos = res.data.metodos
				})
			},
		}
		
	}
</script>