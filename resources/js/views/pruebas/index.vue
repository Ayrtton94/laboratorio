<template>
    <div >
       <div class="page-header d-flex bd-highlight">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4 >Pruebas</h4>
			</div>
            <div class="mr-3">
                <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nueva</button>
                <a href="#" class="card-action card-action-toggle text-white" data-card-toggle=""></a>
            </div>
        </div>

		
        <div class="card mb-0 w-100 mt-3">
			<div class="card-body">
				<data-table :resource="resource" :showTotals="false">
                    <tr slot="heading">
                        <th width="5%">#</th>
						<th width="20%">Matriz</th>
                        <th width="20%">Muestra</th>
						<th width="20%">Nombre</th>
						<th width="20%">Precio</th>
						<th width="20%">Laboratorio</th>
						<th width="20%">Metodo</th>
						<th width="20%">Condicion</th>
						<th width="20%">Tiempo Entrega</th>
                        <th width="30%" class="">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" slot="tbody" :class="row.estado == 1 ? '' : 'table-danger' ">
                        <td>{{ index }}</td>
						<td>{{ row.matriz }}</td>
                        <td>{{ row.muestra }}</td>
						<td>{{ row.name }}</td>
						<td>{{ row.price }}</td>
						<td>{{ row.laboratorio }}</td>
						<td>{{ row.metodo }}</td>
						<td>{{ row.metodo }}</td>
						<td>{{ row.condicion }}</td>
						<td>{{ row.time_entrega }}</td>
                        <td class="d-flex">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary " @click.prevent="clickCreate(row.id)" v-if="row.estado == 1">Editar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger ml-2"  @click.prevent="clickDelete(row.id)" v-if="row.estado == 1">Eliminar</button>
							<button type="button" class="btn waves-effect waves-light btn-sm btn-success ml-2"  @click.prevent="clickRestore(row.id)" v-if="row.estado == 0">Restaurar</button>
                        </td>
               
                    </tr>
                </data-table>
			</div>
         
        </div>

        <prueba-form 
			:showDialog.sync="showDialog" 
			:recordId="recordId"></prueba-form>

    </div>
</template>
<script>


    import PruebaForm from './form.vue'
    import {deletable} from '../../../mixins/deletable'
 	import DataTable from '../../../components/DataTable.vue'
    export default {
        mixins: [deletable],
        components: { PruebaForm, DataTable },
        data() {
            return {

                showDialog: false,
                resource: 'pruebas',
                recordId: null,
                records: [],
            }
        },
        created() {
            this.$eventHub.$on('reloadData', () => {
                this.getData()
            });
            this.getData();
        },
        methods: {
            getData() {
                this.$http.get(`/${this.resource}/records`)
                    .then(response => {
                        this.records = response.data.data;
                    })
            },
            clickCreate(recordId = null) {
                this.recordId = recordId;
                this.showDialog = true
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
			},
			clickRestore(id) {
                this.restore(`/restore/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
			}
        }
    }
</script>