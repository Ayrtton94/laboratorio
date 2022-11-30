<template>
     <div>


		<div class="page-header d-flex bd-highlight">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4 >Editar Órden de Venta</h4>
				<span class="d-block"> Modificar datos de órden.</span>
			</div>
        </div>
        <div class="card mb-0 w-100 mt-3 p-3">
            <div class="tab-content" v-if="loading_form">
                <div class="invoice">

                    <form autocomplete="off" @submit.prevent="submit">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-lg-2 pb-2">
                                    <div class="form-group" :class="{'has-danger': errors.document_type_id}">
                                        <label class="control-label font-weight-bold text-info">Tipo de comprobante</label>
                                        <el-select v-model="form.document_type_id" @change="changeDocumentType" popper-class="el-select-document_type" dusk="document_type_id" class="border-left rounded-left border-info">
                                            <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.document_type_id" v-text="errors.document_type_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.establishment_id}">
                                        <label class="control-label">Sucursal</label>
                                        <el-select v-model="form.establishment_id" @change="changeEstablishment">
                                            <el-option v-for="option in establishments" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.establishment_id" v-text="errors.establishment_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.operation_type_id}">
                                        <label class="control-label">Tipo Operación</label>
                                        <el-select v-model="form.operation_type_id" @change="changeOperationType">
                                            <el-option v-for="option in operation_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.operation_type_id" v-text="errors.operation_type_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.series_id}">
                                        <label class="control-label">Serie</label>
                                        <el-select v-model="form.series_id">
                                            <el-option v-for="option in series" :key="option.id" :value="option.id" :label="option.number"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.series_id" v-text="errors.series_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.currency_type_id}">
                                        <label class="control-label">Moneda</label>
                                        <el-select v-model="form.currency_type_id" @change="changeCurrencyType">
                                            <el-option v-for="option in currency_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.currency_type_id" v-text="errors.currency_type_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.exchange_rate_sale}">
                                        <label class="control-label">Tipo de cambio</label>
                                        <el-input v-model="form.exchange_rate_sale"></el-input>
                                        <small class="form-control-feedback" v-if="errors.exchange_rate_sale" v-text="errors.exchange_rate_sale[0]"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">

                                <customer-search :customer_id.sync="form.customer_id" :document_type_id="form.document_type_id"   :showLabel="true" classes="col-xl-4" :width="true"
                                                 :customersList="customers" :document_type_03_filter="document_type_03_filter" :errors="errors" :molitalia="molitalia"
                                                 :isNewCustomerName="isNewCustomerName"></customer-search>

                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.nombre_cliente}">
                                        <label class="control-label">Nombre - Identificador Cliente</label>
                                        <el-input v-model="form.nombre_cliente"></el-input>
                                        <small class="form-control-feedback" v-if="errors.nombre_cliente" v-text="errors.nombre_cliente[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                        <label class="control-label">Fecha de emisión</label>
                                        <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                        <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group" :class="{'has-danger': errors.date_of_due}">
                                        <label class="control-label">Fecha de vencimiento</label>
                                        <el-date-picker v-model="form.date_of_due" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                        <small class="form-control-feedback" v-if="errors.date_of_due" v-text="errors.date_of_due[0]"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="font-weight-bold">Descripción</th>
                                                    <th class="font-weight-bold">Unidad</th>
                                                    <th class="font-weight-bold text-center" v-if="formato_ordenventa.valor==1">Pric.</th>
                                                    <th class="font-weight-bold text-center cantidadColumn">Cantidad</th>
                                                    <th class="text-right font-weight-bold">Precio Unitario</th>
                                                    <th class="text-right font-weight-bold">Subtotal</th>
                                            		<th class="text-right font-weight-bold">Descuentos</th>
													<th class="text-right font-weight-bold">Cargos</th>
                                                    <th class="text-right font-weight-bold">Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="form.items.length > 0">
                                                <tr v-for="(row, index) in form.items" :key="index">
                                                    <td>{{ index + 1 }}</td>

                                                    <td class="descriptionColumn">{{ row.item.description }} --
                                                        <span v-if="formato_ordenventa.valor==1 && row.item.trademark">({{row.item.trademark.name}})</span>
                                                        <br/>
                                                        <small>{{ row.affectation_igv_type.description }}</small>
													<br>
														<small v-for="(atributo,index) in row.attributes" :key="index">{{ atributo.description }} - {{ atributo.value }}</small>
													</td>
                                                    <td class="unidadColumn">{{ row.unit_type_id }} <br> <small>{{ row.description_unidad}} </small></td>
                                                    <td class="unidadColumn text-warning" v-if="formato_ordenventa.valor==1">
                                                        <span>{{ row.desc_tipoprecio }} </span>
                                                    </td>
                                                	<td class="text-center cantidadColumn" >
														<div class="input-group bootstrap-touchspin text-center ">
															<span class="input-group-btn" @click.prevent="disminuirCantidad(row.item.id,index)">
																<button class="btn  bootstrap-touchspin-down " type="button"><i class="fa fa-minus text-danger"></i></button>
															</span>
															<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
															<input class="touchspin1 form-control input-lg" v-model="row.quantity"
																	@change="recalcularSubTotal(row.item.id,3,index)">
															<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
															<span class="input-group-btn"  @click.prevent="agregarCantidad(row.item.id,index)">
																<button class="btn  bootstrap-touchspin-up" type="button"><i class="fa fa-plus text-info"></i></button>
															</span>
														</div>
													</td>
                                                    <td class="text-right">{{ currency_type.symbol }} {{ formaterNumber(row.unit_price, decimal) }}</td>
                                                    <td class="text-right">{{ currency_type.symbol }} {{ formaterNumber(row.total_value) }}</td>
                                                    <td class="text-right">{{ currency_type.symbol }} {{ formaterNumber(row.total_discount) }}</td>
                                                    <td class="text-right">{{ currency_type.symbol }} {{ formaterNumber(row.total_charge) }}</td>
                                                    <td class="text-right">{{ currency_type.symbol }} {{ formaterNumber(row.total) }}</td>
                                                    <td class="text-right">
														<!-- <button type="button" class="btn waves-effect waves-light btn-sm btn-info" @click="ediItem(row, index)" ><span style='font-size:10px;'>&#9998;</span> </button> -->
                                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickRemoveItem(index)">x</button>

                                                    </td>
                                                </tr>
                                                <tr><td colspan="8"></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                    <div class="col-lg-12 col-md-6 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="button" class="btn waves-effect waves-light btn-primary btn-sm" @click.prevent="showDialogAddItem = true">+ Agregar Producto</button>
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                    <p class="text-right" v-if="form.total_exportation > 0">OP.EXPORTACIÓN: {{ currency_type.symbol }} {{ form.total_exportation }}</p>
                                    <p class="text-right" v-if="form.total_free > 0">OP.GRATUITAS: {{ currency_type.symbol }} {{ form.total_free }}</p>
                                    <p class="text-right" v-if="form.total_unaffected > 0">OP.INAFECTAS: {{ currency_type.symbol }} {{ form.total_unaffected }}</p>
                                    <p class="text-right" v-if="form.total_exonerated > 0">OP.EXONERADAS: {{ currency_type.symbol }} {{ form.total_exonerated }}</p>
                                    <p class="text-right" v-if="form.total_taxed > 0">OP.GRAVADA: {{ currency_type.symbol }} {{ form.total_taxed }}</p>
                                    <p class="text-right" v-if="form.total_igv > 0">IGV: {{ currency_type.symbol }} {{ form.total_igv }}</p>
                                    <h4 class="text-right" v-if="form.total > 0"><b>TOTAL A PAGAR: </b>{{ currency_type.symbol }} {{ form.total }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right mt-4">
                            <el-button @click.prevent="close()" size="medium">Cancelar</el-button>
                            <el-button class="submit btn-md" type="success" native-type="submit" :loading="loading_submit"
                                v-if="form.items.length > 0" size="medium">Generar</el-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <document-form-item :showDialog.sync="showDialogAddItem"
                   :operation-type-id="form.operation_type_id"
                   :currency-type-id-active="form.currency_type_id"
                   :exchange-rate-sale="form.exchange_rate_sale"
                   :moneda="form.currency_type_id"
                   :almacen="form.warehouse_id"
                   :price_list_id="form.price_list_id"
                   :currency_type="currency_type"
                   :checkalmacenprecio="checkalmacenprecio"
                   :isadmin="isadmin"
                   :formato_ordenventa="formato_ordenventa"
                   @add="addRow"></document-form-item>

<!--        <person-form :showDialog.sync="showDialogNewPerson"-->
<!--                       type="customers"-->
<!--                       :external="true"-->
<!--                       :document_type_id = form.document_type_id></person-form>-->

        <document-options :showDialog.sync="showDialogOptions"
                          :recordId="documentNewId"
                          :showClose="false"></document-options>
    </div>
</template>

<script>
    import DocumentFormItem from './partials/item.vue'
    // import PersonForm from '../persons/form.vue'
    import DocumentOptions from '../quotations/partials/options.vue'
    import {functions, exchangeRate} from '../../../mixins/functions'
    import {calculateRowItem, formaterNumber, setExchangerate} from '../../../helpers/functions'
    import CustomerSearch from '../../../components/CustomerSearch'
    import Logo from '../companies/logo.vue'

    export default {
        props: ['order_id','checkalmacenprecio','almacen','sucursal','isadmin',
            'molitalia','formato_ordenventa'],
        components: {DocumentFormItem, DocumentOptions, Logo,CustomerSearch},
        mixins: [functions, exchangeRate],
        data() {
            return {
                resource: 'documentos',
                resource2: 'orders',
                showDialogAddItem: false,
                showDialogNewPerson: false,
                showDialogOptions: false,
                loading_submit: false,
                loading_form: false,
                errors: {},
                form: {},
                document_types: [],
                currency_types: [],
                discount_types: [],
                charges_types: [],
                all_customers: [],
                status_paid: [
                    {"id": "1", "nombre": "Contado"},
                    {"id": "2", "nombre": "Crédito"},
                ],
                customers: [],
                company: null,
                document_type_03_filter: null,
                operation_types: [],
                establishments: [],
                establishment: null,
                all_series: [],
                series: [],
                currency_type: {},
				documentNewId: null,
				tempItem: {},
				decimal: 2,
                isNewCustomerName : null,
                // control_stock: false,
            }
        },
        async created() {
            await this.initForm()
            // await this.$http.get(`/${this.resource2}/tables`)
            //     .then(response => {
            //
            //         this.document_types = response.data.document_types_invoice
            //         this.currency_types = response.data.currency_types
            //         this.establishments = response.data.establishments
            //         this.operation_types = response.data.operation_types
            //         this.all_series = response.data.series
            //         this.all_customers = response.data.customers
            //         this.discount_types = response.data.discount_types
            //         this.charges_types = response.data.charges_types
            //         this.company = response.data.company
            //         this.document_type_03_filter = response.data.document_type_03_filter
            //
            //         this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
            //         this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null
            //         this.form.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
            //         this.form.operation_type_id = (this.operation_types.length > 0)?this.operation_types[0].id:null
            //
            //         // this.form.customer_id = (response.data.order)?  response.data.order[0].customer_id : 1
			// 	    this.decimal = response.data.decimal;
            //         this.changeEstablishment()
            //         this.changeDateOfIssue()
            //         this.changeDocumentType()
            //         this.changeCurrencyType()
            //     })
            await this.$http.get(`/${this.resource2}/tables3/${this.order_id}`)
                .then(response => {

                    this.warehouses = response.data.warehouses
                    this.document_types = response.data.document_types_invoice
                    this.currency_types = response.data.currency_types
                    this.establishments = response.data.establishments
                    this.operation_types = response.data.operation_types
                    this.all_series = response.data.series
                    this.all_customers = response.data.customers
                    this.discount_types = response.data.discount_types
                    this.charges_types = response.data.charges_types
                    this.company = response.data.company
                    this.document_type_03_filter = response.data.document_type_03_filter
                    this.form.warehouse_id = response.data.warehouse_id
                    this.sellers = response.data.sellers;
                    this.payment_methods = response.data.payment_methods
                    this.accounts = response.data.accounts
                    this.order = response.data.order;

                    // this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
                    this.form.currency_type_id = (this.currency_types.length > 0) ? response.data.order.currency_type_id:null
                    this.form.establishment_id = (this.establishments.length > 0)? this.order.establishment_id:null
                    this.form.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
                    this.form.operation_type_id = (this.operation_types.length > 0)?this.operation_types[0].id:null


                    this.identity_document_type_id = response.data.order.customer.identity_document_type_id
                    this.form.seller_id = response.data.order?.user?.person_id;


                    this.form.customer_id = response.data.order.customer_id

                    if(this.form.customer_id == 1 && response.data.order.customer.name !== 'CLIENTES VARIOS'){
                        setTimeout(()=> {
                            this.isNewCustomerName = response.data.order.customer.name;
                        }, 2000)

                    }
                    this.decimal = response.data.decimal;
                    this.exchange_rate = response.data.exchange_rate;
                    this.control_stock = response.data.control_stock;
                    setExchangerate(response.data.exchange_rate)
                    this.changeEstablishment()
                    this.changeDateOfIssue()
                    this.changeDocumentType()
                    this.changeCurrencyType()

                })
            await this.$http.get(`/${this.resource}/productos/tables33/${this.order_id}`)
            .then(response => {
                this.form.items = response.data.items
				this.form.total_exportation = response.data.order.total_exportation
				this.form.nombre_cliente = response.data.order.nombre_cliente
                this.operation_types = response.data.operation_types
                this.all_affectation_igv_types = response.data.affectation_igv_types
                this.system_isc_types = response.data.system_isc_types
                this.discount_types = response.data.discount_types
                this.charge_types = response.data.charge_types
                this.attribute_types = response.data.attribute_types
            })
            this.loading_form = true
            this.form.order_id = this.order_id
            this.calculateTotal()
            this.$eventHub.$on('reloadDataPersons', (customer_id) => {
                this.reloadDataCustomers(customer_id)
            })
            this.$eventHub.$on('changeName', (data) => {
                this.changeName(data)
            })

            this.resetnombrecliente()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    establishment_id: null,
                    document_type_id: null,
                    series_id: null,
                    number: '#',
                    date_of_issue: moment().format('YYYY-MM-DD'),
                    time_of_issue: moment().format('HH:mm:ss'),
                    customer_id: 1,
                    currency_type_id: null,
                    purchase_order: null,
                    exchange_rate_sale: 0,
                    total_prepayment: 0,
                    total_charge: 0,
                    total_discount: 0,
                    order_id: this.order_id,
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
                    actions: {
                        format_pdf:'a4',
					},
					nombre_cliente : ''

                }
            },
            resetForm() {
                this.initForm()
                this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
                this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null
                this.form.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
                this.form.operation_type_id = (this.operation_types.length > 0)?this.operation_types[0].id:null
                this.changeEstablishment()
                this.changeDocumentType()
                this.changeDateOfIssue()
                this.changeCurrencyType()
            },
            resetnombrecliente(){
                // si es boleta
                if(this.form.document_type_id ==='03'){
                    // si nombre del cliente es diferente a clientes varios que siempre será el primero de la lista.
                    if(this.customers.length){
                        if(this.form.customer.name !== this.customers[0].name){
                            this.form.changeName = true;
                            this.form.newName = this.form.customer.name;
                            // el primer elemento siempre será clientes varios
                            this.customers[0].name = this.form.newName ;
                            this.customers[0].description = this.customers[0].number + '-'+this.form.newName
                        }
                    }
                }
            },
            changeOperationType() {

            },
            changeEstablishment() {
                this.establishment = _.find(this.establishments, {'id': this.form.establishment_id})
                this.filterSeries()
            },
            changeDocumentType() {
                this.filterSeries()
                this.filterCustomers()
            },
            changeDateOfIssue() {
                this.form.date_of_due = this.form.date_of_issue
                this.searchExchangeRateByDate(this.form.date_of_issue).then(response => {
                    this.form.exchange_rate_sale = response
                })
            },
            filterSeries() {
                this.form.series_id = null
                this.series = _.filter(this.all_series, {'establishment_id': this.form.establishment_id,
                                                         'document_type_id': this.form.document_type_id})
                this.form.series_id = (this.series.length > 0)?this.series[0].id:null
            },
            filterCustomers() {
                this.customers = this.all_customers
            },
            addRow(row) {
                this.form.items.push(row)
                this.calculateTotal()
            },
            clickRemoveItem(index) {
                this.form.items.splice(index, 1)
                this.calculateTotal()
            },
            changeCurrencyType() {
                this.currency_type = _.find(this.currency_types, {'id': this.form.currency_type_id})
                let items = []
                this.form.items.forEach((row) => {
                    items.push(calculateRowItem(row, this.form.currency_type_id, this.form.exchange_rate_sale))
                });
                this.form.items = items
                this.calculateTotal()
            },
            calculateTotal() {
                let total_discount = 0
                let total_charge = 0
                let total_exportation = 0
                let total_taxed = 0
                let total_exonerated = 0
                let total_unaffected = 0
                let total_free = 0
                let total_igv = 0
                let total_value = 0
                let total = 0
                this.form.items.forEach((row) => {
                    total_discount += parseFloat(row.total_discount)
                    total_charge += parseFloat(row.total_charge)

                    if (row.affectation_igv_type_id === '10') {
                        total_taxed += parseFloat(row.total_value)
                    }
                    if (row.affectation_igv_type_id === '20') {
                        total_exonerated += parseFloat(row.total_value)
                    }
                    if (row.affectation_igv_type_id === '30') {
                        total_unaffected += parseFloat(row.total_value)
                    }
                    if (row.affectation_igv_type_id === '40') {
                        total_exportation += parseFloat(row.total_value)
                    }
                    if (['10', '20', '30', '40'].indexOf(row.affectation_igv_type_id) < 0) {
                        total_free += parseFloat(row.total_value)
                    }
                    if (['10', '20', '30', '40'].indexOf(row.affectation_igv_type_id) > -1) {
                        total_igv += parseFloat(row.total_igv)
                        total += parseFloat(row.total)
                    }
                    total_value += parseFloat(row.total_value)
                });

                this.form.total_exportation = formaterNumber(total_exportation)
                this.form.total_taxed = formaterNumber(total_taxed)
                this.form.total_exonerated = formaterNumber(total_exonerated)
                this.form.total_unaffected = formaterNumber(total_unaffected)
                this.form.total_free = formaterNumber(total_free)
                this.form.total_igv = formaterNumber(total_igv)
                this.form.total_value = formaterNumber(total_value)
                this.form.total_taxes = formaterNumber(total_igv)
                this.form.total = formaterNumber(total)
			},
			formaterNumber(value, decimal){
                return formaterNumber(value, decimal);
            },
            submit() {
                this.loading_submit = true
                this.$http.post(`/${this.resource2}/update/${this.order_id}`, this.form).then(response => {

                    if (response.data.success) {
                        //this.resetForm();
                        this.close()
                        //this.documentNewId = response.data.data.id;
                        //this.showDialogOptions = true;
                    }
                    else {
                        this.$message.error(response.data.message);
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                    else {
                        this.$message.error(error.response.data.message);
                    }
                }).then(() => {
                    this.loading_submit = false;
                });
			},
			disminuirCantidad (id,index){
				this.recalcularSubTotal(id,2,index);
			},
			agregarCantidad(id,index){
                this.recalcularSubTotal(id,1,index);
            },
			// tipo 1 -> aumentar , 2 -> disminuir , 3 setear
			recalcularSubTotal(id,tipo,index){
				this.initTempItem();

				this.tempItem = this.form.items[index];
                if (index > -1) {
                    if(tipo==1){
                        this.tempItem.quantity = parseFloat(parseFloat(this.form.items[index].quantity) + 1).toFixed(3);
                    }else if(tipo==2){
                        this.tempItem.quantity = parseFloat(parseFloat(this.form.items[index].quantity) - 1).toFixed(3)
                    }else{
                        this.tempItem.quantity = parseFloat(this.form.items[index].quantity).toFixed(3)
                    }
                }

					if(this.tempItem.quantity<=0){
						this.form.items.splice(index, 1)
						this.calculateTotal()
					}else{

                        // debugger;
                        this.tempItem.unit_type_id = this.form.items[index].unit_type_id;
                        this.tempItem.item.unit_type_id= this.form.items[index].unit_type_id;

                        // this.tempItem.unit_price =this.form.items[index].unit_price;
                        // this.tempItem.item.unit_price =this.form.items[index].unit_price;

                        if(this.formato_ordenventa.valor==1) {
                           if(tipo == 5){
                               this.tempItem.unit_price =this.form.items[index].unit_price;
                               this.tempItem.item.unit_price =this.form.items[index].unit_price;
                           }else{
                               if(this.tempItem.quantity >= 3){
                                   if(!!this.form.items[index].item.precios_venta){
                                       if(typeof(this.form.items[index].item.precios_venta) == 'object'){

                                           let pre_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                   return equi.precio
                                               }
                                           })
                                           this.tempItem.unit_price = pre_venta[0].precio
                                           this.tempItem.item.unit_price = pre_venta[0].precio
                                           let descprice_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                                           {
                                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                                   return equi.desc_tipoprecio
                                                               }
                                                           })
                                           this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio
                                       }else{
                                           if(this.form.items[index].item.precios_venta.length > 1){

                                               let pre_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                               {
                                                   if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                       return equi.precio
                                                   }
                                               })
                                               this.tempItem.unit_price = pre_venta[0].precio
                                               this.tempItem.item.unit_price = pre_venta[0].precio
                                               let descprice_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                               {
                                                   if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                       return equi.desc_tipoprecio
                                                   }
                                               })
                                               this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio
                                           }
                                       }
                                   }
                                   if(!!this.form.items[index].item.equivalencias){
                                       if(this.form.items[index].item.equivalencias.length > 1){

                                           let pre_venta = this.form.items[index].item.equivalencias.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                   return equi.precio
                                               }
                                           })
                                           this.tempItem.unit_price = pre_venta[0].precio
                                           this.tempItem.item.unit_price = pre_venta[0].precio
                                           let descprice_venta = this.form.items[index].item.equivalencias.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                   return equi.desc_tipoprecio
                                               }
                                           })
                                           this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio
                                       }
                                   }
                               }
                               if(this.tempItem.quantity < 3){
                                   if(!!this.form.items[index].item.precios_venta){
                                       if(typeof(this.form.items[index].item.precios_venta) == 'object'){

                                           let pre_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                   return equi.precio
                                               }
                                           })
                                           this.tempItem.unit_price = pre_venta[0].precio
                                           this.tempItem.item.unit_price = pre_venta[0].precio
                                           let descprice_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                   return equi.desc_tipoprecio
                                               }
                                           })
                                           this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio

                                       }else {
                                           if (this.form.items[index].item.precios_venta.length > 1) {

                                               let pre_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                               {
                                                   if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                       return equi.precio
                                                   }
                                               })
                                               this.tempItem.unit_price = pre_venta[0].precio
                                               this.tempItem.item.unit_price = pre_venta[0].precio
                                               let descprice_venta = this.form.items[index].item.precios_venta.filter(equi =>
                                               {
                                                   if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                       return equi.desc_tipoprecio
                                                   }
                                               })
                                               this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio

                                           }
                                       }
                                   }
                                   if(!!this.form.items[index].item.equivalencias){
                                       if(this.form.items[index].item.equivalencias.length > 1){

                                           let pre_venta = this.form.items[index].item.equivalencias.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                   return equi.precio
                                               }
                                           })
                                           this.tempItem.unit_price = pre_venta[0].precio
                                           this.tempItem.item.unit_price = pre_venta[0].precio
                                           let descprice_venta = this.form.items[index].item.equivalencias.filter(equi =>
                                           {
                                               if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                   return equi.desc_tipoprecio
                                               }
                                           })
                                           this.tempItem.desc_tipoprecio = descprice_venta[0].desc_tipoprecio

                                       }
                                   }
                               }
                           }
						}else{
							this.tempItem.unit_price =this.form.items[index].unit_price;
							this.tempItem.item.unit_price =this.form.items[index].unit_price;
						}

						this.tempItem.id = this.tempItem.item.id

						this.tempItem = calculateRowItem(this.tempItem, this.form.currency_type_id, this.form.exchange_rate_sale)
                        this.tempItem.desc_tipoprecio = this.form.items[index].desc_tipoprecio
						this.tempItem.equivalencia_id = this.form.items[index].equivalencia_id;
                        if(this.formato_ordenventa.valor==1){
                            this.tempItem.desc_tipoprecio = this.form.items[index].desc_tipoprecio
                        }
						this.tempItem.description_unidad = this.form.items[index].description_unidad;
						if (index > -1) {
							this.form.items[index] = this.tempItem;
						} else {
							this.form.items.push(this.tempItem);
						}
						this.initTempItem();
						this.calculateTotal();
					}
            },
			initTempItem() {

                this.tempItem = {
                    item_id: null,
                    item: {},
                    affectation_igv_type_id: null,
                    affectation_igv_type: {},
                    has_isc: false,
                    system_isc_type_id: null,
                    percentage_isc: 0,
                    suggested_price: 0,
                    quantity: 1,
                    unit_price: 0,
                    charges: [],
                    discounts: [],
                    attributes: [],
                }
            },
            close() {
                location.href = '/orders'
            },
            reloadDataCustomers(customer_id) {
                this.$http.get(`/${this.resource}/table/customers`).then((response) => {
                    this.customers = response.data
                    this.form.customer_id = customer_id
                })
            },
            changeName(data){

                if(data.changeName)
                {
                    this.form.changeName = data.changeName;
                    this.form.newName = data.newName;
                }
                else{
                    this.form.changeName = false;
                    this.form.newName = '';
                }

            },
        }
    }
</script>
