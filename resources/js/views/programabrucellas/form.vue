<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Programa Brucellas Manual</span>
						<span v-else>Programa Brucellas Manual</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">

						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Muestras</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<el-select v-model="form.muestra_id" class="w-100" dusk="muestra_id" filterable>
									<el-option v-for="option in muestras" :key="option.id" :label="option.description"  :value="option.id"></el-option>
								</el-select>
								<small class="form-control-feedback text-danger" v-if="errors.muestra_id" v-text="errors.muestra_id[0]"></small>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Ruta</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="ruta" v-model="form.ruta" class="form-control" name="ruta" type="text" placeholder="Descripción">
								<small class="form-control-feedback text-danger" v-if="errors.ruta" v-text="errors.ruta[0]"></small>
							</div>
						</div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Proveedores</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.proveedor_id" class="w-100" dusk="proveedor_id" filterable>
                                    <el-option v-for="option in suppliers" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.proveedor_id" v-text="errors.laboratorio_id[0]"></small>
                            </div>
                        </div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Peso</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="peso" v-model="form.peso" class="form-control" name="peso" type="text" placeholder="Descripción">
								<small class="form-control-feedback text-danger" v-if="errors.peso" v-text="errors.price[0]"></small>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Parcela</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="parcela" v-model="form.parcela" class="form-control" name="parcela" type="text" placeholder="Descripción">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Tiempo de Entrega</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="t_hato" v-model="form.t_hato" class="form-control" name="t_hato" type="text" placeholder="Descripción">
								<small class="form-control-feedback text-danger" v-if="errors.time_entrega" v-text="errors.time_entrega[0]"></small>
							</div>
						</div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Accion</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.accion" class="w-100" dusk="accion" filterable>
                                    <el-option v-for="option in metodos" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.accion" v-text="errors.metodo_id[0]"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Asignación Modulo</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.asignacion_modulo" class="w-100" dusk="asignacion_modulo" filterable>
                                    <el-option v-for="option in asignaciones" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.asignacion_modulo" v-text="errors.metodo_id[0]"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Estado</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.estado" class="w-100" dusk="estado" filterable>
                                    <el-option v-for="option in estados" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.estado" v-text="errors.estado[0]"></small>
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
				resource: 'programabrucellas',
                suppliers: [],
				muestras: [],
                asignaciones: [
                    {"id": "1", "nombre": "Asignacion 01"},
                    {"id": "2", "nombre": "Asignacion 02"},
                ],
                estados: [
                    {"id": "1", "nombre": "Estado 01"},
                    {"id": "2", "nombre": "Estado 02"},
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
					this.suppliers = res.data.suppliers
					this.muestras = res.data.muestras
				})
			},
		}

	}
</script>
