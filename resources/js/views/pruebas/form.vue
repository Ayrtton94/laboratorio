<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Nueva Prueba</span>
						<span v-else>Actualizar Registro</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">Matrices</label>
									<el-select v-model="form.matriz_id" class="w-100" dusk="matriz_id" filterable>
										<el-option v-for="option in matrices" :key="option.id" :label="option.description"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.matriz_id" v-text="errors.matriz_id[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Muestras</label>
									<el-select v-model="form.muestra_id" class="w-100" dusk="muestra_id" filterable>
										<el-option v-for="option in muestras" :key="option.id" :label="option.description"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.muestra_id" v-text="errors.muestra_id[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Nombre</label>
									<input id="name" v-model="form.name" class="form-control" name="name" type="text" placeholder="Descripción">
									<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Precio</label>
									<input id="name" v-model="form.price" class="form-control" name="price" type="text" placeholder="Descripción">
									<small class="form-control-feedback text-danger" v-if="errors.price" v-text="errors.price[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Laboratorios</label>
									<el-select v-model="form.laboratorio_id" class="w-100" dusk="laboratorio_id" filterable>
										<el-option v-for="option in laboratorios" :key="option.id" :label="option.name"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.laboratorio_id" v-text="errors.laboratorio_id[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Metodos</label>
									<el-select v-model="form.metodo_id" class="w-100" dusk="metodo_id" filterable>
										<el-option v-for="option in metodos" :key="option.id" :label="option.name"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.metodo_id" v-text="errors.metodo_id[0]"></small>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Condición</label>
									<input id="name" v-model="form.condicion" class="form-control" name="condicion" type="text" placeholder="Descripción">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Tiempo de Entrega</label>
									<input id="name" v-model="form.time_entrega" class="form-control" name="time_entrega" type="text" placeholder="Descripción">
									<small class="form-control-feedback text-danger" v-if="errors.time_entrega" v-text="errors.time_entrega[0]"></small>
								</div>
							</div>
							<div class="modal-footer">
								<button @click.prevent="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
								<button @click.prevent="store(form)" type="submit" class="btn btn-sm btn-success">
									<span v-if="!form.id">Registrar</span>
									<span v-else>Actualizar</span>
								</button>
							</div>
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
				matrices: [],
				muestras: [],
				laboratorios: [],
				metodos: []
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