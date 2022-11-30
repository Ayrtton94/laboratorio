<template>
    <el-dialog :close-on-click-modal="false" :close-on-press-escape="false" :show-close="false" :title="titleDialog" :visible="showDialog"
               width="70%" @open="create">
        <div class="row mt-4">
            <div class="col-lg-4 col-md-4 col-sm-12 text-center font-weight-bold">
                <p>Imprimir Ticket</p>
                <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" @click="clickPrint('ticket')">
                    <i class="fa fa-ticket "></i>
                </button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 text-center font-weight-bold">
                <p>Imprimir A4</p>
                <button class="btn btn-lg btn-danger waves-effect waves-light" type="button" @click="clickPrint('a4')">
                    <i class="fa fa-file-alt"></i>
                </button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 text-center font-weight-bold">
                <p>Imprimir Despacho</p>
                <button class="btn btn-lg btn-info waves-effect waves-light" type="button" @click="clickPrint('despacho')">
                    <i class="fa fa-file-alt"></i>
                </button>
            </div>

        </div>
        <span slot="footer" class="dialog-footer">

            <template v-if="estadoimpresion == 2">
                <el-button @click="clickClose">Cerrar</el-button>
            </template>
            <template v-else>
                <template v-if="showClose">
                    <el-button @click="clickClose">Cerrar</el-button>
                </template>
                <template v-else>
                    <el-button class="list" @click="clickFinalize">Ir al listado</el-button>
                    <el-button class="list" @click="clickNewOrder">Nuevo Pedido</el-button>
                </template>
            </template>
<!--            <template v-if="showClose">-->
<!--                <el-button @click="clickClose">Cerrar</el-button>-->
<!--            </template>-->
<!--            <template v-else>-->
<!--                <el-button class="list" @click="clickFinalize">Ir al listado</el-button>-->
<!--				<el-button class="list" @click="clickNewOrder">Nuevo Pedido</el-button>-->
<!--            </template>-->
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ['showDialog', 'recordId', 'showClose','estadoimpresion','impredirecta'],
    data() {
        return {
            titleDialog: null,
            loading: false,
            resource: 'orders',
            errors: {},
            form: {},
            company: {}
        }
    },
    async created() {
        this.initForm()
        await this.$http.get(`/companies/record`)
            .then(response => {
                if (response.data !== '') {
                    this.company = response.data.data
                }
            })
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                customer_email: null,
                download_pdf: null,
                external_id: null,
                dominio_cliente: null,
                number: null,
                id: null,
                customer_phone: '',
            };
            this.company = {
                soap_type_id: null,
            }
        },
        create() {
            // debugger;
            this.$http.get(`/${this.resource}/record/${this.recordId}`).then( async response => {
                this.form = response.data.data;
                this.titleDialog = ' Pedido: ' + this.form.number;

                if(this.impresion.valor == 1){
                    await this.$http.get(`${this.form.url_base_print}?impresora=${this.form.nombre_impresora}&url=${this.form.download_url}`);
                    if(this.ventapaloteo.valor ==1){
                        await this.$http.get(`${this.form.url_base_print}?impresora=${this.form.nombre_impresora}&url=${this.form.download_id_url}`);
                    }
                }

            });
        },
        clickPrint(format) {
           window.open(`/orders/imprimir/${this.recordId}/${format}`, '_blank');
        },
        clickDownload(format) {
            window.open(`${this.form.download_pdf}/${format}`, '_blank');
        },
        clickSendWhatsapp() {
            let urlPDF = `${this.form.dominio_cliente}/orders/imprimirA4/${this.recordId}/A4`;
            window.open(`https://wa.me/51${this.form.customer_phone}?text=${encodeURIComponent(urlPDF)}`, '_blank');
        },
        clickSendEmail() {
            this.loading = true
            this.$http.post(`/${this.resource}/email`, {
                customer_email: this.form.customer_email,
                id: this.form.id
            })
                .then(response => {
                    if (response.data.success) {
                        this.$message.success('El correo fue enviado satisfactoriamente')
                    } else {
                        this.$message.error('Error al enviar el correo')
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    } else {
                        this.$message.error(error.response.data.message)
                    }
                })
                .then(() => {
                    this.loading = false
                })
        },
        clickFinalize() {
            this.clickClose();
        },
        clickNewOrder() {

            this.clickClose()
            location.href= '/orders/crear'
        },
        clickNewDocument() {
            this.clickClose()
        },
        clickClose() {
            this.$emit('update:showDialog', false)
            this.initForm()
        },
    }
}
</script>
