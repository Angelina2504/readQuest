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
    }

}