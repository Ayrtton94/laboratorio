<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4">
                	<h6 class="card-title mb-0">GESTIÓN DE ASISTENCIAS</h6>
                  	<div class="dropdown">
						<el-button @click.prevent="clikImport()" type="success">
							<vue-feather type="upload" class="fs-vue-feather-18"></vue-feather>
							Importar
						</el-button>
                	</div>
              	</div>
              <div class="table-responsive">
              	<table class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
					<th class="pt-0">#</th>
						<th class="pt-0">Nombre</th>
						<th class="pt-0">Fecha</th>
						<th class="pt-0">H. Asistidas</th>
						<th class="pt-0">H. No Asistidas</th>
						<th class="pt-0">Retardos (MIN)</th>
						<th class="pt-0">Salidas Tempranas (MIN)</th>
						<th class="pt-0">H. Extras</th>
						<th class="pt-0">H. Justificadas C/G</th>
						<th class="pt-0">H. Justificadas S/G</th>
						<th class="pt-0">H. Compensadas</th>
						<th class="pt-0"></th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ row.id }}</td>
						<td>{{ row.name_staff }}</td>
						<td>{{ row.date_of_issue }}</td>
						<td>{{ row.hours_attended }}</td>
						<td>Aleatorio</td>
						<td>{{ row.delays_min }}</td>
						<td>{{ row.ouput_min }}</td>
						<td>{{ row.extra_hours }}</td>
						<td>
							<el-input v-model="row.justification_hours_cg" placeholder=""/>
						</td>
						<td>
							<el-input v-model="row.justification_hours_sg" placeholder=""/>
						</td>
						<td>
							<el-input v-model="row.comp_hours" placeholder=""/>
						</td>
						<td>
							<a @click.prevent="clickUpdate(row)" class="btn btn-sm btn-success text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Actualizar" aria-label="Actualizar">
								<vue-feather type="refresh-ccw" class="fs-vue-feather-18"></vue-feather>
							</a>
						</td>
					</tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
	<attendance-import v-if="showImportDialog" @closeModal="closeModal"/>
</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import AttendanceImport from "../Attendance/import.vue"
	export default {
		mixins: [deletable],
		components: {
			AttendanceImport
		},
		data(){
			return {
				resource: 'attendance',
				records: [],
				showImportDialog: false,
				form: {},
				errors: {}
			}
		},
        created() {
            this.emitter.on('reloadData', () => {
				this.getData();
			});
			this.getData();
        },
		methods: {
			initForm(){
				this.form = {
					justification_hours_cg: null,
					justification_hours_sg: null,
					comp_hours: null
				}
			},
			clikImport(){
				this.showImportDialog = true;
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.data
				})
			},
			clickCreate(){
				
			},
			clickUpdate(form){
				let formUpdate = {
					id: form.id,
					justification_hours_cg: form.justification_hours_cg,
					justification_hours_sg: form.justification_hours_sg,
					comp_hours: form.comp_hours
				}
				axios.put(`/${this.resource}/update`, formUpdate)
				.then((response) => {
					if(response.status == 200){
						this.$message.success('Datos Actualizados');
						this.form = {};
						this.emitter.emit('reloadData');
					}
				}).catch(error=> {
					console.log(error);
				})
			},
			closeModal(){
				this.showImportDialog = false;
			}
		}
    }
</script>
<style>
	thead, tbody, tfoot, tr, td, th {
    	border-width: thin !important;
	}
</style>