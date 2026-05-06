import api from './api';
import { jwtDecode } from "jwt-decode";

export const authService = {
    async login(email, password) {
        try {
            const response = await api.post('/auth/login', {
                username: email,
                password: password
            });

            const decoded = jwtDecode (response.data.token);

            return { token: response.data.token, roles: decoded.roles }
        } catch (error) {
            console.error('Erreur lors de la connexion :', error.response?.data || error.message);
            throw error;
        }
    },

    async register( userAlias, email, password,){
        try {
            const response = await api.post('/auth/register', {
                email: email,
                password: password,
                user_alias: userAlias
            });

        return response.data
            
        } catch (error) {
            console.error ('Erreur lors de la creation du user:', error.response?.data || error.message);
            throw error;
        }
    },

};