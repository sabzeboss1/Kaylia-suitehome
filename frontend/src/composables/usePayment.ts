import { ref } from 'vue'
import apiClient from '@/utils/api'

export interface PaymentIntent {
  id: string
  client_secret: string
  amount: number
  currency: string
  status: string
}

export interface Payment {
  id: number
  reservation_id?: number
  spa_reservation_id?: number
  amount: number
  currency: string
  payment_method: string
  payment_status: string
  payment_intent_id?: string
  transaction_id?: string
  created_at: string
  updated_at: string
}

export function usePayment() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const paymentIntent = ref<PaymentIntent | null>(null)
  const payment = ref<Payment | null>(null)

  /**
   * Initiate payment for a reservation
   */
  const initiatePayment = async (
    reservationId?: number,
    paymentMethod?: string,
    recaptchaToken?: string,
    spaReservationId?: number
  ): Promise<PaymentIntent> => {
    loading.value = true
    error.value = null

    try {
      const payload: Record<string, any> = {}
      
      if (reservationId) payload.reservation_id = reservationId
      if (spaReservationId) payload.spa_reservation_id = spaReservationId
      if (paymentMethod) payload.payment_method = paymentMethod
      if (recaptchaToken) payload.recaptcha_token = recaptchaToken

      const response = await apiClient.post('/payments/initiate', payload)

      if (response.data.success) {
        paymentIntent.value = response.data.data
        return response.data.data
      } else {
        throw new Error(response.data.error?.message || 'Failed to initiate payment')
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to initiate payment'
      error.value = errorMessage
      throw new Error(errorMessage)
    } finally {
      loading.value = false
    }
  }

  /**
   * Confirm payment after Stripe/PayPal processing
   */
  const confirmPayment = async (
    paymentIntentId: string,
    additionalData?: Record<string, any>
  ): Promise<Payment> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/payments/confirm', {
        payment_intent_id: paymentIntentId,
        ...additionalData
      })

      if (response.data.success) {
        payment.value = response.data.data
        return response.data.data
      } else {
        throw new Error(response.data.error?.message || 'Failed to confirm payment')
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to confirm payment'
      error.value = errorMessage
      throw new Error(errorMessage)
    } finally {
      loading.value = false
    }
  }

  /**
   * Get payment by ID
   */
  const getPayment = async (id: number): Promise<Payment | null> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get(`/payments/${id}`)
      
      if (response.data.success) {
        payment.value = response.data.data
        return response.data.data
      }
      return null
    } catch (e: any) {
      error.value = e.response?.data?.error?.message || e.message || 'Failed to get payment'
      return null
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    paymentIntent,
    payment,
    initiatePayment,
    confirmPayment,
    getPayment
  }
}
