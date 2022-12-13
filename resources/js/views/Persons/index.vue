<template>
	<div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE {{ this.title }}</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">
						Registrar
					</button>
                </div>
              </div>
			  <div class="card-body">
                <data-table :resource="resource+`/${this.type}`" :show-eliminados="true">
					<template v-slot:heading>
						<th class="pt-0">#</th>
						<th class="pt-0">Tipo Doc</th>
						<th class="pt-0">Número</th>
						<th class="pt-0">Nombre</th>
						<th class="pt-0">Email</th>
						<th class="pt-0">Telefono</th>
						<th class="pt-0">Estado</th>
						<th class="pt-0">Acciones</th>
					</template>
					<template v-slot:tbody="{ index, row }">
						<tr>
							<td>{{ index }}</td>
							<td>
								<span v-if="row.identity_document_id=='1'">DNI</span>
								<span v-if="row.identity_document_id=='6'">RUC</span>
							</td>
							<td>{{ row.number }}</td>
							<td>{{ row.name }}</td>
							<td>{{ row.email }}</td>
							<td>{{ row.telephone }}</td>
							<td>
								<span class="badge bg-success" v-if="row.status==1">Activo</span>
								<span class="badge bg-danger" v-else>Eliminado</span>
							</td>
							<td>
								<a v-if="row.status!=0" class="btn text-danger" @click="clickDelete(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar" aria-label="Eliminar">
									<vue-feather type="delete" class="fs-vue-feather-18"></vue-feather>
								</a>
								<a v-if="row.status!=0" @click.prevent="clickUpdate(row)" class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar" aria-label="Editar">
									<vue-feather type="edit" class="fs-vue-feather-18"></vue-feather>
								</a>
								<a class="btn text-success" v-if="row.status==0" @click="clickRestore(row.id)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restaurar" aria-label="Restaurar">
									<vue-feather type="rotate-cw" class="fs-vue-feather-18"></vue-feather>
								</a>
							</td>
						</tr>
					</template>
                </data-table>
            </div>
            </div> 
          </div>
        </div>
    </div>
	<person-modal v-if="showModal" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
	import { deletable } from "../../mixins/deletable"
	import DataTable from '../../components/DataTable.vue'
	import PersonModal from "../Persons/form.vue"
	export default {
		mixins: [deletable],
		components: {
			PersonModal,
			DataTable
		},
		props: ['type'],
		data(){
			return {
				resource: 'persons',
                recordId: null,
				title: null,
				records: [],
				showModal: false,
				form: {},
				errors: {}
			}
		},
        created() {
			this.title = (this.type == 'customers')?'CLIENTES':(this.type === 'staff')? 'PERSONAL' :((this.type === 'suppliers'? 'PROVEEDORES': ''))
        },
        methods: {
			initForm() {
				this.form = {
					id: null,
					type: this.type,
					identity_document_id: '1',
					number: null,
					name: null,
					ap_lastname: null,
					am_lastname: null,
					address: null,
					reference_address: null,
					telephone: null,
					additional_phone: null,
					email: null,
					department_id: null,
					province_id: null,
					district_id: null,
					imagen: null,
					rol: null,
					username: null,
					userpassword: null,
					user_account: false,
					area_id: null,
					schedule_id: null,
				},
				this.errors = {}
			},
            clickCreate() {
				this.form.type = this.type
				this.form.identity_document_id = 1
                this.showModal = true
            },
			clickUpdate(info){
				this.showModal = true;
				this.getDataMoal(info);
			},
			getDataMoal(info){
				this.form.id = info.id
				this.form.type = this.type
				this.form.identity_document_id = info.identity_document_id == 1 ? 1 : 6
				this.form.number = info.number
				this.form.name = info.name
				this.form.ap_lastname = info.ap_lastname
				this.form.am_lastname = info.am_lastname
				this.form.telephone = info.telephone
				this.form.additional_phone = info.additional_phone
				this.form.email = info.email
				this.form.address = info.address
				this.form.imagen = info.imagen
				this.form.reference_address = info.reference_address
				this.form.department_id = info.department_id
				this.form.province_id = info.province_id ? info.province_id.replace(/['"]+/g, '') : ''
				this.form.district_id = info.district_id ? info.district_id.replace(/['"]+/g, '') : ''
				this.form.user_account = info.user_account == 1 ? true : false
				this.form.rol = info.rol
				this.form.username = info.username
				this.form.userpassword = info.userpassword
				this.form.area_id = info.area_id
				this.form.schedule_id = info.schedule_id
			},
			saveAppt(form){
				axios.post(`/${this.resource}`, form)
				.then(res => {
					if(res.status == 200) {
						this.$swal({
							icon: 'success',
							title: res.data.message,
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData');
						this.closeModal();
					}
				}).catch(error=> {
					if(error.response.status === 422){
						this.errors = error.response.data.errors
					}else{
						console.log(error);
					}
				})
			},
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
				this.emitter.emit('reloadData')
                )
            },
			clickRestore(id) {
                this.restore(`/${this.resource}/restore/${id}`).then(() =>
					this.emitter.emit('reloadData')
                )
            },
			closeModal(){
				this.showModal = false
				this.initForm()
			}
        }
    }
</script>