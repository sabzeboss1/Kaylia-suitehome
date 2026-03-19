import { defineStore } from 'pinia'
import { ref } from 'vue'

// Placeholder - will be replaced with proper types later
export interface SpaService {
  id: number
  name: string
  description: string
  price: number
  duration: number
  category: 'appointment' | 'event'
}

export const useSpaStore = defineStore('spa', () => {
  // State
  const services = ref<SpaService[]>([])
  const loading = ref(false)

  // Actions
  async function fetchServices() {
    loading.value = true
    try {
      // API call will be implemented later
      // const response = await apiClient.get('/spa/services')
      // services.value = response.data
    } catch (error) {
      console.error('Failed to fetch spa services:', error)
    } finally {
      loading.value = false
    }
  }

  return {
    // State
    services,
    loading,
    // Actions
    fetchServices
  }
})
