import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import Register from '@/views/auth/Register.vue'
import AboutUs from '@/views/AboutUs.vue'
import Login from '@/views/auth/Login.vue'
import Contact from '@/views/ContactUs.vue'
import Quest from '@/views/Quest.vue'

const routes = [
  { path: '/', component: HomeView, name:'Accueil'},
  { path: '/signin', component: Register, name:'Inscription'},
  { path: '/about', component: AboutUs, name:'Notre histoire'},
  { path: '/login', component: Login, name:'Se connecter'},
  { path: '/contact', component: Contact, name:'Contact'},
  { path: '/quests', component: Quest, name:'Quête'}
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
