import { createRouter, createWebHistory } from 'vue-router'
import usuarios from '../components/Usuarios/index.vue'
const routes = [
	{
		path: '/',
		component: usuarios
	}
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
})

export default router