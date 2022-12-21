<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE PRUEBAS</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nueva </button>
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
						<th class="pt-0"> Matriz</th>
						<th class="pt-0"> Muestra</th>
						<th class="pt-0"> Nombre</th>
						<th class="pt-0"> Precio</th>
						<th class="pt-0"> Laboratorio</th>
						<th class="pt-0"> Metodo</th>
					  	<th class="pt-0"> Condicion</th>
						<th class="pt-0"> Tiempo Entrega</th>
                      	<th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ index + 1 }}</td>
						<td>{{ row.matriz.description }}</td>
						<td>{{ row.muestra.description }}</td>
						<td>{{ row.name }}</td>
						<td>{{ row.price }}</td>
						<td>{{ row.laboratorio.name }}</td>
						<td>{{ row.metodo.name }}</td>
						<td>{{ row.condicion }}</td>
						<td>{{ row.time_entrega }}</td>
						<td>
							<a v-if="row.estado!=0" class="btn text-danger" @click="clickDelete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
								<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
							</a>
							<a v-if="row.estado!=0" @click.prevent="clickUpdate(row)" class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
								<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
							</a>	
							<a class="btn text-success" v-if="row.estado==0" @click="clickRestore(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restaurar" aria-label="Restaurar">
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
	<prueba-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import PruebaModal from "../pruebas/form.vue"
	export default {
		mixins: [deletable],
		components: {
			PruebaModal
		},
		data(){
			return {
				resource: 'pruebas',
				records: [],
				showDialog: false,
				form: {},
				errors: {},
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
					matriz_id:null,
					muestra_id: null,
					name: null,
					price: null,
					laboratorio_id: null,
					metodo_id: null,
					condicion: null,
					time_entrega: null
				},
				this.errors = {}
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.pruebas
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
				this.form.matriz_id = info.matriz_id
				this.form.muestra_id = info.muestra_id
				this.form.name = info.name
				this.form.price = info.price
				this.form.laboratorio_id = info.laboratorio_id
				this.form.metodo_id = info.metodo_id
				this.form.condicion = info.condicion
				this.form.time_entrega = info.time_entrega
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
                this.destroy(`/${this.resource}/${id}`).then(() =>
				this.emitter.emit('reloadData')
                )
            },
			clickRestore(id) {
                this.restore(`/${this.resource}/restore/${id}`).then(() =>
					this.emitter.emit('reloadData')
                )
            },
		}
    }
</script>