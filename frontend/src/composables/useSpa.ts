import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface SpaService {
  id: number
  name: string
  description: string
  price: number
  duration: number
  category: 'appointment' | 'event'
  capacity?: number
  image?: string
}

export interface SpaOpeningHours {
  dayOfWeek: string
  openTime: string
  closeTime: string
  isClosed: boolean
}

export interface SpaReservationData {
  serviceId: number
  date: string
  time: string
  guests: number
  customerInfo: {
    firstName: string
    lastName: string
    email: string
    phone: string
  }
  specialRequests?: string
}

export interface SpaReservationResponse {
  id: number
  reference: string
  status: string
  message?: string
}

export function useSpa() {
  const services = ref<SpaService[]>([])
  const openingHours = ref<SpaOpeningHours[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchServices = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/spa/services')
      // L'intercepteur renvoie response.data qui contient { success, data, meta }
      // On mappe service_type vers category pour correspondre au frontend
      const mappedServices = response.data.map((service: any) => ({
        ...service,
        category: service.service_type // Mapper service_type vers category
      }))
      services.value = mappedServices
      return mappedServices
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch spa services:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const fetchOpeningHours = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/spa/opening-hours')
      // Le backend renvoie { success: true, data: [...] }
      openingHours.value = response.data || []
      return response.data || []
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch opening hours:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const createSpaReservation = async (data: SpaReservationData) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/spa/reservations', data)
      return response.data as SpaReservationResponse
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to create spa reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    services,
    openingHours,
    loading,
    error,
    fetchServices,
    fetchOpeningHours,
    createSpaReservation
  }
}
