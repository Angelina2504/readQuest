import axios from 'axios';

// instance Axios centralisée

const api = axios.create({
    baseURL:'http://localhost:8080/api',
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

export default api;