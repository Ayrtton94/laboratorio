<template>
    <div>
        <div class="row mt-2 mb-2">
            <div class="col-md-12 col-lg-12 col-xl-12 mb-3 mt-2">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2 ml-2">
                        <div class="d-flex">
                            <div style="width:120px;padding-top:5px;font-weight:800">
                                <strong>Filtrar por:</strong>
                            </div>
                            <el-select v-model="search.column"  placeholder="Select" @change="changeClearInput">
                                <el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label"></el-option>
                            </el-select>
                        </div>
                    </div>
					<div class="col-lg-3 col-md-4 col-sm-12 pb-2" v-if="search.column=='date_of_issue'">
						<el-date-picker v-model="search.value" style="width: 100%;" placeholder="Fecha Emisión" value-format="YYYY-MM-DD"/>
					</div>
					<customer-search v-else-if="search.column=='customer_id'" :showLabel="false" v-model:customer_id="search.value" class="col-lg-3 col-md-4 col-sm-12 pb-2"
						:customersList=[] :errors="[]" ></customer-search>
					
					<div class="col-lg-3 col-md-4 col-sm-12 pb-2" v-else-if="search.column=='tporden_id'">
						<el-select v-model="search.value" filterable clearable placeholder="Tipo Orden">
							<el-option v-for="option in services" :key="option.id" :value="option.id" :label="option.name"></el-option>
						</el-select>
					</div>	
					<div class="col-lg-3 col-md-4 col-sm-12 pb-2" v-else>
						<el-input placeholder="Buscar" v-model="search.value" style="width: 100%;" :size="mini" :prefix-icon="Search" clearable filterable @input="getRecords2" />
					</div>
					
					<div class="col-lg-3 col-sm-12 pb-2" v-if="showAtendidos || showEliminados || showStatusPaid " >
						<div class="form-group col-12" v-if="showAtendidos">
							<label class="control-label mr-2">Incluir Atendidos</label>
							<el-checkbox v-model="search.atendidos"  @change="getRecords2"></el-checkbox>
						</div>
						<div class="form-group col-12"  v-if="showEliminados">
							<label class="control-label mr-2">Incluir Eliminadas</label>
							<el-checkbox v-model="search.eliminados"  @change="getRecords2"></el-checkbox>
						</div>
                    </div>
					<div class="col-xl-2">
						<div class="form-group col-12"  v-if="showReload">
							<button type="button" class="btn" @click.prevent="getRecords2"  data-toggle="tooltip" title="Recargar Registros">
								<i class="fa fa-refresh text-warning fs-18"></i>
							</button>
						</div>
					</div>
					<div class="col-xl-2">
						<div class="form-group col-12"  v-if="exportExcel && search.value">
							<button type="button" class="btn" @click.prevent="getRecordsExcel"  data-toggle="tooltip" title="Exportar Registros">
								<i class="fa fa-file-excel-o text-info fs-18"></i>
							</button>
						</div>
					</div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
					<table class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<slot name="heading"></slot>
						</thead>
						<tbody>
							<slot v-for="(row, index) in records" :row="row" :index="customIndex(index)" name="tbody"></slot>
						</tbody>
						<tfoot>
							<slot name="foot"></slot>
						</tfoot>
					</table>
					<slot name="totals" :totals="totals"></slot>
					<div class="mt-2">
						<el-pagination
							@current-change="getRecords2"
							layout="total, prev, pager, next"
							:total="pagination.total"
							v-model:current-page="pagination.current_page"
							:page-size="pagination.per_page"/>
						
					</div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import queryString from 'query-string'
	import CustomerSearch from './CustomerSearch'
    export default {
        props: {
            resource: String,
            showTotals : {
                type:   Boolean,
                default : true
			},
			showEliminados :{
				type : Boolean,
				default : false
			},
			showAtendidos :{
				type : Boolean,
				default : false
			},
			showReload : {
				type : Boolean,
				default : false
			},
			exportPDF : {
				type : Boolean,
				default : false
			},
			exportExcel : {
				type : Boolean,
				default : false
			},
			showStatusPaid: {
				type:Boolean,
				default : false
			},
			columnOrder:{
				type: String,
				default : ''
			}

		},
		components: { CustomerSearch},
        data () {
            return {
                search: {
                    column: null,
					value: null,
					atendidos : false,
					anulados : false,
					eliminados : false,
					showStatusPaid : -1,
					order :'',
					sort : 'DESC'

                },
                columns: [],
                records: [],
                totals: [],
				pagination: {},
				services  : [],
				sucursales : [],
				almacenes : [],
				presentaciones : []
            }
        },
        computed: {
        },
        created() {
            this.emitter.on('reloadData', () => {
                this.getRecords()
                // this.getTotals()
            })
        },
        async mounted () {
			let column_resource = _.split(this.resource, '/')

            await axios.get(`/${_.head(column_resource)}/columns`).then(({data}) => {
                this.columns = data
                this.search.column = _.head(Object.keys(this.columns))
            });
			await this.getRecords()

            // await this.getTotals()
        },
        methods: {
            customIndex(index) {
                return (this.pagination.per_page * (this.pagination.current_page - 1)) + index + 1
            },
            getRecords() {
                return axios.get(`/${this.resource}/records?${this.getQueryParameters()}`).then((response) => {
                    this.records = response.data.data
                    this.pagination = response.data.meta
					this.pagination.per_page = parseInt(response.data.meta.per_page)
                });

            },
			getRecordsExcel()
			{
				window.open(`/${this.resource}/records/excel?${this.getQueryParameters()}`,'_blank');
			},
            // getTotals(){
            //     if(this.showTotals){
            //         return axios.get(`/${this.resource}/totals?${this.getQueryParameters()}`).then((response) => {
            //             this.totals = response.data.data
            //         });
            //     }
            // },
            getQueryParameters() {
                return queryString.stringify({
                    page: this.pagination.current_page,
					limit: this.limit,
					per_page : this.pagination.per_page,
                    ...this.search
                })
            },
            getRecords2(){
                this.getRecords()
                // this.getTotals()
            },
            changeClearInput(){
                this.search.value = ''
                this.getRecords()
                // this.getTotals()
			},
			getServices(){
				axios.get(`/tipodeorden/records`).then(({data}) => {
					this.services = data.tipoorden;
				});
			}
		},
		watch : {
			columnOrder: function(oldVal,newVal){
				this.search.order  = oldVal;
				this.changeClearInput();
			},
			'search.column': function(oldVal,newVal){

				if(this.search.column == 'tporden_id'){
					this.getServices();
				}
			},
			'search.value': function(){
				this.getRecords();
				// this.getTotals()
			}
		}
    }
</script>