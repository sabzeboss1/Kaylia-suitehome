import { ref } from 'vue'
import apiClient from '../api/axios'

interface NewsletterSubscription {
  email: string
  name?: string
}

export function useNewsletter() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const success = ref(false)

  const subscribe = async (data: NewsletterSubscription) => {
    loading.value = true
    error.value = null
    success.value = false

    try {
      const response = await apiClient.post('/newsletter/subscribe', data)
      success.value = true
      return response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to subscribe to newsletter'
      success.value = false
      console.error('Error subscribing to newsletter:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const resetState = () => {
    loading.value = false
    error.value = null
    success.value = false
  }

  return {
    loading,
    error,
    success,
    subscribe,
    resetState
  }
}
