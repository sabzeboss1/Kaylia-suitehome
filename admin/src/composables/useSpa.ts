import { ref } from 'vue'
import apiClient from '../api/axios'
import type { SpaService, SpaReservation } from '../types'

export function useSpa() {
  const services = ref<SpaService[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchServices = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/spa/services')
      services.value = response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch spa services'
      console.error('Error fetching spa services:', e)
    } finally {
      loading.value = false
    }
  }

  const createSpaReservation = async (reservation: SpaReservation) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/spa/reservations', {
        service_id: reservation.serviceId,
        date: reservation.date,
        time: reservation.time,
        guests: reservation.guests,
        customer_info: reservation.customerInfo
      })
      return response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to create spa reservation'
      console.error('Error creating spa reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    services,
    loading,
    error,
    fetchServices,
    createSpaReservation
  }
}
