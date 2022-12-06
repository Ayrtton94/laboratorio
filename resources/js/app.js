require('./bootstrap');

import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import { axios } from 'axios'

import dashboard from './views/Dashboard/DashboardComponent.vue'
// SweetAlert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// FEATHER ICONS
import VueFeather from 'vue-feather'

import mitt from 'mitt';
import Permissions from './mixins/Permissions.js';
// USUARIOS
import usuarios from './views/Usuarios/index.vue'

//ROLES
import roles from './views/Roles/index.vue'
//PERMISOS
import permisos from './views/Permissions/index.vue'
import areas from './views/Area/index.vue'
import tipodeorden from './views/Tipodeorden/index.vue'


//PRESENTACIONES
import presentaciones from './views/presentaciones/index.vue'
import presentacionesform from './views/presentaciones/form.vue'

import especies from './views/especies/index.vue'
import especiesform from './views/especies/form.vue'

import subespecies from './views/subespecies/index.vue'
import subespeciesform from './views/subespecies/form.vue'

import matrices from './views/matrices/index.vue'
import matricesform from './views/matrices/form.vue'

import muestras from './views/muestras/index.vue'
import muestrasform from './views/muestras/form.vue'

import laboratorios from './views/laboratorios/index.vue'
import laboratoriosform from './views/laboratorios/form.vue'

import metodos from './views/metodos/index.vue'
import metodosform from './views/metodos/form.vue'

import pruebas from './views/pruebas/index.vue'
import pruebasform from './views/pruebas/form.vue'
import persons from './views/Persons/index.vue'

import attendance from './views/Attendance/index.vue'

import orders from './views/orders/index.vue'
import ordersinvoice from './views/orders/invoice.vue'

import programabrucellas from './views/programabrucellas/index.vue'
import programabrucellasform from './views/programabrucellas/form.vue'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.mixin(Permissions);
// app.use(ElementPlus, { size: 'mini', zIndex: 3000 })
for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
	app.component(key, component)
}

app.use(ElementPlus, {size: 'mini'});
app.use(VueSweetalert2);
app.use(axios);


app.component(VueFeather.name, VueFeather);
app.component('dashboard', dashboard)

//USUARIOS
app.component('usuarios', usuarios)

//ROLES
app.component('roles', roles)

//PERMISOS
app.component('permissions', permisos)

//PRESENTACIONES
app.component('presentaciones', presentaciones)
app.component('presentaciones-create', presentacionesform)

//ESPECIES
app.component('especies', especies)
app.component('especies-create', especiesform)

//SUB-ESPECIES
app.component('subespecies', subespecies)
app.component('subespecies-create', subespeciesform)

//MATRIZ
app.component('matrices', matrices)
app.component('matrices-create', matricesform)

//MUESTRAS
app.component('muestras', muestras)
app.component('muestras-create', muestrasform)

//LABORATORIO
app.component('laboratorios', laboratorios)
app.component('laboratorios-create', laboratoriosform)

//METODOS
app.component('metodos', metodos)
app.component('metodos-create', metodosform)

//PRUEBA
app.component('pruebas', pruebas)
app.component('pruebas-create', pruebasform)

//AREA
app.component('areas', areas)

//TIPO DE ORDEN
app.component('tipodeorden', tipodeorden)

//PERSONAS
app.component('persons', persons)

//ASISTENCIAS
app.component('attendance', attendance)

//ORDENES
app.component('orders', orders);
app.component('orders-invoice', ordersinvoice);

//PROGRAMA BRUCELLAS
app.component('programabrucellas', programabrucellas);
app.component('programabrucellas-create', programabrucellasform)

app.mount('#app')
