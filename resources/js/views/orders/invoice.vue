<template>
    <div class="container-fluid m-0 pb-0 mt-1">
		<div class="page-header d-flex bd-highlight">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4 >Nueva Orden de Laboratorio</h4>
			</div>
        </div>

        <div class="card mb-0 w-100 mt-3">
<!--            v-if="loading_form"-->
            <div class="card-body">

                <form autocomplete="off" @submit.prevent="submit">

                    <div class="row d-flex justify-content-end">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.num_orden}">
                                <label class="control-label">Número de Orden</label>
                                <el-input v-model="form.num_orden"></el-input>
                                <small class="form-control-feedback" v-if="errors.num_orden" v-text="errors.num_orden[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                <label class="control-label">Fecha de Emisión</label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.tporden_id}">
                                <label class="control-label">(*)Tipo de Orden:</label>
                                <el-select v-model="form.tporden_id">
                                    <el-option v-for="option in typeordenes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.tporden_id" v-text="errors.tporden_id[0]"></small>
                            </div>
                        </div>
                    </div>


                    <div class="row d-flex justify-content-end">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <label class="control-label">(*)Tipo Documento</label>
                            <div class="form-group">
                                <el-select v-model="form.identity_document_id" placeholder="Tipo Documento" >
                                    <el-option v-for="option in identity_document_types" :value="option.id" :key="option.id" :label="option.description"/>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">(*)Documento</label>
                                <el-input v-model="form.number" placeholder="Documento" :maxlength="maxlength">
                                    <template #append>
                                        <el-button @click.prevent="searchDocument">Buscar</el-button>
                                    </template>
                                </el-input>
                                <small class="form-control-feedback text-danger" v-if="errors.number" v-text="errors.number[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    <span v-if="this.form.type=='staff'">(*)Nombres/Razón Social</span>
                                    <span v-else>Nombre</span>
                                </label>
                                <el-input v-model="form.name" type="text" placeholder="Nombre"/>
                                <small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.responsable_id}">
                                <label class="control-label">(*)Responsable</label>
                                <el-select v-model="form.responsable_id">
                                    <el-option v-for="option in staffs" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.responsable_id" v-text="errors.responsable_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.num_orden}">
                                <label class="control-label">(*)Referencia</label>
                                <el-input v-model="form.num_orden"></el-input>
                                <small class="form-control-feedback" v-if="errors.num_orden" v-text="errors.num_orden[0]"></small>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row d-flex justify-content-end">
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
                                    <el-option v-for="option in muestras" :key="option.id" :value="option.id" :label="option.description"></el-option>
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
                                    <el-option v-for="option in subespecies" :key="option.id" :value="option.id" :label="option.description"></el-option>
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
                                <el-date-picker v-model="form.date_of_muestra" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_muestra" v-text="errors.date_of_muestra[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_recepcion}">
                                <label class="control-label">(*)Fecha de Recepción</label>
                                <el-date-picker v-model="form.date_of_recepcion" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_recepcion" v-text="errors.date_of_recepcion[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_result}">
                                <label class="control-label">(*)Fecha de Resultados</label>
                                <el-date-picker v-model="form.date_of_result" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
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
                                            <td class="text-center">{{ total_pagar }}</td>
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

<!--                        <div class=" col-12 col-sm-12 float-right" :class="total > 0 ? 'col-xl-4' : 'col-xl-12'">-->

<!--                            -->
<!--                            <p class="text-right" v-if="form.total_igv > 0">IGV: {{ currency_type.symbol }} {{ form.total_igv }}</p>-->
<!--                            -->
<!--                            <p class="text-right"   v-if="form.total > 0"><button type="button" class="btn  btn-info btn-sm mr-3"-->
<!--                                                                                  @click.prevent="showDialogNotes = true"><i class="fa fa-search fs-15"></i></button>TOTAL NOTA CRÉDITO: {{ currency_type.symbol }} {{ total_nc_apply }}</p>-->
<!--                            <h5 class="text-right" v-if="form.total > 0"><b>TOTAL: </b>{{ currency_type.symbol }} {{ form.total }}</h5>-->
<!--                            -->
<!--                        </div>-->
                    </div>

                </form>
            </div>
        </div>

    </div>
</template>

<script>

    import moment from 'moment'
export default {
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
            matrices: [],
            muestras: [],
            pruebas: [],
            especies: [],
            subespecies: [],
            presentaciones: [],
            staffs: []

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
        initForm() {
            this.errors = {}
            this.form = {

                document_type_id: null,
                series_id: null,
                number: '#',
                customer_id: null,
                identity_document_id: null,
                num_orden: null,
                responsable_id: null,
                referencia: null,
                quantity: 0,
                tporden_id: null,
                // matriz_id: null,
                // muestra_id: null,
                // prueba_id: null,
                // especie_id: null,
                // subespecie_id: null,
                // observacion: null,
                // temperatura: null,
                date_of_issue: moment().format('YYYY-MM-DD'),
                date_of_muestra: moment().format('YYYY-MM-DD'),
                date_of_recepcion: moment().format('YYYY-MM-DD'),
                date_of_result: moment().format('YYYY-MM-DD'),
                tests: [],
                total_value: 0,
                total_igv: 0,
                total: 0

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
                precio_unitario: this.form.precio_unitario,
                price_total: this.form.price_total,
                tiempo_entrega: this.form.tiempo_entrega,
                condicion: this.form.condicion,
                date_of_muestra: this.form.date_of_muestra,
                date_of_recepcion: this.form.date_of_recepcion,
                date_of_result: this.form.date_of_result,
                temperatura: this.form.temperatura
            });


        },
        async submit() {

            this.loading_submit = true

            axios.post(`/${this.resource}`, this.form)
                .then(async response => {
                    if (response.data.success) {
                        this.documentNewId = response.data.data.id;
                        this.resetForm();
                        // this.showDialogOptions = true;
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
            return  parseFloat(this.form.quantity * this.form.quantity).toFixed(2)
        },

    },
    watch :{

    }
}
</script>

