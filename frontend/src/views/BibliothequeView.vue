<template>
    <main class="main-content">
      <BibliothequeSearch />
      <BibliothequeList />
    </main>
</template>

<script setup>
import BibliothequeSearch from '@/components/bibliotheque/BibliothequeSearch.vue';
import BibliothequeList from '@/components/bibliotheque/BibliothequeList.vue';

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