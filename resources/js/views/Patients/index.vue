<template>
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-line">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Administración ERP</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buscar usuario cliente</li>
            </ol>
        </nav>
    </div> <!-- row -->

    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Buscar CLIENTE USUARIO</h6>
                    <p class="text-muted mb-3">FILTRAR</p>
                    <form id="signupForm" @submit.prevent="searchPatient">
                        <div class="row">
                            <div class="col-lg-3 p-2">
                                <div class="mb-3">
                                    <input id="name" class="form-control" v-model="form.names" type="text"
                                        placeholder="Por Nombres o Apellidos">
                                </div>
                            </div>
                            <div class="col-lg-3 p-2">
                                <div class="mb-3">
                                    <input id="name" class="form-control" v-model="form.document" type="text"
                                        placeholder="Por DNI">
                                </div>
                            </div>
                            <div class="col-lg-3 p-2">
                                <div class="mb-3">
                                    <input id="name" class="form-control" v-model="form.phone" type="text"
                                        placeholder="Por Teléfono">
                                </div>
                            </div>
                            <div class="col-lg-3 p-2">
                                <div class="mb-3 text-end">
                                    <input class=" btn btn-primary" type="submit" value="BUSCAR"> <a
                                        class=" btn btn-primary" :href="`/${this.resource}/create`">AGREGAR PACIENTE</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="modal fade" id="agendarcita" tabindex="-1" aria-labelledby="sd" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="as">Agendar Cita</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3"><strong>PACIENTE: DARLINN DANIEL CÓRDOVA ARISMENDIZ</strong></p>
                        <div class="mb-3">
                            <label class="form-label">Tipo de atención</label>
                            <select class="form-select" name="age_select" id="ageSelect">
                                <option>Elegir</option>
                                <option selected>Médica</option>
                                <option>Estética</option>
                                <option>Procedimiento</option>


                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Especialista</label>
                            <select class="form-select" name="age_select" id="ageSelect">
                                <option>Elegir</option>
                                <option selected>Dra. Carolina</option>
                                <option>Dr. Victor Otárola</option>
                                <option>Dr. Arisméndiz</option>


                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Disponibilidad</label>
                            <select class="form-select" data-width="100%">
                                <option value="TX">Miércoles 15 septiembre : 11-12pm</option>
                                <option value="NY">Viernes 17 septimebre: 3-4pm</option>
                                <option value="NY">Viernes 17 septimebre: 3-4pm</option>
                                <option value="NY">Viernes 17 septimebre: 3-4pm</option>
                                <option value="NY">Viernes 17 septimebre: 3-4pm</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="check-square"></i>
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-icon-text text-light" style="background-color: #ce9d20">
                            <i class="btn-icon-append" data-feather="box"></i>
                            Guardar
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Resultado de búsqueda</h6>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="pt-0">Código HC</th>
                                    <th class="pt-0">Perfil</th>
                                    <th class="pt-0">Nombres y Apellidos</th>
                                    <th class="pt-0">DNI</th>
                                    <th class="pt-0">Sexo</th>
                                    <th class="pt-0">Edad</th>
                                    <th class="pt-0">Teléfono</th>
                                    <th class="pt-0">Estado</th>
                                    <th class="pt-0 text-center">Atención</th>
                                    <th class="pt-0 text-center">Facturación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(patient, index) in patients.data" :key="index">
                                    <td>{{patient.codigo_historial_clinico}}</td>
                                    <td>
                                        <div class="me-3">
                                            <img class="wd-30 ht-30 rounded-circle" src="assets/images/face1.jpg"
                                                alt="userr">
                                        </div>
                                    </td>
                                    <td>{{patient.name}} {{patient.last_name}}</td>
                                    <td>{{patient.document}}</td>
                                    <td>{{patient.sexo}}</td>
                                    <td>28</td>
                                    <td>{{patient.phone}}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="patient.estado">Activo</span>
                                        <span class="badge bg-danger" v-else>Eliminado</span>
                                    </td>
                                    <td class="text-center"><a data-bs-toggle="modal" data-bs-target="#agendarcita"
                                            href="#"><vue-feather type="calendar"></vue-feather></a> </td>
                                    <td><span class="badge bg-warning">Pendiente de pago</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination class="my-2" :data="patients" @pagination-change-page="getPatients" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
    export default {
        components:{'Pagination': LaravelVuePagination},
        data() {
            return {
                resource: 'patients',
                patients: [],
                form: {}
            }
        },
        created(){

        },

        mounted() {
            this.getPatients();
        },
        methods: {
            getPatients(page = 1){
				axios.get(`/${this.resource}/records?page=` + page)
				.then(response =>{
					if (response.status === 200) {
						this.patients = response.data.patients
					}
				})
				.catch(error => console.log(error))
			},
			searchPatient(){
				axios.post(`/${this.resource}/search`, this.form)
				.then(response => {
					this.patients = response.data.patients
				})
			}
        },
    }
</script>
