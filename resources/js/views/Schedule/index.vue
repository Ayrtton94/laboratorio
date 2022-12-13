<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE HORARIOS</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nuevo Horario</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"></div>
              </div>  
              <div class="table-responsive">
              	<table class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
						<th class="pt-0">#</th>
						<th class="pt-0">Nombre</th>
						<th class="pt-0">Hora Ingreso</th>
						<th class="pt-0">Hora Salida</th>
						<th class="pt-0">Registro</th>
						<th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ row.id }}</td>
						<td>{{ row.description }}</td>
						<td>{{ row.hour_start }}</td>
						<td>{{ row.hour_end }}</td>
						<td>{{ (row.created_at).split('T')[0] }}</td>
						<td>
							<a v-if="row.status!=0" class="btn text-danger" @click="clickDelete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
									<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
								</a>
								<a v-if="row.status!=0" @click.prevent="clickUpdate(row)" class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
									<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
								</a>
								<a class="btn text-success" v-if="row.status==0" @click="clickRestore(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restaurar" aria-label="Restaurar">
									<vue-feather type="rotate-cw" class="fs-vue-feather-18"></vue-feather>
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
	<schedule-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import ScheduleModal from "../Schedule/form.vue"
	export default {
		mixins: [deletable],
		components: {
			ScheduleModal
		},
		data(){
			return {
				resource: 'schedule',
				records: [],
				showDialog: false,
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
					id: '',
					description: '',
					hour_start : '',
					hour_end: ''
				},
				this.errors = {}
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.schedules
				})
			},
			clickCreate(){
				this.showDialog = true;
			},
			clickUpdate(info){
				this.showDialog = true;
				this.getDataMoal(info);
			},
			getDataMoal(info){
				this.form.id = info.id
				this.form.description = info.description,
				this.form.hour_start = info.hour_start
				this.form.hour_end = info.hour_end
			},
			closeModal(){
				this.showDialog = false;
				this.initForm();
			},
			saveAppt(form){
				axios.post(`/${this.resource}`, form)
				.then(res => {
					if(res.status == 200) {
						this.$swal({
							icon: 'success',
							title: res.data.message,
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData');
						this.closeModal();
					}
				}).catch(error=> {
					if(error.response.status === 422){
						this.errors = error.response.data.errors
					}else{
						console.log(error);
					}
				})
			},
			clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`)
				.then(() =>
                    this.emitter.emit('reloadData')
                )
			},
			clickRestore(id) {
                this.restore(`/${this.resource}/restore/${id}`).then(() =>
					this.emitter.emit('reloadData')
                )
            }
		}
    }
</script>