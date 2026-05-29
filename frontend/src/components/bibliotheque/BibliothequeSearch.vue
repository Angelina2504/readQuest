<template>
<div>
    <input type="text" name="search" v-model="search">
    <button @click="handleSearch">Rechercher</button>

    <div v-for="book in results" :key="book.book_isbn">
        <p>{{ book.book_name }}</p>
        <img :src="book.book_cover" :alt="book.book_name" />
        <button @click="handleAdd(book)">Ajouter</button>
    </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { bibliothequeService } from '@/services/bibliothequeService';

const search = ref('');
const results = ref([]);
const errorMessage = ref(null);

const handleSearch = async () => {
    try {
       results.value = await bibliothequeService.searchBooks(search.value)
    } catch (error) {
        console.error("Erreur détaillée:", error);
        errorMessage.value = "Modification non enregistrer";
    }
}

const handleAdd = async (book) => {
    try {
        await bibliothequeService.addBook({ ...book,reading_status: 'a_lire'})
    } catch (error) {
        console.error("Erreur détaillée:", error);
        errorMessage.value = "Modification non enregistrer";
    }
}

</script>

<style scoped>

</style>