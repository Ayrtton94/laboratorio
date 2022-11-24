<template>
	<div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.7); display: block;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mr-3 ml-3">
					<h4 class="modal-title">
						<span v-if="!form.id">Nueva Especie</span>
						<span v-else>Actualizar Registro</span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="signupForm" autocomplete="off" @submit.prevent="submit">
						<div class="form-group">
							<label class="control-label col-md-12 col-sm-12 col-xs-12">(*)Descripción</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="name" v-model="form.description" class="form-control" name="description" type="text" placeholder="Descripción">
							</div>
						</div>
						<div class="modal-footer">
							<button @click.prevent="closeModal" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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
				default: ()=>{}
			},
		},
		methods:{
			store(form){
				this.$emit('saveAppt', form);
			},
			closeModal(){
				this.$emit('closeModal');
			}
		}
		
	}
</script>