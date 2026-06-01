import api from './api';

export const bibliothequeService = {
    async searchBooks(query){
        try {const response = await api.get(`/books/search?q=${query}`);
        return response.data
        } catch (error) {
            console.error('Erreur lors de la recherche de livres :', error.response?.data || error.message);
            throw error; 
        }
    },

    async addBook(bookData){
        try {const response = await api.post(`/books/add`, bookData);
        return response.data
        } catch (error) {
            console.error('Erreur lors de l\'ajout du livre :', error.response?.data || error.message);
            throw error; 
        }
    },

    async getLibrary(){
        try {
            const response = await api.get('/books/library')
            return response.data
        } catch (error) {
            console.error('Erreur lors de l\'obtention du livre :', error.response?.data || error.message);
            throw error; 
        }
    },

    async updateReading(id, status){
        try {
            const response = await api.patch(`/library/${id}`, {reading_status: status})
            return response.data
        } catch (error) {
            console.error('Erreur lors de la mise à jours du statut :', error.response?.data || error.message);
            throw error; 
        }
    }

}