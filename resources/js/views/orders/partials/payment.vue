<template>
	<el-dialog :title="titleDialog" model-value="showDialogEvaluarOrder" class="mt-2" @close="closeModalPayment" width="30%">
		<form autocomplete="off" @submit.prevent="submit">
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)ESTADO</label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<el-select v-model="form.payment_id" class="w-100" filterable>
							<el-option v-for="option in status_paid" :key="option.id" :label="option.nombre"  :value="option.id"></el-option>
						</el-select>
						<!-- <small class="form-control-feedback text-danger" v-if="errors.payment_id" v-text="errors.payment_id[0]"></small> -->
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<el-button @click.prevent="closeModalPayment">Salir</el-button>
				<button type="submit" class="btn btn-sm btn-success">Guardar</button>
			</div>
		</form>
	</el-dialog>
</template>

<script>
	export default {
		props: ['showDialogPayment', 'recordId'],
		data(){
			return {
				resource: 'orders',
				status_paid: [
                    {"id": "1", "nombre": "EFECTIVO"},
                    {"id": "2", "nombre": "DEPOSITO"},
                ],
				form: {}
			}
		},
		created(){
			console.log(this.recordId);
		},
		methods:{
			initForm(){
				this.form = {
					payment_id: 1
				};
			},
			closeModalPayment(){
				this.$emit('closeModalPayment');
				// this.initForm();
			},
			submit(){
				
				axios.put(`/${this.resource}/status_paid/${this.recordId}`, this.form)
				.then(response => {
					console.log(response);
                    // this.form = response.data.data;
                    // this.titleDialog = 'Orden de Laboratorio: '+this.form.number;
                });
			},
		}
		
	}
</script>