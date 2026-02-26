<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-container">
      <h2 class="modal-main-title">Les Niveaux de Quête</h2>
      
      <div class="levels-grid">
        <div v-for="level in levelRules" :key="level.h3" class="level-card">
          <div class="level-icon">
            <img v-if="level.img" :src="`/src/assets/quetes/niveau/${level.img}`" :alt="level.h3" />
          </div>
          <div class="level-content">
            <h3 class="level-name">{{ level.h3 }}</h3>
            <p class="level-text">{{ level.text }}</p>
          </div>
        </div>
      </div>    
      </div>
  </div>
</template>

<script setup>

defineEmits(['close']);

const levelRules = [
  {
    h3: 'Fable - niveau 1', 
    img: 'lvl1Fable.png', 
    text: "La découverte accessible. C’est votre point d’entrée. Ces quêtes proposent d'explorer de nouveaux horizons sans contrainte majeure."
  },
  {
    h3: 'Légende - niveau 2', 
    img: 'lvl2Legende.png', 
    text: "L’exigence s’affirme. Le défi demande un peu plus d’attention. On attend de vous une immersion plus longue ou une action plus réfléchie."
  },
  {
    h3: 'Mythe - niveau 3', 
    img:'lvl3Mythe.png', 
    text: "L’immersion totale. Ici, vous changez de dimension. Ce rang marque les quêtes qui exigent une réflexion, une recherche ou une confrontation."
  },
  {
    h3: 'Odyssée - niveau 4', 
    img: 'lvl4Odysee.png', 
    text: "Le défi d’endurance. Préparez-vous pour le temps long. L'Odyssée récompense la persévérance : sagas monumentales ou parcours complexes."
  },
  {
    h3: 'Anthologie - niveau 5', 
    img: 'lvl5Anthologie.png', 
    text: "Le sommet de l’expertise. Le rang des maîtres. Une quête Anthologie est une quête d'exception : elle demande de l'érudition ou une vision globale."
  }
]
</script>

<style scoped>

</style>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  backdrop-filter: blur(4px);
}

.modal-container {
  background-color: #F9F5F0;
  width: 90%;
  max-width: 800px;
  max-height: 85vh;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  overflow-y: auto;
  position: relative;
}

.modal-main-title {
  text-align: center;
  color: #944242;
  font-family: serif;
  font-size: 28px;
  margin-bottom: 30px;
  border-bottom: 1px solid #e0dbd5;
  padding-bottom: 15px;
}

.levels-grid {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.level-card {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  padding-bottom: 20px;
  border-bottom: 1px inset #eeeae5;
}

.level-card:last-child {
  border-bottom: none;
}

.level-icon img {
  width: 90px;
  height: 90px;
  object-fit: contain;
  filter: sepia(0.4);
}

.level-name {
  font-size: 18px;
  font-weight: 600;
  color: #944242;
  margin: 0 0 5px 0;
}

.level-text {
  font-size: 15px;
  line-height: 1.5;
  color: #333;
  margin: 0;
  text-align: justify;
}

.close-button {
  display: block;
  margin: 30px auto 0;
  padding: 10px 25px;
  background-color: transparent;
  border: 1px solid #944242;
  color: #944242;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.close-button:hover {
  background-color: #944242;
  color: #F9F5F0;
}
</style>