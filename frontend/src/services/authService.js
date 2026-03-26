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

            if (response.data.token) {
                //Save token in localStorage
                localStorage.setItem('token', response.data.token);
                localStorage.setItem('user_roles',JSON.stringify(decoded.roles))
                console.log('Connexion réussie, rôles extraits :', decoded.roles);
            }
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la connexion :', error.response?.data || error.message);
            throw error;
        }
    },

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user_roles');
    },

    isAdmin() {
        const roles = JSON.parse(localStorage.getItem('user_roles') || '[]');
        return roles.includes('ROLE_ADMIN');
    },

    isAuthenticated() {
    return !!localStorage.getItem('token');
}
};