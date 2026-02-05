<template>
  <div class="formRegister">
    <!--Listen click event form - .prevent automatically calls event.preventDefault() = stay on the page and process the data in JavaScript -->
    <form @submit.prevent="handleSubmit">

        <div action=""
        v-for="form in formItems"
        :key="form.name"
        class="form-item"
        >

        <label :for="form.name">{{ form.label }}</label>
        
        <input 
        :type="form.type"
        :placeholder="form.placeholder"
        :id="form.name"
        :required="form.required"
        v-model="formData[form.name]" 
         >
        </div>
    
        <button type="submit">S'inscrire</button>
    </form>
  </div>
  
</template>

<script setup>
import { reactive } from 'vue';

const formData = reactive({
    identifiant:"",
    email:"",
    confirmEmail:"",
    password:"",
    confirmPassword:""
})

const formItems = reactive([
    {label:'Identifiant', type:'text', placeholder:'Identifiant', name:'identifiant', required: true, error:'Identifiant déjà utiliser'},
    {label:'Email', type:'email', placeholder:'Email', name:'email', required: true, error:'Email invalide'},
    {label:'Confirmation email', type:'email', placeholder:'email', name:'confirmEmail', required: true, error:'Les emails ne sont pas iddentique'},
    {label:'Mot de passe', type:'password', placeholder:'Mot de passe', name:'password', required: true, error:'Mot de passe invalide'},
    {label:'Confirmation mot de passe', type:'password', placeholder:'Confirmation mot de passe', name:'confirmPassword', required: true, error:'Les mots de passe ne sont pas iddentiques'},
])

const handleSubmit = () => {
   
}
</script>

<style scoped>
</style>
