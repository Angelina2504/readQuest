<script setup>
import Navbar from './components/layout/Navbar.vue';
import AppFooter from './components/layout/Footer.vue';

</script>

<template>
  <div class="app-layout">
    <Navbar />
    
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
</style>
