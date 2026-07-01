<template>
    <div class="quest-wrapper">
        <h2 class="quest-title">Mes quêtes</h2>
        <p v-if="participations.length === 0" class="empty">Aucune quête en cours.</p>
        <div class="quest-grid">
            <div class="quest-card" v-for="participation in participations" :key="participation.participation_id">
                <img :src="'/src/assets/quetes/quest/' + participation.quest_badge" :alt="participation.quest_badge" class="quest-badge" />
                <p class="quest-name">{{ participation.quest_title }}</p>
                <div class="difficulty-row">
                    <span class="quest-difficulty">{{ participation.quest_difficulty }}</span>
                    <InfoPopup :buttonSize="16"><LevelRules/></InfoPopup>
                </div>
                <p class="quest-description">{{ participation.quest_description }}</p>
                <p class="quest-progression">{{ participation.particip_progression }} / {{ participation.quest_criteria_target }}</p>
                <button class="btn-leave" @click="leaveQuest(participation.quest_id)">Quitter la quête</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import LevelRules from '../information/LevelRules.vue';
import InfoPopup from '../Base/InfoPopup.vue';
import { questService } from '@/services/questService';
import { onMounted, ref } from 'vue';

const errorMessage = ref(null)
const participations = ref([])

onMounted(async () => {
  try {
    participations.value = await questService.getMyQuests()
  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
})

const leaveQuest = async(id) => {
  try {
    await questService.leaveQuests(id)
    participations.value = participations.value.filter(participations => participations.quest_id !== id)
  } catch (error) {
     console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
}

</script>

<style scoped>
.quest-wrapper {
  padding: 0 20px 40px;
  background-color: #FDF8F3;
}

.quest-title {
  font-size: 20px;
  font-weight: 600;
  color: #833c3c;
  margin-bottom: 24px;
}

.empty {
  color: #525252;
  font-size: 14px;
}

.quest-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}

.quest-card {
  background: #FFFFFF;
  border: 2px solid #EDE4D3;
  border-radius: 16px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: border-color 0.2s ease;
}

.quest-card:hover {
  border-color: #833c3c;
}

.quest-badge {
  width: 80px;
  height: 80px;
  object-fit: contain;
}

.quest-name {
  margin: 0;
  font-size: 15px;
  font-weight: 600;
  color: #333333;
  text-align: center;
}

.difficulty-row {
  display: flex;
  align-items: center;
  gap: 6px;
}

.quest-difficulty {
  font-size: 12px;
  color: #FFFFFF;
  background-color: #833c3c;
  border-radius: 25px;
  padding: 4px 12px;
}

.quest-description {
  margin: 0;
  font-size: 13px;
  color: #525252;
  text-align: center;
}

.quest-progression {
  font-size: 14px;
  font-weight: 600;
  color: #833c3c;
  margin: 0;
}

.btn-leave {
  padding: 6px 16px;
  background-color: #FFFFFF;
  border: 2px solid #7a3535;
  border-radius: 25px;
  color: #7a3535;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-leave:hover {
  background-color: #7a3535;
  color: #FFFFFF;
}

@media (max-width: 768px) {
  .quest-wrapper {
    padding: 0 16px 32px;
  }
  .quest-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 14px;
  }
}
</style>