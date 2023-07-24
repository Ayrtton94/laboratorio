<template>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">
                            Lavoratorio Brucella
                        </h6>
                        <div class="dropdown">
                            <a href="laboratoriobrucellas/crear" class="btn btn-success btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a>
                        </div>
                      </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Fecha</th>
                                <th class="pt-0">Tipo de usuario</th>   
                                <th class="pt-0">Tipo de persona</th>                     
                                <th class="pt-0">Observacion</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in records" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ row.date_of_issue }}</td>
                                    <td>{{ row.customer_id }}</td>
                                    <td>{{ row.responsable_id }}</td>
                                    <td>{{ row.observacion }}</td>
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
</template>
<script>
export default {
    middleware: ['index'],
    data() {
            return {    
                resource: 'laboratoriobrucellas',
				records: [],
            }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData(){
				axios.get(`/laboratoriobrucellas/records`)
				.then(res => {
					this.records = res.data
                    console.log(this.records)
				})
			},

    },
}
</script>