<template>
    <div class="container-fluid">
        <div class="card">
            <div class="page-header d-flex bd-highlight">
				<div class="ml-4 mt-2 p-2 flex-grow-1">
					<h4>Nueva Orden de Laboratorio Brucella</h4>
				</div>
			</div>
			<hr class="mt-0 mb-0">
            <div class="card-body">
                <form autocomplete="off" @submit.prevent="submit">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <div class="form-group" :class="{'has-danger': errors.series_id}">
                                    <label class="control-label">(*)Serie</label>
                                    <el-input v-model="form.series_id"></el-input>
                                    <small class="form-control-feedback" v-if="errors.series_id" v-text="errors.series_id[0]"></small>
                                </div>                                                                                      
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label">Fecha de Emisión</label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label">Ingresa tu excel</label>
                                <form>
                                        <div class="cold-md-2">
                                            <input class="form-control" type="file" @change="handleFileUpload" required>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <customer-search :showLabel="true" v-model:customer_id="form.customer_id" class="col-xs-12 col-sm-4 col-md-4"
						:customersList="customers" :errors="errors"></customer-search>

                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group" :class="{'has-danger': errors.responsable_id}">
                                <label class="control-label">(*)Responsable</label>
                                <el-select v-model="form.responsable_id">
                                    <el-option v-for="option in staffs" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.responsable_id" v-text="errors.responsable_id[0]"></small>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-4">
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
                        <div class="col-lg-3">
                            <div class="form-group" :class="{'has-danger': errors.temperatura}">
                                <label class="control-label">Temperatura</label>
                                <el-input v-model="form.temperatura"></el-input>
                                <small class="form-control-feedback" v-if="errors.temperatura" v-text="errors.temperatura[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" :class="{'has-danger': errors.date_of_muestra}">
                                <label class="control-label">(*)Fecha de Muestra</label>
                                <el-date-picker v-model="form.date_of_muestra" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_muestra" v-text="errors.date_of_muestra[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" :class="{'has-danger': errors.date_of_recepcion}">
                                <label class="control-label">(*)Fecha de Recepción</label>
                                <el-date-picker v-model="form.date_of_recepcion" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_recepcion" v-text="errors.date_of_recepcion[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" :class="{'has-danger': errors.date_of_resultado}">
                                <label class="control-label">(*)Fecha de Resultados</label>
                                <el-date-picker v-model="form.date_of_resultado" type="date" value-format="YYYY-MM-DD" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_resultado" v-text="errors.date_of_resultado[0]"></small>
                            </div>
                        </div>
                        <div>
                            <div class="form-group" :class="{'has-danger': errors.observacion}">
                                <label class="control-label">Observación</label>
                                <el-input v-model="form.observacion"></el-input>
                                <small class="form-control-feedback" v-if="errors.observacion" v-text="errors.observacion[0]"></small>
                            </div>
                        </div>   
                    </div>
                    <div class="row responsive">                        
                    <div class="col-lg-3">
                        <h4>Muestra</h4>
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Número</th>
                                <th># Registro</th>
                                <th>Reg.Error</th>
                                </tr>
                            </thead>
                            <tbody v-if="Array.isArray(form.data)">
                                <tr v-for="(row, index) in form.data" :key="index + 1">
                                    <td>{{ index + 1 }}</td>
                                    <td><input class="form-control" type="text" v-model="form.dato1[index]"></td>
                                    <td><input class="form-control" type="text" v-model="form.dato2[index]"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-9">
                        <h4>Detalles de muestras</h4>
                        <br>
                        <table class="table responsive">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Peso</th>
                                <th>Vacas en Producción</th>
                                <th>Total Hato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in form.data" :key="index">                                
                                <td><input class="form-control" type="text" v-model="row[2]"></td>
                                <td><input class="form-control" type="text" v-model="row[1]"></td>
                                <td><input class="form-control" type="text" v-model="row[4]"></td>
                                <td><input class="form-control" type="text" v-model="row[5]"></td>
                                <td><input class="form-control" type="text" v-model="row[6]"></td>
                                <td><input class="form-control" type="text" v-model="row[7]"></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-sm-12 float-right">
                        <button type="submit" class="btn btn-sm btn-success">
                        <span>Registrar</span>
                        </button>                         
                    </div>
                    <div class="col-12 col-sm-12 float-right">
                        <span><a class="btn btn-sm btn-danger" :href="`/${resource}`">Salir</a></span>                         
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
    data(){
        return{
            resource: 'laboratoriobrucellas',
            staffs: [],
            all_customers: [],
			customers: [],
            errors: {},
            form: {
                data: [],
            },
        }

    },
    created() {
        this.getDataTables();
        this.initForm()
    },
    methods: {
        setData(responseData) {
            this.data = responseData;
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('excel_file', file);

            // Enviar el archivo al servidor Laravel
            axios.post(`/${this.resource}/importar`, formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                // Actualizar los datos en la instancia de Vue
                this.form.data = response.data; // Asignar los datos al arreglo 'data'
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        },

        initForm() {
            this.errors = {};
            this.form = {
                data: [],
                series_id: null,
                date_of_issue: moment().format('YYYY-MM-DD'),
                customer_id: null,
                responsable_id: null,
                referencia: null,
                temperatura: null,
                date_of_muestra: null,
                date_of_recepcion: null,
                date_of_resultado: null,
                observacion: null,
                dato1: [], // Inicializar como arreglo vacío
                dato2: [] // Inicializar como arreglo vacío
            };
        },

        getDataTables(){
            axios.get(`/${this.resource}/tables`)
                .then(response => {
                    this.identity_document_types = response.data.identity_document_types
                    this.serieDocument = response.data.serieDocument
                    this.staffs = response.data.staffs
					this.all_customers = response.data.customers
					this.customers = response.data.customers
                })
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

        async submit() {
            this.loading_submit = true;
            axios.post(`/${this.resource}`, this.form)
                .then(async response => {
                    if (response.data.success) {
                        this.$swal({
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.reload(); // aquí se recarga la página
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
    },
}
</script>