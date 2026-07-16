<template>
    <main class="main-content">
      <BibliothequeSearch @bookAdded="onBookAdded" />
      <BibliothequeList ref="listRef" />
    </main>
</template>

<script setup>
import { ref } from 'vue';
import BibliothequeSearch from '@/components/bibliotheque/BibliothequeSearch.vue';
import BibliothequeList from '@/components/bibliotheque/BibliothequeList.vue';

const listRef = ref(null)
const onBookAdded = (reading) => {
    if (reading) listRef.value?.addBook(reading)
}
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