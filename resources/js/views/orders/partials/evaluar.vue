<template>
	<el-dialog :title="titleDialog" model-value="showDialogEvaluarOrder" class="mt-2" @close="closeModal" width="85%">			
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
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Estado</label>
									<el-select v-model="form.status_test" class="w-100" filterable>
										<el-option v-for="option in statustest" :key="option.id" :label="option.nombre"  :value="option.id"></el-option>
									</el-select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">(*)Observación</label>
									<el-input v-model="form.comentario" type="textarea" autosize style="height: 70px !important"></el-input>								
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row">
							<div class="table-responsive">
								<h5># Cant Muestras</h5>
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
								<h5>Lista de pruebas</h5>
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
						<div class="modal-footer">
							<button @click.prevent="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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
				titleDialog: 'EVALUACIÓN DE ORDEN DE LABORATORIO',
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

<style>
.el-dialog__body {
    padding-top: 0 !important;
	padding: 1.5rem !important;
}
</style>