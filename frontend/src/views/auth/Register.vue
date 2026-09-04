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

        <span class="error-message" v-if="form.displayError">{{ form.error }}</span>
       
        </div>

        <p class="error-message" v-if="errorMessage">{{ errorMessage }}</p>

        <button type="submit">S'inscrire</button>
    </form>
  </div>
  
</template>

<script setup>
import { reactive, ref } from 'vue';
import { authService } from '@/services/authService';
import { useRouter } from 'vue-router';

const router = useRouter();

const isLoading = ref(false)

const errorMessage = ref(null)

const formData = reactive({
    identifiant:"",
    email:"",
    confirmEmail:"",
    password:"",
    confirmPassword:""
})

const formItems = reactive([
    {label:'Identifiant', type:'text', placeholder:'Identifiant', name:'identifiant', required: true, error:'Identifiant déjà utiliser',displayError: false},
    {label:'Email', type:'email', placeholder:'Email', name:'email', required: true, error:'Email invalide', displayError: false},
    {label:'Confirmation email', type:'email', placeholder:'Email', name:'confirmEmail', required: true, error:'Les emails ne sont pas identiques', displayError: false},
    {label:'Mot de passe', type:'password', placeholder:'Mot de passe', name:'password', required: true, error:'Mot de passe invalide', displayError: false},
    {label:'Confirmation mot de passe', type:'password', placeholder:'Confirmation mot de passe', name:'confirmPassword', required: true, error:'Les mots de passe ne sont pas identiques', displayError: false},
])

const handleSubmit = async () => {
  formItems.forEach(item => {item.displayError = false
  });
  
  if (formData.email !== formData.confirmEmail) {
    const itemEmail = formItems.find(item => item.name === 'confirmEmail')
    itemEmail.displayError = true
    return
  }
  if (formData.password !== formData.confirmPassword) {
    const itemPassword = formItems.find(item => item.name === 'confirmPassword')
    itemPassword.displayError = true
    return
  }

  try {
    errorMessage.value = null;
    isLoading.value = true;
    await authService.register(formData.identifiant, formData.email, formData.password) ;
    router.push('/login')
  } catch (error) { 
    if (error.response?.status === 409){
      errorMessage.value = "Cette adresse email est déjà utilisée"
   } else {
     errorMessage.value = "Une erreur est survenue, veuillez réessayer"
  }} finally {
    isLoading.value = false
  }
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
  background-color: #FDF8F3;
  border: 2px solid #833c3c;
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
  color: #333333;
  margin-bottom: 10px;
}

.form-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

label {
  font-size: 14px;
  color: #333333;
  margin-left: 10px;
}

input {
  background-color: #EDE4D3;
  border: 1px solid #833c3c;
  border-radius: 20px;
  padding: 12px 20px;
  font-size: 14px;
  outline: none;
  transition: all 0.3s ease;
}

input:focus {
  background-color: #EDE4D3;
  box-shadow: 0 0 0 2px rgba(148, 66, 66, 0.2);
}

button {
  margin-top: 20px;
  background-color: #EDE4D3;
  border: 1px solid #833c3c;
  border-radius: 25px;
  padding: 12px;
  font-size: 16px;
  font-weight: 500;
  color: #333333;
  cursor: pointer;
  transition: all 0.3s ease;
  align-self: center;
  width: 60%;
}

button:hover {
  background-color: #833c3c;
  color: #FFFFFF;
}

.error-message{
  color: #A50000;
  padding: 10px 10px 0px 50px ;
}

@media (max-width: 768px) {
  .formRegister {
    padding: 24px 16px;
    align-items: flex-start;
  }
  form {
    border-radius: 20px;
    padding: 28px 20px;
  }
}
</style>
