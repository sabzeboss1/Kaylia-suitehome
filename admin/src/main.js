import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './style.css'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

// Mount the app first
app.mount('#app')

// Initialize auth after mounting
import { useAuthStore } from './stores/auth'
const authStore = useAuthStore()
authStore.initializeAuth()
