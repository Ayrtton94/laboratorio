<template>
	<el-dialog :title="titleDialog" model-value="showDialogEvaluarOrder" class="mt-2" @close="closeModalResult" width="85%">			
		<div class="modal-body p-0">
			<form id="signupForm" autocomplete="off" @submit.prevent="submit">
				<div class="row">
					<div class="col-6">
						<div class="row">
							<div class="col-md-12">
								<el-descriptions title="Detalle de prueba" direction="vertical" :column="6" size="small" border>
									<el-descriptions-item label="F. recepcción" size="small">10/11/2022 - 12:40</el-descriptions-item>
									<el-descriptions-item label="Temperatura Cº:" size="small">5°</el-descriptions-item>
								</el-descriptions>
								<el-descriptions direction="vertical" :column="6" size="small" border>
									<el-descriptions-item label="F. Muestreo:" size="small">10/11/2022 - 12:40</el-descriptions-item>
									<el-descriptions-item label="Muestreado por:" size="small">CAROLINA TORRES FERNANDEZ RIVERA</el-descriptions-item>
								</el-descriptions>
								<el-descriptions direction="vertical" :column="6" size="small" border>
									<el-descriptions-item label="F. Entrega:" size="small">14/11/2022 - 12:40</el-descriptions-item>
									<el-descriptions-item label="Recepción:" size="small">JUANA MARY TEJADA ALARCON</el-descriptions-item>
								</el-descriptions>
								<hr class="mt-0 mb-2">
								<el-descriptions direction="vertical" :column="4" size="small" border>
									<el-descriptions-item label="Producto declarado:" size="small">LECHE FRESCA DE BOVINO</el-descriptions-item>
									<el-descriptions-item label="Presentación" size="small">TUBO DE PLÁSTICO</el-descriptions-item>
									<el-descriptions-item label="Capacidad" size="small">Aprox 10ML</el-descriptions-item>
								</el-descriptions>
								<hr class="mt-0 mb-2">
								<h5>Datos de la Prueba</h5>
								
								<el-descriptions direction="vertical" size="small" border >
									<el-descriptions-item label="Prueba/Ensayo:">
										Detección de anticuerpos frente a Brucella abortus mediante la tecnica de elisa indirecta en leche fresca de bovino*
									</el-descriptions-item>
								</el-descriptions>
								<el-descriptions direction="vertical" size="small" border>
									<el-descriptions-item label="Norma /referencia:">
										LVS-LIM-01 versión 02.(Basado en Guía Brucella abortus Antibody test kit /Bovine Milk) (validado) - 2020
									</el-descriptions-item>
								</el-descriptions>

								<el-descriptions direction="vertical" size="small" border>
									<el-descriptions-item label="Forma de entrega">Informe: PERSONAL</el-descriptions-item>
									<el-descriptions-item label="Informe:">NO DECLARADO</el-descriptions-item>
									<el-descriptions-item label="Inf. oficial:">SI</el-descriptions-item>
								</el-descriptions>
								<el-descriptions direction="vertical" size="small" border>
									<el-descriptions-item :span="3" label="Observaciones">CONTRATO 2022</el-descriptions-item>
								</el-descriptions>
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
										<tr>
											<td>
												<div class="form-check form-check-inline">
													<input type="checkbox" name="skill_check" class="form-check-input" id="checkInline1" checked="checked">
												</div>
											</td>
											<td>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
											01 - Ver
											</button>
											<!-- Modal -->
											<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
																<tr>
																	<td>Detección de anticuerpos frente a Brucella abortus mediante la tecnica de elisa indirecta en leche fresca de bovino* </td>
																	<td>Leche fresca de bovino</td>
																	<td>Cuerpos, tejidos y fluidos biologicos animales </td>
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
												<select class="form-select bg-white text-black" name="age_select" id="ageSelect">
													<option >----</option>
													<option >POSITIVO</option>
													<option selected="">NEGATIVO</option>
												</select>
											</td>
											<td><input class="form-control" type="" name="" value="AA221"></td>
											<td><input class="form-control" type="" name="" value="05/11/2022"></td>
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
				titleDialog: 'REGISTRAR RESULTADOS DEL LABORATORIO',
				resource: 'pruebas',
				tableData:[
					{"id": "1", "item": "LECHE FRESCA DE BOVINO", "presentacion": "TUBO DE PLÁSTICO", "capacidad": "Aprox 10ML"}
				],
				statustest: [
                    {"id": "1", "nombre": "Aceptada"},
                    {"id": "2", "nombre": "Rechazada"},
                ],
				tableDataPruebas:[
                    {"id": "1", "prueba": "Detección de anticuerpos frente a Brucella abortus mediante la tecnica de elisa indirecta en leche fresca de bovino*", "matriz": "Cuerpos, tejidos y fluidos biologicos animales"},
                ],
				tableDataGrupo:[
                    {"id": "1", "grupo": "GRUPO", "muestra": "MUESTRA"}                   
                ],
				form: {}
			}
		},
		created(){
			this.tables();
		},
		methods:{
			initForm(){
				this.form = {
					status_test: null,
					comentario: null
				}
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