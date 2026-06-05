<template>
  <main>
    <InfoPopup>
      <LevelRules/>
    </InfoPopup>
    <QuestList/>
    <MyQuest v-if="authStore.isAuthenticated"/>

  </main>
</template>

<script setup>
import InfoPopup from '@/components/Base/InfoPopup.vue';
import LevelRules from '@/components/information/LevelRules.vue';
import QuestList from '@/components/quest/QuestList.vue';
import MyQuest from '@/components/quest/MyQuest.vue';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore()

</script>

<style scoped>

</style>