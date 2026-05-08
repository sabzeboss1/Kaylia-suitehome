import { ref } from 'vue'
import apiClient from '@/utils/api'

export interface SiteSettings {
  company_name: string
  company_email: string
  company_phone: string
  company_whatsapp: string
  company_address: string
  company_city: string
  company_postal_code: string
  company_country: string
  facebook_url: string
  instagram_url: string
  twitter_url: string
  linkedin_url: string
  youtube_url: string
}

const settings = ref<SiteSettings | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)

export function useSiteSettings() {
  const fetchSettings = async () => {
    // Return cached settings if already loaded
    if (settings.value) {
      return settings.value
    }

    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/public/settings')
      
      if (response.success && response.data) {
        settings.value = response.data
        return response.data
      } else {
        throw new Error('Failed to load site settings')
      }
    } catch (e: any) {
      error.value = e.message || 'Failed to load site settings'
      console.error('Error loading site settings:', e)
      
      // Return default values as fallback
      const defaultSettings: SiteSettings = {
        company_name: 'Kaylia Suite Home',
        company_email: 'contact@kayliasuitehome.com',
        company_phone: '+237 00 00 00 00',
        company_whatsapp: '+237 00 00 00 00',
        company_address: '',
        company_city: '',
        company_postal_code: '',
        company_country: '',
        facebook_url: '',
        instagram_url: '',
        twitter_url: '',
        linkedin_url: '',
        youtube_url: ''
      }
      
      settings.value = defaultSettings
      return defaultSettings
    } finally {
      loading.value = false
    }
  }

  return {
    settings,
    loading,
    error,
    fetchSettings
  }
}
