import { ref } from 'vue'
import apiClient from '../api/axios'
import type { CustomerInfo } from '../types'

interface ReservationData {
  apartment_id: number
  check_in: string
  check_out: string
  guests: number
  customer_info: CustomerInfo
  promo_code?: string
  add_ons?: Array<{ id: number; quantity: number }>
}

export function useBooking() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const promoCodeValid = ref(false)
  const promoCodeDiscount = ref(0)

  const createReservation = async (data: ReservationData) => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/reservations', data)
      return response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to create reservation'
      console.error('Error creating reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const validatePromoCode = async (code: string, apartmentId: number, checkIn: string, checkOut: string) => {
    loading.value = true
    error.value = null
    promoCodeValid.value = false
    promoCodeDiscount.value = 0

    try {
      const response = await apiClient.post('/promo-codes/validate', {
        code,
        apartment_id: apartmentId,
        check_in: checkIn,
        check_out: checkOut
      })
      
      const data = response.data.data
      promoCodeValid.value = data.valid
      promoCodeDiscount.value = data.discount_amount || 0
      
      return data
    } catch (e: any) {
      error.value = e.message || 'Invalid promo code'
      promoCodeValid.value = false
      promoCodeDiscount.value = 0
      console.error('Error validating promo code:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    promoCodeValid,
    promoCodeDiscount,
    createReservation,
    validatePromoCode
  }
}
