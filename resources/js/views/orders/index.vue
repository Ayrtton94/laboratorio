<template>
    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-10">
                        <h6 class="card-title mb-0">GESTIÓN DE ORDENES DE LABORATORIOS</h6>
                        <div class="dropdown">
                            <a :href="`/${resource}/crear`" class="btn btn-success btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-30"></div>
                    </div>
                    <div class="table-responsive">
                        <data-table :resource="resource">
							<template v-slot:heading>
                                <th class="pt-0">#</th>
								<th class="pt-0">Número</th>
                                <th class="pt-0">Fecha</th>
								<th class="pt-0">Cliente</th>
								<th class="pt-0">Tipo</th>
                                <th class="pt-0">Referencia</th>
								<th class="pt-0">Estado</th>
								<th class="pt-0">Estado Evaluación de Orden</th>
								<th class="pt-0">Total</th>
                                <th class="pt-0">Acciones</th>
                            </template>
                            <template v-slot:tbody="{ index, row }">
								<tr>
									<td>{{ index + 1 }}</td>
									<td>{{ row.number }}</td>
									<td>{{ row.date_of_issue }}</td>
									<td>{{ row.customer_number }} - {{ row.customer_name }}</td>
									<td>{{ row.tipo_orden }}</td>
									<td>{{ row.referencia }}</td>
									<td>
										<span v-if="row.status_paid==1" class="badge bg-success">Pagado</span>
										<span v-else class="badge bg-warning">Pendiente</span>
									</td>
									<td>
										<span v-if="row.status_order==1" class="badge bg-success">Revisada</span>
										<span v-else-if="row.status_order==2" class="badge bg-warning">Recibida</span>
										<span v-else class="badge bg-danger">Pendiente</span>
									</td>
									<td>{{ row.total }}</td>
									<td class="text-right">
										<div class="btn-group" role="group">
											<button id="btnGroupDrop2" type="button" class="btn btn-sm  btn-success dropdown-toggle dropdown-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Opciones
											</button>
											<div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
											
												<a v-if="row.estado!=0" :href="`/${resource}/editar/${row.id}`" class="dropdown-item btn"> <vue-feather type="edit" class="fs-vue-feather-14"></vue-feather> Editar</a>
												<a class="dropdown-item btn" :href="`/${resource}/imprimir/${row.id}/a4`" target="_blank"> <vue-feather type="printer" class="fs-vue-feather-14"></vue-feather> Imprimir</a>
												<a v-if="row.estado!=0" @click="clickDelete(row.id)" class="dropdown-item btn"> <vue-feather type="delete" class="fs-vue-feather-14"></vue-feather> Eliminar</a>
												<a class="dropdown-item btn" v-if="row.estado==0" @click="clickRestore(row.id)"><vue-feather type="rotate-cw" class="fs-vue-feather-14"></vue-feather></a>
												<a v-if="row.estado!=0" @click.prevent="evaluateOrder(row.id)" class="dropdown-item btn"><vue-feather type="archive" class="fs-vue-feather-14"></vue-feather> Evaluar Orden</a>
												<a v-if="row.estado!=0" @click.prevent="registrarResultOrder(row)" class="dropdown-item btn"><vue-feather type="archive" class="fs-vue-feather-14"></vue-feather> + Resultados</a>		
												<a v-if="row.estado!=0" @click.prevent="modoPayment(row.id)" class="dropdown-item btn"> <vue-feather type="credit-card" class="fs-vue-feather-14"></vue-feather> Forma de Pago</a>
											</div>
										</div>
									</td>
								</tr>
                            </template>
                        </data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <evaluar-order v-if="showDialogEvaluarOrder" @closeModal="closeModal"/>
   <payment v-if="showDialogPayment" :recordId="recordId" @closeModalPayment="closeModalPayment"/>
   <modal-options v-if="showDialogOptions" :recordId="recordId" @showClose="showClose" :showError="false"/>
   <registrar-order v-if="showDialogRegistrarResult" :recordId="recordId" @closeModalResult="closeModalResult" :showError="false"/>
</template>
<script>
    import { deletable } from "../../mixins/deletable"
	import DataTable from '../../components/DataTableOrder'
	import EvaluarOrder from "../orders/partials/evaluar.vue"
	import RegistrarOrder from "../orders/partials/registrar.vue"
	import Payment from "../orders/partials/payment.vue"
	import ModalOptions from "./partials/options.vue"

export default {
    mixins: [deletable],
    components: {
		DataTable,
        EvaluarOrder, Payment, ModalOptions, RegistrarOrder
    },
    data(){
        return {
            resource: 'orders',
            records: [],
            showDialog: false,
			showDialogEvaluarOrder :false,
			showDialogRegistrarResult: false,
			showDialogPayment: false,
			showDialogOptions: false,
            form: {},
            errors: {},
        }
    },
    created() {
    },
    methods: {
        clickCreate(){
            this.showDialog = true;
        },
		evaluateOrder(recordId = null){
			this.recordId = recordId;
			this.showDialogEvaluarOrder = true;
		},
		registrarResultOrder(recordId = null){
			this.recordId = recordId
			this.showDialogRegistrarResult = true
		},
		modoPayment(recordId = null){
			this.recordId = recordId
			this.showDialogPayment = true;
		},
        closeModal(){
            this.showDialogEvaluarOrder = false;
        },
		closeModalPayment(){
            this.showDialogPayment = false;
        },
		showClose(){
			this.showDialogOptions = false;
		},
		closeModalResult(){
			this.showDialogRegistrarResult = false;
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
		clickOptions(recordId = null) {
			this.recordId = recordId
			this.showDialogOptions = true
		}
    }
}
</script>
