<template>
  <div class="contact-form-container">
    <form @submit.prevent="handleSubmit">
      <h2 class="form-title">CONTACTEZ-NOUS</h2>

      <div class="top-row">
        <div v-for="item in contactItems.slice(0, 2)" :key="item.name" class="form-item">
          <label :for="item.name">{{ item.label }}</label>
          <input 
            :type="item.type" 
            :id="item.name" 
            v-model="contactData[item.name]" 
            :placeholder="item.placeholder"
          >
        </div>
      </div>

      <div class="form-item full-width">
        <label for="message">Raconte ton histoire</label>
        <textarea 
          id="message" 
          v-model="contactData.message" 
          placeholder="Raconte ton histoire..."
        ></textarea>
      </div>

      <button type="submit">Envoyer</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';

const contactData = reactive({
  email: '',
  objet: '',
  message: ''
})

const contactItems = [
  { label: 'Email', type: 'email', name: 'email', placeholder: 'Email' },
  { label: 'Objet', type: 'text', name: 'objet', placeholder: 'Objet' }
]

const handleSubmit = () => {
}
</script>

<style scoped>

.contact-form-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  background-color: #F9F5F0; 
}

form {
  background-color: #FDFBF7; 
  border: 1.5px solid #A66D6D; 
  border-radius: 50px; 
  padding: 40px;
  width: 100%;
  max-width: 700px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.form-title {
  font-size: 1.2rem;
  color: #333;
  margin-bottom: 10px;
  letter-spacing: 1px;
}

.top-row {
  display: flex;
  width: 100%;
  gap: 30px;
}

.form-item {
  display: flex;
  flex-direction: column;
  flex: 1; 
  text-align: center;
}

.full-width {
  width: 100%;
}

label {
  margin-bottom: 5px;
  font-size: 0.9rem;
  color: #333;
}

input, textarea {
  background-color: #EDE4D3;
  border: 1px solid #944242;
  border-radius: 25px;
  padding: 10px 20px;
  outline: none;
}


textarea {
  border-radius: 40px;
  height: 150px;
  resize: vertical;

}

button {
  background-color: #EDE4D3;
  border: 1.5px solid #944242;
  border-radius: 20px;
  padding: 8px 40px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.3s;
}

button:hover {
  background-color: #944242;
  color: white;
}
</style>