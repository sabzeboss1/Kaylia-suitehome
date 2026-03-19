import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface Apartment {
  id: number
  name: string
  slug: string
  type: 'studio' | 't2' | 't3'
  description: string
  capacity: number
  surface: number
  bedrooms: number
  beds: Array<{
    type: string
    count: number
  }>
  floor: string
  pricePerNight: number
  images: Array<string | { id: number; image_url: string; thumbnail_url: string; alt_text: string | null; display_order: number; is_primary: boolean }>
  equipment: string[]
  services?: string[]
  rating?: number
  reviewCount?: number
  featured: boolean
}

export interface ApartmentFilters {
  guests?: number
  bedrooms?: number
  checkIn?: string
  checkOut?: string
  type?: string
}

export interface AvailabilityParams {
  checkIn: string
  checkOut: string
  guests: number
}

export interface AvailabilityResponse {
  available: boolean
  price?: number
  message?: string
}

export function useApartments() {
  const apartments = ref<Apartment[]>([])
  const apartment = ref<Apartment | null>(null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchApartments = async (filters?: ApartmentFilters) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/apartments', {
        params: filters
      })
      // L'interceptor retourne response.data, donc response est { success, data, meta }
      apartments.value = response.data || []
      console.log('Apartments loaded from API:', apartments.value.length)
      return apartments.value
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch apartments:', e)
      apartments.value = []
      throw e
    } finally {
      loading.value = false
    }
  }

  const fetchApartment = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/apartments/${id}`)
      // L'interceptor retourne response.data, donc response est { success, data, meta }
      apartment.value = response.data || null
      console.log('Apartment loaded from API:', apartment.value?.name)
      return apartment.value
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch apartment:', e)
      apartment.value = null
      throw e
    } finally {
      loading.value = false
    }
  }

  const checkAvailability = async (apartmentId: number, params: AvailabilityParams) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post(
        `/apartments/${apartmentId}/check-availability`,
        params
      )
      // L'interceptor retourne déjà response.data
      return (response.data || response) as AvailabilityResponse
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to check availability:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    apartments,
    apartment,
    loading,
    error,
    fetchApartments,
    fetchApartment,
    checkAvailability
  }
}
