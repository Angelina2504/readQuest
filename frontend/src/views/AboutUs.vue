<template>

    <div class="button-group">
        <router-link 
          v-for="about in aboutLinks" 
          :key="about.text" 
          :to="about.path" 
          class="custom-button"
        >
          {{ about.text }}
        </router-link>
    </div>

    <div class="img-deco">
       <img src="@/assets/deco/aboutLessBG.png" alt="Illustration ReadQuest" />
     </div>
</template>

<script setup>
const aboutLinks = ([

    { text: 'ReadQuest', path: '/signin', isHovered: false },
    { text: 'Livresse podcast', path: '/login', isHovered: false },

])
</script>

<style scoped>
</style>