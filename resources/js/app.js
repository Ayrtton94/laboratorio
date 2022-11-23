require('./bootstrap');

import { createApp } from 'vue'
import { axios } from 'axios'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

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
import search from './views/Usuarios/search.vue'
import usuariosform from './views/Usuarios/form.vue'
import usuarioseditar from './views/Usuarios/edit.vue'
//ROLES
import roles from './views/Roles/index.vue'
import rolesform from './views/Roles/form.vue'
import roleseditar from './views/Roles/edit.vue'
//PERMISOS
import permisos from './views/Permissions/index.vue'
//PACIENTES
import patiends from './views/Patients/index.vue'
import patiendsform from './views/Patients/form.vue'

//PRESENTACIONES
import presentaciones from './views/presentaciones/index.vue'
import presentacionesform from './views/presentaciones/form.vue'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.mixin(Permissions);

app.use(VueSweetalert2);
app.use(axios);
app.use(ElementPlus);

app.component(VueFeather.name, VueFeather);
app.component('dashboard', dashboard)

//USUARIOS
app.component('usuarios', usuarios)
app.component('usuarios-search', search)
app.component('usuarios-create', usuariosform)
app.component('usuarios-editar', usuarioseditar)

//ROLES
app.component('roles', roles)
app.component('roles-create', rolesform)
app.component('roles-editar', roleseditar)

//PERMISOS
app.component('permissions', permisos)

//PACIENTES
app.component('patiends', patiends)
app.component('patients-create', patiendsform)


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


app.mount('#app')