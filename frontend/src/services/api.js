import axios from 'axios';
import router from '@/router'
import { useAuthStore } from '@/stores/authStore';



// instance Axios centralisée

const api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    headers: { "Content-Type": 'application/json', }
});

//Automation of token sending for each future request.
api.interceptors.request.use(
    (config)=> {
        const token = localStorage.getItem('token')

        if (token) {
            // Celui qui porte ce jeton a le droit d'entrer
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
    
);

api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            const authStore = useAuthStore()
            authStore.logout()
            router.push('/login')
        }
    return Promise.reject(error)
    }
);

export default api;