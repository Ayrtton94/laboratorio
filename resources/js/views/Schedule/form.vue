<template>
	<div class="modal fade show" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Registrar Horario</span>
						<span v-else>Actualizar Datos</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<table class="table">
							<tbody>
								<tr>
									<td colspan="2">
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Nombre</label>
										<div class="form-group">
											<input v-model="form.description" class="form-control" type="text" placeholder="Nombre Horario">
											<small class="form-control-feedback text-danger" v-if="errors.description" v-text="errors.description[0]"></small>
										</div>
									</td>
								</tr>
								<tr>								
									<td>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Hora Ingreso</label>
										<div class="form-group">
											<el-time-select v-model="form.hour_start" :max-time="endTime" placeholder="Hora Ingreso" start="08:30" step="00:15" end="18:30"/>
											<small class="form-control-feedback text-danger" v-if="errors.hour_start" v-text="errors.hour_start[0]"></small>
										</div>
									</td>
									<td>
										<label class="control-label col-md-12 col-sm-12 col-xs-12">Hora Salida</label>
										<div class="form-group">
											<el-time-select v-model="form.hour_end" :min-time="startTime" placeholder="Hora Salida" start="08:30" step="00:15" end="18:30"/>
											<small class="form-control-feedback text-danger" v-if="errors.hour_end" v-text="errors.hour_end[0]"></small>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

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
	export default {
		props: {
			form: {
				type: Object,
				default: () => {}
			},
			errors: {}
		},
		methods: {
			store(form){
				this.$emit('saveAppt',form);
			},
			closeModal(){
				this.$emit('closeModal');
			}
		}
	}
</script>

<style scoped>
    .table th, .table td { 
        border-top: none !important;
        border-left: none !important;

		border-right: none !important;
		border-below: none !important;

    }
</style>