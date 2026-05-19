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

    async updateProfile(birthday, gender,avatar){
        try {const response = await api.patch('/user/profile',{
               birthday : birthday,
               gender: gender,
               avatar: avatar

            });
            return response.data
        } catch (error) {
            console.error ('Erreur lors de la creation du user:', error.response?.data || error.message);
            throw error;
        }
    }
};