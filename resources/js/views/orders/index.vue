<template>
    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">GESTIÓN DE ORDENES DE LABORATORIOS</h6>
                        <div class="dropdown">
<!--                            <button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">Nueva </button>-->
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
                                <th class="pt-0">Fecha Emisión</th>
                                <th class="pt-0">Hora</th>
                                <th class="pt-0">Usuario</th>
                                <th class="pt-0">Cliente</th>
                                <th class="pt-0">Número</th>
                                <th class="pt-0">Total</th>
                                <th class="pt-0">Nombre</th>
                                <th class="pt-0">Tipo</th>
                                <th class="pt-0">Estado</th>
                                <th class="pt-0">Observaciones</th>
                                <th class="pt-0">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.date_of_issue }}</td>
<!--                                <td>{{ row.muestra.description }}</td>-->
<!--                                <td>{{ row.name }}</td>-->
<!--                                <td>{{ row.price }}</td>-->
<!--                                <td>{{ row.laboratorio.name }}</td>-->
<!--                                <td>{{ row.metodo.name }}</td>-->
<!--                                <td>{{ row.condicion }}</td>-->
<!--                                <td>{{ row.time_entrega }}</td>-->
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
<!--    <order-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>-->
</template>
<script>
    import { deletable } from "../../mixins/deletable"
    import OrderModal from "../orders/invoice.vue"
export default {
    mixins: [deletable],
    // components: {
    //     OrderModal
    // },
    data(){
        return {
            resource: 'orders',
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
                establishment_id : null,
                warehouse_id :  null,
                document_type_id: null,
                series_id: null,
                series: null,
                number: '#',
                date_of_issue: moment().format('YYYY-MM-DD'),
                time_of_issue: moment().format('HH:mm:ss'),
                customer_id: null,
                currency_type_id: null,
                purchase_order: null,
                exchange_rate_sale: 0,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                operation_type_id: null,
                date_of_due: moment().format('YYYY-MM-DD'),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                type_document_fact : '03',
                informacion_adicional: "",
                actions: {
                    format_pdf: 'ticket',
                },
                equivalencia_id: '',
                quantity: 1,
                status_paid : 1,
                order_id : '',
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
