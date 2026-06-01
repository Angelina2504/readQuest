<template>
    <div class="library-wrapper">
        <h2 class="library-title">Ma bibliothèque</h2>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        <p v-if="library.length === 0" class="empty">Aucun livre dans votre bibliothèque.</p>
        <div class="library-grid">
            <div class="book-card" v-for="book in library" :key="book.book_isbn">
                <img :src="book.book_cover || 'https://placehold.co/120x160?text=No+cover'" :alt="book.book_name" />
                <p class="book-title">{{ book.book_name }}</p>
                <select v-model="book.reading_status" @change="updateStatus(book)">
                  <option value="a_lire">À lire</option>
                  <option value="en_cours">En cours</option>
                  <option value="lu">Lu</option>
                </select>
                <button @click="deleteBook(book.reading_id)">Supprimer</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { bibliothequeService} from '@/services/bibliothequeService';
import { onMounted, ref } from 'vue';

const errorMessage = ref(null)
const library = ref([]);
const updateStatus = async (book) => {
    try {
        await bibliothequeService.updateReading(book.reading_id, book.reading_status)
    } catch (error) {
        console.error("Erreur:", error);
    }
}

onMounted(async () => {
  try {
    library.value = await bibliothequeService.getLibrary()
  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
})

const deleteBook = async(id) => {
  try {
    await bibliothequeService.deleteReading(id)
    library.value = library.value.filter(b => b.reading_id !== id)
  } catch (error) {
     console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
}

</script>

<style scoped>
.library-wrapper {
  padding: 16px 20px 40px;
  background-color: #FDF8F3;
}

.library-title {
  font-size: 20px;
  font-weight: 600;
  color: #944242;
  margin-bottom: 24px;
}

.empty {
  color: #999;
  font-size: 14px;
}

.error {
  color: #b0413e;
  font-size: 14px;
}

.library-grid {
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

.book-title {
  margin: 0;
  font-size: 13px;
  font-weight: 600;
  color: #333;
  text-align: center;
}

.book-status {
  font-size: 12px;
  color: white;
  background-color: #944242;
  border-radius: 25px;
  padding: 4px 12px;
}

button {
  padding: 6px 16px;
  background-color: white;
  border: 2px solid #b0413e;
  border-radius: 25px;
  color: #b0413e;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

button:hover {
  background-color: #b0413e;
  color: white;
}

select {
  padding: 4px 12px;
  border: 2px solid #944242;
  border-radius: 25px;
  color: #944242;
  font-size: 12px;
  font-weight: 500;
  background-color: white;
  cursor: pointer;
  outline: none;
}
</style>