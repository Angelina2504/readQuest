import { createRouter, createWebHistory } from 'vue-router';
import AboutUs from '@/views/AboutUs.vue';
import AdminView from '@/views/adminSystem/AdminView.vue';
import Contact from '@/views/ContactUs.vue';
import HomeView from '@/views/HomeView.vue';
import Login from '@/views/auth/LoginAuth.vue';
import Profil from '@/views/ProfilUser.vue';
import Quest from '@/views/Quest.vue';
import Register from '@/views/auth/Register.vue';
import Bibliotheque from '@/views/BibliothequeView.vue'
import { useAuthStore } from '@/stores/authStore';

const routes = [
  // visitor
  { path: '/', component: HomeView, name:'Accueil'},
  { path: '/about', component: AboutUs, name:'Notre histoire'},
  { path: '/contact', component: Contact, name:'Contact'},
  { path: '/login', component: Login, name:'Se connecter',  meta: {requiresAuth : false}},
  { path: '/signin', component: Register, name:'Inscription', meta: {requiresAuth : false}},

  // user
  { path: '/profil', component: Profil, name:'Profil', meta: {requiresAuth : true}},
  { path: '/quests', component: Quest, name:'Quête', meta: {requiresAuth : true}},
  { path: '/bibliotheque', component: Bibliotheque, name:'Bibliotheque', meta: {requiresAuth : true}},

  //admin
  { path: '/admin', component: AdminView, name:"Admin", meta:{requiresAdmin : true}},
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  const isConnected = authStore.isAuthenticated;
  const isAdmin = authStore.isAdmin;

  if (to.meta.requiresAdmin) {
    if (isConnected && isAdmin) {
      next();
    } else {
      next({ name: 'Accueil' });
    }
  } 
  else if (to.meta.requiresAuth) {
    if (isConnected) {
      next();
    } else {
      next({ name: 'Se connecter' });
    }
  }
  else if (to.meta.requiresAuth === false && isConnected) {
      next("/profil")
  }
  else {
    next();
  }
});

export default router
