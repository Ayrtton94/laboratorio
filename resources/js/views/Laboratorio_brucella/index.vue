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
                                <th class="pt-0">Nombre</th>
                                <th class="pt-0">Tipo de usuario</th>   
                                <th class="pt-0">Tipo de persona</th>                     
                                <th class="pt-0">Estado</th>
                                <th class="pt-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>                                       
                                    </td>
                                    <td>
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
                lav_brudellas : []
            }
    },
    mounted() {
            this.getlavbrucellas()
    },
    methods: {

    },
}
</script>