<script setup>
import { onMounted } from 'vue';
import Navbar from './components/layout/NavBar.vue';
import AppFooter from './components/layout/Footer.vue';
import { useAuthStore } from './stores/authStore';

const authStore = useAuthStore()

onMounted(()=>{ authStore.initAuth()
})

</script>

<template>
  <div class="app-layout">
    <Navbar/>
    
    <main class="main-content">
      <router-view />
    </main>
    
    <AppFooter />
  </div>
</template>

<style >
body {
  margin: 0;
  padding: 0;
  background-color: #F9F5F0;}

.app-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
}

@media (min-width: 992px) {
  .main-content {
    padding: 0 clamp(40px, 6vw, 100px);
  }
}

@media (min-width: 1200px) {
  .main-content {
    padding: 0 clamp(100px, 10vw, 160px);
  }
}
</style>
