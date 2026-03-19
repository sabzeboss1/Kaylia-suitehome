import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import apiClient from '@/utils/api'

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
  video_url?: string
  nearby_attractions?: string[]
}

export interface ApartmentFilters {
  guests: number | null
  bedrooms: number | string | null
  checkIn: string | null
  checkOut: string | null
}

export const useApartmentsStore = defineStore('apartments', () => {
  // State
  const apartments = ref<Apartment[]>([])
  const loading = ref(false)
  const filters = ref<ApartmentFilters>({
    guests: null,
    bedrooms: null,
    checkIn: null,
    checkOut: null
  })

  // Getters
  const filteredApartments = computed(() => {
    let result = apartments.value

    // Filter by guests
    if (filters.value.guests) {
      result = result.filter(apt => apt.capacity >= filters.value.guests!)
    }

    // Filter by bedrooms
    if (filters.value.bedrooms !== null) {
      if (filters.value.bedrooms === 'studio') {
        result = result.filter(apt => apt.type === 'studio')
      } else {
        result = result.filter(apt => apt.bedrooms === filters.value.bedrooms)
      }
    }

    return result
  })

  // Actions
  async function fetchApartments() {
    loading.value = true
    try {
      const response = await apiClient.get('/apartments')
      // L'interceptor retourne response.data, donc response est déjà l'objet { success, data, meta }
      apartments.value = response.data || []
      console.log('Apartments loaded:', apartments.value.length)
    } catch (error) {
      console.error('Failed to fetch apartments:', error)
      apartments.value = []
    } finally {
      loading.value = false
    }
  }

  function setFilters(newFilters: Partial<ApartmentFilters>) {
    filters.value = { ...filters.value, ...newFilters }
  }

  function clearFilters() {
    filters.value = {
      guests: null,
      bedrooms: null,
      checkIn: null,
      checkOut: null
    }
  }

  return {
    // State
    apartments,
    loading,
    filters,
    // Getters
    filteredApartments,
    // Actions
    fetchApartments,
    setFilters,
    clearFilters
  }
})
