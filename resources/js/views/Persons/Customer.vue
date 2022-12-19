<template>
    <el-dialog :title="titleDialog" model-value="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
					<div class="col-md-6">
						<div class="form-group" :class="{'has-danger': errors.identity_document_id}">
							<label class="control-label">Tipo Documento</label>
							<el-select v-model="form.identity_document_id" filterable>
								<el-option v-for="option in identity_document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
							</el-select>
							<small class="form-control-feedback" v-if="errors.identity_document_id" v-text="errors.identity_document_id[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label class="control-label">(*)Documento</label>
							<el-input v-model="form.number" placeholder="Documento" :maxlength="maxlength">
								<template #append>
									<el-button @click.prevent="queryDocument">Buscar</el-button>
								</template>
							</el-input>
							<small class="form-control-feedback text-danger" v-if="errors.number" v-text="errors.number[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<label class="control-label">
								<span>Nombre</span>
							</label>
							<el-input v-model="form.name" type="text" placeholder="Nombre"/>
							<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<label class="control-label">Telefono</label>
							<el-input v-model="form.telephone" type="text" placeholder="Telefono"/>
							<small class="form-control-feedback text-danger" v-if="errors.telephone" v-text="errors.telephone[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<label class="control-label">Email</label>
							<el-input v-model="form.email" type="email" placeholder="Email"/>
							<small class="form-control-feedback text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<label class="control-label">Dirección</label>
							<el-input v-model="form.address" type="text" placeholder="Dirección"/>
							<small class="form-control-feedback text-danger" v-if="errors.address" v-text="errors.address[0]"></small>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<label class="control-label">Departamento</label>
						<div class="form-group">
							<el-select v-model="form.department_id" filterable clearable @change="filterProvince" placeholder="Seleccione">
								<el-option v-for="option in all_departments" :key="option.id" :value="option.id" :label="option.description" />
							</el-select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<label class="control-label">Provincia</label>
						<div class="form-group">
							<el-select v-model="form.province_id" filterable clearable @change="filterDistrict" placeholder="Seleccione">
								<el-option v-for="option in provinces" :key="option.id" :value="option.id" :label="option.description" />
							</el-select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4">
						<label class="control-label">Distrito</label>
						<div class="form-group">
							<el-select v-model="form.district_id" filterable clearable placeholder="Seleccione">
								<el-option v-for="option in districts" :key="option.id" :value="option.id" :label="option.description" />
							</el-select>
						</div>
					</div>
				</div>
				<div class="form-actions text-right mt-4">
					<el-button @click.prevent="close()">Cancelar</el-button>
					<el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
				</div>
			</div>
        </form>
    </el-dialog>
</template>

<script>

	import { allDepartments } from "../../mixins/deletable"
	import { searchDcumentType } from "../../mixins/searchApi"

    export default {
        mixins: [allDepartments, searchDcumentType],
        props: ['showDialog', 'recordId', 'external'],
        data() {
            return {
                loading_submit: false,
                titleDialog: 'Nuevo Cliente',
                resource: 'persons',
                errors: {},
                form: {},
                all_departments: [],
                all_provinces: [],
                all_districts: [],
                provinces: [],
                districts: [],
                identity_document_types: []
            }
        },
        created() {
            this.initForm()
            axios.get(`/${this.resource}/tables`)
                .then(response => {
                    this.all_departments = response.data.departments
                    this.all_provinces = response.data.provinces
                    this.all_districts = response.data.districts
                    this.identity_document_types = response.data.identity_document_types
                })
        },
        computed: {
            maxLength: function () {
                if (this.form.identity_document_id === 6) {
                    return 11
                }
                if (this.form.identity_document_id === 1) {
                    return 8
                }
            }
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    id: null,
                    identity_document_id: 1,
                    number: null,
                    name: null,
                    department_id: null,
                    province_id: null,
                    district_id: null,
                    address: null,
                    telephone: null,
                    email: null
                }
            },
            create() {
                if (this.recordId) {
                    axios.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            this.filterProvinces()
                            this.filterDistricts()
                        })
                }
            },
            submit() {
                this.loading_submit = true
                axios.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            // if (this.external) {
                            //     this.emitter.emit('reloadDataCustomers', response.data.id)
                            // } else {
                                // this.emitter.emit('reloadData')
								this.emitter.emit('reloadDataCustomers', response.data.id)
                            // }
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            }
        }
    }
</script>