<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE PROGRAMA BRUCELLAS</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nueva </button>
                    <el-button @click.prevent="clickImport()" type="success">
                      <vue-feather type="upload" class="fs-vue-feather-18"></vue-feather>
                      Importar
                    </el-button>
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
						<th class="pt-0">Code</th>
						<th class="pt-0"> Muestra</th>
						<th class="pt-0"> Ruta</th>
						<th class="pt-0"> Proveedor</th>
						<th class="pt-0"> Peso</th>
						<th class="pt-0"> Parcela</th>
                        <th class="pt-0"> V. Producción</th>
						<th class="pt-0"> Tiempo Hato</th>
					  	<th class="pt-0"> Accion</th>
                        <th class="pt-0"> Asignar Modulo</th>
                      	<th class="pt-0">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ index + 1 }}</td>
						<td>{{ row.code }}</td>
						<td>{{ row.muestra.description }}</td>
						<td>{{ row.ruta }}</td>
						<td>{{ row.supplier.name }}</td>
						<td>{{ row.peso }}</td>
						<td>{{ row.parcela }}</td>
						<td>{{ row.v_produccion }}</td>
                        <td>{{ row.t_hato }}</td>
						<td>
                            <div v-if="row.accion == 1">
                                <p>Accion</p>
                            </div>
                            <div v-if="row.accion == 2">
                                <p>Certificado</p>
                            </div>
                            <div v-if="row.accion == 3">
                                <p>Comprobante</p>
                            </div>
                            <div v-if="row.accion == 4">
                                <p>Certificado/Comprobante</p>
                            </div>
                            <div v-if="row.accion == 5">
                                <p>Ninguno</p>
                            </div>
                        </td>
						<td>
                            <div v-if="row.asignar_modulo == 1">
                                <p>de Modulo</p>
                            </div>
                            <div v-else>
                                <p>de Planta</p>
                            </div>
                        </td>
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
	<programa-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
    <program-brucella-import v-if="showImportDialog" @closeModalImport="closeModalImport"/>

</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import ProgramaModal from "../programabrucellas/form.vue"
    import ProgramBrucellaImport from './import.vue'
	export default {
		mixins: [deletable],
		components: {
            ProgramaModal, ProgramBrucellaImport
		},
		data(){
			return {
				resource: 'programabrucellas',
				records: [],
				showDialog: false,
				form: {},
				errors: {},
                showImportDialog: false,
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
                    muestra_id:null,
                    ruta: null,
                    supplier_id: null,
					peso: null,
                    parcela: null,
                    v_produccion: null,
                    t_hato: null,
                    accion: null,
					status_paid: 1,
					code: null,
                    asignar_modulo: null
				},
				this.errors = {}
			},
			getData(){
				axios.get(`/${this.resource}/records`)
				.then(res => {
					this.records = res.data.program
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
				this.form.muestra_id = info.muestra_id
				this.form.ruta = info.ruta
				this.form.supplier_id = info.supplier_id
				this.form.peso = info.peso
				this.form.parcela = info.parcela
                this.form.v_produccion = info.v_produccion
				this.form.t_hato = info.t_hato
				this.form.status_paid = info.status_paid
				this.form.code = info.code
				this.form.accion = info.accion
				this.form.asignar_modulo = info.asignar_modulo
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
            clickImport() {
                this.showImportDialog = true
            },
            closeModalImport(){
                this.showImportDialog = false;
            },
		}
    }
</script>
<style>
thead, tbody, tfoot, tr, td, th {
    border-width: thin !important;
}
</style>
