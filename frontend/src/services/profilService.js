import api from './api';

export const profilService = {
    async getProfil(){
        try {const response = await api.get('/user/profile', {
            });
        return response.data
        } catch (error) {
            console.error('Erreur lors de la connexion :', error.response?.data || error.message);
            throw error; 
        }
    },

    async updateProfile(birthday, gender, alias, email){
        try {const response = await api.patch('/user/profile',{
               birthday : birthday,
               gender: gender,
               alias: alias,
               email: email
            });
            return response.data
        } catch (error) {
            console.error ('Erreur lors de la creation du user:', error.response?.data || error.message);
            throw error;
        }
    },

    async uploadAvatar(formData){
        try {const response = await api.post('/user/avatar', formData, {
            headers: { 'Content-Type': 'multipart/form-data' } })
            return response.data
        } catch (error) {
            console.error ('Erreur lors du téléchargement de la photo:', error.response?.data || error.message);
            throw error;
        }
    }
};