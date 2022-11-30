<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE AREAS</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nueva Area</button>
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
					  <th class="pt-0">Descripción</th>
					  <th class="pt-0">Registro</th>
                      <th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records.data" :key="index">
						<td>{{ row.id }}</td>
						<td>{{ row.name }}</td>
						<td>{{ row.description }}</td>
						<td>{{ (row.created_at).split('T')[0] }}</td>
						<td>
							<a class="btn text-danger" @click="clickDelete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
								<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
							</a>
							<a @click.prevent="clickUpdate(row)" class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
								<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
							</a>
						</td>
					</tr>
                  </tbody>
                </table>
              </div>
			  <Pagination class="my-2" :data="records" @pagination-change-page="getAreas" />
            </div> 
          </div>
        </div>
    </div>
	<area-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import AreaModal from "../Area/form.vue"
	import LaravelVuePagination from 'laravel-vue-pagination'
	export default {
		mixins: [deletable],
		components: {
			AreaModal,
			'Pagination': LaravelVuePagination
		},
		data(){
			return {
				resource: 'areas',
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
					name : '',
					description: ''
				},
				this.errors = {}
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.areas
				})
			},
			getAreas(page = 1){
				axios.get(`/${this.resource}/records?page=` + page)
				.then(response =>{
					if (response.status === 200) {
						this.records = response.data.areas
					}
				})
				.catch(error => console.log(error))
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
				this.form.name = info.name
				this.form.description = info.description
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
		}
    }
</script>