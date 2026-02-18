<template>
  <div class="home-container">
    <div class="content-left">
      <p class="hero-text">
        Les pages murmurent des défis. Accomplis des quêtes, récolte des récompenses et explore un monde sculpté par les mots.
      </p>
      
      <div class="button-group">
        <router-link 
          v-for="button in buttonLinks" 
          :key="button.text" 
          :to="button.path" 
          class="custom-button"
        >
          {{ button.text }}
        </router-link>
      </div>
    </div>

    <div class="img-deco">
       <img src="@/assets/deco/homeLessBG.png" alt="Illustration ReadQuest" />
    </div>
  </div>
</template>

<script setup>

const buttonLinks = ([

    { text: 'Inscription', path: '/signin', isHovered: false },
    { text: 'Se connecter', path: '/login', isHovered: false },

])

</script>

<style scoped>
.home-container {
  display: flex;
  align-items: center;
  justify-content: space-around;
  padding: 50px;
  gap: 20px;
  background-color: #FDF8F3; 
  min-height: 60vh;
}

.content-left {
  max-width: 450px;
  text-align: center; 
}

.hero-text {
  font-size: 1.5rem;
  line-height: 1.4;
  color: #1a1a1a;
  margin-bottom: 40px;
  padding: 30px;
}

.button-group {
  display: flex;
  gap: 40px;
  justify-content: center;
}

.custom-button {
  display: inline-block;
  padding: 12px 30px;
  background-color: #EDE4D3;
  border: 1px solid #944242;
  border-radius: 25px;  
  color: #1a1a1a;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.custom-button:hover {
 background-color: #944242;
  color: white;
  transform: translateY(-2px);
}

.img-deco img {
  max-width: 100%;
  height: auto;

}

</style>
