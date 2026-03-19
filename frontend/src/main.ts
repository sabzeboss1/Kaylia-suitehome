import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './assets/css/main.css'
import App from './App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()

// Global error handler
app.config.errorHandler = (err, instance, info) => {
  console.error('Global error:', err)
  console.error('Component:', instance)
  console.error('Error info:', info)
  
  // Log to error tracking service in production
  if (import.meta.env.PROD) {
    // TODO: Send to error tracking service (e.g., Sentry)
    // logErrorToService(err, instance, info)
  }
}

// Global warning handler (development only)
if (import.meta.env.DEV) {
  app.config.warnHandler = (msg, _instance, trace) => {
    console.warn('Vue warning:', msg)
    console.warn('Trace:', trace)
  }
}

app.use(pinia)
app.use(router)

app.mount('#app')
