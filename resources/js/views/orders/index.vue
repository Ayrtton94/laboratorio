<template>
    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">GESTIÓN DE ORDENES DE LABORATORIOS</h6>
                        <div class="dropdown">
                            <a :href="`/${resource}/crear`" class="btn btn-success btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a>
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
								<th class="pt-0">Número</th>
                                <th class="pt-0">Fecha</th>
								<th class="pt-0">Cliente</th>
								<th class="pt-0">Tipo</th>
                                <th class="pt-0">Referencia</th>
								<th class="pt-0">Estado</th>
								<th class="pt-0">Estado Evaluación de Orden</th>
								<th class="pt-0">Total</th>
                                <th class="pt-0">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in records" :key="index">
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
											<a v-if="row.estado!=0" @click.prevent="evaluateOrder(row)" class="dropdown-item btn"><vue-feather type="archive" class="fs-vue-feather-14"></vue-feather> Evaluar Orden</a>		
											<a v-if="row.estado!=0" @click.prevent="modoPayment(row)" class="dropdown-item btn"> <vue-feather type="credit-card" class="fs-vue-feather-14"></vue-feather> Forma de Pago</a>
										</div>
									</div>
								</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <evaluar-order v-if="showDialogEvaluarOrder" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
   <payment v-if="showDialogPayment" :form="form" :errors="errors" @closeModalPayment="closeModalPayment" @saveAppt="saveAppt"/>
   <modal-options v-if="showDialogOptions" :recordId="recordId" @showClose="showClose" :showError="false"/>
</template>
<script>
    import { deletable } from "../../mixins/deletable"
	import EvaluarOrder from "../orders/partials/evaluar.vue"
	import Payment from "../orders/partials/payment.vue"
	import ModalOptions from "./partials/options.vue"

export default {
    mixins: [deletable],
    components: {
        EvaluarOrder, Payment, ModalOptions
    },
    data(){
        return {
            resource: 'orders',
            records: [],
            showDialog: false,
			showDialogEvaluarOrder :false,
			showDialogPayment: false,
			showDialogOptions: false,
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
        getData(){
            axios.get(`/${this.resource}/records`)
                .then(res => {
                    this.records = res.data.data
					// console.log(res);
                })
        },
        clickCreate(){
            this.showDialog = true;
        },
		evaluateOrder(info){
			this.showDialogEvaluarOrder = true;
            this.getDataMoal(info);
		},
		modoPayment(info){
			this.showDialogPayment = true;
            this.getDataMoalPayment(info);
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
            this.showDialogEvaluarOrder = false;
            this.initForm();
        },
		getDataMoalPayment(info){
            this.form.id = info.id
            this.form.status_paid = info.status_paid
        },
		closeModalPayment(){
            this.showDialogPayment = false;
            this.initForm();
        },
		showClose(){
			this.showDialogOptions = false;
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
		clickOptions(recordId = null) {
			this.recordId = recordId
			this.showDialogOptions = true
		}
    }
}
</script>
