<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import"    :close-on-modal="false"
               :show-close="false"
               :close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="/formats/programa-brucellas.xlsx"  class="text-primary" target="_new"><i class="fa fa-file-excel-o text-success fs-18"></i> Descargar formato</a>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group text-center" :class="{'has-danger': errors.file}">
<!--                            :headers="headers"-->
                            <el-upload
                                ref="upload"

                                action="/productos/import"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :limit="1"
                                :on-success="successUpload">
                                <el-button slot="trigger" type="primary">Seleccione un archivo (xlsx)</el-button>
                            </el-upload>
                            <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="success" native-type="submit" :loading="loading_submit">Procesar</el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>

export default {
    props: ['showDialog'],
    data() {
        return {
            loading_submit: false,
            // headers: headers_token,
            titleDialog: null,
            resource: 'programabrucellas',
            errors: {},
            form: {},
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
            this.titleDialog = 'Importar Programa de Brucellas'
        },
        async submit() {

            this.loading_submit = true
            // await this.$refs.upload.submit()
            this.loading_submit = false
        },
        close() {
            // this.$emit('update:showDialog', false)
            this.initForm()
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$message.success(response.message)
                // this.$eventHub.$emit('reloadData')
                // this.$refs.upload.clearFiles()
                this.close()
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
