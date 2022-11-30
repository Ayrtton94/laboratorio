<template>
	<div class="modal fade show" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Registrar Tipo de Orden</span>
						<span v-else>Actualizar Datos</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Nombre</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input v-model="form.name" class="form-control" type="text" placeholder="Nombre Orden">
								<small class="form-control-feedback text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
							</div>
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