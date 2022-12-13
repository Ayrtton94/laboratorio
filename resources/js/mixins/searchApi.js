export const searchDcumentType = {
	data() {
		return {

		}
	},
	methods: {
		clearForm(){
			this.form.number = ''
			this.form.name = ''
			this.form.address = ''
			this.form.department_id = ''
			this.form.province_id = ''
			this.form.district_id = ''
		},
		queryDocument(){
			let tipoDoc = this.form.identity_document_id == 1 ? 'dni' : 'ruc';
			let documentNumber = this.form.number;
			if(!documentNumber) {
				this.$message.warning('Ingrese el documento')
				return false;
			}
			else {
				if(tipoDoc== 'dni' && documentNumber.length!=8) return this.$message.warning('El DNI ingresado debe ser de 8 digitos');
				if(tipoDoc== 'ruc' && documentNumber.length!=11) return this.$message.warning('El RUC ingresado debe ser de 11 digitos');
				axios.get(`/apiservices/${tipoDoc}/${documentNumber}`)
				.then(response => {
					if (response.data.success) {
						let data = response.data.data
						this.form.name = data.name_full
						this.form.department_id = data.ubigeo[0]
						this.form.province_id = data.ubigeo[1]
						this.form.district_id = data.ubigeo[2]
						this.form.address = data.address_full
					} else {
						this.$message.error(response.data.message)
						this.clearForm();
					}
				})
				.catch(error => {
					if(error.response.status === 500){
						this.$message.error('No se encontraron resultados')
						this.clearForm();
					}else{
						console.log(error);
					}
				})
			}
		},
	}
}