import { ref } from 'vue'

export interface PublicSettings {
  social_facebook: string
  social_instagram: string
  social_tiktok: string
  social_linkedin: string
  social_twitter: string
  social_youtube: string
  business_phone: string
  business_email: string
  business_address: string
  business_whatsapp: string
}

const settings = ref<PublicSettings | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<PublicSettings | null> | null = null

export function usePublicSettings() {
  const fetchSettings = async () => {
    // Return cached settings if already loaded
    if (settings.value) {
      return settings.value
    }

    // Return existing promise if already fetching
    if (fetchPromise) {
      return fetchPromise
    }

    loading.value = true
    error.value = null

    fetchPromise = (async () => {
      try {
        console.log('Fetching public settings from API...')
        
        // Use fetch instead of apiClient to avoid sending auth token
        const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api'
        const response = await fetch(`${API_URL}/settings/public`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const data = await response.json()
        console.log('API Response:', data)
        
        // Backend returns { success: true, data: {...} }
        settings.value = data.data || data
        console.log('Settings loaded:', settings.value)
        
        return settings.value
      } catch (err: any) {
        error.value = err.message || 'Failed to load settings'
        console.error('Error fetching public settings:', err)
        return null
      } finally {
        loading.value = false
        fetchPromise = null
      }
    })()

    return fetchPromise
  }

  // Auto-fetch immediately if not already loaded
  if (!settings.value && !loading.value && !fetchPromise) {
    fetchSettings()
  }

  return {
    settings,
    loading,
    error,
    fetchSettings
  }
}

