<template>
    <div class="container-fluid m-0 pb-0 mt-1">
        <div class="card mb-0 w-100">
			<div class="page-header d-flex bd-highlight">
				<div class="ml-4 mt-2 p-2 flex-grow-1">
					<h4 >Nueva Orden de Laboratorio</h4>
				</div>
			</div>
			<hr class="mt-0 mb-0">
            <div class="card-body">
                <form autocomplete="off" @submit.prevent="submit">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.num_orden}">
                                <label class="control-label">Número de Orden</label>
                                <el-input v-model="form.num_orden"></el-input>
                                <small class="form-control-feedback" v-if="errors.num_orden" v-text="errors.num_orden[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                <label class="control-label">Fecha de Emisión</label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.tporden_id}">
                                <label class="control-label">(*)Tipo de Orden:</label>
                                <el-select v-model="form.tporden_id">
                                    <el-option v-for="option in typeordenes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.tporden_id" v-text="errors.tporden_id[0]"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
						<customer-search :showLabel="true" v-model:customer_id="form.customer_id" class="col-xs-12 col-sm-3 col-md-3"
						:customersList="customers" :errors="errors" ></customer-search>
						<div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group" :class="{'has-danger': errors.responsable_id}">
                                <label class="control-label">(*)Responsable</label>
                                <el-select v-model="form.responsable_id">
                                    <el-option v-for="option in staffs" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.responsable_id" v-text="errors.responsable_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group" :class="{'has-danger': errors.referencia}">
                                <label class="control-label">(*)Referencia</label>
                                <el-input v-model="form.referencia"></el-input>
                                <small class="form-control-feedback" v-if="errors.referencia" v-text="errors.referencia[0]"></small>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <h4>Pruebas</h4>
                        <br>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.quantity}">
                                <label class="control-label">(*)Cantidad</label>
                                <el-input v-model="form.quantity"></el-input>
                                <small class="form-control-feedback" v-if="errors.quantity" v-text="errors.quantity[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.matriz_id}">
                                <label class="control-label">(*)Matriz</label>
                                <el-select v-model="form.matriz_id">
                                    <el-option v-for="option in matrices" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.matriz_id" v-text="errors.matriz_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.muestra_id}">
                                <label class="control-label">(*)Muestra</label>
                                <el-select v-model="form.muestra_id">
                                    <el-option v-for="option in this.matrizFilter" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.muestra_id" v-text="errors.muestra_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.prueba_id}">
                                <label class="control-label">(*)Prueba</label>
                                <el-select v-model="form.prueba_id">
                                    <el-option v-for="option in pruebas" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.prueba_id" v-text="errors.prueba_id[0]"></small>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.especie_id}">
                                <label class="control-label">Especie</label>
                                <el-select v-model="form.especie_id">
                                    <el-option v-for="option in especies" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.especie_id" v-text="errors.especie_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.subespecie_id}">
                                <label class="control-label">Sub-Especie</label>
                                <el-select v-model="form.subespecie_id">
                                    <el-option v-for="option in this.subespecieFilter" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.subespecie_id" v-text="errors.subespecie_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.presentacion_id}">
                                <label class="control-label">(*)Presentación</label>
                                <el-select v-model="form.presentacion_id">
                                    <el-option v-for="option in presentaciones" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.presentacion_id" v-text="errors.presentacion_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.observacion}">
                                <label class="control-label">Observación</label>
                                <el-input v-model="form.observacion"></el-input>
                                <small class="form-control-feedback" v-if="errors.observacion" v-text="errors.observacion[0]"></small>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_muestra}">
                                <label class="control-label">(*)Fecha de Muestra</label>
                                <el-date-picker v-model="form.date_of_muestra" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_muestra" v-text="errors.date_of_muestra[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_recepcion}">
                                <label class="control-label">(*)Fecha de Recepción</label>
                                <el-date-picker v-model="form.date_of_recepcion" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_recepcion" v-text="errors.date_of_recepcion[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_result}">
                                <label class="control-label">(*)Fecha de Resultados</label>
                                <el-date-picker v-model="form.date_of_result" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_result" v-text="errors.date_of_result[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.temperatura}">
                                <label class="control-label">Temperatura</label>
                                <el-input v-model="form.temperatura"></el-input>
                                <small class="form-control-feedback" v-if="errors.temperatura" v-text="errors.temperatura[0]"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center font-weight-bold">MUESTRA</th>
                                            <th class="text-center font-weight-bold">ENSAYO</th>
                                            <th class="text-center font-weight-bold">ESPECIE</th>
                                            <th class="text-center font-weight-bold">OBSERVACIÓN</th>
                                            <th class="text-center font-weight-bold">PRESENTACIÓN</th>
                                            <th class="text-center font-weight-bold">LAB</th>
                                            <th class="text-center font-weight-bold">CANTIDAD</th>
                                            <th class="text-center font-weight-bold">PRECIO UNITARIO</th>
                                            <th class="text-center font-weight-bold">PRECIO TOTAL</th>
                                            <th class="text-center font-weight-bold">TIEMPO ENTREGA</th>
                                            <th class="text-center font-weight-bold">CONDICIÓN</th>
                                            <th class="text-center font-weight-bold">FECHA MUESTRA</th>
                                            <th class="text-center font-weight-bold">FECHA RECEPCIÓN</th>
                                            <th class="text-center font-weight-bold">FECHA RESULTADOS</th>
                                            <th class="text-center font-weight-bold">TEMPERATURA</th>
                                            <th class="text-center font-weight-bold">OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr v-for="(row, index) in form.tests" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td class="text-center">{{ getNameMuestra(row.muestra_id) }}</td>
                                            <td class="text-center">{{ getNamePrueba(row.prueba_id) }}</td>
                                            <td class="text-center">{{ getNameEspecie(row.especie_id) }}</td>
                                            <td class="text-center">{{ row.observacion }}</td>
                                            <td class="text-center">{{ getNamePresentacion(row.presentacion_id) }}</td>
                                            <td class="text-center">{{ getNameLaboratorio(row.prueba_id) }}</td>
                                            <td class="text-center">{{ row.quantity }}</td>
                                            <td class="text-center">{{ getPruebaPrice(row.prueba_id) }}</td>
                                            <td class="text-center">{{ getTotal(row.prueba_id) }}</td>
                                            <td class="text-center">{{ getPruebaTime(row.time_entrega) }}</td>
                                            <td class="text-center">{{ getPruebaCondition(row.condicion) }}</td>
                                            <td class="text-center">{{ row.date_of_muestra }}</td>
                                            <td class="text-center">{{ row.date_of_recepcion }}</td>
                                            <td class="text-center">{{ row.date_of_result }}</td>
                                            <td class="text-center">{{ row.temperatura }}</td>
                                            <td class="text-center"></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 mt-3 d-flex align-items-end mb-3">
                            <div class="form-group">
                                <button type="button" class="btn  btn-primary btn-sm" @click="AddTest"> Agregar +</button>
                            </div>
                        </div>

                        <div class=" col-12 col-sm-12 float-right">

                            <h5 class="text-right"><b>TOTAL: </b>{{ total_pagar }}</h5>

                        </div>

                        <div class=" col-12 col-sm-12 float-right">

                            <button  type="submit" class="btn btn-sm btn-success">
                                <span>Registrar</span>
                            </button>

                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</template>

<script>
import CustomerSearch from '../../components/CustomerSearch.vue'
import moment from 'moment'
export default {
	mixins: [],
    components: {
		CustomerSearch
	},
    data() {
        return {
            resource: 'orders',
            showDialogOptions: false,
            loading_submit: false,
            loading_form: false,
            errors: {},
            form: {},
            typeordenes: [
                {"id":1,"description":"Servicio"},
                {"id":2,"description":"Capacitación"},
                {"id":3,"description":"Otros"}
            ],
            identity_document_types: [],
            matrices: [],
            muestras: [],
            pruebas: [],
            especies: [],
            subespecies: [],
            presentaciones: [],
            staffs: [],
			departments: [],
			provinces: [],
			districts: [],
			all_departments: [],
			all_provinces: [],
			all_districts: [],
			all_customers: [],
			customers: []
        }
    },
    created() {
        this.getDataTables();
        this.initForm();
    },
    methods: {
        getDataTables(){
            axios.get(`/${this.resource}/tables`)
                .then(response => {

                    this.identity_document_types = response.data.identity_document_types
                    this.tpordenes = response.data.tpordenes
                    this.matrices = response.data.matrices
                    this.muestras = response.data.muestras
                    this.pruebas = response.data.pruebas
                    this.especies = response.data.especies
                    this.subespecies = response.data.subespecies
                    this.presentaciones = response.data.presentaciones
                    this.staffs = response.data.staffs
					this.all_customers = response.data.customers
					this.customers = response.data.customers
					this.all_departments = response.data.departments
					this.all_provinces = response.data.provinces
					this.all_districts = response.data.districts

                })
        },
        getNameMuestra(id){
            const itemMuestra = _.find(this.muestras, {id: id})
            if(itemMuestra) return itemMuestra.description;
            return '';
        },
        getNamePrueba(id){
            const itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.description;
            return '';
        },
        getNameEspecie(id){
            const itemEspecie = _.find(this.especies, {id: id})
            if(itemEspecie) return itemEspecie.description;
            return '';
        },
        getNamePresentacion(id){
            const itemPresentacion = _.find(this.presentaciones, {id: id})
            if(itemPresentacion) return itemPresentacion.description;
            return '';
        },
        getNameLaboratorio(id){
            const itemPresentacion = _.find(this.presentaciones, {id: id})
            if(itemPresentacion) return itemPresentacion.description;
            return '';
        },
        getPruebaCondition(id){
            const itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.condicion;
            return '';
        },
        getPruebaTime(id){
            const itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.time_entrega;
            return '';
        },
        getPruebaPrice(id){
            const itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.price;
            return '';
        },
        getTotal(id){

            const itemTotal = _.find(this.pruebas, {id: id})
            if(itemTotal) return itemTotal.price * this.form.quantity;
            return '';
        },
        initForm() {
            this.errors = {}
            this.form = {

                tests: [],

                user_id: null,
                establishment_id: null,
                establishment: null,
                state_type_id: null,
                group_id: null,
                document_type_id: null,
                series: null,
                date_of_issue: moment().format('YYYY-MM-DD'),
                time_of_issue: moment().format('HH:mm:ss'),
				customer_id: null,
                customer: null,
                currency_type_id: null,
                tporden_id: null,
                responsable_id: null,
                documento_referencia: null,

                total_value: 0,
                total_igv: 0,
                total: 0,

                legends: null,
                filename: null,
                estado: null,
                type_document_fact: '03',
                tipo: null
            }
        },
		reloadDataCustomers(customer_id) {
			axios.get(`/${this.resource}/table/customers`).then((response) => {
				this.customers = response.data
				this.all_customers = response.data
				this.form.customer_id  = customer_id
			})
		},
		filterCustomers() {
			this.form.customer_id = null
			this.customers = this.all_customers

			if(this.customers.length >0){
				let per = this.customers.find(el=> el.id == 1);
				if(per) this.form.customer_id = per.id;
			}
		},
        AddTest(){

            this.form.tests.push({
                codigo: this.form.codigo,
                muestra_id: this.form.muestra_id,
                prueba_id: this.form.prueba_id,
                especie_id: this.form.especie_id,
                observacion: this.form.observacion,
                presentacion_id: this.form.presentacion_id,
                laboratorio_id: this.form.laboratorio_id,
                quantity: this.form.quantity,
                precio_unitario: this.getPruebaPrice(this.form.prueba_id),
                price_total: this.getTotal(this.form.prueba_id),
                tiempo_entrega: this.form.tiempo_entrega,
                condicion: this.form.condicion,
                date_of_muestra: this.form.date_of_muestra,
                date_of_recepcion: this.form.date_of_recepcion,
                date_of_result: this.form.date_of_result,
                temperatura: this.form.temperatura
            });
        },
		queryDocumentApi(){
           this.queryDocument()
		},
        async submit() {

            this.loading_submit = true

            axios.post(`/${this.resource}`, this.form)
                .then(async response => {
                    console.log(response.data)
                    if (response.data.success) {
                        this.resetForm();
                    }
                    else {
                        this.$message.error(response.data.message);
                        this.loading_submit = false;
                    }
                }).catch(error => {

                if (error.response.status === 422) {
                    this.errors = error.response.data;
                }
                else {
                    this.$message.error(error.response.data.message);
                }
                this.loading_submit = false;
            });

        },
        close() {
            location.href = '/orders'
        },
    },
    computed :{
        total_pagar(){

            let itemsTotales = this.form.tests;
            if(itemsTotales.length > 0) {
                return itemsTotales.reduce((sum,item)=>{
                    return sum+ +item.price_total;
                },0);
            }


        },
        matrizFilter(){
            return this.muestras.filter(el=> el.matriz_id == this.form.matriz_id);
        },
        subespecieFilter(){
            return this.subespecies.filter(el=> el.especie_id == this.form.especie_id);
        },


    },
    watch :{

    }
}
</script>

