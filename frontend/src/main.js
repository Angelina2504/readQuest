import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { authService } from './services/authService'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')

authService.login('test@example.com', 'password1234')
    .then(data => console.log("Réponse API :", data))
    .catch(err => console.log("Échec du test :", err));