<template>
<div class="search-wrapper">
    <div class="search-bar">
        
        <input type="text" name="search" v-model="search" placeholder="Rechercher un livre...">
        <button class="btn-search" @click="handleSearch">Rechercher</button>
    </div>
      <p v-if="successMessage" class="success">{{ successMessage }}</p>
    <div class="results-grid">
        <div class="book-card" v-for="book in results" :key="book.book_isbn">
            <img :src="book.book_cover || 'https://placehold.co/120x160?text=No+cover'" :alt="book.book_name" />
            <p>{{ book.book_name }}</p>
            <button class="btn-add" @click="handleAdd(book)">Ajouter</button>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { bibliothequeService } from '@/services/bibliothequeService';

const search = ref('');
const results = ref([]);
const errorMessage = ref(null);
const successMessage = ref(null);
const emit = defineEmits(['bookAdded'])

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
        await bibliothequeService.addBook({ ...book,reading_status: 'a_lire'});
        successMessage.value="Livre ajouté à votre bibliothèque";
        emit('bookAdded')
    } catch (error) {
        console.error("Erreur détaillée:", error);
        errorMessage.value = "Modification non enregistrer";
    }
}

</script>

<style scoped>
.search-wrapper {
  padding: 40px 20px 16px;
  background-color: #FDF8F3;
}

.search-bar {
  display: flex;
  gap: 12px;
  margin-bottom: 32px;
}

.search-bar input {
  flex: 1;
  padding: 10px 16px;
  border: 2px solid #944242;
  border-radius: 25px;
  font-size: 14px;
  outline: none;
  background: white;
  color: #333;
}

.search-bar input:focus {
  box-shadow: 0 0 0 3px rgba(148, 66, 66, 0.15);
}

.btn-search {
  padding: 10px 24px;
  background-color: #944242;
  color: white;
  border: 2px solid #944242;
  border-radius: 25px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-search:hover {
  background-color: white;
  color: #944242;
}

.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
}

.book-card {
  background: white;
  border: 2px solid #EDE4D3;
  border-radius: 16px;
  padding: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: border-color 0.2s ease;
}

.book-card:hover {
  border-color: #944242;
}

.book-card img {
  width: 100%;
  max-width: 120px;
  height: 160px;
  object-fit: cover;
  border-radius: 8px;
}

.book-card p {
  margin: 0;
  font-size: 13px;
  font-weight: 600;
  color: #333;
  text-align: center;
}

.btn-add {
  padding: 6px 20px;
  background-color: white;
  border: 2px solid #944242;
  border-radius: 25px;
  color: #944242;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-add:hover {
  background-color: #944242;
  color: white;
}

.success {
  color: #4f805d;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 12px;
}
</style>