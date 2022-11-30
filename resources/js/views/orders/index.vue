<template>
    <div>
		<div class="page-header d-flex bd-highlight">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4>Órdenes de Venta
					<button v-if="this.orden_list.valor==1" type="button" class="btn" @click="getOrders"  title="Recargar">
						<i class="fa fa-refresh text-warning fs-18"></i>
					</button>
				</h4>

				<span v-if="this.orden_list.valor==0" class="d-block"> Genere pedidos / órdenes de venta para sus clientes, Luego podrá generar un comprobante directo.</span>
			</div>
            <div v-show="hasPermissionTo('tenant.orders.store')" class="mr-3">
                <a :href="`/${resource}/crear`" class="btn btn-custom btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a>
            </div>
        </div>
        <div class="card mb-0 w-100 mt-3">
			<div class="card-body p-0" v-if="this.orden_list.valor==1">
				<div class="row">
					<div class="col-md-3 pr-3 pl-3 pb-2">
						<div class="demo-input-suffix">
							<el-input size="mini" id="input_lg" placeholder="BUSCAR PEDIDOS" prefix-icon="el-icon-search" v-model="search"></el-input>
						</div>
					</div>
					<div class="col-md-3 pr-3 pl-3 pb-2">
						<el-select size="mini" v-model="estadosOrderSelect"  @change="selectEstadosOrder" placeholder="Estados Pedidos">
							<el-option v-for="statusOrder in estadosOrder" :key="statusOrder.id" :label="statusOrder.name" :value="statusOrder.id"></el-option>
						</el-select>
					</div>
					<div class="col-md-3 pr-3 pl-3 pb-2">
						<div class="form-group">
							<el-date-picker v-model="fecha_inicio" size="mini" type="date" style="width: 100%;" placeholder="Buscar" value-format="yyyy-MM-dd"></el-date-picker>
						</div>
					</div>
					<div class="col-md-3 pr-3 pl-3 pb-2">
						<div class="form-group">
							<el-date-picker v-model="fecha_fin" size="mini" type="date" style="width: 100%;" placeholder="Buscar" value-format="yyyy-MM-dd"></el-date-picker>
						</div>
					</div>
				</div>
				<div class="pt-2 pb-2" id="idgaleria" style="width: 100%;">
					<div class="card-body p-0 sombra-curv-fondo">
						<div class="row-cols-1 row-cols-md-1 card-padre" style=" overflow-y: scroll; ">
							<div class="row pl-3">
								<div v-for="pedidos in recordOrderAll" :key="pedidos.id" class="col-6 col-sm-4 col-md-3 col-xl-2 mb-1 p-1">
									<div class="card zoom" :class="pedidos.type_document_fact == '03' ? 'text-warning-fact' : 'text-success-fact'" style="height: 100% !important;">
										<a :href="pedidos.estado==1 ? `/documentos/create3/`+pedidos.id : '#' " class="hover_none">
											<div class="card-body p-0 text-center">
												<h5 class="font-weight-bold card-text titulo-card">
													{{ pedidos.number }}
													<div class="row" style="margin-left: auto !important; flex-wrap: inherit !important;">
														<div class="col-md-6 pr-1">
															<a v-if="pedidos.estado==1" :href="`/orders/editar/`+pedidos.id">
																<el-button type="primary" icon="el-icon-edit" circle></el-button>
															</a>
														</div>
														<div class="col-md-6 pr-3 pl-0">
															<el-button type="danger" v-if="pedidos.estado==1" @click.prevent="clickDelete(pedidos.id)" icon="el-icon-delete" circle></el-button>
														</div>
													</div>
												</h5>
												<p class="font-weight-bold card-text mt-0 mb-0 ">{{ pedidos.nombre_cliente == "" ? pedidos.customer_name : pedidos.customer_number == '00000000' ? pedidos.nombre_cliente : pedidos.customer_name}}</p>
											</div>
											<div class="card-footer bg-success-lr text-black font-weight-bold text-center p-1 fs_ft">
												{{ pedidos.total }}
                                                <el-button type="warning"  class="float-right" @click.prevent="clickOptions(pedidos.id)"
                                                            circle>
                                                    <i class="fa fa-ticket "></i>
                                                </el-button>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body" v-else>
                <data-table :resource="resource" :showAtendidos="true" :showReload="true" :showEliminados="true">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">Fecha Emisión</th>
						<th class="text-center">Hora</th>
						<th>Usuario</th>
                        <th>Cliente</th>
                        <th>Número</th>
                        <th class="text-center">Moneda</th>
                        <th class="text-right">Total</th>
						<th class="text-right">Nombre</th>
						<th class="text-right">Tipo</th>
						<th class="text-right">Estado</th>
						<th class="text-right">Observaciones</th>
                        <th class="text-right">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" slot="tbody" :class="{
                                                    'text-danger': (row.state_type_id === '11'),
                                                    'text-warning': (row.state_type_id === '13'),
                                                    'border-light': (row.state_type_id === '01'),
                                                    'border-left border-info': (row.state_type_id === '03'),
                                                    'border-left border-success': (row.state_type_id === '05'),
                                                    'border-left border-secondary': (row.state_type_id === '07'),
                                                    'border-left border-dark': (row.state_type_id === '09'),
                                                    'border-left border-danger': (row.state_type_id === '11'),
                                                    'border-left border-warning': (row.state_type_id === '13')
                    }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
						<td class="text-center">{{ row.time_of_issue }}</td>
						<td >{{ row.usuario }}</td>
                        <td>{{ row.customer_name }}<br/><small v-text="row.customer_number"></small></td>
                        <td>{{ row.number }}</td>

                        <td class="text-center">{{ row.currency_type_id }}</td>
                        <td class="text-right">{{ row.total }}</td>
						<td class="text-right">{{ row.nombre_cliente }}</td>
						<td class="text-right">
							<span class="badge  text-white bg-primary" v-if="row.tipo == 1">Pedido</span>
                            <span class="badge  text-white bg-secondary" v-if="row.tipo ==2">Tienda Virtual</span>
						</td>
						<td class="text-right">
							<span class="badge  text-white bg-info" v-if="row.estado == 1">Pendiente</span>
                            <span class="badge  text-white bg-success" v-if="row.estado ==2">Atendida</span>
							<span class="badge  text-white bg-danger" v-if="row.estado ==0">Eliminada</span>
						</td>
						<td class="text-right" v-html="row.observaciones"></td>
                        <td class="text-right" >
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown" v-if="row.estado == 1">

								<button id="btnGroupDrop1" type="button" class="btn  btn-sm  btn-pink dropdown-toggle dropdown-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Opciones
								</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
									<a v-show="hasPermissionTo('tenant.documents.store')" v-if="row.estado==1" class="dropdown-item" :href="`/documentos/create3/`+row.id">
										<i class="ti-layers-alt i-icon text-primary"></i> Crear venta</a>
									<a v-show="hasPermissionTo('tenant.orders.update')" v-if="row.estado==1" class="dropdown-item" :href="`/orders/editar/`+row.id">
										<i class="fa fa-pencil i-icon text-info"></i> Editar</a>
                                    <button v-show="hasPermissionTo('tenant.orders.update')"
                                        class="dropdown-item" @click.prevent="clickOptions(row.id)">
                                        <i class="fa fa-print i-icon text-warning"></i> Imprimir</button>
									<a v-show="hasPermissionTo('tenant.orders.update')" v-if="row.estado==1" class="dropdown-item" @click.prevent="clickDelete(row.id)" >
										<i class="fa fa-trash-o i-icon text-danger"></i> Eliminar</a>

								</div>

                            </div>
                        </td>
                    </tr>
                    <div class="row col-md-12 justify-content-center" slot-scope="{ totals }" slot="totals">
                        <div class="col-md-3" v-if="totals.totalPEN">
                            <h5><strong>Total órdenes en soles ({{ totals.totalPEN.quantity}}) </strong>S/. {{ totals.totalPEN.total }}</h5>
                        </div>
                        <div class="col-md-3" v-if="totals.totalUSD">
                            <h5><strong>Total órdenes en dólares ({{ totals.totalUSD.quantity}}) </strong>$ {{ totals.totalUSD.total }}</h5>
                        </div>
                    </div>
                </data-table>
            </div>
            <orders-voided :recordId="recordId"
                           :showDialog.sync="showDialogVoided"></orders-voided>

            <quotation-options :recordId="recordId"
                               :showClose="true"
                               :showDialog.sync="showDialogOptions"></quotation-options>

            <document-options :recordId="recordId"
                              :showClose="false"
                              :impredirecta="impredirecta"
                              :showDialog.sync="showDialogOptions" :showError="true"></document-options>

        </div>
    </div>
</template>

<script>
	import moment from 'moment'
    import ordersVoided from './partials/voided.vue'
    import QuotationOptions from './partials/options.vue'
    import DocumentOptions from './partials/options.vue'
    import DataTable from '../../../components/DataTable.vue'
	import {deletable} from '../../../mixins/deletable'
    export default {
		mixins: [deletable],
		props: ['formato_ordenventa','impredirecta','orden_list'],
        components: {ordersVoided, QuotationOptions, DocumentOptions, DataTable},
        data() {
            return {
                showDialogVoided: false,
                resource: 'orders',
                recordId: null,
				showDialogOptions: false,
				orderVenta: [],
				estadosOrderSelect: 1,
				fecha_inicio: moment().format('YYYY-MM-DD'),
				fecha_fin: moment().format('YYYY-MM-DD'),
				estadosOrder: [
					{id: 1, name: 'REGISTRADOS'},
					{id: 2, name: 'ATENDIDOS'},
					{id: 3, name: 'ELIMINADOS'}
				],
				search: '',
				interval: null
            }
        },
        created() {
			if(this.orden_list.valor==1){
				this.getOrders();
			}
        },
        methods: {
			refreshPage(){
				if(this.orden_list.valor==1){
					this.getOrders()
				}else{
					this.$eventHub.$emit('reloadData')
				}
			},
			getOrders(){
				const formSearch = { order_id: this.estadosOrderSelect, fecha_inicio: this.fecha_inicio, fecha_fin: this.fecha_fin };
				this.$http.post(`/${this.resource}/orderall`, formSearch)
				.then(response => {
						this.orderVenta = response.data.data;
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message)
                    })
			},
			selectEstadosOrder(){
				this.getOrders();
			},
            clickVoided(recordId = null) {
                this.recordId = recordId
                this.showDialogVoided = true
            },
            clickDownload(download) {
                window.open(download);
            },
			 clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
					this.refreshPage()
                )
			},
            clickCreateSale(download) {
                window.open(download, '_blank');
            },
            clickResend(quotation_id) {
                this.$http.get(`/${this.resource}/send/${quotation_id}`)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message)
                    })
            },
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },
        },
		watch: {
			search(){
                if(this.search && this.search.length > 2){
					const formSearch = { search: this.search, order_id: this.estadosOrderSelect, fecha_inicio: this.fecha_inicio, fecha_fin: this.fecha_fin };
					this.$http.post(`/${this.resource}/AllOrder`, formSearch)
                    .then(res => {
						this.orderVenta = res.data.data;
                    });
                }
                else if(this.search.length==0){
                    this.getOrders();
                }
            }
		},
		computed : {
			recordOrderAll(){
				return this.orderVenta;
			}
		}
    }
</script>
<style lang="">
	.el-button--small.is-circle {
		padding: 5px !important;
	}
</style>
