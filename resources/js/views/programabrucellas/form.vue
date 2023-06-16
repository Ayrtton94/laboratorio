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
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Code</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="code" v-model="form.code" class="form-control" name="code" type="text" placeholder="Descripción">
								<small class="form-control-feedback text-danger" v-if="errors.code" v-text="errors.code[0]"></small>
							</div>
						</div>

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
                                <el-select v-model="form.supplier_id" class="w-100" dusk="supplier_id" filterable>
                                    <el-option v-for="option in suppliers" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.supplier_id" v-text="errors.supplier_id[0]"></small>
                            </div>
                        </div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Peso</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="peso" v-model="form.peso" class="form-control" name="peso" type="number" placeholder="Descripción"> 
								<small class="form-control-feedback text-danger" v-if="errors.peso" v-text="errors.price[0]"></small>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Parcela</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="parcela" v-model="form.parcela" class="form-control" name="parcela" type="number" placeholder="Descripción">
							</div>
						</div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)V. Producción</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="v_produccion" v-model="form.v_produccion" class="form-control" name="v_produccion" type="number" placeholder="Descripción">
                                <small class="form-control-feedback text-danger" v-if="errors.v_produccion" v-text="errors.v_produccion[0]"></small>
                            </div>
                        </div>
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Tiempo de Entrega</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="t_hato" v-model="form.t_hato" class="form-control" name="t_hato" type="number" placeholder="Descripción">
								<small class="form-control-feedback text-danger" v-if="errors.time_entrega" v-text="errors.time_entrega[0]"></small>
							</div>
						</div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Accion</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.accion" class="w-100" dusk="accion" filterable>
                                    <el-option v-for="option in acciones" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.accion" v-text="errors.metodo_id[0]"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Asignación Modulo</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <el-select v-model="form.asignar_modulo" class="w-100" dusk="asignar_modulo" filterable>
                                    <el-option v-for="option in asignaciones" :key="option.id" :label="option.name"  :value="option.id"></el-option>
                                </el-select>
                                <small class="form-control-feedback text-danger" v-if="errors.asignar_modulo" v-text="errors.asignar_modulo[0]"></small>
                            </div>
                        </div>

						<div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Tipo de pago</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								<el-select v-model="form.status_paid" class="w-100" filterable>
									<el-option v-for="option in status_paid" :key="option.id" :label="option.nombre"  :value="option.id"></el-option>
								</el-select>
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
                    {"id": 1, "name": "de Modulo"},
                    {"id": 2, "name": "de Planta"},
                ],
                acciones: [

                    {"id": 1, "name": "Accion" },
                    {"id": 2, "name": "Certificado" },
                    {"id": 3, "name": "Comprobante" },
                    {"id": 4, "name": "Certificado/comprobante" },
                    {"id": 5, "name": "Ninguno" }

                ],
				status_paid: [
					{"id": "0", "nombre": "PENDIENTE"},
                    {"id": "1", "nombre": "EFECTIVO"},
                    {"id": "2", "nombre": "DEPOSITO"},
                ]
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
