import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface ContactMessage {
  firstName: string
  lastName: string
  email: string
  phone?: string
  subject: string
  message: string
  recaptcha_token?: string | null
}

export interface ContactResponse {
  success: boolean
  message: string
}

export function useContact() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const success = ref(false)

  const sendMessage = async (data: ContactMessage) => {
    loading.value = true
    error.value = null
    success.value = false

    try {
      const response = await apiClient.post('/contact', data)
      success.value = true
      return response.data as ContactResponse
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to send contact message:', e)
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
    sendMessage,
    reset
  }
}
