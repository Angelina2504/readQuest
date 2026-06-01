<template>
    <div v-for="book in library" :key="book.book_isbn">
        <img :src="book.book_cover" :alt="book.book_name" />
        <p>{{ book.book_name }}</p>
        <p>{{ book.reading_status }}</p>
    </div>
</template>

<script setup>
import { bibliothequeService} from '@/services/bibliothequeService';
import { onMounted, ref } from 'vue';

const errorMessage = ref(null)
const library = ref([]);

onMounted(async () => {
  try {
    library.value = await bibliothequeService.getLibrary()
  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
})

</script>

<style scoped>

</style>