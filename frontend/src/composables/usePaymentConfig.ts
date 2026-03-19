import { ref } from 'vue'
import api from '@/utils/api'

interface PaymentConfig {
  stripe: {
    enabled: boolean
    publishable_key: string | null
  }
  paypal: {
    enabled: boolean
    client_id: string | null
    mode: 'sandbox' | 'live'
  }
}

const config = ref<PaymentConfig | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)

export function usePaymentConfig() {
  async function loadConfig(): Promise<PaymentConfig | null> {
    if (config.value) {
      return config.value
    }

    isLoading.value = true
    error.value = null

    try {
      const response = await api.get('/payment/config')
      
      if (response.data.success) {
        config.value = response.data.data
        return config.value
      } else {
        error.value = 'Failed to load payment configuration'
        return null
      }
    } catch (err: any) {
      error.value = err.message || 'Failed to load payment configuration'
      console.error('Error loading payment config:', err)
      return null
    } finally {
      isLoading.value = false
    }
  }

  function getStripeKey(): string | null {
    return config.value?.stripe.publishable_key || null
  }

  function getPayPalClientId(): string | null {
    return config.value?.paypal.client_id || null
  }

  function getPayPalMode(): 'sandbox' | 'live' {
    return config.value?.paypal.mode || 'sandbox'
  }

  function isStripeEnabled(): boolean {
    return config.value?.stripe.enabled || false
  }

  function isPayPalEnabled(): boolean {
    return config.value?.paypal.enabled || false
  }

  return {
    config,
    isLoading,
    error,
    loadConfig,
    getStripeKey,
    getPayPalClientId,
    getPayPalMode,
    isStripeEnabled,
    isPayPalEnabled
  }
}
