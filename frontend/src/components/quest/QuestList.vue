<template>
    <div class="quest-wrapper">
        <h2 class="quest-title">Quêtes disponibles</h2>
        <p v-if="quests.length === 0" class="empty">Aucune quête disponible pour le moment.</p>
        <div class="quest-grid">
            <div class="quest-card" v-for="quest in quests" :key="quest.quest_id">
                <img :src="'/src/assets/quetes/quest/' + quest.quest_badge" :alt="quest.quest_badge" class="quest-badge" />
                <p class="quest-name">{{ quest.quest_title }}</p>
                <div class="difficulty-row">
                    <span class="quest-difficulty">{{ quest.quest_difficulty }}</span>
                    <InfoPopup :buttonSize="16"><LevelRules/></InfoPopup>
                </div>
                <p class="quest-description">{{ quest.quest_description }}</p>
                <button v-if="authStore.isAuthenticated" class="btn-join" @click="handleJoin(quest.quest_id)">Rejoindre</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { questService } from '@/services/questService';
import { useAuthStore } from '@/stores/authStore';
import LevelRules from '../information/LevelRules.vue';
import InfoPopup from '../Base/InfoPopup.vue';

const authStore = useAuthStore()
const errorMessage = ref(null);
const quests = ref([]);
const emit = defineEmits(['joinQuests'])

onMounted(async () => {
  try {
    quests.value = await questService.getQuest()
  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
})

const handleJoin = async (id) => {
    try {
        await questService.joinQuests(id)
        emit('joinQuests')
    } catch (error) {
        console.error("Erreur:", error);
    }
}

</script>

<style scoped>
.quest-wrapper {
  padding: 40px 20px 16px;
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

.btn-join {
  padding: 6px 20px;
  background-color: #FFFFFF;
  border: 2px solid #833c3c;
  border-radius: 25px;
  color: #833c3c;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-join:hover {
  background-color: #833c3c;
  color: #FFFFFF;
}

@media (max-width: 768px) {
  .quest-wrapper {
    padding: 24px 16px 12px;
  }
  .quest-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 14px;
  }
}
</style>