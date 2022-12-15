<template>
    <div class="container-fluid m-0 pb-0 mt-1">
        <div class="card mb-0 w-100">
            <div class="page-header d-flex bd-highlight">
                <div class="ml-4 mt-2 p-2 flex-grow-1">
                    <h4 >Editar una Orden de Laboratorio</h4>
                </div>
            </div>
            <hr class="mt-0 mb-0">
            <div class="card-body">
                <form autocomplete="off" @submit.prevent="submit">
                    <div class="row">

                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.series_id}">
                                <label class="control-label">Serie</label>
                                <el-select v-model="form.series_id">
                                    <el-option v-for="option in serieDocument" :key="option.id" :value="option.id" :label="option.serie"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.series_id" v-text="errors.series_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                <label class="control-label">Fecha de Emisión</label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
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
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <label class="control-label">(*)Tipo Documento</label>
                            <div class="form-group">
                                <el-select v-model="form.identity_document_id" placeholder="Tipo Documento">
                                    <el-option v-for="option in identity_document_types" :value="option.id" :key="option.id" :label="option.description"/>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label">(*)Documento</label>
                                <el-input v-model="form.number" placeholder="Documento" :maxlength="maxlength">
                                    <template #append>
                                        <el-button @click.prevent="queryDocumentApi">Buscar</el-button>
                                    </template>
                                </el-input>
                                <small class="form-control-feedback text-danger" v-if="errors.number" v-text="errors.number[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label">(*)Nombre / Razón Social</label>
                                <el-input v-model="form.name" type="text" placeholder="Nombre"/>
                                <small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <label class="control-label">Departamento</label>
                            <div class="form-group">
                                <el-select v-model="form.department_id" filterable clearable @change="filterProvince" placeholder="Seleccione">
                                    <el-option v-for="option in all_departments" :key="option.id" :value="option.id" :label="option.description" />
                                </el-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <label class="control-label">Provincia</label>
                            <div class="form-group">
                                <el-select v-model="form.province_id" filterable clearable @change="filterDistrict" placeholder="Seleccione">
                                    <el-option v-for="option in provinces" :key="option.id" :value="option.id" :label="option.description" />
                                </el-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <label class="control-label">Distrito</label>
                            <div class="form-group">
                                <el-select v-model="form.district_id" filterable clearable placeholder="Seleccione">
                                    <el-option v-for="option in districts" :key="option.id" :value="option.id" :label="option.description" />
                                </el-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label">Dirección</label>
                                <el-input v-model="form.address" type="text" placeholder="Dirección"/>
                                <small class="form-control-feedback text-danger" v-if="errors.address" v-text="errors.address[0]"></small>
                            </div>
                        </div>
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
                                <el-date-picker v-model="form.date_of_muestra" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_muestra" v-text="errors.date_of_muestra[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_recepcion}">
                                <label class="control-label">(*)Fecha de Recepción</label>
                                <el-date-picker v-model="form.date_of_recepcion" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_recepcion" v-text="errors.date_of_recepcion[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_result}">
                                <label class="control-label">(*)Fecha de Resultados</label>
                                <el-date-picker v-model="form.date_of_result" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
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
                                        <td class="text-center">{{ getPruebaTime(row.prueba_id) }}</td>
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
import { allDepartments } from "../../mixins/deletable"
import { searchDcumentType } from "../../mixins/searchApi"
import moment from 'moment'
export default {
    mixins: [allDepartments, searchDcumentType],
    props: {
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
            serieDocument: [],
            matrices: [],
            muestras: [],
            pruebas: [],
            especies: [],
            subespecies: [],
            presentaciones: [],
            laboratorios: [],
            metodos: [],
            staffs: [],
            departments: [],
            provinces: [],
            districts: [],
            all_departments: [],
            all_provinces: [],
            all_districts: []
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
                    this.serieDocument = response.data.serieDocument
                    this.tpordenes = response.data.tpordenes
                    this.matrices = response.data.matrices
                    this.muestras = response.data.muestras
                    this.pruebas = response.data.pruebas
                    this.especies = response.data.especies
                    this.subespecies = response.data.subespecies
                    this.presentaciones = response.data.presentaciones
                    this.laboratorios = response.data.laboratorios
                    this.metodos = response.data.metodos
                    this.staffs = response.data.staffs
                    this.all_departments = response.data.departments
                    this.all_provinces = response.data.provinces
                    this.all_districts = response.data.districts

                })

            this.edit()
        },
        getNameMuestra(id){
            let itemMuestra = _.find(this.muestras, {id: id})
            if(itemMuestra) return itemMuestra.description;
            return '';
        },
        getNamePrueba(id){
            let itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.name;
            return '';
        },
        getNameEspecie(id){
            let itemEspecie = _.find(this.especies, {id: id})
            if(itemEspecie) return itemEspecie.description;
            return '';
        },
        getNamePresentacion(id){
            let itemPresentacion = _.find(this.presentaciones, {id: id})
            if(itemPresentacion) return itemPresentacion.description;
            return '';
        },
        getNameLaboratorio(id){
            let Labo = _.find(this.pruebas, {id: id})
            let itemlabo = _.find(this.laboratorios, {id: Labo.laboratorio_id})
            if(itemlabo) return itemlabo.name;
            return '';
        },
        getPruebaCondition(id){
            let itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.condicion;
            return '';
        },
        getPruebaTime(id){
            let itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.time_entrega;
            return '';
        },
        getPruebaPrice(id){
            let itemPrueba = _.find(this.pruebas, {id: id})
            if(itemPrueba) return itemPrueba.price;
            return '';
        },
        getTotal(id){

            let itemTotal = _.find(this.pruebas, {id: id})
            if(itemTotal) return itemTotal.price * this.form.quantity;
            return '';
        },
        edit(){
            let me = this

            me.form.establishment_id = me.document.establishment_id
            me.form.document_type_id = me.document.document_type_id

            me.form.number = me.document.number
            me.form.series_id = me.document.series

            me.form.dias_credito = me.document.dias_credito
            me.form.num_cuotas = me.document.num_cuota
            me.form.currency_type_id = me.document.currency_type_id

            me.form.date_of_issue = me.document.date_of_issue
            me.form.date_of_due = me.document.invoice.date_of_due
            me.form.warehouse_id= me.document.warehouse_id
            me.form.exchange_rate_sale = me.document.exchange_rate_sale

            me.form.total_igv = me.document.total_igv
            me.form.total_value = me.document.total_value
            me.form.total = me.document.total


            me.$http.get(`/${this.resource}/productos/tables3/${me.document.id}`).then(response => {
                let items = response.data.items
                me.operation_types = response.data.operation_types
                me.all_affectation_igv_types = response.data.affectation_igv_types

                let operation_type = _.find(this.operation_types, {id: this.form.operation_type_id})
                me.affectation_igv_types = _.filter(this.all_affectation_igv_types, {exportation: operation_type.exportation})


                for (let index = 0; index < items.length; index++) {
                    const item = items[index];
                    me.form.item = item

                    me.form.charges = item.charges ?  Object.keys(item.charges).map(i => item.charges[i]): []
                    me.form.discounts =  item.discounts ? Object.keys(item.discounts).map(i => item.discounts[i]) : []
                    me.form.attributes = item.attributes?  Object.keys(item.attributes).map(i => item.attributes[i]) : []

                    me.form.unit_type_id = item.unit_type_id;
                    me.form.item.unit_price = (item.unit_price)
                    me.form.quantity = item.quantity

                    me.form.affectation_igv_type_id = item.affectation_igv_type_id
                    me.form.item.included_igv = 1
                    me.form.affectation_igv_type = _.find(me.affectation_igv_types, {'id': item.affectation_igv_type_id})

                    me.row = calculateRowItem(me.form, me.form.currency_type_id, me.form.exchangeRateSale)
                    me.row.equivalencia_id =  item.equivalencia_id
                    me.row.description_unidad =  item.description_unidad
                    me.row.total_igv = item.total_igv
                    me.row.total_value = item.total_value
                    me.row.total_taxes = item.total_igv
                    me.row.total = item.total
                    me.row.unit_price = item.unit_price

                    me.row.warehouse_id = item.warehouse_id
                    me.row.warehouseDescription = item.warehouseDescription
                    me.addRow(me.row)
                }
            })



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
                series_id: null,
                number: null,
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
        maxlength: function(){
            if(this.form.identity_document_id === '6'){
                return 11;
            }

            if(this.form.identity_document_id === '1'){
                return 8;
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

