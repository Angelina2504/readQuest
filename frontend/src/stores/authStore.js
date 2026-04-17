import { ref, computed } from 'vue'
import { defineStore } from 'pinia'


export const useAuthStore = defineStore('auth', () => {
  const isAuthenticated = ref(false)
  const token = ref(null)
  const userRoles = ref([])
  const isAdmin = computed(() => userRoles.value.includes('ROLE_ADMIN'))


  function login(newtoken, newUserRoles){
    isAuthenticated.value = true;
    token.value = newtoken;
    userRoles.value = newUserRoles;

    localStorage.setItem('token', newtoken);
    localStorage.setItem('user_roles',JSON.stringify(newUserRoles))
    }

  function logout(){
    isAuthenticated.value = false;
    token.value = null;
    userRoles.value = [];

    localStorage.removeItem('token');
    localStorage.removeItem('user_roles');
  }

  // is used to rebuild the  the store state on page refresh
  function initAuth(){

    const savedToken = localStorage.getItem('token')
    const savedRole = JSON.parse(localStorage.getItem('user_roles') || '[]')

    if (savedToken){
    isAuthenticated.value = true
    token.value = savedToken
    userRoles.value = savedRole
    }
  }

  return { isAuthenticated, token, userRoles, login, logout, initAuth, isAdmin }
})
