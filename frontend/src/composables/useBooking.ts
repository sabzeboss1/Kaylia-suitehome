import { ref } from 'vue'
import apiClient, { getErrorMessage } from '@/utils/api'

export interface CustomerInfo {
  firstName: string
  lastName: string
  email: string
  phone: string
  country: string
  specialRequests?: string
}

export interface AddOn {
  id: number
  name: string
  price: number
  quantity: number
}

export interface ReservationData {
  apartmentId: number
  checkIn: string
  checkOut: string
  guests: number
  customerInfo: CustomerInfo
  addOns?: AddOn[]
  promoCode?: string
  totalPrice: number
}

export interface ReservationResponse {
  id: number
  reference: string
  status: string
  totalPrice: number
  message?: string
}

export interface PromoCodeValidation {
  valid: boolean
  code?: string
  discountType?: 'percentage' | 'fixed'
  discountValue?: number
  message?: string
}

export function useBooking() {
  const loading = ref(false)
  const error = ref<string | null>(null)

  const createReservation = async (data: ReservationData) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/reservations', data)
      return response.data as ReservationResponse
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to create reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const validatePromoCode = async (code: string, apartmentId: number, checkIn: string, checkOut: string) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/promo-codes/validate', {
        code,
        apartmentId,
        checkIn,
        checkOut
      })
      return response.data as PromoCodeValidation
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to validate promo code:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const getReservation = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/reservations/${id}`)
      return response.data
    } catch (e) {
      error.value = getErrorMessage(e)
      console.error('Failed to fetch reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    createReservation,
    validatePromoCode,
    getReservation
  }
}
