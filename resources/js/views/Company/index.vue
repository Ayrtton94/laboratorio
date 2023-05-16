<template>
    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h6 class="card-title mb-0">GESTIÓN DE EMPRESAS</h6>
                  <div class="dropdown">
					<button @click.prevent="clickCreate()" type="button" class="btn btn-sm btn-success btn-icon-text text-light mx-1">
						Registrar
					</button>
                </div>
              </div>
			  <div class="card-body">
                <table class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
						<th class="pt-0">#</th>
						<th class="pt-0">TIPO DOC </th>
						<th class="pt-0">Número</th>
						<th class="pt-0">Razón social/Nombre Completo</th>
						<th class="pt-0">Email</th>
						<th class="pt-0">Telefono</th>
						<th class="pt-0">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr v-for="(row, index) in records" :key="index">
						<td>{{ row.id }}</td>
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
						<td>{{ (row.created_at).split('T')[0] }}</td>
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
                  </tbody>
                </table>
            </div>
            </div> 
          </div>
        </div>
    </div>
    <Company-modal v-if="showDialog" :form="form" :errors="errors" @closeModal="closeModal" @saveAppt="saveAppt"/>
</template>
<script>
import { deletable } from "../../mixins/deletable"
import CompanyModal from "../Company/form.vue"
export default ({
    mixins: [deletable],
		components: {
			CompanyModal
		},
        data(){
            return{
                resource: 'company',
				records: [],
				showDialog: false,
				form: {},
				errors: {}
            }
        },
        created() {
            this.emitter.on('reloadData', () => {
				this.getData();
			});
			this.getData();
        },
        methods:{
            initForm() {
				this.form = {
					id: null,
					type: this.type,
					identity_document_id: '1',
					number: null,
					name: null,
                    email: null,
                    telephone: null,
                    ruc: null,
                    business_name: null,

                    address: null,
                    department_id: null,
                    province_id: null,
                    district_id: null,
				},
				this.errors = {}
			},

            clickCreate(){
				this.showDialog = true;
			},
			clickUpdate(info){
				this.showDialog = true;
				this.getDataMoal(info);
			},
			closeModal(){
				this.showDialog = false;
				this.initForm();
			},
            getDataMoal(info){
                this.form.id = info.id
                this.form.identity_document_id = info.identity_document_id == 1 ? 1 : 6
                this.form.number = info.number
                this.form.name = info.name
                this.form.ruc = info.ruc
                this.form.business_name = info.business_name

                this.form.address = info.address
                this.form.department_id = info.department_id
				this.form.province_id = info.province_id ? info.province_id.replace(/['"]+/g, '') : ''
				this.form.district_id = info.district_id ? info.district_id.replace(/['"]+/g, '') : ''
				this.form.email = info.email
				this.form.telephone = info.telephone
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
            getData(){
				axios.get(`/company/records`)
				.then(res => {
					this.records = res.data.companys
				})
			},
        },
})
</script>
