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
                this.$confirm('¿Desea restaurar el registro?', 'Restaurar', {
                    confirmButtonText: 'Restaurar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
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
                }).catch(error => {
                    console.log(error)
                });
            })
        },
    }
}