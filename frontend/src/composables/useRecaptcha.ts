import { ref } from 'vue'
import apiClient from '@/utils/api'

declare global {
  interface Window {
    grecaptcha: any
  }
}

export interface RecaptchaConfig {
  enabled: boolean
  site_key: string | null
}

export function useRecaptcha() {
  const config = ref<RecaptchaConfig>({ enabled: false, site_key: null })
  const loading = ref(false)
  const error = ref<string | null>(null)
  const scriptLoaded = ref(false)

  /**
   * Fetch reCAPTCHA configuration from backend
   */
  const fetchConfig = async () => {
    try {
      const response = await apiClient.get('/recaptcha/config')
      config.value = response.data
      return response.data
    } catch (e) {
      console.error('Failed to fetch reCAPTCHA config:', e)
      error.value = 'Failed to load reCAPTCHA configuration'
      return null
    }
  }

  /**
   * Load reCAPTCHA script
   */
  const loadScript = async (): Promise<boolean> => {
    if (scriptLoaded.value) {
      return true
    }

    if (!config.value.enabled || !config.value.site_key) {
      return false
    }

    return new Promise((resolve) => {
      // Check if script already exists
      const existingScript = document.querySelector('script[src*="recaptcha"]')
      if (existingScript) {
        scriptLoaded.value = true
        resolve(true)
        return
      }

      // Create and load script
      const script = document.createElement('script')
      script.src = `https://www.google.com/recaptcha/api.js?render=${config.value.site_key}`
      script.async = true
      script.defer = true

      script.onload = () => {
        scriptLoaded.value = true
        resolve(true)
      }

      script.onerror = () => {
        error.value = 'Failed to load reCAPTCHA script'
        resolve(false)
      }

      document.head.appendChild(script)
    })
  }

  /**
   * Execute reCAPTCHA and get token
   */
  const execute = async (action: string = 'submit'): Promise<string | null> => {
    if (!config.value.enabled || !config.value.site_key) {
      return null
    }

    if (!scriptLoaded.value) {
      await loadScript()
    }

    try {
      loading.value = true
      error.value = null

      // Wait for grecaptcha to be ready
      await new Promise<void>((resolve) => {
        if (window.grecaptcha && window.grecaptcha.ready) {
          window.grecaptcha.ready(() => resolve())
        } else {
          // Fallback: wait a bit and try again
          setTimeout(() => resolve(), 1000)
        }
      })

      // Execute reCAPTCHA
      const token = await window.grecaptcha.execute(config.value.site_key, { action })
      return token
    } catch (e) {
      console.error('reCAPTCHA execution failed:', e)
      error.value = 'reCAPTCHA verification failed'
      return null
    } finally {
      loading.value = false
    }
  }

  /**
   * Initialize reCAPTCHA
   */
  const init = async () => {
    await fetchConfig()
    if (config.value.enabled && config.value.site_key) {
      await loadScript()
    }
  }

  return {
    config,
    loading,
    error,
    scriptLoaded,
    fetchConfig,
    loadScript,
    execute,
    init
  }
}
