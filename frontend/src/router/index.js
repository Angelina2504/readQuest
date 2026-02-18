import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import Register from '@/views/auth/Register.vue'
import AboutUs from '@/views/AboutUs.vue'

const routes = [
  { path: '/', component: HomeView, name:'Accueil'},
  { path: '/signin', component: Register, name:'Inscription'},
  { path: '/about', component: AboutUs, name:'Notre histoire'}
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
