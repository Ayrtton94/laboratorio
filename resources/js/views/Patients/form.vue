<template>
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-line">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Administración ERP</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nuevo cliente usuario</li>
            </ol>
        </nav>
    </div> <!-- row -->
    <form id="signupForm"  @submit.prevent="submit">
        <div class="row">
            <div class="col-xl-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-3">Ingresar los datos del formulario</p>
                        <div class="row">
                            <div class="col-lg-6 p-3" style="background-color:#f9fafb;">
                                <h6 class="card-title">Información General</h6>
                                <div class="row">
                                    <div class=" p-2">
                                        <div class="mb-3">
                                            <input id="name" class="form-control" :class="errors.name ? 'is-invalid' : ''" v-model="form.name" type="text"
                                                placeholder="Nombres">
                                                <small class="text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
                                        </div>
                                        <div class="mb-3">
                                            <input id="name" class="form-control" :class="errors.last_name ? 'is-invalid' : ''" v-model="form.last_name" type="text"
                                                placeholder="Apellidos">
                                                <small class="text-danger" v-if="errors.last_name" v-text="errors.last_name[0]"></small>
                                        </div>
                                        <div class="mb-3">
                                            <input id="name" class="form-control" :class="errors.document ? 'is-invalid' : ''" v-model="form.document" type="text"
                                                placeholder="DNI">
                                                <small class="text-danger" v-if="errors.namdocumente" v-text="errors.document[0]"></small>
                                        </div>
                                        <div class="mb-3">
                                            <select class="form-select" v-model="form.sexo" :class="errors.sexo ? 'is-invalid' : ''" aria-label="Default select example">
                                                <option v-for="sexo in sexos" :key="sexo.id" :value="sexo.name" :disabled="sexo.disabled">{{sexo.name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.sexo" v-text="errors.sexo[0]"></small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Fecha nacimiento:</label>
                                            <input type="date" v-model="form.birth_date" :class="errors.birth_date ? 'is-invalid' : ''" class="form-control mb-4 mb-md-0"/>
                                                <small class="text-danger" v-if="errors.birth_date" v-text="errors.birth_date[0]"></small>
                                        </div>
                                        <div class="mb-3">
                                            <input id="name" class="form-control" :class="errors.lugar_nacimiento ? 'is-invalid' : ''" v-model="form.lugar_nacimiento" type="text"
                                                placeholder="Lugar de Nacimiento">
                                                <small class="text-danger" v-if="errors.lugar_nacimiento" v-text="errors.lugar_nacimiento[0]"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-3  text-light" style="background-color:#b5d6e5">
                                <h6 class="card-title">Información de contacto</h6>
                                <div class="mb-3">
                                    <input id="name" class="form-control" :class="errors.ocupacion ? 'is-invalid' : ''" v-model="form.ocupacion" type="text"
                                        placeholder="Ocupación">
                                        <small class="text-danger" v-if="errors.ocupacion" v-text="errors.ocupacion[0]"></small>
                                </div>
                                <div class="mb-3">
                                    <input id="name" class="form-control" :class="errors.email ? 'is-invalid' : ''" v-model="form.email" type="text"
                                        placeholder="Correo">
                                        <small class="text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
                                </div>
                                <div class="mb-3">
                                    <input id="name" class="form-control" :class="errors.phone ? 'is-invalid' : ''" v-model="form.phone" type="text"
                                        placeholder="Teléfono">
                                        <small class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></small>
                                </div>
                                <div class="mb-3">
                                    <input id="name" class="form-control" :class="errors.address ? 'is-invalid' : ''" v-model="form.address" type="text"
                                        placeholder="Dirección">
                                        <small class="text-danger" v-if="errors.address" v-text="errors.address[0]"></small>
                                </div>
                                <div class="mb-3">
									<select class="form-select" v-model="form.country_id" :class="errors.country_id ? 'is-invalid' : ''">
										<option v-for="country in countries" :key="country.id" :value="country.id">{{country.description}}</option>
									</select>
                                    <small class="text-danger" v-if="errors.country_id" v-text="errors.country_id[0]"></small>
                                </div>
                                <div class="mb-3">
									<select class="form-select" v-model="form.department_id"  :class="errors.department_id ? 'is-invalid' : ''">
										<option v-for="department in departments" :key="department.id" :value="department.id">{{department.description}}</option>
									</select>
                                    <small class="text-danger" v-if="errors.department_id" v-text="errors.department_id[0]"></small>
                                </div>
                                <div class="mb-3">
									<select class="form-select" v-model="form.province_id"  :class="errors.province_id ? 'is-invalid' : ''">
										<option v-for="province in provincesfilter" :key="province.id" :value="province.id">{{province.description}}</option>
									</select>
                                    <small class="text-danger" v-if="errors.province_id" v-text="errors.province_id[0]"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 p-3 "></div>
                            <div class="col-lg-6 p-3 text-end">
                                <button type="button" class="btn btn-primary btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="check-square"></i>
                                    Limpiar formulario
                                </button>
                                <button type="submit" class="btn btn-icon-text text-light mx-1"
                                    style="background-color: #ce9d20">
                                    <i class="btn-icon-append" data-feather="box"></i>
                                    Agregar paciente
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
        data() {
            return {
                resource: 'patients',
                form: {},
				errors: {},
				countries: [],
				departments: [],
				provinces: [],
                sexos: [
                    {
                        'selected': true,
                        'id': 2,
                        'name' : 'Masculino'
                    },
                    {
                        'id': 3,
                        'name' : 'Femenino'
                    },
                    {
                        'id': 3,
                        'name' : 'Otro'
                    },
            ]
            }
        },
        created() {
            // this.errors = {}
			this.getCountries()

        },
	mounted() {
            this.form.sexo = this.sexos.find(el => el.selected).name
			this.form.country_id = 4
        },

	methods: {
            submit(){
                this.errors = {}
                axios.post(`/${this.resource}`, this.form)
                .then(response => {
                    if(response.status == 200){
                        if (!response.data.status) {
                            this.$swal({
                            icon: 'warning',
                            title: `${response.data.message}`,
							})

                        }else{
                            this.$swal({
                            icon: 'success',
                            title: 'Registrado',
                            showConfirmButton: false,
                            timer: 1500
							})
							this.form = {}
                            }
						}
                })
                .catch(error => {
						if (error.response.status === 422) {
							this.errors = error.response.data.errors;
						} else {
							console.log('Ocurrió un inconveniente :(')
						}
					})
			},
			getCountries() {
				axios.get(`/${this.resource}/means`)
					.then(response => {
						this.countries = response.data.countries
						this.departments = response.data.departments
						this.provinces = response.data.provinces
				})
			}
        },
        watch: {
            'form.document': function(old_val){
                this.form.codigo_historial_clinico = "HC"+old_val
			}
	},
		computed: {
			provincesfilter() {
				return this.provinces.filter(el => el.department_id == this.form.department_id)
			}
		},
    }
</script>
