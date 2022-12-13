<template>
    <div>
        <div class="row mt-2 mb-2">
            <div class="col-md-12 col-lg-12 col-xl-12 mb-3 mt-2">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2 ml-2">
                        <div class="d-flex">
                            <div style="width:120px;padding-top:5px;font-weight:800">
                                <strong>Filtrar:</strong>
                            </div>
							<el-date-picker v-model="search.date_of_issue_1" style="width: 100%;" placeholder="Fecha Inicio" value-format="YYYY-MM-DD"/>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
						<el-date-picker v-model="search.date_of_issue_2" style="width: 100%;" placeholder="Fecha Fin" value-format="YYYY-MM-DD"/>
                    </div>
					<div class="col-lg-3 col-md-4 col-sm-12 pb-2" v-if="(search.date_of_issue_1 && search.date_of_issue_2)">
						<el-select v-model="search.staff_id" filterable clearable @change="getRecords2" placeholder="Trabajador">
							<el-option v-for="option in persons" :key="option.id" :value="option.id" :label="option.name_full"></el-option>
						</el-select>
					</div>
					<div class="col-xl-2">
						<div class="form-group col-12">
							
							<button v-if="(exportPDF && search.staff_id && search.date_of_issue_1 && search.date_of_issue_2)" type="button" class="p-1 btn btn-sm btn-danger" @click.prevent="getRecordsPdf"  data-toggle="tooltip" title="Exportar Registros">
								<el-icon style="display: inline !important;"><List /></el-icon> <span>Pdf</span>
							</button>&nbsp;
							<button v-if="(exportExcel && search.staff_id && search.date_of_issue_1 && search.date_of_issue_2)" type="button" class="p-1 btn btn-sm btn-success" @click.prevent="getRecordsExcel"  data-toggle="tooltip" title="Exportar Registros">
								<el-icon style="display: inline !important;"><Checked/></el-icon> <span>Excel</span>
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

    import moment from 'moment'
    import queryString from 'query-string'
    export default {
        props: {
            resource: String,
			exportPDF : {
				type : Boolean,
				default : false
			},
			exportExcel : {
				type : Boolean,
				default : false
			}
		},
        data () {
            return {
                search: {
					date_of_issue_1: null,
					date_of_issue_2: null,
					staff_id: null
                },
                records: [],
                totals: [],
				pagination: {},
				persons  : []
            }
        },
        computed: {
        },
        created() {
            this.emitter.on('reloadData', () => {
                this.getRecords()
            })
        },
        async mounted () {
			await this.getRecords()
			this.getStaff();
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
			getRecordsPdf(){
				window.open(`/${this.resource}/records/pdf?${this.getQueryParameters()}`,'_blank');
			},
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
            },
			getStaff(){
				axios.get(`persons/staff/records`).then(({data}) => {
					this.persons = data.data;
				});
			}
		},
		watch : {
			'search.staff_id': function(){
				this.getRecords();
			}
		}
    }
</script>