<template>
  <main>
    <QuestList  @joinQuests="refreshList"/>
    <MyQuest v-if="authStore.isAuthenticated" :key="listKey"/>

  </main>
</template>

<script setup>
import QuestList from '@/components/quest/QuestList.vue';
import MyQuest from '@/components/quest/MyQuest.vue';
import { useAuthStore } from '@/stores/authStore';
import { ref } from 'vue';

const authStore = useAuthStore();
const refreshList = () => listKey.value++;
const listKey = ref(0);

</script>

<style scoped>

</style>