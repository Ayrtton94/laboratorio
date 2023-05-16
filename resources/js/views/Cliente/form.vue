<template>
	<div class="modal fade show" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3">
					<h4 class="modal-title">
						<span v-if="!form.id">
							{{ this.title }}
						</span>
						<span v-else>Actualizar Datos</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="row">
							<table class="table">
								<tbody>
									<tr>
										<td>
											<label class="control-label">Tipo Documento3</label>
											<div class="form-group">
												<el-select v-model="form.identity_document_id" placeholder="Tipo Documento" >
													<el-option v-for="option in identity_document_types" :value="option.id" :key="option.id" :label="option.description"/>
												</el-select>
											</div>
										</td>
										<td>											
												<label class="control-label">Documento</label>
												<div class="form-group">
													<el-input v-model="form.number" placeholder="Documento" :maxlength="maxlength">
														<template #append>
															<el-button @click.prevent="searchDocument">Buscar</el-button>
														</template>
													</el-input>
													<small class="form-control-feedback text-danger" v-if="errors.number" v-text="errors.number[0]"></small>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table">
								<tbody>
									<tr>
										<td>
											<div>
												<div class="form-group">
													<el-input v-model="form.name" type="text" placeholder="Nombre"/>
													<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
												</div>
												
											</div>
										</td>
									</tr>
								</tbody>
							</table>

							<table class="table">
								<tbody>
									<tr>
										<td>
											<div>
												<label class="control-label">Departamentod</label>
												<div class="form-group">
													<el-select v-model="form.department_id" filterable clearable @change="filterProvince" placeholder="Seleccione">
														<el-option v-for="option in all_departments" :key="option.id" :value="option.id" :label="option.description" />
													</el-select>
												</div>
											</div>
										</td>
										<td>
											<div>
												<label class="control-label">Provincia</label>
												<div class="form-group">
													<el-select v-model="form.province_id" filterable clearable @change="filterDistrict" placeholder="Seleccione">
														<el-option v-for="option in provinces" :key="option.id" :value="option.id" :label="option.description" />
													</el-select>
												</div>
											</div>
										</td>
										<td>
											<div>
												<label class="control-label">Distrito</label>
												<div class="form-group">
													<el-select v-model="form.district_id" filterable clearable placeholder="Seleccione">
														<el-option v-for="option in districts" :key="option.id" :value="option.id" :label="option.description" />
													</el-select>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table">
								<tbody>
									<tr>
										<td>
											<div>
												<label class="control-label">Dirección</label>
												<div class="form-group">
													<el-input v-model="form.address" type="text" placeholder="Dirección"/>
													<small class="form-control-feedback text-danger" v-if="errors.address" v-text="errors.address[0]"></small>
												</div>												
											</div>
										</td>
									</tr>									
								</tbody>
							</table>
							<table class="table">
								<tbody>
									<tr>
										<td>
											<div>
												<label class="control-label">Telefono</label>
												<div class="form-group">
													<el-input v-model="form.telephone" type="text" placeholder="Telefono"/>
													<small class="form-control-feedback text-danger" v-if="errors.telephone" v-text="errors.telephone[0]"></small>
												</div>
												
											</div>
										</td>
										<td>
											<div>
												<label class="control-label">Teléfono adicional</label>
												<div class="form-group">
													<el-input v-model="form.additional_phone" type="text" placeholder="Telefono Adicional"/>
													<small class="form-control-feedback text-danger" v-if="errors.additional_phone" v-text="errors.additional_phone[0]"></small>
												</div>												
											</div>
										</td>
										<td>
											<div>
												<label class="control-label">Email</label>
												<div class="form-group">
													<el-input v-model="form.email" type="email" placeholder="Email"/>
													<small class="form-control-feedback text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
												</div>												
											</div>
										</td>
									</tr>
								</tbody>
							</table>															
						</div>
						
						<div class="modal-footer">
							<button @click.prevent="closeModal"  type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button @click.prevent="store(form)" type="submit" class="btn btn-sm btn-success">
								<span v-if="!form.id">Registrar</span>
								<span v-else>Actualizar</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import { allDepartments, searchDcumentAll } from "../../mixins/deletable" 
	export default {
		mixins: [allDepartments,searchDcumentAll],
		props: {
			form: {
				type: Object,
				default: () => {}
			},
			errors: {}
		},
		data() {
			return {
				resource: 'persons',
				title: null,
				
				departments: [],
				provinces: [],
				districts: [],
				all_departments: [],
                all_provinces: [],
                all_districts: [],
				
				identity_document_types: [],
				roles: [],
				schedules: [],
				areas: []
			}
		},
		created(){
			this.getCustomerData();
			this.title = (this.form.type === 'customers')?'Nuevo Cliente':(this.form.type === 'staff')? 'Nuevo Personal' :((this.form.type === 'suppliers'? 'Nuevo Proveedor': ''));
			if(this.form.type === 'staff') this.getRoles()
			if(this.form.type === 'staff') this.getSchedules()
			if(this.form.type === 'staff') this.getAreas()
		},
		methods: {
			getCustomerData(){
				axios.get(`/${this.resource}/tables`)
				.then(res => {
					this.identity_document_types = res.data.identity_document_types
					this.all_departments = res.data.departments
					this.all_provinces = res.data.provinces
					this.all_districts = res.data.districts
				})
			},

			getRoles(){
				axios.get(`/roles/records`)
				.then(response => {
					this.roles = response.data.roles
				})
			},
			getSchedules(){
				axios.get(`/schedule/records`)
				.then(response => {
					this.schedules = response.data.schedules
				})
			},
			getAreas(){
				axios.get(`/areas/records`)
				.then(response => {
					this.areas = response.data.areas
				})
			},

			store(form){
				this.$emit('saveAppt',form);
				this.$emit('uploadImage');
				
			},
			closeModal(){
				this.$emit('closeModal');
			}
		},
		computed:{
			maxlength: function(){
				if(this.form.identity_document_id === 6){
					return 11;
				}

				if(this.form.identity_document_id === 1){
					return 8;
				}
			}
		}
	}
</script>

<style scoped>
    .table th, .table td { 
        border-top: none !important;
        border-left: none !important;
    }
</style>