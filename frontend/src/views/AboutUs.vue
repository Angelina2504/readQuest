<template>
  <div class="about-page">
    <div class="about-container">
      <div class="about-column">
        <router-link :to="aboutLinks[0].path" class="about-title">{{ aboutLinks[0].text }}</router-link>
        <p class="about-text">
          Créer un moyen de rebooster l’envie de lire en s’amusant. Toujours motivé par des challenges, 
          je me suis dit que des challenges littéraires seraient la solution pour sortir de son confort 
          littéraire ou pour découvrir la littérature.
        </p>
      </div>

      <div class="img-deco">
        <img src="@/assets/deco/aboutLessBG.png" alt="Illustration ReadQuest" />
      </div>

      <div class="about-column">
        <a :href="aboutLinks[1].url" target="_blank" class="about-title">{{ aboutLinks[1].text }}</a>
        <p class="about-text">
          La création d’un podcast littéraire m’a poussé à vouloir aller plus loin, à créer plus 
          dans un univers que j’aime. Livresse est un podcast littéraire où des copains discutent 
          d’une lecture commune autour d’un livre !
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
const aboutLinks = ([

    { text: 'ReadQuest', path: '/quests', isHovered: false },
    { text: 'Livresse podcast', url: 'https://linktr.ee/LivressePodcast', isHovered: false },

])
</script>

<style scoped>
.about-page {
  background-color: #F9F5F0;
  min-height: 60vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 20px;
}

.about-container {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 1000px;
  gap: 40px;
}

.about-column {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
  text-align: center;
}

.about-title {
  font-size: 20px;
  font-weight: 500;
  color: #333;
  text-decoration: none;
  margin-bottom: 10px;
}

.about-title:hover {
  color: #944242;
}

.about-text {
  font-size: 16px;
  line-height: 1.6;
  color: #333;
  margin: 0;
}

.img-deco {
  flex: 0 0 auto;
}

.img-deco img {
  max-height: 400px; /* Ajuste selon la taille de ton image */
  width: auto;
  filter: sepia(0.2); 
}
</style>