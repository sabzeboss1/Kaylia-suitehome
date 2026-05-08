import { ref } from 'vue'
import axios from 'axios'
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
      console.log('🚀 Creating reservation with data:', data)
      
      // apiClient returns response.data directly due to interceptor
      const responseData = await apiClient.post('/reservations', data)
      
      console.log('✅ API Response Data:', responseData)
      
      // Check if response indicates success
      if (responseData.success === false) {
        const errorMsg = responseData.error?.message || responseData.message || 'Failed to create reservation'
        console.error('❌ API returned success=false:', responseData)
        throw new Error(errorMsg)
      }
      
      // Extract reservation data (could be in .data or directly in response)
      const reservationData = responseData.data || responseData
      
      // Validate that we have a reservation with an ID
      if (!reservationData.id) {
        console.error('❌ No reservation ID in response:', reservationData)
        throw new Error('Invalid reservation data received')
      }
      
      console.log('✅ Reservation created successfully:', reservationData)
      reservation.value = reservationData
      return reservationData
    } catch (e: any) {
      console.error('❌ Full error object:', e)
      console.error('❌ Error response:', e.response)
      console.error('❌ Error response data:', e.response?.data)
      console.error('❌ Error response status:', e.response?.status)
      
      // Log validation details if present
      if (e.response?.data?.error?.details) {
        console.error('❌ VALIDATION DETAILS:', e.response.data.error.details)
      }
      
      // Extract detailed error message
      let errorMessage = 'Failed to create reservation'
      
      if (e.response?.data) {
        const apiError = e.response.data
        
        // Check for validation errors (422)
        if (e.response.status === 422 && apiError.errors) {
          const firstErrorKey = Object.keys(apiError.errors)[0]
          const firstError = apiError.errors[firstErrorKey]
          errorMessage = Array.isArray(firstError) ? firstError[0] : firstError
          console.error('❌ Validation error:', firstErrorKey, '=', errorMessage)
        }
        // Check for error message in response
        else if (apiError.message) {
          errorMessage = apiError.message
          console.error('❌ API error message:', errorMessage)
        }
        // Check for error object
        else if (apiError.error?.message) {
          errorMessage = apiError.error.message
          console.error('❌ API error.message:', errorMessage)
        }
      }
      // Network or other errors
      else if (e.message) {
        errorMessage = e.message
        console.error('❌ Exception message:', errorMessage)
      }
      
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
      // apiClient returns response.data directly due to interceptor
      const responseData = await apiClient.post('/reservations/check-availability', {
        apartment_id: apartmentId,
        check_in_date: checkInDate,
        check_out_date: checkOutDate
      })

      if (responseData.success) {
        return responseData.data.available
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
      // apiClient returns response.data directly due to interceptor
      const responseData = await apiClient.post('/promo-codes/validate', {
        code,
        total_nights: totalNights,
        subtotal
      })

      // Success case: { success: true, data: { id, code, discount_amount, ... } }
      if (responseData.success && responseData.data) {
        const promoCode = responseData.data
        return {
          valid: true,
          discount: promoCode.discount_amount || 0
        }
      } else {
        // Cas improbable mais on gère quand même
        return {
          valid: false,
          error: 'Code promo invalide'
        }
      }
    } catch (e: any) {
      // L'API retourne 422 pour un code invalide
      // Error structure: { success: false, error: { code: "...", message: "...", details: {...} } }
      if (e.response?.status === 422 && e.response?.data?.error) {
        const apiError = e.response.data.error
        return {
          valid: false,
          error: apiError.message || 'Code promo invalide'
        }
      }
      
      // Autres erreurs
      const errorMessage = e.response?.data?.error?.message || e.message || 'Erreur lors de la validation du code promo'
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
      // apiClient returns response.data directly due to interceptor
      const responseData = await apiClient.get(`/reservations/${id}`)
      
      if (responseData.success) {
        reservation.value = responseData.data
        return responseData.data
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
      // Use axios directly to bypass the interceptor for blob responses
      const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/reservations/${reservationId}/invoice`, {
        responseType: 'blob',
        headers: {
          'Accept': 'application/pdf'
        }
      })

      // response.data is already a Blob
      const blob = response.data
      
      // Create blob URL and trigger download
      const url = window.URL.createObjectURL(blob)
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', `facture-${reservationId}.pdf`)
      document.body.appendChild(link)
      link.click()
      
      // Cleanup
      setTimeout(() => {
        link.remove()
        window.URL.revokeObjectURL(url)
      }, 100)
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
