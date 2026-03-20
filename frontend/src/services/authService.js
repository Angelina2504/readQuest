import api from './api';

export const authService = {
    async login(email, password) {
        try {
            const response = await api.post('/auth/login', {
                username: email,
                password: password
            });

            if (response.data.token) {
                //Save token in localStorage
                localStorage.setItem('token', response.data.token);
                console.log('Connexion réussie, token sauvegardé !');
            }
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la connexion :', error.response?.data || error.message);
            throw error;
        }
    },

    logout() {
        localStorage.removeItem('token');
    }
};