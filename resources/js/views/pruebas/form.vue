<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" append-to-body  
		:close-on-modal="false"
		:show-close="false"
		:close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
				<div class="row">
                    <div class="col-md-12">
                        <div :class="{'has-danger': errors.matriz_id}" class="form-group">
                            <label class="control-label d-block">Matrices</label>
                            <el-select v-model="form.matriz_id" class="w-100" dusk="matriz_id" filterable>
                                <el-option v-for="option in matrices" :key="option.id" :label="option.description"  :value="option.id"></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div :class="{'has-danger': errors.muestra_id}" class="form-group">
                            <label class="control-label d-block">Muestras</label>
                            <el-select v-model="form.muestra_id" class="w-100" dusk="muestra_id" filterable>
                                <el-option v-for="option in muestras" :key="option.id" :label="option.description"  :value="option.id"></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">Nombre</label>
                            <el-input v-model="form.name" ref="name"></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div> 
                </div>
				<div class="row">
                    <div class="col-md-9">
                        <div class="form-group" :class="{'has-danger': errors.price}">
                            <label class="control-label">Precio</label>
                            <el-input v-model="form.price" ref="price"></el-input>
                            <small class="form-control-feedback" v-if="errors.price" v-text="errors.price[0]"></small>
                        </div>
                    </div> 
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div :class="{'has-danger': errors.laboratorio_id}" class="form-group">
                            <label class="control-label d-block">Laboratorio</label>
                            <el-select v-model="form.laboratorio_id" class="w-100" dusk="laboratorio_id" filterable>
                                <el-option v-for="option in laboratorios" :key="option.id" :label="option.description"  :value="option.id"></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div :class="{'has-danger': errors.metodo_id}" class="form-group">
                            <label class="control-label d-block">Metodo</label>
                            <el-select v-model="form.metodo_id" class="w-100" dusk="metodo_id" filterable>
                                <el-option v-for="option in metodos" :key="option.id" :label="option.description"  :value="option.id"></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-9">
                        <div class="form-group" :class="{'has-danger': errors.condicion}">
                            <label class="control-label">Condicion</label>
                            <el-input v-model="form.condicion" ref="condicion"></el-input>
                            <small class="form-control-feedback" v-if="errors.condicion" v-text="errors.condicion[0]"></small>
                        </div>
                    </div> 
                </div>
				<div class="row">
                    <div class="col-md-9">
                        <div class="form-group" :class="{'has-danger': errors.time_entrega}">
                            <label class="control-label">Tiempo de Entrega</label>
                            <el-input v-model="form.time_entrega" ref="time_entrega"></el-input>
                            <small class="form-control-feedback" v-if="errors.time_entrega" v-text="errors.time_entrega[0]"></small>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>

</template>

<script>

    export default {
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'pruebas',
                errors: {},
                form: {},
                options: [],
				matrices: [],
				muestras: [],
				laboratorios: [],
				metodos: []
            }
        },
        created() {
            this.initForm()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    id: null, 
					matriz_id: null,
					muestra_id: null,
					laboratorio_id: null,
					metodo_id: null,
                    name: null,
					price: 0,
					condicion: null,
					time_entrega: null
                }
            },
            create() {
            
                this.titleDialog = (this.recordId)? 'Editar Registro de Pruebas':'Nuevo Registro de Pruebas';

                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data 
                        })                        
                } 
            },
			tables() {
				this.$http.get(`/${this.resource}/tables`)
					.then(response => {
						this.matrices = response.data.matrices
						this.muestras = response.data.muestras
						this.labortorios = response.data.labortorios
						this.metodos = response.data.metodos
					})
			},
            submit() {
                this.loading_submit = true                  
                this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data 
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
        }
    }
</script>
