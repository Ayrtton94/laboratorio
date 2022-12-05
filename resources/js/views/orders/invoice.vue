npm<template>
    <div class="container-fluid m-0 pb-0 mt-1">
		<div class="page-header d-flex bd-highlight">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4 >Nueva Orden de Laboratorio</h4>
			</div>
        </div>
		<div class="card">
			<div class="card-body">
				<div class="row flex-row">

					<div class="col-xl-5 col-12">
						<div class="input-group input-group-lg border border-primary rounded">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fas fa-barcode text-secondary font-weight-bold fs-18"></i>
								</span>
							</div>
							<input type="text" class="form-control" id="searchbox"
                                :placeholder="searchCode ? 'Buscar productos por código' : 'Buscar productos por nombre o código'"
                                autofocus
								v-model="searchBox" refs="search"
								@keyup.enter="enterAddItem">
							<button type="button" class="btn" @click.prevent="searchBox = '';$refs.search.focus();"
								data-toggle="tooltip" title="Limpiar">
								<i class="fas fa-eraser text-info fs-18"></i>
							</button>
							<button type="button" class="btn" @click="typeList = ! typeList "  data-toggle="tooltip" title="Cambiar tipo de lista de Productos">
                                <i class="fa fa-list text-warning fs-18" v-if="typeList"></i>
                                <i class="fa fa-id-card-o text-primary fs-18" v-else></i>
                            </button>
						</div>
						<div class="mt-3 overflow-auto border border-primary rounded rounded-0 bg-gris">
							<div class="d-flex flex-row flex-wrap p-2" v-if="typeList">
								<div v-for="option in findItem" :key="option.id" class="card m-1 col-xl-3 col-sm-4 col-12"
									@click.prevent="option.stock>0 && selectItem(option.id)">

									<div class="card-header p-1 text-white" :class="option.stock > 0 ? 'bg-primary-400' : 'bg-warning' " >{{option.internal_id}} </div>

									<div class="card-body p-1 text-dark" style="width: 100%">
										<span class="font-weight-blod fs-span">
                                            {{option.description}}
                                            <small v-if="option.codigo_personalizado">({{option.codigo_personalizado}}-{{option.marca}})</small>
                                        </span> <br>
										<small>{{option.unit_type_id}}</small>
										<br>
										<p class="text-info font-weight-bold fs-11" v-if="option.stock>0" v-html="option.stock"></p>

										<p class="text-info font-weight-bold fs-11"   v-else >SIN STOCK</p>
<!--										<div v-if="muestraprecios.valor=='1'">-->
<!--											<div v-if="muestrapreciocompra.valor=='1' && admin==true">-->
<!--												<p class="text-success font-weight-bold fs-11">PRECIOS COMPRA</p>-->
<!--												<div v-for="valor in option.precios_compra" :key="valor.id">-->
<!--												<span class="font-weight-bold" style="font-size: 11px !important; color: #7481C9;">-->
<!--													{{valor.descripcion}} {{valor.unidad_medida_id}}:-->
<!--												</span>-->
<!--												<span class="font-weight-bold" style="font-size: 11px !important; color: rgb(233 13 13);">-->
<!--													{{valor.moneda.symbol}}{{formaterNumber(valor.precio,2)}}-->
<!--												</span>-->
<!--											</div>-->
<!--											</div>-->
<!--											<p class="text-success font-weight-bold fs-11">PRECIOS VENTA</p>-->
<!--											<div v-for="valor in option.precios_venta" :key="valor.id">-->
<!--												<span class="font-weight-bold" style="font-size: 11px !important; color: #7481C9;">-->
<!--													{{valor.descripcion}} {{valor.unidad_medida_id}}:-->
<!--												</span>-->
<!--												<span class="font-weight-bold" style="font-size: 11px !important; color: rgb(233 13 13);">-->
<!--													{{valor.moneda.symbol}}{{formaterNumber(valor.precio,2)}}-->
<!--												</span>-->
<!--											</div>-->

<!--										</div>-->
<!--										<div v-if="muestraprecios.valor=='0'">-->
<!--											<div v-if="muestrapreciocompra.valor=='1' && admin==true">-->
<!--												<p class="text-danger font-weight-bold fs-11">PRECIO COMPRA</p>-->
<!--												<span class="font-weight-bold text-primary">-->
<!--												{{option.currency_type_symbol}} {{ formaterNumber(option.purchase_unit_price, decimal) }}-->
<!--											</span>-->
<!--											</div>-->
<!--											<p class="text-success font-weight-bold fs-11">PRECIO VENTA</p>-->
<!--											<span class="font-weight-bold text-primary">-->
<!--												{{option.currency_type_symbol}} {{ formaterNumber(option.sale_unit_price, decimal) }}-->
<!--											</span>-->
<!--										</div>-->
									</div>
								</div>
							</div>
                            <div class="table-responsive table-responsive-md" style="font-size: 11px;" v-else>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th v-if="checkImages"></th>
                                            <th>CÓDIGO</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>PRECIOS</th>
                                            <th>CANT.</th>
                                            <th>PRECIO</th>
                                            <th>ACT.</th>

                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">

                                        <tr  v-for="(option, index) in findItem" :key="option.id" :class="option.stock>0 ? 'fs-td bg-white' : 'fs-td bg-warning-tr'">
                                            <td class="text-center fs-td" v-if="checkImages"><img :src="option.avatar" class="uploading-image" height="50" width="50"/></td>
                                            <td class="fs-td" v-text="option.internal_id"></td>
											<td class="fs-td" v-text="`${!option.codigo_personalizado ? '-' : option.codigo_personalizado} - ${option.description} - ( ${!option.marca ? '-' : option.marca })`"></td>
                                            <td class="fs-td">
                                                <div v-for="valor in option.precios_venta" :key="valor.id">
                                                    <span class="font-weight-bold" style="font-size: 11px !important; color: #7481C9;">
                                                         {{valor.tipoprecio.name}} - {{valor.moneda.symbol}}. {{valor.precio}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <el-input-number style="width: 100px;" v-model="option.quantity" size="mini" value="1" :min="1" @change="cambiarPrecio(option,index)"></el-input-number>
                                            </td>
                                            <td class="fs-td"> {{option.currency_type_symbol}} {{ formaterNumber(option.sale_unit_price, decimal) }}</td>
                                            <td class="text-center">
												<el-button-group>
													<el-button type="button" class="btn btn-sm btn-info" @click.prevent="AddItemList(option)"><i class="fa fa-plus"></i></el-button>
													<el-button type="button" class="btn btn-sm btn-success" @click.prevent="descItemList(option)"><i class="fa fa-pencil"></i></el-button>
												</el-button-group>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
					<div class="col-xl-7 col-12">
						<div class="card mb-0 shadow-0">
							<div class="card-body p-0 overflow-auto" style="height: 35vh;">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-sm m-0 p-0">
										<thead class="bg-dark">
										<tr>
											<th class="text-center">#</th>
											<th class="text-center w-50">Art.</th>
											<th class="text-center">UN.</th>
                                            <th class="text-center">CANT.</th>
											<th class="text-center">PU.</th>
											<th class="text-center">Total</th>
											<th class="text-center">Act</th>
										</tr>
										</thead>
										<tbody v-if="form.items.length > 0">
<!--											<tr v-for="(row, index) in form.items" :key="index">-->
<!--												<td class="fs-td">{{ index + 1 }}</td>-->
<!--												<td class="fs-td">-->
<!--													{{ row.item.description }} - {{ 'stock' }} : {{ row.item.stock }} &#45;&#45;-->
<!--													<span v-if="formato_ordenventa.valor==1 && row.item.marca">({{row.item.marca}})</span>-->
<!--													<br/>-->
<!--													<small>-->
<!--														{{ row.affectation_igv_type.description }}/{{ row.unit_type_id }}-->
<!--														{{ row.description_unidad}}-->
<!--													</small>-->
<!--													<br>-->
<!--													<div v-if="venta_multialmacen.valor == 1" class="float-right">-->
<!--														<el-select v-model="row.warehouse_id"  style="width: 250px;">-->
<!--															<el-option v-for="option in warehouses" :key="option.id" :value="option.id" :label="option.description"></el-option>-->
<!--														</el-select>-->
<!--													</div>-->

<!--												</td>-->
<!--                                                <td class="fs-td" style="width: 25px;">{{ row.item.desc_tipoprecio }}</td>-->
<!--												<td class="" >-->
<!--													<div id="outer" style="width:100%; text-align: center;">-->
<!--														<span class="inner" style="display: inline-block;" @click.prevent="disnimuirCantidad(row.item.id,index)">-->
<!--															<el-button type="button" class="btn btn-sm btn-warning">-</el-button>-->
<!--														</span>-->
<!--														<span class="inner" style="display: inline-block;">-->
<!--															<el-input class="touchspin1" style="width: 80px; top: 2px;" size="mini" v-model="row.quantity" @change="recalcularSubTotal(row.item.id,3,index)"></el-input>-->
<!--														</span>-->
<!--														<span class="inner" style="display: inline-block;" @click.prevent="agregarCantidad(row.item.id,index)">-->
<!--															<el-button type="button" class="btn btn-sm btn-info">+</el-button>-->
<!--														</span>-->
<!--													</div>-->
<!--												</td>-->
<!--												<td v-if="validarprecios.valor=='0'" class="text-right ">-->
<!--													<el-input class="touchspin1" size="mini" style="width: 80px;" v-model="row.unit_price" @change="recalcularSubTotal(row.item.id,3,index)" :readonly="! editar_precio"></el-input>-->
<!--												</td>-->
<!--												<td v-if="validarprecios.valor=='1'" class="text-right ">-->
<!--													<el-input class="touchspin1" size="mini" style="width: 80px;" v-model="row.unit_price" @change="modificarprecio(row.item.id,index)" :readonly="! editar_precio"></el-input>-->
<!--												</td>-->
<!--												<td class="text-center fs-td">-->
<!--													<div style="width: 80px;">{{ currency_type.symbol }} {{ formaterNumber(row.total) }}</div>-->
<!--												</td>-->
<!--												<td class="text-center pl-0 pr-0">-->
<!--													<el-button type="button" class="btn waves-effect waves-light btn-sm btn-danger" size="small" @click.prevent="clickRemoveItem(index)">x</el-button>-->
<!--												</td>-->
<!--											</tr>-->
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer overflow-auto bg-dark" >
								<div class="row">
									<div class="col-xs-3 col-sm-6 col-md-3">
										<div class="form-group" :class="{'has-danger': errors.currency_type_id}">
											<label class="control-label text-white">Moneda</label>
											<el-select v-model="form.currency_type_id" @change="changeCurrencyType" size="mini">
												<el-option v-for="option in currency_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
											</el-select>
											<small class="form-control-feedback" v-if="errors.currency_type_id" v-text="errors.currency_type_id[0]"></small>
										</div>
									</div>
									<div class="col-xs-3 col-sm-6 col-md-3">
										<div class="form-group" :class="{'has-danger': errors.exchange_rate_sale}">
											<label class="control-label text-white">Tipo de cambio
												<el-tooltip class="item" effect="dark" content="Valor obtenido de SUNAT" placement="top-end">
													<i class="fa fa-info-circle"></i>
												</el-tooltip>
											</label>
											<el-input v-model="form.exchange_rate_sale"></el-input>
											<small class="form-control-feedback" v-if="errors.exchange_rate_sale" v-text="errors.exchange_rate_sale[0]"></small>
										</div>
									</div>
									<div class="col-xs-3 col-sm-6 col-md-3">
										<div class="form-group mb-2">
											<label class="control-label text-white">Almacén</label>
											<el-select v-model="form.warehouse_id" size="mini">
												<el-option v-for="option in warehouses" :key="option.id" :value="option.id" :label="option.description"></el-option>
											</el-select>
											<small class="form-control-feedback" v-if="errors.warehouse_id" v-text="errors.warehouse_id[0]"></small>
											<br>
										</div>
									</div>
									<div class="col-xs-3 col-sm-6 col-md-3">
										<div class="form-group" :class="{'has-danger': errors.type_document_fact}">
											<label class="control-label text-white">Tipo Comprobante</label>
											<el-select v-model="form.type_document_fact" filterable
												clearable size="mini"
												class="border-left rounded-left border-info"
												popper-class="el-select-customers" dusk="type_document_fact">
												<el-option v-for="option in types" :key="option.id" :value="option.id" :label="option.description"></el-option>
											</el-select>
											<small class="form-control-feedback" v-if="errors.type_document_fact" v-text="errors.type_document_fact[0]"></small>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4">
										<div class="form-group" >
											<label class="control-label text-right font-weight-bold text-white">
												<el-checkbox v-model="searchCode" class="d-block font-weight-bold  text-white">Búscar solo por código</el-checkbox>
											</label>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-5">
										<customer-search :customer_id.sync="form.customer_id" :document_type_id.sync="form.type_document_fact" :width="true"
											:customersList.sync="customers" :document_type_03_filter="document_type_03_filter"
											:errors="errors" :showLabel="true"></customer-search>
										<small class="form-control-feedback" v-if="errors.type_document_fact" v-text="errors.type_document_fact[0]"></small>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3">
										<div class="form-group mb-2">
											<label class="control-label text-white">Nombre Cliente</label>
											<input type="text" class="form-control"  autofocus v-model="form.nombre_cliente" >
											<small class="form-control-feedback" v-if="errors.nombre_cliente" v-text="errors.nombre_cliente[0]"></small>
										</div>
									</div>
								</div>
								<div>
									<p class="text-right text-white mb-1" v-if="form.total_exportation > 0">
										OP.EXPORTACIÓN: {{ currency_type.symbol }} {{ form.total_exportation }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_free > 0">
										OP.GRATUITAS: {{ currency_type.symbol}} {{ form.total_free }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_unaffected > 0">
										OP.INAFECTAS: {{ currency_type.symbol }} {{ form.total_unaffected }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_exonerated > 0">
										OP.EXONERADAS: {{ currency_type.symbol }} {{ form.total_exonerated }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_taxed > 0">
										OP.GRAVADA: {{ currency_type.symbol }} {{ form.total_taxed }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_igv > 0">
										IGV: {{ currency_type.symbol }} {{ form.total_igv }}
									</p>
									<p class="text-right text-white mb-1" v-if="form.total_igv > 0">
										ICBPER: {{ currency_type.symbol }} {{ form.total_plastic_bag_taxes }}
									</p>
									<h4 class="text-right text-white mb-1" v-if="form.total > 0">
										<b>TOTAL A PAGAR: </b>{{ currency_type.symbol }} {{ form.total }}
									</h4>
								</div>
								<div class="row pt-1">
									<div class="col-xs-6 col-sm-6 col-md-6 mt-2">
										<el-button class="btn btn-danger btn-block fs-15" type="danger" size="mini" @click.prevent="close" native-type="button">
											<i class="fa fa-trash-o fs-15">  </i>&nbsp;&nbsp;Cancelar
										</el-button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 mt-2">
										<el-button class="btn btn-submit btn-block  btn-gradient-purple btn-fix fs-15"
											native-type="submit" :loading="loading_submit" size="mini"
											type="primary"  @click.prevent="submit" v-if="form.items.length > 0">
											<i class="fa fa-floppy-o fs-15">  </i>&nbsp;&nbsp;Procesar Pedido
										</el-button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <document-form-item :showDialog.sync="showDialogAddItem"
                            :operation-type-id="form.operation_type_id"
                            :currency-type-id-active="form.currency_type_id"
                            :exchange-rate-sale="form.exchange_rate_sale"
							:venta_multialmacen="venta_multialmacen"
                            :formato_ordenventa="formato_ordenventa"
                            @add="addRow"></document-form-item>

        <el-dialog  :visible.sync="modalprecios"
                :close-on-modal="false"
                :show-close="false"
				:close-on-click-modal="false"
                title="Seleccione el Precio"
                top="5vh" width="60%" @close="clear">
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-danger': errors.equivalencia_id}">
                        <label class="control-label">Precio Venta</label>
                        <el-select v-model="form.equivalencia_id"  filterable>
                            <el-option v-for="option in precios_venta" :key="option.id" :value="option.id"
                                :label="`${option.descripcion} ${option.unidad_medida_id} - ${option.tipoprecio.name} - ${option.moneda.symbol} - ${option.precio}`"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.equivalencia_id" v-text="errors.equivalencia_id[0]"></small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group" :class="{'has-danger': errors.unit_price}">
                        <label class="control-label">Precio Unitario</label>
                        	<el-input v-model="precio" @change="verificarprecio" :readonly="! editar_precio">
                            <template slot="prepend" v-if="monedaequivalencia">{{ monedaequivalencia.symbol }}</template>
                        </el-input>
                    </div>
                </div>
				<div class="col-lg-3">
					<div class="form-group" :class="{'has-danger': errors.warehouse_id}">
						<label class="control-label">Almacén</label>
						<el-select v-model="warehouse_id" style="font-size: 12px !important;">
							<el-option v-for="option in warehouses" :key="option.id" :value="option.id" :label="option.description"></el-option>
						</el-select>
					</div>
				</div>
				 <div class="col-md-3">
                    <div class="form-group" :class="{'has-danger': errors.stock_actual}">
                        <label class="control-label">Stock Actual</label>
                        <el-input  :value="stock_actual" readonly ></el-input>
                        <small class="form-control-feedback" v-if="errors.stock_actual" v-text="errors.stock_actual[0]"></small>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group" :class="{'has-danger': errors.quantity}">
                        <label class="control-label">Cantidad</label>
                        <el-input-number v-model="form.quantity"  ></el-input-number>
                        <small class="form-control-feedback" v-if="errors.quantity" v-text="errors.quantity[0]"></small>
                    </div>
                </div>
                <div class="col-md-3 col-12 mx-auto mt-3 form-inline">
                    <el-button  class="btn btn-info" native-type="button" type="button" v-if="form.equivalencia_id" @click.prevent="cerrarPrecio">Agregar</el-button>
					<el-button class="btn btn-danger" @click.prevent="closePrecios()">Salir</el-button>
                </div>
            </div>
       </el-dialog>

        <el-dialog :visible.sync="modalDescuentos"
                   :close-on-modal="false"
                   :show-close="true"
                   :close-on-click-modal="false"
                   top="4vh" width="60%">
            <div class="col-md-12 mt-3" >
                <section class=" mb-2 card-transparent card-collapsed" id="card-section" >
                    <header class="card-header hoverable  border-top rounded-0 py-1 border-info" data-card-toggle style="cursor: pointer;"
                            data-toggle="collapse" href="#card-sections" >
                        <div class="card-actions" style="margin-top: -12px;">
                            <a href="#" class="card-action card-action-toggle text-info"><i class="fa fa-angle-double-down  fs-18"></i></a>
                        </div>
                        <p class="pl-1 text-info font-weight-bolder">Añadir Descuento x Item</p>
                    </header>
                    <div class="card-body px-0" :class=" form.attributes.length > 0 ? '' : 'collapse' " id="card-sections"  style="overflow-y: auto;min-height:300px;">
                        <div class="col-md-12 px-0" v-if="discount_types.length > 0">
                            <label class="control-label text-danger">
                                Descuentos
                                <a href="#" class="text-danger" @click.prevent="clickAddItemDiscount">[+ Agregar]</a>
                            </label>
                            <div class="table-reponsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Porcentaje</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(row, index) in tempItem.discounts">
                                        <td>
                                            <el-select v-model="row.discount_type_id" @change="changeItemDiscountType(index)">
                                                <el-option v-for="option in discount_types" :key="option.id" :value="option.id" :label="option.description" :clearable="true" filterable></el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-input v-model="row.description"></el-input>
                                        </td>
                                        <td>
                                            <el-checkbox v-model="row.is_amount">Ingresar Monto</el-checkbox><br>
                                            <el-input v-model="row.monto" v-if="row.is_amount"></el-input>
                                            <el-input v-model="row.percentage" v-else></el-input>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger  btn-sm" @click.prevent="clickRemoveItemDiscount(index)">x</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-3 col-12 mx-auto mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <el-button class="btn btn-info"  @click.prevent="closeDescuentos()">Agregar</el-button>
                    </div>
                </div>
            </div>
        </el-dialog>
    </div>
</template>

<script>

    // import DocumentFormItem from './partials/item.vue';
    // import DocumentOptions from './partials/options.vue'
    // import {functions, exchangeRate} from '../../../mixins/functions'
    // import {calculateRowItem, checkEmptyObject, formaterNumber} from '../../../helpers/functions'
    // import Logo from '../companies/logo.vue'
	// import CustomerSearch from '../../../components/CustomerSearch'
    export default {
        // props: ['pos_station', 'pos_shift_id','checkalmacenprecio','almacen','sucursal','isadmin','molitalia','muestraprecios','validarprecios',
		// 	'venta_multialmacen','venta_multipagos','muestrapreciocompra','admin','inventory_configuration',
        //     'formato_ordenventa','impredirecta'],
        // components: {
        //       CustomerSearch, DocumentOptions, Logo
        // },
        // mixins: [functions, exchangeRate],
        data() {
            return {
                resource: 'orders',
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
                searchBox: '',
                showDialogNewItem: false,
                showDialogMakeSale: false,
                factura_d: {},
                informacion_adicional: {
                    general: [],
                    pagos: [
                        {tipo: 1, monto: '', cuenta : 1}
                    ]
                },
                items: [],
                warehouses: [],
                payment_methods: [],
                accounts: [],
                tempItem: [],
                tituloPago: "",
                affectation_igv_types: {},
				decimal: 2,
                model : '',
                types : [
					{ id: '01', description : 'FACTURA ELECTRÓNICA'},
					{ id: '03', description : 'BOLETA DE VENTA ELECTRÓNICA'},
					{ id: '100', description : 'NOTA DE VENTA'},
				],
                modalprecios : false,
                modalDescuentos: false,
                selecciono_precio : false,
				precios_venta:  [],
				editar_precio : false,
				precio : 0,
				stock_details : [],
				stock_number : 0,
				warehouse_id: null,
				unidad_equivalente : null,
                searchCode  : false,
                typeList : true,
                checkImages:false
            }
        },
        async created() {
            // if(this.formato_ordenventa.valor==1){
            //     this.typeList= false;
            // }
            await this.initForm();
            await this.initTempItem();
            await this.refreshItems();
            await axios.get(`/${this.resource}/tables`)
                .then(response => {
                    this.document_types = response.data.document_types_invoice2
                    this.currency_types = response.data.currency_types
                    this.establishments = response.data.establishments
                    this.operation_types = response.data.operation_types
                    this.all_series = response.data.series
					this.all_customers = response.data.customers
					this.customers = response.data.customers
                    this.discount_types = response.data.discount_types
                    this.charges_types = response.data.charges_types
                    this.company = response.data.company
                    this.document_type_03_filter = response.data.document_type_03_filter
                    this.warehouses = response.data.warehouses
                    this.payment_methods = response.data.payment_methods
                    this.accounts = response.data.accounts

					this.decimal = response.data.decimal;
					this.editar_precio = response.data.editar_precio;

                    this.form.currency_type_id = (this.currency_types.length > 0) ? this.currency_types[0].id : null
                    this.form.document_type_id = (this.document_types.length > 0) ? '104' : null
                    this.form.operation_type_id = (this.operation_types.length > 0) ? this.operation_types[0].id : null

                    this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null
                    this.form.warehouse_id = (this.warehouses.length > 0)? response.data.warehouse_id:null


                    this.changeEstablishment()
                    this.changeDateOfIssue()
                    this.changeDocumentType()
                    this.changeCurrencyType()
                })
            this.loading_form = true
            this.$eventHub.$on('changeName', (data) => {
                this.changeName(data)
            })

        },
		mounted(){
            const alertSucursal = document.querySelector('.alert-sucursal-almacen');
            if(alertSucursal){
                alertSucursal.style.display = 'none';
            }
			const alertCaja = document.querySelector('.alert-caja');
            if(alertCaja){
                alertCaja.style.display = 'none';
            }

            document.addEventListener('keydown', (event)=>{
				if(event.code == 'F2'){
					this.searchCode = ! this.searchCode;
				}
			}, false);
		},
        computed: {
			stock_actual(){

                const stockItem = this.stock_details.find(el=> el.warehouse_id == this.form.warehouse_id);//( this.venta_multialmacen.valor == 1 ? this.warehouse_id : this.form.warehouse_id));
				const eequivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});

                if(stockItem) {
                    if(eequivalencia){
						this.stock_number = `${stockItem.stock/ ( eequivalencia.factor<=0 ? 1 : eequivalencia.factor)}`;
                        return `${ _.round((stockItem.stock/ ( eequivalencia.factor<=0 ? 1 : eequivalencia.factor)),2)} - DE  ${ eequivalencia.descripcion}` ;
					}

                    this.stock_number = isNaN(stockItem.stock) ? 0 : stockItem.stock;
                    return   isNaN(stockItem.stock) ? 0 : stockItem.stock
                }
                return 0;
            },
			monedaequivalencia(){
				if(this.precios_venta.length == 1) return this.precios_venta[0].moneda;
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
                if(equivalencia ) return  equivalencia.moneda;

			},
            getActivePago(){
                return this.informacion_adicional.pagos.findIndex(el=> el.active ===1);
            },
            payment() {
                let pago = 0;
                _.forEach(this.informacion_adicional.pagos, function (p) {
                    if (p.monto > 0) {
                        pago += p.monto * 1;
                    }
                });
                return {
                    total: _.round((this.form.total), 2),
                    pagando: _.round(pago, 2),
                    delta: _.round((this.form.total - pago), 2)
                }
            },
            adicionalInfo() {
                let _currency = this.currency_type.symbol;
                let pagos = _.flatMap(this.informacion_adicional.pagos, function (p) {
                    let v = ' -- ';
                    v += p.tipo + ': ';
                    v += _currency + '.' + p.monto;
                    if (p.tipo !== 'Efectivo' && p.tipo !== '') {
                        v += ' - (Ref:' + (p.ref ? p.ref : '###') + ')';
                    }
                    return v;
                });

                return _.join([
                    'Forma de Pago:',
                    _.join(pagos, '|')
                ], '|');
            },
            findItem() {
                return this.items;
            }


        },
        watch: {
			'form.equivalencia_id' : function(){
				if(this.precios_venta.length == 1) return this.precios_venta[0].precio;
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
				this.unidad_equivalente = equivalencia;
                if(equivalencia ) this.precio =  equivalencia.precio;
                else this.precio =  0;
			},
            searchBox : function(oldVal,newVal){

                if(oldVal){
					if(oldVal.length> 2)
					{
						axios.post(`/orders/items`,{ search  :oldVal,warehouse_id : this.form.warehouse_id,
                            searchCode : this.searchCode}).then(({data}) => {
							let lista = data.items;
							// console.log(data.items);
							this.items = data.items;
						});
					}
                }else{
					this.items = [];
				}
            },
            "form.document_type_id": function () {
                this.titlePay();
            },
            "form.series_id": function () {
                this.titlePay();
            },
            "form.customer_id": function () {
                this.titlePay();
            },
            showDialogNewItem: function () {
                this.refreshItems();
            },
            'form.status_paid' : function(oldVal,newVval){

                if(oldVal==1){
                    // this.assignTotalPay();
                    this.form.dias_credito = 0
                    this.form.num_cuota = 0
                }
                if (oldVal == 2) {
                    // this.form.num_cuota = 1
                }
            },
            showDialogAttrib(){
                if(!this.showDialogAttrib){
                    axios.get(`/${this.resource}/productos/tables`).then(response => {
                        this.discount_types = response.data.discount_types
                        this.charge_types = response.data.charge_types
                        this.attribute_types = response.data.attribute_types
                    })
                }
            },

        },
        methods: {
            changeName(data) {

                if (data.changeName) {
                    this.form.changeName = data.changeName;
                    this.form.newName = data.newName;
                } else {
                    this.form.changeName = false;
                    this.form.newName = '';
                }

            },
			getStock(id){

				axios.get(`/productos/stock_details/${id}`)
				.then(response => {
						this.stock_details = response.data.stock_details
					}
				)
			},
            enterAddItem(e) {

                let lista = this.findItem;
                if (lista.length === 1) {
                    this.selectItem(lista[0].id);
                    this.searchBox = '';
                }
            },
            titlePay() {
                let document = _.find(this.document_types, {id: this.form.document_type_id});
                let serie = _.find(this.series, {id: this.form.series_id});
                let customer = this.form.customer_id ? _.find(this.customers, {id: this.form.customer_id}) : null;
                this.tituloPago = [
                    document ?document.description : null,
                    serie ? serie.number : null,
                    this.form.customer_id ? customer.description : ""
                ].join(' / ');
            },
            initForm() {
                this.errors = {}
                this.form = {
                    establishment_id : (this.establishments.length > 0)?this.establishments[0].id:null,//(this.establishments.length > 0) ? this.establishments[0].id : null,
               		warehouse_id :  (this.warehouses.length > 0)?this.warehouses[0].id:null,//(this.warehouses.length > 0) ? this.warehouses[0].id : null,
                    document_type_id: null,
					series_id: null,
					series: null,
                    number: '#',
                    // date_of_issue: moment().format('YYYY-MM-DD'),
                    // time_of_issue: moment().format('HH:mm:ss'),
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
                    // date_of_due: moment().format('YYYY-MM-DD'),
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
					nombre_cliente : '',
                    changeName : false,
                    newName : '',
                    newAddress : '',
                }
            },

            resetForm() {

                this.initForm()
                this.form.currency_type_id = (this.currency_types.length > 0) ? this.currency_types[0].id : null
                this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null
                this.form.warehouse_id = (this.warehouses.length > 0)?this.warehouses[0].id:null

                this.form.document_type_id = (this.document_types.length > 0) ? '104' : null
                this.form.operation_type_id = (this.operation_types.length > 0) ? this.operation_types[0].id : null
                this.changeEstablishment()
				this.changeWarehouse()
                this.changeDocumentType()
                this.changeDateOfIssue()
                this.changeCurrencyType()
                this.informacion_adicional.pagos = [
                    {tipo: 1, monto: '',cuenta : 1,active: 1}
                ]
            },
            changeEstablishment() {
                this.establishment = _.find(this.establishments, {'id': this.form.establishment_id})
                this.filterSeries()
            },
			changeWarehouse() {
               if(this.almacen.id > 0){
						this.form.warehouse_id = (this.warehouses.length > 0) ? this.almacen.id : null
				}else{
						this.form.warehouse_id = (this.warehouses.length > 0) ? this.warehouses[0].id: null
				}

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
                this.series = _.filter(this.all_series, {
                    'establishment_id': this.form.establishment_id,
                    'document_type_id': this.form.document_type_id
                })
				this.form.series_id = (this.series.length > 0) ? this.series[0].id : null
				this.form.series = (this.series.length > 0) ? this.series[0].number : null
            },
            filterCustomers() {

				this.form.customer_id = null
				this.customers = this.all_customers;
				let per = this.customers.find(el=> el.id == 1);
				if(per) this.form.customer_id = per.id;

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
					let rowIten =calculateRowItem(row, this.form.currency_type_id, this.form.exchange_rate_sale)
					rowIten.equivalencia_id =row.equivalencia_id;
					rowIten.description_unidad=row.description_unidad
					items.push(rowIten)
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
				let total_plastic_bag_taxes = 0
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
					total_plastic_bag_taxes += parseFloat(row.total_plastic_bag_taxes)
                });

                this.form.total_exportation = formaterNumber(total_exportation)
                this.form.total_taxed = formaterNumber(total_taxed)
                this.form.total_exonerated = formaterNumber(total_exonerated)
                this.form.total_unaffected = formaterNumber(total_unaffected)
                this.form.total_free = formaterNumber(total_free)
                this.form.total_igv = formaterNumber(total_igv)
                this.form.total_value = formaterNumber(total_value)
				this.form.total_taxes = formaterNumber(total_igv)
				this.form.total_plastic_bag_taxes = formaterNumber(total_plastic_bag_taxes)
                total =total + parseFloat(this.form.total_plastic_bag_taxes);
                this.form.total = formaterNumber(total)

                this.informacion_adicional.pagos[0].monto = this.form.total;

            },
            submit() {

				if(this.stockitembase()) {
					this.$message.warning("No puede procesar la orden porque no cuenta con stock necesario. Realice un ajuste o ingrese stock por medio de una compra")

                }else{

                this.loading_submit = true
				this.model = 'orders'
				this.table_name = 'orders'

					axios.post(`/${this.model}`, this.form).then(({data}) => {
						if (data.success) {
							this.$message.success(data.message);
							this.resetForm();
							this.loading_submit = false;

						} else {
							this.$message.error(data.message);
						}
					}).catch(error => {
						if (error.response.status === 422) {
							this.errors = error.response.data;
						} else {
							this.$message.error(error.response.data.message);
						}
							this.loading_submit = false;
					})

				}
		   },
            closePrecios() {
                this.modalprecios = false;
            },
            closeDescuentos() {
                this.modalDescuentos = false;
            },
            cambiarPrecio(option,index){

                if(option.quantity >= 3){
                    this.items.map(el=> {
                        if(el.id == option.id){

                            let precio_venta = Object.values(option.precios_venta)
                            let sale_price = precio_venta.filter(equi =>
                                {
                                    if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                        return equi.precio
                                    }
                                })
                            return el.sale_unit_price = sale_price[0].precio
                        }
                    })
                }
                if(option.quantity < 3){
                    this.items.map(el=> {
                        if(el.id == option.id){

                            let precio_venta = Object.values(option.precios_venta)
                            let sale_price = precio_venta.filter(equi =>
                                {
                                    if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                        return equi.precio
                                    }
                                })
                            return el.sale_unit_price = sale_price[0].precio
                        }
                    })
                }
            },
            AddItemList(option){

                let item_cant =option.quantity;
                if(item_cant < 3) {
                    this.tempItem.item.id = option.id
                    let precio_venta = Object.values(option.precios_venta)
                    let equi_precio = precio_venta.filter(equi =>
                                    {
                                        if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                            return equi.id
                                        }
                                    })
                    this.tempItem.item.equivalencia_id = equi_precio[0].id
                    this.form.quantity = option.quantity
                    this.form.warehouse_id = 1
                    this.selecciono_precio = true
                    this.selectItem(this.tempItem.item.id);
                }else{
                    this.tempItem.item.id = option.id
                    let precio_venta = Object.values(option.precios_venta)
                    let equi_precio = precio_venta.filter(equi =>
                                        {
                                            if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                return equi.id
                                            }
                                        })
                    this.tempItem.item.equivalencia_id = equi_precio[0].id
                    this.form.quantity = option.quantity
                    this.form.warehouse_id= 1
                    this.selecciono_precio = true
                    this.selectItem(this.tempItem.item.id);
                }
            },
            descItemList(option) {
                this.modalDescuentos = true;
            },
            close(){

                this.$confirm('¿Desea cancelar la venta actual?', 'Cancelar Venta', {
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    type: 'danger'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: 'La venta ha sido cancelada con exito'
                    });
                    this.showDialogMakeSale = false;
                    this.resetForm();

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Cancelacion suspendida'
                    });
                });
            },
			stockitembase(){
				var band = false;
					for(var i=0; i<this.form.items.length; i++){
						if(parseFloat(this.form.items[i].item.stock) <  parseFloat(this.form.items[i].quantity)){
							band = true;
						}
					}
				return band;

			},
            refreshItems() {

                this.items = [];

                axios.get(`/documentos/productos/tables`).then(response => {
                    this.affectation_igv_types = response.data.affectation_igv_types
                })
            },
            initTempItem() {
                this.errors = {}
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
            clickAddItemDiscount() {
                this.tempItem.discounts.push({
                    discount_type_id: null,
                    discount_type: null,
                    description: null,
                    percentage: 0,
                    factor: 0,
                    amount: 0,
                    base: 0,
                    is_amount : false,
                    monto: 0
                })
            },
            clickRemoveItemDiscount(index) {
                this.tempItem.discounts.splice(index, 1)
            },
            changeItemDiscountType(index) {
                let discount_type_id = this.tempItem.discounts[index].discount_type_id
                this.tempItem.discounts[index].discount_type = _.find(this.discount_types, {id: discount_type_id})
            },
            selectItem(id) {

				this.getStock(id);
				this.tempItem.item = _.find(this.items, {'id': id})

                this.precios_venta = this.getPreciosVenta(id);
				this.precios_compra = this.getPreciosCompra(id);
                if(this.precios_venta.length == 0){
                     this.$message.warning("Verificar, No tiene precios asignados para el almacén y Moneda seleccionada");
                }else{
					let index = -1;
					// es un código de equivalencia

					if(this.tempItem.item.type == 1  ){
						this.modalprecios = false;
						this.selecciono_precio = true;
						this.form.equivalencia_id = this.tempItem.item.equivalencia_id
						this.warehouse_id = this.form.warehouse_id;
					}
                    if(this.precios_venta.length > 1 && ! this.selecciono_precio){
                        this.modalprecios = true;
                        this.selecciono_precio = false;
						this.warehouse_id = this.form.warehouse_id;
                    }else{

						this.warehouse_id = this.warehouse_id ? this.warehouse_id : this.form.warehouse_id;
                        let uniType= this.getUnidadfinal(this.precios_venta,this.form.equivalencia_id);
                        if(typeof uniType ==='undefined' ) uniType =this.tempItem.item.unit_type_id;

                        index =  _.findIndex(this.form.items, {item: {id: id, unit_type_id : uniType } ,
                         equivalencia_id :this.form.equivalencia_id});

                        this.tempItem = Object.assign({}, this.tempItem, {unit_type_id : uniType })
                        this.tempItem.item = Object.assign({},this.tempItem.item, {unit_type_id : uniType })

                        if (index > -1) {

                            if( this.selecciono_precio){
                                this.tempItem = Object.assign({}, this.tempItem, {quantity : parseFloat(this.form.quantity) });
								this.tempItem.quantity = (parseFloat(this.tempItem.quantity) + parseFloat(this.form.items[index].quantity)).toFixed(3)

                            }else{

                                this.form.items[index].quantity = parseInt(this.form.items[index].quantity);
                                this.tempItem.quantity +=this.form.items[index].quantity;
                            }
                        }else{
                            if( this.selecciono_precio){

                                this.tempItem.quantity = parseFloat(this.form.quantity).toFixed(3) || 1;
                            } else{

								 this.tempItem.quantity =  1;
							}
						}

                        this.tempItem.id = this.tempItem.item.id

                        this.tempItem.unit_price = +this.precio  || +this.precios_venta[0].precio || + this.tempItem.item.sale_unit_price;

                        if(this.monedaequivalencia == undefined){
                            this.tempItem.item.currency_type_id = "PEN"
                        }else{
						    this.tempItem.item.currency_type_id = this.monedaequivalencia.id
                        }

                        this.tempItem.affectation_igv_type_id = this.tempItem.item.sale_affectation_igv_type_id

                        this.tempItem.item.unit_price =  +this.precio  || +this.precios_venta[0].precio || + this.tempItem.item.sale_unit_price;


                        this.tempItem.affectation_igv_type = _.find(this.affectation_igv_types, {'id': this.tempItem.affectation_igv_type_id})
                        this.tempItem.has_plastic_bag_taxes = (this.tempItem.item.has_plastic_bag_taxes)?true:false
						// this.tempItem = calculateRowItem(this.tempItem, this.form.currency_type_id, this.form.exchange_rate_sale)
						this.tempItem = Object.assign({},this.tempItem,{'item' : this.tempItem.item,'warehouse_id' : this.warehouse_id});
						this.tempItem.equivalencia_id = this.form.equivalencia_id;
						this.tempItem.warehouse_id = this.warehouse_id;
						this.tempItem.description_unidad = this.descripcionUnidad( )
                        if (index > -1) {
                            this.form.items[index] = this.tempItem;
                        } else {
                            this.form.items.unshift(this.tempItem);
							document.querySelector('#searchbox').focus();
                        }

                        this.initTempItem();
                        this.calculateTotal();
                        this.form.equivalencia_id = '';
                        this.form.quantity = 1;
                        this.modalprecios = false;
						this.selecciono_precio = false;
						this.items = [];
                        this.refreshItems();
						this.searchBox = '' ;
						this.warehouse_id = null;
                    }
                }


			},
			clear(){
				this.form.equivalencia_id = '';
				this.form.quantity = 1;
				this.modalprecios = false;
                this.modalDescuentos = false;
				this.selecciono_precio = false;
				this.items = [];
				this.searchBox = '' ;
			},
			descripcionUnidad(){
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});

                if(equivalencia )return equivalencia.descripcion;
			},
            calculateIgv(included_igv, affectation_igv_type_id, value){
                let price_array = calculateIgv(included_igv, affectation_igv_type_id, value)

                return price_array
            },
            formaterNumber(value, decimal){
                return formaterNumber(value, decimal);
			},
			disnimuirCantidad(id,index){
				this.recalcularSubTotal(id,2,index);
			},
			agregarCantidad(id,index){
                this.recalcularSubTotal(id,1,index);
            },
			modificarprecio(id,index){
				this.recalcularSubTotal(id,3,index);
			},
            reloadEmbed(){
				let iframe =  this.model=='notas-venta' ?  document.getElementById('embednota') : document.getElementById('embeddocument');
				const source = iframe.src
				let clone=iframe.cloneNode(true);
				clone.setAttribute('src',source);
				iframe.parentNode.replaceChild(clone,iframe)

            },
			// tipo 1 -> aumentar , 2 -> disminuir ,3 modificarprecio, 4 setear
			recalcularSubTotal(id,tipo,index){

				this.tempItem = this.form.items[index];
				let preciocomprafinal =0;
				let precioventafinal = 0;
				this.form.items[index] = Object.assign({}, this.form.items[index], {
						quantity :  parseFloat(this.form.items[index].quantity).toFixed(3)});
				if(this.validarprecios.valor=="1"){
					let preciocompra =  _.find(this.form.items[index].item.precios_compra, {'unidad_medida_equivalente_id': this.form.items[index].item.unit_type_id});

					preciocomprafinal = !preciocompra ? 0 : preciocompra.precio;
					const precioventa =  _.find(this.form.items[index].item.precios_venta, {'unidad_medida_equivalente_id': this.form.items[index].item.unit_type_id});
					precioventafinal = +precioventa.precio;
					if(!preciocomprafinal || preciocomprafinal==0){
						let factor = precioventa.factor;
						let preciocomprabase = this.form.items[index].item.preciobase == null ? 0 : this.form.items[index].item.preciobase.precio;
						if(!preciocomprabase || preciocomprabase==0){
								preciocomprabase = precioventa.precio- 1;
								preciocomprafinal = preciocomprabase;
						}else{
							preciocomprafinal =  factor * preciocomprabase;
						}

					}
				}
                if (index > -1) {
                    if(tipo==1){
						this.tempItem.quantity = parseFloat(this.form.items[index].quantity)  + 1;
                    }else if(tipo==2){
						this.tempItem.quantity = parseFloat(this.form.items[index].quantity)  -  1;
                    }else if(tipo==3){
							if(this.tempItem.unit_price < +preciocomprafinal){
								this.$message.warning('No puedes vender a un Precio menor,que el precio compra.');
							}
                    }else{
						this.tempItem.quantity = parseFloat(this.form.items[index].quantity);
					}
                }
                if(this.tempItem.quantity <= parseFloat(this.form.items[index].item.stock)){
                    if(this.tempItem.quantity<=0){
                        this.form.items.splice(index, 1)
                        this.calculateTotal()
                    }else{

                        this.tempItem.unit_type_id = this.form.items[index].unit_type_id;
                        this.tempItem.item.unit_type_id= this.form.items[index].unit_type_id;
                        this.tempItem.item.currency_type_id =this.form.items[index].currency_type_id;
							if(this.tempItem.unit_price <  +preciocomprafinal){
								this.tempItem.unit_price =precioventafinal;
                      		   this.tempItem.item.unit_price =precioventafinal;
							}else{

                               this.tempItem.unit_price =this.form.items[index].unit_price;
                               this.tempItem.item.unit_price =this.form.items[index].unit_price;

							}
                        this.tempItem.id = this.tempItem.item.id

                            this.tempItem.discounts = this.tempItem.discounts.map(el=>{
                                return {
                                    amount: 0,
                                    base: 0,
                                    description: el.description,
                                    discount_type: el.discount_type,
                                    discount_type_id:el.discount_type_id,
                                    factor: 0,
                                    is_amount:el.is_amount,
                                    percentage: el.percentage,
                                    monto : el.monto
                                }
                            });

                        this.tempItem.affectation_igv_type_id = this.tempItem.affectation_igv_type_id
                        this.tempItem.has_plastic_bag_taxes = this.tempItem.item.has_plastic_bag_taxes
                        this.tempItem.affectation_igv_type = _.find(this.affectation_igv_types, {'id': this.tempItem.affectation_igv_type_id})
                        // this.tempItem = calculateRowItem(this.tempItem, this.form.currency_type_id, this.form.exchange_rate_sale)
                        this.tempItem.equivalencia_id =this.form.items[index].equivalencia_id;

                        this.tempItem.description_unidad = this.form.items[index].description_unidad;
						this.tempItem.warehouse_id =this.form.items[index].warehouse_id;
                        if (index > -1) {
                            this.form.items[index] = this.tempItem;
                        } else {
                            this.form.items.push(this.tempItem);
                        }
                        this.initTempItem();
                        this.calculateTotal();
                    }
                }else{
						this.$message.warning(this.form.items[index].item.description + ' - ' + 'No se puede añadir porque no cuenta con stock necesario. Realice un ajuste o ingrese stock por medio de una compra.');

                        this.tempItem.unit_type_id = this.form.items[index].unit_type_id;
                        this.tempItem.item.unit_type_id= this.form.items[index].unit_type_id;
                        this.tempItem.item.currency_type_id =this.form.items[index].currency_type_id;
                        this.tempItem.unit_price =this.form.items[index].unit_price;
                        this.tempItem.item.unit_price =this.form.items[index].unit_price;


                        this.tempItem.id = this.tempItem.item.id
                        this.tempItem.affectation_igv_type_id = this.tempItem.affectation_igv_type_id
                        this.tempItem.has_plastic_bag_taxes = this.tempItem.item.has_plastic_bag_taxes
                        this.tempItem.affectation_igv_type = _.find(this.affectation_igv_types, {'id': this.tempItem.affectation_igv_type_id})
                        // this.tempItem = calculateRowItem(this.tempItem, this.form.currency_type_id, this.form.exchange_rate_sale)
                        this.tempItem.equivalencia_id =this.form.items[index].equivalencia_id;
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
            getPreciosVenta(idItem){

                const pro =  _.find(this.items, {'id': idItem});
                if(pro ){

					const result = Object.keys(pro.precios_venta).map(i => pro.precios_venta[i]);
                    //  si es 1, tomamos en cuuenta el almacén
					// if(this.checkalmacenprecio.valor == 1) return result.filter(el=> el.almacen_id == this.almacen);
					// else
                        return result;

                }
                return []
            },
			getPreciosCompra(idItem){
                const pro =  _.find(this.items, {'id': idItem});
                if(pro ){

					const result = Object.keys(pro.precios_compra).map(i => pro.precios_compra[i]);
					return result;

                }
                return []
            },
            cerrarPrecio(){
				if(this.stock_number <  parseFloat(this.form.quantity))
				{
					this.$message.warning('No puede añadir porque no cuenta con stock necesario. Realice un ajuste o ingrese stock por medio de una compra');
					return;
				}
				else{
					this.modalprecios = false;
               		this.selecciono_precio = true;
					this.selectItem(this.tempItem.item.id);

				}

            },
			// verificarprecio(){
			// 	if(this.validarprecios.valor=="1"){
			// 		const unidadmedida =  _.find(this.precios_venta, {'id': this.form.equivalencia_id}).unidad_medida_equivalente_id;
			// 		let preciocompra =  _.find(this.precios_compra, {'unidad_medida_equivalente_id':unidadmedida});
			// 		let precioventa =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
			// 		let preciocomprafinal = !preciocompra ? 0 : preciocompra.precio;
			// 		if(!preciocompra){
			// 			let factor = precioventa.factor ;
			// 			let preciocomprabase = this.items[0].preciobase.precio;
			// 			preciocomprafinal =  factor * preciocomprabase ;
			// 		}
			// 		if(+preciocomprafinal >= +this.precio)
			// 		{
			// 			this.$message.warning('No puedes vender a un Precio menor,que el precio compra.');
			// 			this.precio = +precioventa.precio ;
			// 			return;
			// 		}
			// 	}
            // },
            unidadfinal(){
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
                if(equivalencia )return equivalencia.unidad_medida_equivalente_id;
            },
            getUnidadfinal(precios,id){
                const equivalencia =  _.find(precios, {'id': id});
                if(equivalencia )return equivalencia.unidad_medida_equivalente_id;
            },
            recargarProductos(){
                this.refreshItems();
            },
            addMoney(monto){
                if(parseFloat(monto) > this.payment.pagando) this.setMoney(monto);
                else {
                    if(this.getActivePago== -1)  this.informacion_adicional.pagos[0].monto =parseFloat(parseFloat(this.informacion_adicional.pagos[0].monto) +  parseFloat(monto)).toFixed(2);
                    else this.informacion_adicional.pagos[this.getActivePago].monto =parseFloat(parseFloat(this.informacion_adicional.pagos[this.getActivePago].monto) +  parseFloat(monto)).toFixed(2);
                }
            },
            setMoney(monto){

                if(this.getActivePago== -1)this.informacion_adicional.pagos[0].monto =parseFloat(monto).toFixed(2);
                else this.informacion_adicional.pagos[this.getActivePago].monto =parseFloat(monto).toFixed(2);
            },
            addNewPago(){
                this.informacion_adicional.pagos.push({tipo:1,cuenta : 1,monto:this.payment.total - this.payment.pagando, active : 1});
                this.changeActive(this.informacion_adicional.pagos.length-1);
            },
            changeActive(i){
                this.informacion_adicional.pagos.map(el=> el.active = 0);
               this.informacion_adicional.pagos[i].active = 1;
            }  ,
            limpiarMoney(){
                if(this.getActivePago== -1)this.informacion_adicional.pagos[0].monto =parseFloat(this.payment.total).toFixed(2);
                else this.informacion_adicional.pagos[this.getActivePago].monto =parseFloat(this.payment.total - (this.payment.pagando-this.informacion_adicional.pagos[this.getActivePago].monto)).toFixed(2);
            }
        }
    }
</script>
<style lang="scss" >


	.h-number{
		height: 42px !important;
	}
	.bg-pos{
		background: rgb(70, 70, 70) !important;
	}
	@media only screen and (min-width: 300px) and (max-width: 820px){
		.h-number{
			height: 42px !important;
		}
	}

	.bg-dark, .bg-dark tr  {
		background: #1f496a !important;
	}
	.table thead th{
		background: #3183c1 !important;
		color : #ffffff  !important;
	}
	.border-primary {
		border-color: #3183c1 !important;
	}
	.fs-11{
		font-size: 12px;
	}
	.el-input--small {
    	font-size: 11px !important;
	}

	.el-select-dropdown__item {
		font-size: 12px;
	}

	.fs-td{
		font-size: 11px !important;
	}
	.fs-span{
		font-size: 11.5px;
		font-weight: bold;
	}
	.bg-warning-tr{
		background: #ff9c00ba !important;
		color: #fff;
	}
</style>
