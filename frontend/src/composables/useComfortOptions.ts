import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface ComfortOption {
  id: number
  name: string
  description: string | null
  price: number
  price_type: 'per_night' | 'one_time'
  category: 'cleaning' | 'wine' | 'confectionery' | 'other'
  image_url: string | null
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface ComfortOptionsResponse {
  success: boolean
  data: ComfortOption[]
  grouped: {
    cleaning?: ComfortOption[]
    wine?: ComfortOption[]
    confectionery?: ComfortOption[]
    other?: ComfortOption[]
  }
}

export function useComfortOptions() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const options = ref<ComfortOption[]>([])
  const grouped = ref<ComfortOptionsResponse['grouped']>({})

  const fetchOptions = async (category?: string) => {
    loading.value = true
    error.value = null

    try {
      console.log('🚀 Fetching comfort options from API...')
      const params = category ? { category } : {}
      const response = await apiClient.get('/comfort-options', { params })
      console.log('📦 Raw API response:', response)
      
      // L'interceptor retourne déjà response.data, donc response est déjà l'objet { success, data, grouped }
      const data = response as unknown as ComfortOptionsResponse
      console.log('✨ Parsed data:', data)
      
      options.value = data.data
      grouped.value = data.grouped

      console.log('✅ Options stored:', options.value.length, 'options')
      console.log('✅ Grouped stored:', Object.keys(grouped.value))

      return data
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('❌ Failed to fetch comfort options:', e)
      console.error('❌ Error details:', error.value)
      throw e
    } finally {
      loading.value = false
    }
  }

  const getOptionById = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/comfort-options/${id}`)
      return response.data.data as ComfortOption
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch comfort option:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  // Helper to format price
  const formatPrice = (option: ComfortOption): string => {
    const price = (option.price / 100).toFixed(2)
    return `${price}€`
  }

  // Helper to get price unit label
  const getPriceUnit = (option: ComfortOption): string => {
    return option.price_type === 'per_night' ? '/nuit' : ''
  }

  // Helper to get category label
  const getCategoryLabel = (category: string): string => {
    const labels: Record<string, string> = {
      cleaning: 'Ménage & Confort',
      wine: 'Vin',
      confectionery: 'Confiseries',
      other: 'Autres services'
    }
    return labels[category] || category
  }

  return {
    loading,
    error,
    options,
    grouped,
    fetchOptions,
    getOptionById,
    formatPrice,
    getPriceUnit,
    getCategoryLabel
  }
}
