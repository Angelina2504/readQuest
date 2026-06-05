<template>
  <main>
    <QuestList/>
    <MyQuest v-if="authStore.isAuthenticated"/>

  </main>
</template>

<script setup>
import QuestList from '@/components/quest/QuestList.vue';
import MyQuest from '@/components/quest/MyQuest.vue';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore()

</script>

<style scoped>

</style>