<template>
	<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
		<div>
			<h4 class="mb-3 mb-md-0">Bienvenido {{ this.user_name }}!</h4>
		</div>
		<div class="d-flex align-items-center flex-wrap text-nowrap">
			<div class="input-group date datepicker wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
				<span class="input-group-text input-group-addon bg-transparent border-primary">
					<vue-feather type="calendar" class="fs-vue-feather-18 text-primary"></vue-feather>
				</span>
				<input type="date" class="form-control border-primary bg-transparent text-white"/>
			</div>
		</div>
	</div>
    <div class="row">
		<div class="col-12 col-xl-12 stretch-card">
		<div class="row flex-grow-1">
			<div class="col-md-3 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
					<h6 class="card-title mb-3">SERVICIOS DE LABORATORIO</h6>
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
					<h5 class="mb-2">3,897</h5>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>+3.3%</span>
						<vue-feather type="arrow-up" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather>
						</p>
					</div>
					</div>
					<div class="col-6 col-md-12 col-xl-7">
					<div id="customersChart" class="mt-md-3 mt-xl-0"></div>
					</div>
				</div>
				</div>
			</div>
			</div>
			<div class="col-md-3 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
					<h6 class="card-title mb-3">MUESTREOS DEL AÑO</h6>
					
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
					<h5 class="mb-2">35,084</h5>
					<div class="d-flex align-items-baseline">
						<p class="text-danger">
						<span>-2.8%</span>
						<vue-feather type="arrow-down" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather>
						</p>
					</div>
					</div>
					<div class="col-6 col-md-12 col-xl-7">
					<div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
					</div>
				</div>
				</div>
			</div>
			</div>
			<div class="col-md-3 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
					<h6 class="card-title mb-3">PROGRAMA DE BRUCELLAS</h6>
					
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
					<h5 class="mb-2">89.87%</h5>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>+2.8%</span>
						<vue-feather type="arrow-up" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather>
						</p>
					</div>
					</div>
					<div class="col-6 col-md-12 col-xl-7">
					<div id="growthChart" class="mt-md-3 mt-xl-0"></div>
					</div>
				</div>
				</div>
			</div>
			</div>
			<div class="col-md-3 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
					<h6 class="card-title mb-3">VENTAS TOTALES</h6>
					
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
					<h5 class="mb-2">S/.825 600</h5>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>+2.8%</span>
						<vue-feather type="arrow-up" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather>
						</p>
					</div>
					</div>
					<div class="col-6 col-md-12 col-xl-7">
					<div id="ventaspormes" class="mt-md-3 mt-xl-0"></div>
					</div>
				</div>
				</div>
			</div>
			</div>
		</div>
		</div>
    </div>
	<div class="row">
		<div class="col-lg-12 col-xl-12 stretch-card">
			<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4">
				<h6 class="card-title mb-0">Últimas órdenes Programa Brucella</h6>
				<div class="dropdown">
					<a href="menu_brucellas.php">
					VER TODOS
					</a>
				
				</div>
				</div>


				<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead>
					<tr>
						<th class="pt-0">#</th>
						<th class="pt-0">Referencia</th>
						<th class="pt-0">Fecha de Muestreo</th>
						<th class="pt-0">Cant. Muestras</th>
						<th class="pt-0">Cliente</th>
						<th class="pt-0">Ubicación</th>
						<th class="pt-0">Status</th>
						<th class="pt-0"></th>
					
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>1</td>
						<td>B155/3</td>
						<td>01/01/2022</td>
						<td>71</td>
						<td>LECHE GLORIA S.A</td>
						<td>PLANTA APLAOICAR CHUQUBAMBA KM1</td>
						<td><span class="badge bg-info">Pendiente</span></td>
					<td  data-bs-toggle="collapse" href="#id1" role="button" aria-expanded="false" aria-controls="collapseExample">
						<vue-feather type="eye" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather>
					</td>
					</tr>
					<tr class="collapse" id="id1">
						<td colspan="8" >
							<div class="card card-body">
						
							<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
								<option selected>Muestra | Proveedores</option>
								<option value="1">01  | 14 </option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								</select>


						</div>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td>B155/3</td>
						<td>01/01/2022</td>
						<td>71</td>
						<td>LECHE GLORIA S.A</td>
						<td>PLANTA APLAOICAR CHUQUBAMBA KM1</td>
						<td><span class="badge bg-success">Aprobado</span></td>
						<td  data-bs-toggle="collapse" href="#id2" role="button" aria-expanded="false" aria-controls="collapseExample"><vue-feather type="eye" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather></td>
						

					</tr>
					<tr class="collapse" id="id2">
						<td colspan="8" >
							<div class="card card-body">
						contenido 2
						</div>
						</td>
					
					</tr>
					<tr>
						<td>3</td>
						<td>B155/3</td>
						<td>01/01/2022</td>
						<td>71</td>
						<td>LECHE GLORIA S.A</td>
						<td>PLANTA APLAOICAR CHUQUBAMBA KM1</td>
						<td><span class="badge bg-danger">Observado</span></td>
						<td><vue-feather type="eye" class="icon-sm mb-1 fs-vue-feather-14"></vue-feather></td>
					</tr>
					</tbody>
				</table>
				</div>
			</div> 
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		props: ['user_auth'],
		data(){
			return {
				resource: 'home',
				records: [],
				showDialog: false,
				form: {},
				errors: {},
				user_name: this.user_auth.name
			}
		},
        created() {
        },
		methods: {
			
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.areas
				})
			}
		}
    }
</script>
