<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE ESPECIES</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nueva Especie</button>
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
                      <th class="pt-0">Nombre Especie</th>
                      <th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ index + 1 }}</td>
						<td>{{ row.description }}</td>
						<td>
							<a class="btn text-danger" @click="Delete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
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
            </div> 
          </div>
        </div>
    </div>
	<especie-modal v-if="showDialog" :form="form" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
	import EspecieModal from "../especies/form.vue"
	export default {
		components: {
			EspecieModal
		},
		data(){
			return {
				resource: 'especies',
				records: [],
				showDialog: false,
				form: {}
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
					description: ''
				}
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.especies
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
				})
			},
			Delete(id){
				this.$swal.fire({
					title: '¿Eliminar registro?',
					text: "Eliminando Perfil Seleccionado!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Si!',
					cancelButtonText: 'No!',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post(`/${this.resource}/eliminar/${id}`)
						.then(res => {
							if(res.status) {
								this.$swal({
									icon: 'success',
									title: res.data.message,
									showConfirmButton: false,
									timer: 1500
								})					
								this.emitter.emit('reloadData');
							}
						})
					}				
				})
			}
		}
    }
</script>