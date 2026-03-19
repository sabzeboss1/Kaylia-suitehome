import { ref } from 'vue'
import apiClient from '@/utils/api'
import type { SelectedComfortOption } from '@/stores/booking'

export interface CreateReservationData {
  apartment_id: number
  check_in_date: string
  check_out_date: string
  adults: number
  children?: number
  customer: {
    first_name: string
    last_name: string
    email: string
    phone?: string
    nationality?: string
    is_newsletter_subscribed?: boolean
  }
  comfort_options?: Array<{
    id: number
    quantity: number
  }>
  promo_code?: string
  pricing_type?: 'flexible' | 'on_site_payment'
  special_requests?: string
  recaptcha_token?: string
}

export interface Reservation {
  id: number
  apartment_id: number
  customer_id: number
  check_in_date: string
  check_out_date: string
  adults: number
  children: number
  total_nights: number
  base_price: number
  options_price: number
  promo_discount: number
  total_price: number
  promo_code: string | null
  pricing_type: string
  status: string
  payment_status: string
  special_requests: string | null
  created_at: string
  updated_at: string
  apartment?: any
  customer?: any
  comfortOptions?: any[]
}

export function useReservation() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const reservation = ref<Reservation | null>(null)

  /**
   * Create a new reservation
   */
  const createReservation = async (data: CreateReservationData): Promise<Reservation> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/reservations', data)
      
      if (response.data.success) {
        reservation.value = response.data.data
        return response.data.data
      } else {
        throw new Error(response.data.error?.message || 'Failed to create reservation')
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to create reservation'
      error.value = errorMessage
      throw new Error(errorMessage)
    } finally {
      loading.value = false
    }
  }

  /**
   * Check availability for specific dates
   */
  const checkAvailability = async (
    apartmentId: number,
    checkInDate: string,
    checkOutDate: string
  ): Promise<boolean> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/reservations/check-availability', {
        apartment_id: apartmentId,
        check_in_date: checkInDate,
        check_out_date: checkOutDate
      })

      if (response.data.success) {
        return response.data.data.available
      }
      return false
    } catch (e: any) {
      error.value = e.response?.data?.error?.message || e.message || 'Failed to check availability'
      return false
    } finally {
      loading.value = false
    }
  }

  /**
   * Validate promo code
   */
  const validatePromoCode = async (
    code: string,
    totalNights: number,
    subtotal?: number
  ): Promise<{ valid: boolean; discount?: number; error?: string }> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/promo-codes/validate', {
        code,
        total_nights: totalNights,
        subtotal
      })

      if (response.data.success && response.data.data.valid) {
        return {
          valid: true,
          discount: response.data.data.promo_code.discount_amount || 0
        }
      } else {
        return {
          valid: false,
          error: response.data.data.error || 'Invalid promo code'
        }
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to validate promo code'
      error.value = errorMessage
      return {
        valid: false,
        error: errorMessage
      }
    } finally {
      loading.value = false
    }
  }

  /**
   * Get reservation by ID
   */
  const getReservation = async (id: number): Promise<Reservation | null> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/reservations/${id}`)
      
      if (response.data.success) {
        reservation.value = response.data.data
        return response.data.data
      }
      return null
    } catch (e: any) {
      error.value = e.response?.data?.error?.message || e.message || 'Failed to get reservation'
      return null
    } finally {
      loading.value = false
    }
  }

  /**
   * Download invoice for reservation
   */
  const downloadInvoice = async (reservationId: number): Promise<void> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/reservations/${reservationId}/invoice`, {
        responseType: 'blob'
      })

      // Create blob link to download
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', `invoice-${reservationId}.pdf`)
      document.body.appendChild(link)
      link.click()
      link.remove()
      window.URL.revokeObjectURL(url)
    } catch (e: any) {
      error.value = e.response?.data?.error?.message || e.message || 'Failed to download invoice'
      throw new Error(error.value)
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    reservation,
    createReservation,
    checkAvailability,
    validatePromoCode,
    getReservation,
    downloadInvoice
  }
}
