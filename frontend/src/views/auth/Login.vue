<template>
  <div class="form-Login-container">
    <form @submit.prevent="handleSubmit">
      <div 
        v-for="item in loginItems" 
        :key="item.name" 
        class="form-item"
      >
        <label :for="item.name">{{ item.label }}</label>
        
        <input 
          :type="item.type"
          :placeholder="item.placeholder" 
          :id="item.name"
          :required="item.required"
          v-model="loginData[item.name]"
        >
      </div>

      <button type="submit">Se connecter</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';

const loginData = reactive({
    identifiant: "",
    password: "",
})

const loginItems = reactive([
    { label: 'Identifiant', type: 'text', placeholder: 'Identifiant', name: 'identifiant', required: true },
    { label: 'Mot de passe', type: 'password', placeholder: 'Mot de passe', name: 'password', required: true }
])

const handleSubmit = () => {
    
}
</script>

<style scoped>

.form-Login-container {
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
  content: "Se connecter";
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