<template>
  <div class="formRegister">
    <!--Listen click event form - .prevent automatically calls event.preventDefault() = stay on the page and process the data in JavaScript -->
    <form @submit.prevent="handleSubmit">
        <div
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
    {label:'Confirmation email', type:'email', placeholder:'Email', name:'confirmEmail', required: true, error:'Les emails ne sont pas iddentique'},
    {label:'Mot de passe', type:'password', placeholder:'Mot de passe', name:'password', required: true, error:'Mot de passe invalide'},
    {label:'Confirmation mot de passe', type:'password', placeholder:'Confirmation mot de passe', name:'confirmPassword', required: true, error:'Les mots de passe ne sont pas iddentiques'},
])

const handleSubmit = () => {
   
}
</script>

<style scoped>
.formRegister {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  background-color: #F9F5F0;
  font-family: sans-serif;
  padding: 40px;
}

form {
  background-color: #FDFBF7;
  border: 2px solid #944242;
  border-radius: 40px;
  padding: 40px;
  width: 100%;
  max-width: 400px;
  display: flex;
  flex-direction: column;
  gap: 15px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

form::before {
  content: "Inscription";
  display: block;
  text-align: center;
  font-size: 24px;
  font-weight: 500;
  color: #333;
  margin-bottom: 10px;
}

.form-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

label {
  font-size: 14px;
  color: #333;
  margin-left: 10px;
}

input {
  background-color: #EDE4D3;
  border: 1px solid #944242;
  border-radius: 20px;
  padding: 12px 20px;
  font-size: 14px;
  outline: none;
  transition: all 0.3s ease;
}

input:focus {
  background-color: #e5dac4;
  box-shadow: 0 0 0 2px rgba(148, 66, 66, 0.2);
}

button {
  margin-top: 20px;
  background-color: #EDE4D3;
  border: 1px solid #944242;
  border-radius: 25px;
  padding: 12px;
  font-size: 16px;
  font-weight: 500;
  color: #333;
  cursor: pointer;
  transition: all 0.3s ease;
  align-self: center;
  width: 60%;
}

button:hover {
  background-color: #944242;
  color: white;
}
</style>
