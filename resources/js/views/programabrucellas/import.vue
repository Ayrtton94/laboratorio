<template>
    <div class="modal fade show" aria-modal="true" role="dialog" style="background-color: rgba(0,0,0,0.7); display: block;">
        <div class="modal-dialog">
            <div class="modal-content modal-import">
                <div class="modal-body">
                    <form autocomplete="off" @submit.prevent="submit">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="form-group text-center" :class="{'has-danger': errors.file}">
                                        <input type="file" ref="fileInput" @change="handleFileUpload" accept=".xlsx, .xls, .csv">
                                        <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="donwload-format text-left mt-2" href="/formats/programabrucellas.xlsx" target="_new">
                                        <vue-feather type="download" class="fs-vue-feather-18 mt-3"></vue-feather> Formato
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-actions text-right mt-2">
                                        <el-button type="danger" @click.prevent="closeModalImport"><vue-feather type="slash" class="fs-vue-feather-18"></vue-feather></el-button>
                                        <button @click="importData">Importar</button>
                                            <vue-feather type="navigation" class="fs-vue-feather-18"></vue-feather>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading_submit: false,
            headers: headers_token,
            titleDialog: null,
            resource: 'programabrucellas',
            errors: {},
            form: {},
            type: 'suppliers'
        }
    },
    created() {
        this.initForm()
    },
    methods: {
        initForm() {
            this.errors = {}
            this.form = {
                file: null,
            }
        },
        create() {
            this.titleDialog = 'Importar Datos Programa Brucella'
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        create() {
            this.titleDialog = 'Importar Datos Programa Brucella'
        },
        async importData() {
            const formData = new FormData();
            formData.append('file', this.file);

            try {
                const response = await axios.post('/programabrucellas/import', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                });

                if(res.status == 200) {
						this.$swal({
							icon: 'success',
							title: res.data.message,
							showConfirmButton: false,
							timer: 1500
						})
						this.emitter.emit('reloadData');
						this.closeModal();
					}

            } catch (error) {
                if(error.response.status === 422){
						this.errors = error.response.data.errors
					}else{
						console.log(error);
					}
            }
        },
        closeModalImport() {
            this.$emit('closeModalImport');
        },
        successUpload(response, file, fileList) {
            console.log(response);
            if (response.success) {
                this.$message.success(response.message)
                this.emitter.emit('reloadData')
                this.$refs.upload.clearFiles()
                this.closeModal()
            } else {
                this.$message({message:response.message, type: 'error'})
            }
        },
        errorUpload(response) {
            console.log(response)
        }
    }
}
</script>
