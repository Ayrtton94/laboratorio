<template>
	<el-dialog :title="titleDialog" model-value="showDialogEvaluarOrder" class="mt-2" @close="closeModalResult" width="85%">			
		<div class="modal-body p-0">
			<form id="signupForm" autocomplete="off" @submit.prevent="submit">
				<div class="row">
					<div class="col-6">
						<div class="row">
							<div class="col-md-12">
								<el-descriptions title="Detalle de Orden" direction="vertical" :column="6" size="small" border>
									<el-descriptions-item label="F. recepcción" size="small">{{  pruebas.date_of_recepcion }}</el-descriptions-item>
									<el-descriptions-item label="Número de orden" size="small">{{ pruebas.number }}</el-descriptions-item>
								</el-descriptions>
								<div v-for="(row, index) in datodetalles" :key="index">
										<hr class="mt-0 mb-2">
									<el-descriptions title="Detalle de prueba" direction="vertical" :column="6" size="small" border>
										<el-descriptions-item label="F. recepcción" size="small">{{  row.date_of_recepcion }}</el-descriptions-item>
										<el-descriptions-item label="Temperatura Cº:" size="small">{{ row.temperatura }}</el-descriptions-item>
									</el-descriptions>
									<el-descriptions direction="vertical" :column="6" size="small" border>
										<el-descriptions-item label="F. Muestreo:" size="small">{{ row.date_of_muestra }}</el-descriptions-item>
										<el-descriptions-item label="Muestreado por:" size="small"></el-descriptions-item>
									</el-descriptions>
									<el-descriptions direction="vertical" :column="6" size="small" border>
										<el-descriptions-item label="F. Entrega:" size="small">{{ row.date_of_resultado }}</el-descriptions-item>
										<el-descriptions-item label="Recepción:" size="small">{{ pruebas.responsable_id }}</el-descriptions-item>
									</el-descriptions>
									<hr class="mt-0 mb-2">
									<el-descriptions direction="vertical" :column="4" size="small" border>
										<el-descriptions-item label="Producto declarado:" size="small">{{ row.muestar }}</el-descriptions-item>
										<el-descriptions-item label="Presentación" size="small">{{ row.matriz }}</el-descriptions-item>
										<el-descriptions-item label="Capacidad" size="small">{{ row.quantity }}</el-descriptions-item>
									</el-descriptions>
									<hr class="mt-0 mb-2">
									<h5>Datos de la Prueba</h5>
									
									<el-descriptions direction="vertical" size="small" border >
										<el-descriptions-item label="Prueba/Ensayo:">
											{{ row.prueba }}
										</el-descriptions-item>
									</el-descriptions>
									<el-descriptions direction="vertical" size="small" border>
										<el-descriptions-item label="Norma /referencia:">
											{{ pruebas.referencia }}
										</el-descriptions-item>
									</el-descriptions>

									<el-descriptions direction="vertical" size="small" border>
										<el-descriptions-item label="Forma de entrega">Informe: PERSONAL</el-descriptions-item>
										<el-descriptions-item label="Informe:">NO DECLARADO</el-descriptions-item>
										<el-descriptions-item label="Inf. oficial:">SI</el-descriptions-item>
									</el-descriptions>
									<el-descriptions direction="vertical" size="small" border>
										<el-descriptions-item :span="3" label="Observaciones">{{ row.observacion }}</el-descriptions-item>
									</el-descriptions>
								</div>								
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row">
							<div class="table-responsive bg-white text-black">
								<table class="table  bg-white text-black ">
									<thead>
									<tr>
										<th></th>
										<th>Muestra</th>
										<th>Resultado</th>
										<th>Lote Num</th>
										<th>F. Vencimiento</th>
									</tr>
									</thead>
									<tbody>
										<tr v-for="(row, index) in detalles" :key="index">
											<td>
												<div class="form-check form-check-inline">
													<input type="radio" name="skill_check" class="form-check-input" id="checkInline1" @click="getmostrar(row.id)">
												</div>
											</td>
											<td>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" :data-bs-target="'#exampleModal-' + row.id" @click="getPrueba(row.id)">
												{{ index + 1 }} - Ver
											</button>
											<!-- Modal -->
											<div class="modal fade" :id="'exampleModal-' + row.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content bg-white text-black">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Detalle de Prueba</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
													</div>
												<div class="modal-body">
													
													<div class="table-responsive bg-white text-black">
														<table class="table  bg-white text-black ">
															<thead>
																<th>Prueba</th>
																<th>Muestra</th>
																<th>Matriz</th>
															</thead>
															<tbody>
																<tr v-for="(row, index) in depruebas" :key="index">
																	<td>{{ row.prueba }}</td>
																	<td>{{ row.muestar }}</td>
																	<td>{{ row.matriz }}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											</div>
											</div>
											</td>
											<td>
											<select class="form-select bg-white text-black" v-model="form.age_select[index]">
												<option>----</option>
												<option>POSITIVO</option>
												<option>NEGATIVO</option>
											</select>
										</td>
										<td><input class="form-control" type="" v-model="form.lote[index]"></td>
										<td><input class="form-control" type="date" v-model="form.datef[index]"></td>

										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button @click.prevent="closeModalResult" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-sm btn-success">
								<span>Registrar</span>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</el-dialog>
</template>

<script>
	export default {
		props: ['showDialogEvaluarOrder', 'recordId'],
		data(){
			return {
				resource: 'pruebas',
				pruebas: [],
				detalles: [],
				datodetalles: [],
				depruebas: [],
				idre:{
					id:[]
				},
				form: {
						age_select: [],
						lote: [],
						datef: []
				},
				
			}
		},
		created(){
			this.tables();
			this.getData();
			this.getDetalle();
			this.getPrueba();
			this.getmostrar();
		},
		methods:{
			submit() {
				for (let i = 0; i < this.form.age_select.length; i++) {
				const data = {
					age_select: this.form.age_select[i],
					lote: this.form.lote[i],
					datef: this.form.datef[i]
				};
					axios.post(`/orders/resultado_order/${this.detalles[i].id}`, data)
					.then(response => {
						this.$swal({
							icon: 'success',
							title: response.data.message,
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData')
						this.closeModalResult();
					});
				}
			},

			getData(){
				axios.get(`/orders/evaluacion/${this.recordId}`)
				.then(response => {
					this.pruebas = response.data;
					console.log(this.pruebas)
				})

			},
			getDetalle(){
				axios.get(`/orders/detalle/${this.recordId}`)
				.then(response => {
					this.detalles = response.data;
					console.log(this.detalles)
				})

			},
			getPrueba(row) {
				axios.get(`/orders/list_prueba/${row}`)
					.then(response => {
						this.depruebas = response.data;
						console.log(this.depruebas);
						// Aquí puedes realizar las operaciones adicionales que necesites con los datos obtenidos
					})
					.catch(error => {
						console.error(error);
					});
			},

			getmostrar(row) {
				axios.get(`/orders/dato_detalle/${row}`)
					.then(response => {
						this.datodetalles = response.data;
						console.log(this.datodetalles);
						// Aquí puedes realizar las operaciones adicionales que necesites con los datos obtenidos
					})
					.catch(error => {
						console.error(error);
					});
			},
			
			closeModalResult(){
				this.$emit('closeModalResult');
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

<style>
.el-dialog__body {
    padding-top: 0 !important;
	padding: 1.5rem !important;
}
</style>