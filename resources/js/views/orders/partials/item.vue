<template>
	<div>
		<el-dialog :title="titleDialog" :visible="showDialog" @open="create" @close="close" width="70%" append-to-body>
			<form autocomplete="off" @submit.prevent="clickAddItem">
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-danger': errors.item_id}">
								<label class="control-label">
									Producto/Servicio
									<a href="#"  v-show="hasPermissionTo('tenant.items.store')" class="text-info font-weight-bold mr-4"  @click.prevent="showDialogNewItem = true">[+ Nuevo]</a>
								</label>
								<el-checkbox v-model="checkListProductTable" >Ver Tabla - Stock</el-checkbox>
								<el-select v-model="form.item_id"
									@change="changeItem"
									filterable
									remote
									clearable
									placeholder="Búsqueda por descripción, Código, Marca, Familia"
									id="select-width"
									dusk="item_id"
									:remote-method="loadItems"

									 >
									<el-option v-for="option in itemsBack" :key="option.id" :value="option.id"
										:label=" checkListProductTable ? option.full_description : (option.internal_id + ' - ' + option.description )" >
										<span v-if="! checkListProductTable" v-text="option.internal_id + ' - ' + option.description "></span>
										<span v-else v-text="option.full_description"></span>
									</el-option>

								</el-select>




								<small class="form-control-feedback" v-if="errors.item_id" v-text="errors.item_id[0]"></small>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group" :class="{'has-danger': errors.affectation_igv_type_id}">
								<label class="control-label">Afectación Igv</label>
								<el-select v-model="form.affectation_igv_type_id" :disabled="!change_affectation_igv_type_id" filterable>
									<el-option v-for="option in affectation_igv_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
								</el-select>
								<el-checkbox v-model="change_affectation_igv_type_id">Editar</el-checkbox>
								<small class="form-control-feedback" v-if="errors.affectation_igv_type_id" v-text="errors.affectation_igv_type_id[0]"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-danger': errors.equivalencia_id}">
								<label class="control-label">Precio Venta</label>
								<el-select v-model="form.equivalencia_id"  filterable>
									<el-option v-for="option in precios_venta" :key="option.id" :value="option.id"
										:label="`${option.descripcion} ${option.unidad_medida_id} - ${option.tipoprecio.name}  - ${option.moneda.symbol}  `"></el-option>
								</el-select>
								<!-- <el-checkbox v-model="change_affectation_igv_type_id">Editar</el-checkbox> -->
								<small class="form-control-feedback" v-if="errors.equivalencia_id" v-text="errors.equivalencia_id[0]"></small>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="form-group" :class="{'has-danger': errors.unit_price}">
								<label class="control-label mr-2">Precio Unitario
									<el-checkbox v-model="dialogFormVisible" v-if=" ! autorizado ">Modificar</el-checkbox></label>
									<el-input v-model="form.unit_price" :readonly="! autorizado">
										<template slot="prepend" v-if="monedaequivalencia">{{ monedaequivalencia.symbol }}</template>
									</el-input>

								<small class="form-control-feedback" v-if="errors.unit_price" v-text="errors.unit_price[0]"></small>
							</div>
						</div>

						<div class="col-md-3 col-sm-6">
							<div class="form-group" :class="{'has-danger': errors.quantity}">
								<label class="control-label">Cantidad</label>
								<el-input-number v-model="form.quantity" :min="0.01"></el-input-number>
								<small class="form-control-feedback" v-if="errors.quantity" v-text="errors.quantity[0]"></small>
							</div>
						</div>

						<div class="col-md-3 col-sm-6">
							<div class="form-group" >
								<label class="control-label text-warning">Stock</label>
								<el-input :value="stock_actual" readonly  class="text-warning"></el-input>
							</div>
						</div>
						<br>
						<div class="col-md-12 col-sm-12" v-if=" form.item_id  && form.item.unit_type_id != 'ZZ' && stock_number <= 0" >
							<div class="alert" role="alert">
								<strong class="text-danger">PRODUCTO SIN STOCK</strong>
							</div>
						</div>
						<!-- <div class="col-md-3 center-el-checkbox">
							<div class="form-group" :class="{'has-danger': errors.has_igv}">
								<el-checkbox v-model="form.has_plastic_bag_taxes">Impuesto a la Bolsa Plástica</el-checkbox><br>
							</div>
						</div> -->

						<div class="col-md-12 mt-3" >
							<section class=" mb-2 card-transparent card-collapsed" id="card-section" >
								<header class="card-header hoverable  border-top rounded-0 py-1 border-info" data-card-toggle style="cursor: pointer;"
										data-toggle="collapse" href="#card-sections" >
									<div class="card-actions" style="margin-top: -12px;">
										<a href="#" class="card-action card-action-toggle text-info"><i class="fa fa-angle-double-down  fs-18"></i></a>
									</div>
									<p class="pl-1 text-info font-weight-bolder">Añadir atributos, descuentos y Cargos UBL 2.1</p>
								</header>
								<div class="card-body px-0" :class=" form.attributes.length > 0 ? '' : 'collapse' " id="card-sections"  style="overflow-y: auto;min-height:300px;">
									<div class="col-md-12 px-0" v-if="discount_types.length > 0">
										<label class="control-label text-danger">
											Descuentos
											<a href="#" class="text-danger" @click.prevent="clickAddDiscount">[+ Agregar]</a>
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
												<tr v-for="(row, index) in form.discounts">
													<td>
														<el-select v-model="row.discount_type_id" @change="changeDiscountType(index)">
															<el-option v-for="option in discount_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
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
														<button type="button" class="btn btn-danger  btn-sm" @click.prevent="clickRemoveDiscount(index)">x</button>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-12 px-0" v-if="charge_types.length > 0">
										<label class="control-label text-warning">
											Cargos
											<a href="#" class=" text-warning"  @click.prevent="clickAddCharge">[+ Agregar]</a>
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
												<tr v-for="(row, index) in form.charges">
													<td>
														<el-select v-model="row.charge_type_id" @change="changeChargeType(index)">
															<el-option v-for="option in charge_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
														</el-select>
													</td>
													<td>
														<el-input v-model="row.description"></el-input>
													</td>
													<td>
														<el-input v-model="row.percentage"></el-input>
													</td>
													<td>
														<button type="button" class="btn btn-danger  btn-sm" @click.prevent="clickRemoveCharge(index)">x</button>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-12 px-0" v-if="attribute_types.length > 0">
										<label class="control-label text-success">
											Atributos
											<a href="#" class="text-success" @click.prevent="clickAddAttribute">[+ Agregar]</a>

										</label>
										<a  class="btn  btn-sm btn-primary text-white" @click.prevent="clickCreateAttr">Nuevo Atributo</a>
										<div class="table-reponsive">
											<table class="table">
												<thead>
												<tr>
													<th>Tipo</th>
													<th>Descripción</th>
													<th></th>
												</tr>
												</thead>
												<tbody>
												<tr v-for="(row, index) in form.attributes">
													<td>
														<el-select v-model="row.attribute_type_id" filterable @change="changeAttributeType(index)">
															<el-option v-for="option in attribute_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
														</el-select>
													</td>
													<td>
														<el-input v-model="row.value"></el-input>
													</td>
													<td>
														<button type="button" class="btn btn-danger btn-sm" @click.prevent="clickRemoveAttribute(index)">x</button>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="form-actions text-right pt-2">
					<el-button @click.prevent="close()">Cerrar</el-button>
					<el-button class="add" type="primary" native-type="submit">Agregar</el-button>
				</div>
			</form>
			<item-form :showDialog.sync="showDialogNewItem"
					:external="true"></item-form>
		</el-dialog>
		<tribute-concept-types-form :showDialog.sync="showDialogAttrib"
										:recordId="null"></tribute-concept-types-form>
		<el-dialog title="Acceso - Autorizador" :visible.sync="dialogFormVisible" width="40%" @close="closeCredito"
			center lock-scroll :close-on-press-escape="false"  :close-on-click-modal="false" >
			<el-form :model="form2">
				<el-form-item label="Usuario" >
					<el-input v-model="form2.usuario_autorizador" autocomplete="off"></el-input>
				</el-form-item>
				<el-form-item label="Clave Autorizador" >
					<el-input v-model="form2.clave_autorizador" autocomplete="off" type="password"></el-input>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="closeCredito">Cancel</el-button>
				<el-button type="success" @click="validarAutorizacion">Autorizar</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>

    import itemForm from '../../items/form.vue'
    import {calculateRowItem} from '../../../../helpers/functions'
    import ElCheckbox from "../../../../../../node_modules/element-ui/packages/checkbox/src/checkbox";
	import TributeConceptTypesForm from '../../attribute_types/form.vue'
    export default {
        props: ['showDialog', 'operationTypeId', 'currencyTypeIdActive', 'exchangeRateSale', 'price_list_id','almacen','moneda',
            'checkalmacenprecio','currency_type','isadmin','control_stock','customer_id','formato_ordenventa'],
        components: {
            ElCheckbox,
			itemForm,
			TributeConceptTypesForm},
        // mixins: [formDocumentItem],
        data() {
            return {
                titleDialog: 'Agregar Producto o Servicio',
                resource: 'documentos',
				showDialogNewItem: false,
				showDialogAttrib : false,
				dialogFormVisible : false,
                errors: {},
                form: {},
                items: [],
                operation_types: [],
                all_affectation_igv_types: [],
                affectation_igv_types: [],
                system_isc_types: [],
                discount_types: [],
                charge_types: [],
                attribute_types: [],
                use_price: 1,
                change_affectation_igv_type_id: false,
				stock_details : [],
				stock_number : 0,
				autorizado :!!  this.isadmin,
				itemsBack : [],
				form2 : {
					usuario_autorizador : '',
					clave_autorizador : '',
				},
				checkListProductTable  : false,
				input : '',

				precios_cliente: []
            }
        },
        created() {
            this.initForm()
            this.$http.get(`/${this.resource}/productos/tables`).then(response => {
				this.items = response.data.items
				this.itemsBack = response.data.items
                this.operation_types = response.data.operation_types
                this.all_affectation_igv_types = response.data.affectation_igv_types
                this.system_isc_types = response.data.system_isc_types
                this.discount_types = response.data.discount_types
                this.charge_types = response.data.charge_types
                this.attribute_types = response.data.attribute_types
            })

            this.$eventHub.$on('reloadDataItems', (item_id) => {
                this.reloadDataItems(item_id)
			})
			this.stock_details = [];
        },
        methods: {

            initForm() {
                this.errors = {}
                this.form = {
//                    category_id: [1],
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
                    has_plastic_bag_taxes:false,
                    equivalencia_id:  '',
                }
            },
            // initializeFields() {
            //     this.form.affectation_igv_type_id = this.affectation_igv_types[0].id
            // },
            create() {

                let operation_type = _.find(this.operation_types, {id: this.operationTypeId})
				this.affectation_igv_types = _.filter(this.all_affectation_igv_types, {exportation: operation_type.exportation})
				this.precios_cliente = [];
				if(this.customer_id && this.customer_id != 1){
					this.$http.post(`/productos/precios_cliente/${this.form.item_id}`,{ customer_id : this.customer_id })
					.then(response => {
							this.precios_cliente = response.data.precios

						}
					)
				}
            },
            clickAddDiscount() {
                this.form.discounts.push({
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
            clickRemoveDiscount(index) {
                this.form.discounts.splice(index, 1)
            },
            changeDiscountType(index) {
                let discount_type_id = this.form.discounts[index].discount_type_id
                this.form.discounts[index].discount_type = _.find(this.discount_types, {id: discount_type_id})
            },
            clickAddCharge() {
                this.form.charges.push({
                    charge_type_id: null,
                    charge_type: null,
                    description: null,
                    percentage: 0,
                    factor: 0,
                    amount: 0,
                    base: 0
                })
            },
            clickRemoveCharge(index) {
                this.form.charges.splice(index, 1)
            },
            changeChargeType(index) {
                let charge_type_id = this.form.charges[index].charge_type_id
                this.form.charges[index].charge_type = _.find(this.charge_types, {id: charge_type_id})
            },
            clickAddAttribute() {
                this.form.attributes.push({
                    attribute_type_id: null,
                    description: null,
                    value: null,
                    start_date: null,
                    end_date: null,
                    duration: null,
                })
            },
            clickRemoveAttribute(index) {
                this.form.attributes.splice(index, 1)
            },
            changeAttributeType(index) {
                let attribute_type_id = this.form.attributes[index].attribute_type_id
                let attribute_type = _.find(this.attribute_types, {id: attribute_type_id})
                this.form.attributes[index].description = attribute_type.description
            },
            close() {
                this.initForm()
                this.$emit('update:showDialog', false)
            },
            changeItem() {
				this.autorizado = !!  this.isadmin;
				if(this.form.item_id){
					this.form.item = _.find(this.items, {'id': this.form.item_id})

					this.form.affectation_igv_type_id = this.form.item.sale_affectation_igv_type_id
                    // this.form.affectation_igv_type_id = this.form.item.purchase_affectation_igv_type_id
					this.form.has_plastic_bag_taxes = (this.form.item.has_plastic_bag_taxes)?true:false
				}

            },
            clickAddItem() {

				if(!this.form.equivalencia_id){
					this.$message.error("Seleccione un precio venta, caso contrario deberá registrar en la opción de producto.");
					return ;
				}
				if( this.form.unit_price <=0){

					this.$message.warning("Debe Seleccionar un precio de mayor a 0");
					return;
				}

				if(this.control_stock){
					if(this.form.item.item_type_id == '01'  &&  +this.stock_number<=0){
						this.$message.warning("El producto que no tiene Stock Suficiente. Verifique su stock");
						return ;
					}
				}

                const unidadFinal =  this.unidadfinal();

                this.form = Object.assign({}, this.form, {unit_type_id : unidadFinal })
                //this.form.item = Object.assign({}, this.form.item, {unit_type_id : unidadFinal })
				this.form.item.unit_price = this.form.unit_price;

				this.form.item.currency_type_id = this.monedaequivalencia.id;
                this.form.affectation_igv_type = _.find(this.affectation_igv_types, {'id': this.form.affectation_igv_type_id})
				this.row = calculateRowItem(this.form, this.currencyTypeIdActive, this.exchangeRateSale);
				this.row.mercado_especial =  this.form.item.mercado_especial;
				this.row.equivalencia_id = this.form.equivalencia_id;
                if(this.formato_ordenventa.valor==1) {
                    let precios = Object.values(this.form.item.precios_venta)
                    let name_precio = precios.filter(el => {
                        if (el.id == this.form.equivalencia_id) {
                            return el.desc_tipoprecio
                        }
                    })
                    this.row.desc_tipoprecio = name_precio[0].desc_tipoprecio
                }
				this.row.description_unidad = this.descripcionUnidad(this.form.equivalencia_id);
				this.row.edit = false;
                this.initForm()

                this.$emit('add', this.row)
            },
            reloadDataItems(item_id) {
                // this.$http.get(`/${this.resource}/table/items`).then((response) => {
                //     this.items = response.data
                //     this.form.item_id = item_id
                //     this.changeItem()
				// })
				// this.$http.get(`/${this.resource}/table/items`).then(({data}) => {
                //     this.items =data.items;
                //     this.form.item_id = item_id
                //     this.changeItem()
                // })
			},
			loadItems(query) {
				if(query && query.length> 2){
					this.$http.post(`/${this.resource}/items`,{search : query})
					.then(({data})=>{
						this.items = data;
						this.itemsBack = data;
					});
				}
			},
			loadItems2(queryString, cb) {
				if(queryString && queryString.length> 2){
					this.$http.post(`/documentos/items`,{search : queryString})
					.then(({data})=>{
						this.items = data;
						this.itemsBack = data;
					});
				}

            },
            unidadfinal(){
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});

                if(equivalencia )return equivalencia.unidad_medida_equivalente_id;
			},
			descripcionUnidad(){
                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});

                if(equivalencia )return equivalencia.descripcion;
			},
			clickCreateAttr() {

                this.showDialogAttrib = true
			},
			validarAutorizacion(){
				this.$http.post('/autorizar/users',this.form2)
					.then(({data})=>{
						if(data.success){
							this.$message.success(data.message);
							this.autorizado = true;
							this.form2.usuario_autorizador = '';
							this.form2.clave_autorizador = '';
							this.dialogFormVisible = false;
						}
						else{
							this.autorizado = false;
							this.$message.error(data.message);
						}
					})
					.catch(error=>{
						console.log(error);
					})
			},
			closeCredito(){

				this.dialogFormVisible = false;
				this.form2.usuario_autorizador = '';
				this.form2.clave_autorizador = '';
			}
        },
        computed : {
            precios_venta(){
                const pro =  _.find(this.items, {'id': this.form.item_id});
                if(pro ){
                    const result = Object.keys(pro.precios_venta).map(i => pro.precios_venta[i]);
                    //  si es 1, tomamos en cuuenta el almacén
                    //if(this.checkalmacenprecio.valor == 1) return result.filter(el=> el.almacen_id == this.almacen && el.moneda_id == this.moneda);
					if(this.checkalmacenprecio.valor == 1) return result.filter(el=> el.almacen_id == this.almacen);
					//else return result.filter(el=> el.moneda_id == this.moneda);
					else return result;
                }
                this.form.equivalencia_id = null;
                return []
			},
			equivalencias(){
				const pro =  _.find(this.items, {'id': this.form.item_id});
				 if(pro ) return pro.equivalencias;
				 return [];
            },
            precio(){


                const equivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
                if(equivalencia )return equivalencia.precio;
                return 0;
            },
           stock_actual(){

                const stockItem = this.stock_details.find(el=> el.warehouse_id == this.almacen);
				const eequivalencia =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
                if(stockItem) {
                    if(eequivalencia){
						this.stock_number = _.round(`${stockItem.stock/ ( eequivalencia.factor<=0 ? 1 : eequivalencia.factor)}`);
                        return `${ _.round((stockItem.stock/ ( eequivalencia.factor<=0 ? 1 : eequivalencia.factor)),2)} - DE  ${ eequivalencia.descripcion}` ;
					}

                    return   isNaN(stockItem.stock) ? 0 : stockItem.stock
                }
                return 0;
			},
			monedaequivalencia(){
				const equi =  _.find(this.precios_venta, {'id': this.form.equivalencia_id});
				if(equi){
					return equi.moneda;
				}
				return this.currency_type;
			}
        },
        watch : {
            'form.equivalencia_id': function(oldVal,newVal){


				const val = oldVal ? oldVal : newVal;
				const equivalenciaProducto =  _.find(this.precios_cliente, {'equivalencia_id':val});
				if(equivalenciaProducto ) this.form.unit_price = equivalenciaProducto.precio;

				else{
					const equivalencia =  _.find(this.precios_venta, {'id':val});
					this.form.unit_price = equivalencia ? equivalencia.precio : 0;
				}



            },
            'form.item_id': function(oldVal,newVal){
                if(oldVal){
					if(this.form.item_id){
						let itemSearch = this.items.find(el=> el.id == this.form.item_id);
						if(itemSearch.type && itemSearch.type== 1){
							this.form.equivalencia_id = itemSearch.equivalencia_id;

						}
						else{
							if(this.precios_venta.length >0){
								this.form.equivalencia_id = this.precios_venta[0].id;
							}
							else{
								this.form.unit_price  = 0;
							}
						}
						this.form.attributes=itemSearch.attributes;
						this.changeItem();
						this.$http.get(`/productos/stock_details/${this.form.item_id}`)
						.then(response => {
								this.stock_details = response.data.stock_details
							}
						)



					}
                }

			},
			showDialogAttrib(){
				if(!this.showDialogAttrib){
					this.$http.get(`/${this.resource}/productos/tables`).then(response => {
						this.discount_types = response.data.discount_types
						this.charge_types = response.data.charge_types
						this.attribute_types = response.data.attribute_types
					})
				}
			},
            'form.quantity' : function(oldVal,newVal){
                // debugger;
                if(this.formato_ordenventa.valor==1) {
                    if (oldVal >= 3) {
                        this.items.map(el => {
                            if (el.id == this.form.item_id) {
                                if (this.precios_venta.length > 0) {
                                    // this.form.unit_price = this.precios_venta[1].precio
                                    let unitprice = this.precios_venta.filter(equi =>
                                                {
                                                    if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                        return equi.precio
                                                    }
                                                })
                                    this.form.unit_price = unitprice[0].precio
                                    // this.form.equivalencia_id = this.precios_venta[1].id;
                                    let equiprice = this.precios_venta.filter(equi =>
                                                {
                                                    if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "X MAYOR"){
                                                        return equi.id
                                                    }
                                                })
                                    this.form.equivalencia_id = equiprice[0].id
                                } else {
                                    this.form.unit_price = 0;
                                }
                            }
                        })
                    }
                    if (oldVal < 3) {
                        this.items.map(el => {
                            if (el.id == this.form.item_id) {
                                if (this.precios_venta.length > 0) {
                                    // this.form.unit_price = this.precios_venta[0].precio
                                    let unitprice = this.precios_venta.filter(equi =>
                                                    {
                                                        if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                            return equi.precio
                                                        }
                                                    })
                                    this.form.unit_price = unitprice[0].precio
                                    // this.form.equivalencia_id = this.precios_venta[0].id;
                                    let equiprice = this.precios_venta.filter(equi =>
                                                    {
                                                        if(!!equi.desc_tipoprecio && equi.desc_tipoprecio === "GENERAL"){
                                                            return equi.id
                                                        }
                                                    })
                                    this.form.equivalencia_id = equiprice[0].id
                                } else {
                                    this.form.unit_price = 0;
                                }
                            }
                        })
                    }
                }
            }


        }
    }

</script>
