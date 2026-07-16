<template>
<div class="search-wrapper">
    <div class="search-bar">
        
        <input type="text" name="search" v-model="search" placeholder="Rechercher un livre...">
        <button class="btn-search" @click="handleSearch" :disabled="loading">{{ loading ? 'Recherche...' : 'Rechercher' }}</button>
    </div>
      <p v-if="successMessage" class="success">{{ successMessage }}</p>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    <div class="results-grid">
        <div class="book-card" v-for="book in results" :key="book.book_isbn">
            <img :src="book.book_cover || 'https://placehold.co/120x160?text=No+cover'" :alt="book.book_name"/>
            <p>{{ book.book_name }}</p>
            <div class="book-genres" v-if="book.books_genre?.length">
                <span class="genre-tag" v-for="genre in book.books_genre" :key="genre">{{ genre }}</span>
            </div>
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
const successMessage = ref(null);
const errorMessage = ref(null);
const loading = ref(false);
const emit = defineEmits(['bookAdded'])

const handleSearch = async () => {
    loading.value = true;
    errorMessage.value = null;
    try {
       results.value = await bibliothequeService.searchBooks(search.value)
       successMessage.value = null
    } catch (error) {
        console.error("Erreur lors de la recherche de livres", error);
        errorMessage.value = error.response?.data?.message ?? 'Une erreur est survenue, réessaie dans un instant.';
    } finally {
        loading.value = false;
    }
}

const handleAdd = async (book) => {
    try {
        const response = await bibliothequeService.addBook({ ...book, reading_status: 'a_lire' });
        successMessage.value = "Livre ajouté à votre bibliothèque";
        emit('bookAdded', response.reading)
    } catch (error) {
        console.error("Erreur lors de l'ajout du livre", error);
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
  border: 2px solid #833c3c;
  border-radius: 25px;
  font-size: 14px;
  outline: none;
  background: #FFFFFF;
  color: #333333;
}

.search-bar input:focus {
  box-shadow: 0 0 0 3px rgba(148, 66, 66, 0.15);
}

.btn-search {
  padding: 10px 24px;
  background-color: #833c3c;
  color: #FFFFFF;
  border: 2px solid #833c3c;
  border-radius: 25px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-search:hover {
  background-color: #FFFFFF;
  color: #833c3c;
}

.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
}

.book-card {
  background: #FFFFFF;
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
  border-color: #833c3c;
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
  color: #333333;
  text-align: center;
}

.book-genres {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
  justify-content: center;
}

.genre-tag {
  font-size: 11px;
  color: #833c3c;
  background-color: #f5ece8;
  border-radius: 25px;
  padding: 2px 8px;
  border: 1px solid #EDE4D3;
}

.btn-add {
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

.btn-add:hover {
  background-color: #833c3c;
  color: #FFFFFF;
}

.success {
  color: #385a3f;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 12px;
}

.error {
  color: #b0413e;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 12px;
}

@media (max-width: 768px) {
  .search-wrapper {
    padding: 24px 16px 12px;
  }
  .search-bar {
    flex-wrap: wrap;
  }
  .results-grid {
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 14px;
  }
}
</style>