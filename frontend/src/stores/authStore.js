import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { jwtDecode } from 'jwt-decode'

export const useAuthStore = defineStore('auth', () => {
  const isAuthenticated = ref(false)
  const token = ref(null)
  const userRoles = ref([])
  const isAdmin = computed(() => userRoles.value.includes('ROLE_ADMIN'))


  function login(newtoken){
    const decoded = jwtDecode(newtoken)
    const roles = decoded.roles

    userRoles.value = roles
    isAuthenticated.value = true;
    token.value = newtoken;

    localStorage.setItem('token', newtoken);
    localStorage.setItem('user_roles',JSON.stringify(roles))
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

    if (!savedToken) {
     return
    } 

    const decoded = jwtDecode(savedToken)
    const isExpired = decoded.exp < Date.now() / 1000

    if(isExpired) {
    logout()
    return
    }else{
    isAuthenticated.value = true
    token.value = savedToken
    userRoles.value = savedRole 
    return 
    }}

  return { isAuthenticated, token, userRoles, login, logout, initAuth, isAdmin }
})
