import { ref } from 'vue'
import apiClient from '../api/axios'
import type { Apartment, ApartmentFilters, DateRange } from '../types'

export function useApartments() {
  const apartments = ref<Apartment[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchApartments = async (filters?: ApartmentFilters) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/apartments', {
        params: filters
      })
      apartments.value = response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch apartments'
      console.error('Error fetching apartments:', e)
    } finally {
      loading.value = false
    }
  }

  const checkAvailability = async (apartmentId: number, dates: DateRange) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post(`/apartments/${apartmentId}/check-availability`, {
        check_in: dates.checkIn,
        check_out: dates.checkOut
      })
      return response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to check availability'
      console.error('Error checking availability:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    apartments,
    loading,
    error,
    fetchApartments,
    checkAvailability
  }
}
