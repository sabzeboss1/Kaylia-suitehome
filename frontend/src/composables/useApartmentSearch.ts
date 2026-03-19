import { ref } from 'vue'
import apiClient from '@/utils/api'
import type { Apartment } from '@/stores/apartments'

export interface SearchParams {
  checkIn?: string
  checkOut?: string
  guests?: number
  minPrice?: number
  maxPrice?: number
  type?: 'studio' | 't2' | 't3'
}

export interface SearchResult {
  apartments: Apartment[]
  total: number
  currentPage: number
  lastPage: number
  filtersApplied: Record<string, any>
}

export function useApartmentSearch() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const results = ref<SearchResult | null>(null)

  const searchApartments = async (params: SearchParams, page = 1) => {
    loading.value = true
    error.value = null

    try {
      const queryParams: any = { page, per_page: 20 }
      
      if (params.checkIn) queryParams.check_in = params.checkIn
      if (params.checkOut) queryParams.check_out = params.checkOut
      if (params.guests) queryParams.guests = params.guests
      if (params.minPrice) queryParams.min_price = params.minPrice
      if (params.maxPrice) queryParams.max_price = params.maxPrice
      if (params.type) queryParams.type = params.type

      console.log('Searching apartments with params:', queryParams)

      const response = await apiClient.get('/apartments/search', { params: queryParams })
      
      console.log('Search response:', response)

      results.value = {
        apartments: response.data || [],
        total: response.meta?.total || 0,
        currentPage: response.meta?.current_page || 1,
        lastPage: response.meta?.last_page || 1,
        filtersApplied: response.meta?.filters_applied || {}
      }

      return results.value
    } catch (err: any) {
      error.value = err.response?.data?.message || err.message || 'Erreur lors de la recherche'
      console.error('Search error:', err)
      results.value = {
        apartments: [],
        total: 0,
        currentPage: 1,
        lastPage: 1,
        filtersApplied: {}
      }
      return null
    } finally {
      loading.value = false
    }
  }

  const clearResults = () => {
    results.value = null
    error.value = null
  }

  return {
    loading,
    error,
    results,
    searchApartments,
    clearResults
  }
}
