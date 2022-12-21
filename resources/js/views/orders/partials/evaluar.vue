<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span>EVALUACIÓN DE ORDEN DE LABORATORIO</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="row">
							<div class="table-responsive">
								<h4>Lista de pruebas</h4>
								<table class="table table-bordered">
									<thead class="table-primary">
										<tr>
											<th width="5px">#</th>
											<th class="text-center font-weight-bold" width="60px">GRUPO</th>
											<th class="text-center font-weight-bold" width="60px">MUESTRA</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(row, index) in this.tableDataGrupo" :key="index">
											<td>{{ index + 1 }}</td>
											<td>{{ row.grupo }}</td>
											<td>{{ row.muestra }}</td>
										</tr>		
										<tr>
											<td colspan="1" class="font-weight-bold text-center">Registros: 1</td>
											<td colspan="1" class="font-weight-bold text-center">Aceptadas: 0</td>
											<td colspan="1" class="font-weight-bold text-center">Rechazadas: 0</td>
										</tr>								
									</tbody>
								</table>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="table-responsive">
								<h4>Lista de pruebas</h4>
								<table class="table table-bordered">
									<thead class="table-primary">
										<tr>
											<th width="5px">#</th>
											<th class="text-center font-weight-bold" width="60px">PRUEBA</th>
											<th class="text-center font-weight-bold" width="60px">MATRIZ</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(row, index) in this.tableDataPruebas" :key="index">
											<td>{{ index + 1 }}</td>
											<td>{{ row.prueba }}</td>
											<td>{{ row.matriz }}</td>
										</tr>										
									</tbody>
								</table>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-12 col-sm-12 col-xs-12">F. Recepción:</label>
										<p>10/12/2022 - 12:40</p>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">F. Muestreo:</label>
										<p>10/12/2022 - 12:40</p>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">F. entrega:</label>
										<p>14/12/2022 - 12:40</p>
									</div>										
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Temperatura Cº:</label>
										<p>5º</p>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Muestreado por:</label>
										<p>CAROLINA TORRES FERNANDEZ RIVERA</p>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Recepción:</label>
										<p>JUANA MARY TEJADA ALARCON</p>
									</div>						
								</div>
							</div>
						</div>
																		
						<hr>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead class="table-primary">
									<tr>
										<th width="5px">#</th>
										<th class="text-center font-weight-bold" width="60px">Producto declarado:</th>
										<th class="text-center font-weight-bold" width="50">Presentación</th>
										<th class="text-center font-weight-bold" width="50">Capacidad</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(row, index) in this.tableData" :key="index">
										<td>{{ index + 1 }}</td>
										<td>{{ row.item }}</td>
										<td>{{ row.presentacion }}</td>
										<td>{{ row.capacidad }}</td>
									</tr>										
								</tbody>
							</table>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-6">
								<h3>Datos de la Prueba</h3>
								<div class="row">
									<div class="form-group">
										<h5 class="control-label col-md-12 col-sm-12 col-xs-12">Prueba/Ensayo:</h5>
										<p>Detección de anticuerpos frente a Brucella abortus mediante la tecnica de elisa indirecta en leche fresca de bovino*</p>
										<h5 class="control-label col-md-12 col-sm-12 col-xs-12">Norma /referencia:</h5>
										<p>LVS-LIM-01 versión 02.(Basado en Guía Brucella abortus Antibody test kit /Bovine Milk) (validado) - 2020</p>
										<h5 class="control-label col-md-12 col-sm-12 col-xs-12">Recepción:</h5>
										<p>JUANA MARY TEJADA ALARCON</p>
									</div>						
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-2">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Forma de entrega Informe:</label>
												<p>PERSONAL</p>
											</div>
											<div class="col-md-2">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Plan de Muestreo:</label>
												<p>NO DECLARADO</p>
											</div>
											<div class="col-md-2">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Inf. oficial:</label>
												<p>SI</p>
											</div>
											<div class="col-md-2">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Observaciones:</label>
												<p>CONTRATO 2022</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)ESTADO</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<el-select v-model="form.status_test" class="w-100" dusk="matriz_id" filterable>
										<el-option v-for="option in status_test" :key="option.id" :label="option.nombre"  :value="option.id"></el-option>
									</el-select>
									<small class="form-control-feedback text-danger" v-if="errors.matriz_id" v-text="errors.matriz_id[0]"></small>
								</div>
							</div>
							<div class="col-lg-4">
							<div class="form-group" :class="{'has-danger': errors.comentario}">
								<label class="control-label">(*)OBSERVACION</label>
								<el-input v-model="form.comentario" type="textarea" autosize style="height: 50px !important"></el-input>								
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
				tableData:[
					{"id": "1", "item": "LECHE FRESCA DE BOVINO", "presentacion": "TUBO DE PLÁSTICO", "capacidad": "Aprox 10ML"}
				],
				status_test: [
                    {"id": "1", "nombre": "ACEPTADA"},
                    {"id": "2", "nombre": "RECHAZADA"},
                ],
				tableDataPruebas:[
                    {"id": "1", "prueba": "Detección de anticuerpos frente a Brucella abortus mediante la tecnica de elisa indirecta en leche fresca de bovino*", "matriz": "Cuerpos, tejidos y fluidos biologicos animales"},
                ],
				tableDataGrupo:[
                    {"id": "1", "grupo": "GRUPO", "muestra": "MUESTRA"}                   
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