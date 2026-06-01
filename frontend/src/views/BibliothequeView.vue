<template>
    <main class="main-content">
      <BibliothequeSearch @bookAdded="refreshList" />
      <BibliothequeList :key="listKey" />
    </main>
</template>

<script setup>
import { ref } from 'vue';
import BibliothequeSearch from '@/components/bibliotheque/BibliothequeSearch.vue';
import BibliothequeList from '@/components/bibliotheque/BibliothequeList.vue';

const listKey = ref(0)
const refreshList = () => listKey.value++

</script>

<style scoped>
.main-content {
  display: flex;
  flex-direction: column;
  gap: 0;
  background-color: #FDF8F3;
  min-height: 100vh;
}
</style>