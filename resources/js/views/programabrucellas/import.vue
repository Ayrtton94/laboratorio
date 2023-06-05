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
                                        <el-upload
                                            ref="upload"
                                            :data="{'type': type}"
                                            :headers="headers"
                                            action="/programabrucellas/import"
                                            :show-file-list="true"
                                            :auto-upload="false"
                                            :multiple="false"
                                            :on-error="errorUpload"
                                            :limit="1"
                                            :on-success="successUpload">

                                            <template #trigger>
                                                <el-button type="success" class="bg-import">
                                                    <vue-feather type="upload" class="fs-vue-feather-14"></vue-feather> Importar Excel
                                                </el-button>
                                            </template>
                                        </el-upload>
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
                                        <el-button class="ml-3" type="success" native-type="submit" :loading="loading_submit">
                                            <vue-feather type="navigation" class="fs-vue-feather-18"></vue-feather>
                                        </el-button>
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
        async submit() {
            this.loading_submit = true
            await this.$refs.upload.submit()
            this.loading_submit = false
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
