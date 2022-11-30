export const deletable = {
    methods: {
        destroy(url) {
            return new Promise((resolve) => {
				this.$swal.fire({
					title: '¿Eliminar registro?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Si!',
					cancelButtonText: 'No!',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post(url,{ '_method': 'DELETE'})
						.then(res => {
							if(res.status) {
								this.$message.success('Se eliminó correctamente el registro')
                                resolve()
							}
						}).catch(error => {
                            if (error.res.status === 500) {
                                this.$message.error('Error al intentar eliminar');
                            } else {
                                console.log(error.res.data.message)
                            }
                        })
					}				
				}).catch(error => {
                    console.log(error)
                });
            })
		},
		
		restore(url) {
            return new Promise((resolve) => {
				axios.get(url)
				.then(res => {
					if(res.data.success) {
						this.$message.success('Se restauro correctamente el registro')
						resolve()
					}
				})
				.catch(error => {
					if (error.response.status === 500) {
						this.$message.error('Error al intentar restaurar');
					} else {
						console.log(error.response.data.message)
					}
				})
            })
        },
    }
}


export const allDepartments = {
	data(){
		return {

		}
	},
	methods: {
		
		filterProvinces() {
			this.provinces = this.all_provinces.filter(f => {
				return f.department_id === this.form.department_id
			})
		},
		filterDistricts() {
			this.districts = this.all_districts.filter(f => {
				return f.province_id === this.form.province_id
			})
		}
	},
	computed: {
		filterProvince() {
			// this.form.province_id = null
			// this.form.district_id = null
			this.filterProvinces()
		},
		
		filterDistrict() {
			// this.form.district_id = null
			this.filterDistricts()
		}
	}
}

export const searchDcumentAll = {
	data() {
		return {

		}
	},
	methods: {
		searchDocument(){
			let tipoDoc = this.form.identity_document_id == 1 ? 'dni' : 'ruc';
			let documentNumber = this.form.number;
			if(!documentNumber) {
				this.$message.warning('Ingrese el documento')
				return false;
			}
			else {
				if(tipoDoc== 'dni' && documentNumber.length!=8) return this.$message.warning('El DNI ingresado debe ser de 8 digitos');
				if(tipoDoc== 'ruc' && documentNumber.length!=11) return this.$message.warning('El RUC ingresado debe ser de 11 digitos');
				
				fetch('https://apiperu.dev/api/'+tipoDoc+'/'+documentNumber+'?api_token=374e1ae308a99aa17f68782a5e68e80247487f6a2bca2f44b822064caa4175be')
				.then(res => res.json())
				.then(res => {
					if(res.success == false){
						this.$message.warning('Datos no encontrados');
						this.form.number = ''
						this.form.name = ''
						this.form.ap_lastname = ''
						this.form.am_lastname = ''
						this.form.address = ''
					}else{
						if(this.form.type=='staff'){
							this.form.name = tipoDoc == 'dni' ? res.data.nombres : res.data.nombre_o_razon_social
							this.form.ap_lastname = res.data.apellido_paterno
							this.form.am_lastname = res.data.apellido_materno
						}else{
							this.form.name = tipoDoc == 'dni' ? res.data.nombre_completo : res.data.nombre_o_razon_social
						}
						this.form.department_id = res.data.ubigeo[0]
						this.form.province_id = res.data.ubigeo[1]
						this.form.district_id = res.data.ubigeo[2]
						this.form.address = res.data.direccion_completa
					}
				})
				.catch(function (e) {
					console.log(e);
				})
			}
		},
	}
}