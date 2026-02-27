<template>
  <img 
    class="button-question" 
    :src="buttonImgPopup" 
    alt="Aide"
    @click="isOpen = true"/>
  

  <Teleport to="body">
    
    <div class="modal-overlay" v-if="isOpen"  @click.self="isOpen = false">
      
      <div class="modal-content">
        <button class="close-btn" @click="isOpen = false">X</button>

        <slot></slot>
      </div>

    </div>
  </Teleport>
 
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  buttonImgPopup: {
    type: String,
    default: '/src/assets/icons/ptInterogationBlack.png'
  }
});

const isOpen = ref(false);

</script>

<style scoped>
.button-question {
  cursor: pointer;
  width: 25px;
  transition: 0.2s;
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100vw; height: 100vh;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-content {
  background-color: #F9F5F0;
  width: 90%;
  max-width: 600px;
  max-height: 300px;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  overflow-y: auto;
  position: relative;
}
.modal-content::-webkit-scrollbar {
  width: 8px;
}

.modal-content::-webkit-scrollbar-track {
  background: #F1E9DB; 
  border-radius: 10px;
}

.modal-content::-webkit-scrollbar-thumb {
  background: #944242; 
  border-radius: 10px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
  background: #7a3535;
}

.close-btn {
  display: block;
  position:sticky;
  margin-left: auto;
  top: 0; 
  right: 10px;
  cursor: pointer;
  border: none; background: none;
  font-weight: bold;
}
</style>