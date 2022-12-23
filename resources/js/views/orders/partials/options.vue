<template>
    <el-dialog :title="titleDialog" model-value="showDialogOptions" @close="showClose" width="40%">
       <div class="row mt-2">
            <div class="col-lg-6 col-md-6 col-sm-12 text-center font-weight-bold" v-if="titleDialog && form.id">
                <p class="">A4</p>
                <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" @click="clickPrint('a4')">
                    <vue-feather type="file-text" class="fs-vue-feather-18"></vue-feather>
                </button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-center font-weight-bold" v-if="titleDialog && form.id"> 
                <p>Ticket</p>
                <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" @click="clickPrint('ticket')">
					<vue-feather type="file-minus" class="fs-vue-feather-18"></vue-feather>
                </button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
    export default {
        props: ['showDialogOptions', 'recordId'],
        data() {
            return {
                titleDialog: null,
                loading: false,
                resource: 'orders',
                errors: {},
                form: {}
            }
        },
        async created() {
            this.initForm()
			this.create();
        },
        methods: {
            initForm() {
                this.errors = {};
                this.form = {
                    id: null,
                    number: null,
					download_pdf: null
                };
            },
            create() {
                axios.get(`/${this.resource}/record/${this.recordId}`).then(response => {
                    this.form = response.data.data;
                    this.titleDialog = 'Orden de Laboratorio: '+this.form.number;
                });
            },
            clickPrint(format){
                window.open(`/${this.resource}/imprimir/${this.form.id}/${format}`, '_blank');
            },
			showClose(){
				this.$emit('showClose');
			}
        }
    }
</script>