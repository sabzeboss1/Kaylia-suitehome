import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface NewsletterSubscription {
  email: string
  firstName?: string
  lastName?: string
}

export interface NewsletterResponse {
  success: boolean
  message: string
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
      return response.data as NewsletterResponse
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to subscribe to newsletter:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const reset = () => {
    loading.value = false
    error.value = null
    success.value = false
  }

  return {
    loading,
    error,
    success,
    subscribe,
    reset
  }
}
