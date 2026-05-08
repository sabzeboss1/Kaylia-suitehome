<template>
  <PaymentLayout>
    <!-- Payment Page -->
    <section v-if="isLoading" class="bg-gray-50 py-8 md:py-12">
      <div class="container mx-auto px-4 md:px-6 max-w-7xl">
        <div class="flex items-center justify-center py-20">
          <LoadingSpinner />
        </div>
      </div>
    </section>
    
    <section v-else class="min-h-screen">
      <!-- Container with max-width matching header -->
      <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
          <!-- Left Column - White Background -->
          <div class="bg-white py-8 md:py-12 pl-4 md:pl-8 pr-4 md:pr-6">
            <div class="max-w-2xl">
              <!-- Progress Steps -->
              <div class="flex items-center justify-start gap-4 md:gap-8 mb-8">
                <ProgressSteps :current-step="2" />
              </div>
              
              <!-- Currency Selection -->
              <CurrencySelector />

              <!-- Payment Method Selection -->
              <PaymentMethod
                v-model="selectedPaymentMethod"
                :total-amount="amountToCharge"
                :is-processing="isProcessing"
                :show-pay-button="selectedPaymentMethod !== 'card'"
                @pay="handlePayment"
              />

              <!-- Deposit Info Box (if deposit payment) -->
              <div v-if="isDepositPayment && depositAmount > 0" class="mt-6 bg-gradient-to-r from-[#A8927D]/10 to-[#A8927D]/20 border-2 border-[#A8927D]/40 rounded-xl p-6 shadow-sm">
                <div class="flex items-start gap-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-[#0B6087] rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h3 class="text-lg font-bold text-[#0B6087] mb-2">💳 Paiement du dépôt de garantie</h3>
                    <p class="text-sm text-gray-800 mb-4">Pour sécuriser votre réservation, vous payez maintenant le dépôt de garantie. Le solde sera à régler sur place.</p>
                    
                    <div class="bg-white rounded-lg p-4 space-y-2">
                      <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Montant total de la réservation</span>
                        <span class="text-sm font-medium text-gray-900">{{ formatPrice(totalAmount) }}</span>
                      </div>
                      <div class="border-t border-gray-200"></div>
                      <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-[#0B6087]">Dépôt à payer maintenant ({{ depositPercentage }}%)</span>
                        <span class="text-xl font-bold text-[#0B6087]">{{ formatPrice(depositAmount) }}</span>
                      </div>
                      <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Solde à payer sur place</span>
                        <span class="text-sm font-medium text-gray-900">{{ formatPrice(remainingAmount) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Stripe Card Element (only shown for card payment) -->
              <div v-if="selectedPaymentMethod === 'card' && paymentIntentClientSecret && stripePublishableKey" class="mt-6">
                <StripeCardElement
                  :client-secret="paymentIntentClientSecret"
                  :amount="amountToCharge"
                  :publishable-key="stripePublishableKey"
                  @success="handleStripeSuccess"
                  @error="handleStripeError"
                />
              </div>

              <!-- Deposit Notice (if deposit payment) -->
              <div v-if="isDepositPayment && depositAmount > 0" class="mt-6 p-4 bg-[#A8927D]/10 border border-[#A8927D]/30 rounded-lg">
                <div class="flex gap-3">
                  <svg class="w-5 h-5 text-[#0B6087] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <div class="text-sm text-gray-800">
                    <p class="font-semibold mb-1">Paiement du dépôt de garantie</p>
                    <p class="mb-2">Vous payez actuellement le dépôt de garantie de <span class="font-bold">{{ formatPrice(depositAmount) }}</span>.</p>
                    <p>Le solde restant de <span class="font-bold">{{ formatPrice(remainingAmount) }}</span> sera à régler sur place lors de votre arrivée.</p>
                  </div>
                </div>
              </div>

              <!-- Loading message for Stripe -->
              <div v-else-if="selectedPaymentMethod === 'card' && !stripePublishableKey" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                ⚠️ Configuration Stripe non disponible. Veuillez contacter l'administrateur.
              </div>

              <!-- PayPal Buttons (only shown for PayPal payment) -->
              <div v-if="selectedPaymentMethod === 'paypal' && paypalClientId && currentReservationId" class="mt-6">
                <PayPalButtons
                  :client-id="paypalClientId"
                  :amount="amountToCharge"
                  :mode="paypalMode"
                  :reservation-id="currentReservationId"
                  @success="handlePayPalSuccess"
                  @error="handlePayPalError"
                  @cancel="handlePayPalCancel"
                />
              </div>

              <!-- Loading message for PayPal -->
              <div v-else-if="selectedPaymentMethod === 'paypal' && !paypalClientId" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                ⚠️ Configuration PayPal non disponible. Veuillez contacter l'administrateur.
              </div>

              <!-- Message: Creating reservation for PayPal -->
              <div v-else-if="selectedPaymentMethod === 'paypal' && !currentReservationId && isProcessing" class="mt-6 p-4 bg-[#A8927D]/10 border border-[#A8927D]/30 rounded-lg text-sm text-gray-800">
                <div class="flex items-center gap-2">
                  <svg class="animate-spin h-5 w-5 text-[#0B6087]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Préparation du paiement PayPal...</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column - Gray Background (#EDEDED) -->
          <div class="bg-[#ededed] py-8 md:py-12 pl-4 md:pl-6 pr-4 md:pr-8">
            <div class="max-w-2xl space-y-6 pt-8 md:pt-12">
              <!-- Total -->
              <PriceBreakdown 
                :total-price="amountToCharge" 
                :is-deposit="isDepositPayment"
                :full-amount="totalAmount"
              />

              <!-- Reservation Details -->
              <ReservationSummary
                :apartment-name="bookingStore.apartment?.name || 'Appartement X'"
                :check-in="bookingStore.checkIn || new Date()"
                :check-out="bookingStore.checkOut || new Date()"
                :base-price="basePrice"
                :add-ons="addOns"
                :discount="discount"
                :total-price="totalAmount"
                :night-count="bookingStore.nightCount"
              />

              <!-- Practical Information -->
              <PracticalInfo
                :apartment-name="bookingStore.apartment?.name || 'Appartement X'"
                :guests="bookingStore.guests"
                :apartment-images="apartmentImages"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Deposit Notice Modal -->
    <DepositNoticeModal
      v-model="showDepositModal"
      :title="noticeTitle"
      :message="noticeMessage"
      :total-amount="totalAmount"
      :deposit-amount="depositAmount"
      :remaining-amount="remainingAmount"
      :deposit-percentage="depositPercentage"
      @confirm="showDepositModal = false"
      @close="handleDepositModalClose"
    />
  </PaymentLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import { useApartmentsStore } from '@/stores/apartments'
import { useRecaptcha } from '@/composables/useRecaptcha'
import { useReservation, type CreateReservationData } from '@/composables/useReservation'
import { usePayment } from '@/composables/usePayment'
import { usePaymentConfig } from '@/composables/usePaymentConfig'
import { useDepositPayment } from '@/composables/useDepositPayment'
import { logger } from '@/utils/logger'
import PaymentLayout from '@/layouts/PaymentLayout.vue'
import ProgressSteps from '@/components/booking/ProgressSteps.vue'
import CurrencySelector from '@/components/payment/CurrencySelector.vue'
import PaymentMethod from '@/components/payment/PaymentMethod.vue'
import StripeCardElement from '@/components/payment/StripeCardElement.vue'
import PayPalButtons from '@/components/payment/PayPalButtons.vue'
import PriceBreakdown from '@/components/booking/PriceBreakdown.vue'
import ReservationSummary from '@/components/payment/ReservationSummary.vue'
import PracticalInfo from '@/components/payment/PracticalInfo.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import DepositNoticeModal from '@/components/payment/DepositNoticeModal.vue'

const router = useRouter()
const route = useRoute()
const bookingStore = useBookingStore()
const apartmentsStore = useApartmentsStore()
const { init: initRecaptcha, execute: executeRecaptcha } = useRecaptcha()
const { createReservation, checkAvailability } = useReservation()
const { initiatePayment, confirmPayment } = usePayment()
const { loadConfig, getStripeKey, getPayPalClientId, getPayPalMode, isStripeEnabled, isPayPalEnabled } = usePaymentConfig()
const { loadConfig: loadDepositConfig, calculateDeposit, isDepositEnabled, depositPercentage, noticeTitle, noticeMessage } = useDepositPayment()

const isLoading = ref(true)
const isProcessing = ref(false)
const selectedPaymentMethod = ref<'card' | 'sepa' | 'paypal' | 'applepay'>('card')
const errorMessage = ref<string | null>(null)
const stripePublishableKey = ref<string | null>(null)
const paypalClientId = ref<string | null>(null)
const paypalMode = ref<'sandbox' | 'live'>('sandbox')
const paymentIntentClientSecret = ref<string | null>(null)
const currentReservationId = ref<number | null>(null)
const showDepositModal = ref(false)
const depositAmount = ref(0)
const remainingAmount = ref(0)
const isDepositPayment = ref(false)

// Get dynamic data from booking store with safe defaults
const basePrice = computed(() => bookingStore.basePrice || 0)
const addOns = computed(() => bookingStore.selectedComfortOptions || [])
const discount = computed(() => bookingStore.promoCodeDiscount || 0)
const totalAmount = computed(() => bookingStore.calculatedTotalPrice || 0)

// Amount to charge (deposit or full amount)
const amountToCharge = computed(() => {
  return isDepositPayment.value ? depositAmount.value : totalAmount.value
})

// Get apartment images (first 3)
const apartmentImages = computed(() => {
  if (!bookingStore.apartment?.images || bookingStore.apartment.images.length === 0) {
    return []
  }
  
  return bookingStore.apartment.images.slice(0, 3).map((img: any) => {
    // Handle both string URLs and image objects
    if (typeof img === 'string') {
      return img
    }
    return img.image_url || img.url || ''
  }).filter(url => !!url)
})

async function handlePayment(method: 'card' | 'sepa' | 'paypal' | 'applepay') {
  if (isProcessing.value) return
  
  // Validate required data
  if (!bookingStore.apartment || !bookingStore.checkIn || !bookingStore.checkOut || !bookingStore.customerInfo) {
    errorMessage.value = 'Données de réservation incomplètes'
    return
  }
  
  isProcessing.value = true
  errorMessage.value = null

  try {
    // 1. Check availability before creating reservation
    logger.log('Checking availability...')
    const isAvailable = await checkAvailability(
      bookingStore.apartment.id,
      bookingStore.checkIn.toISOString().split('T')[0],
      bookingStore.checkOut.toISOString().split('T')[0]
    )

    if (!isAvailable) {
      errorMessage.value = 'Désolé, cet appartement n\'est plus disponible pour ces dates.'
      isProcessing.value = false
      return
    }

    // 2. Get reCAPTCHA token
    logger.log('Getting reCAPTCHA token...')
    const recaptchaToken = await executeRecaptcha('payment')

    // 3. Create reservation
    logger.log('Creating reservation...')
    const reservationData: CreateReservationData = {
      apartment_id: bookingStore.apartment.id,
      check_in_date: bookingStore.checkIn.toISOString().split('T')[0],
      check_out_date: bookingStore.checkOut.toISOString().split('T')[0],
      adults: bookingStore.guests,
      children: 0,
      customer: {
        first_name: bookingStore.customerInfo.firstName,
        last_name: bookingStore.customerInfo.lastName,
        email: bookingStore.customerInfo.email,
        phone: bookingStore.customerInfo.phone || undefined,
        nationality: bookingStore.customerInfo.country || undefined,
        is_newsletter_subscribed: false
      },
      comfort_options: bookingStore.selectedComfortOptions.map(opt => ({
        id: opt.id,
        quantity: opt.quantity
      })),
      promo_code: bookingStore.promoCode || undefined,
      pricing_type: 'flexible',
      special_requests: bookingStore.customerInfo.specialRequests || undefined,
      recaptcha_token: recaptchaToken || undefined
    }

    const reservation = await createReservation(reservationData)
    logger.log('Reservation created:', reservation.id)
    currentReservationId.value = reservation.id

    // 4. Handle payment based on method
    if (method === 'card') {
      // For Stripe card payment
      logger.log('Initiating Stripe payment...')
      const paymentIntent = await initiatePayment(
        reservation.id,
        'card',
        recaptchaToken || undefined
      )
      logger.log('Payment intent created:', paymentIntent.id)
      
      // Store client secret for Stripe Elements
      paymentIntentClientSecret.value = paymentIntent.client_secret
      
      // Stripe Elements will handle the rest
      // isProcessing will be set to false in handleStripeSuccess or handleStripeError
    } else if (method === 'paypal') {
      // For PayPal, just wait for PayPal buttons to be clicked
      // The reservation is created, PayPal buttons will appear
      logger.log('Reservation created, waiting for PayPal payment...')
      isProcessing.value = false
    } else {
      // For other methods (SEPA, Apple Pay), simulate for now
      logger.log('Processing payment with method:', method)
      
      const paymentIntent = await initiatePayment(
        reservation.id,
        method,
        recaptchaToken || undefined
      )
      
      // Simulate payment processing
      await new Promise(resolve => setTimeout(resolve, 1500))

      // Confirm payment
      logger.log('Confirming payment...')
      const payment = await confirmPayment(paymentIntent.id)
      logger.log('Payment confirmed:', payment.id)

      // Store confirmation number and navigate
      bookingStore.confirmationNumber = `KSH-${reservation.id.toString().padStart(6, '0')}`
      bookingStore.step = 3
      router.push({ name: 'confirmation' })
    }
  } catch (error: any) {
    logger.error('Payment failed:', error)
    errorMessage.value = error.message || 'Le paiement a échoué. Veuillez réessayer.'
    isProcessing.value = false
  }
}

async function handleStripeSuccess(paymentIntent: any) {
  try {
    logger.log('Stripe payment succeeded:', paymentIntent.id)
    
    // Confirm payment in our backend
    const payment = await confirmPayment(paymentIntent.id)
    logger.log('Payment confirmed in backend:', payment.id)

    // Store confirmation number
    if (currentReservationId.value) {
      bookingStore.confirmationNumber = `KSH-${currentReservationId.value.toString().padStart(6, '0')}`
    }
    bookingStore.step = 3

    // Navigate to confirmation
    router.push({ name: 'confirmation' })
  } catch (error: any) {
    logger.error('Failed to confirm payment:', error)
    errorMessage.value = 'Le paiement a réussi mais la confirmation a échoué. Contactez-nous.'
  } finally {
    isProcessing.value = false
  }
}

function handleStripeError(error: string) {
  logger.error('Stripe payment failed:', error)
  errorMessage.value = error
  isProcessing.value = false
}

async function handlePayPalSuccess(orderId: string, details: any) {
  try {
    logger.log('PayPal payment succeeded:', orderId)
    logger.log('PayPal details:', details)
    
    // The payment is already captured by PayPal
    // We need to confirm it in our backend
    // For now, we'll use the orderId as the payment intent ID
    
    // Create a payment record in our backend
    if (currentReservationId.value) {
      // Initiate payment to create record
      const paymentIntent = await initiatePayment(
        currentReservationId.value,
        'paypal'
      )
      
      // Confirm payment with PayPal order ID
      const payment = await confirmPayment(paymentIntent.id, {
        paypal_order_id: orderId,
        paypal_details: details
      })
      
      logger.log('Payment confirmed in backend:', payment.id)

      // Store confirmation number
      bookingStore.confirmationNumber = `KSH-${currentReservationId.value.toString().padStart(6, '0')}`
      bookingStore.step = 3

      // Navigate to confirmation
      router.push({ name: 'confirmation' })
    }
  } catch (error: any) {
    logger.error('Failed to confirm PayPal payment:', error)
    errorMessage.value = 'Le paiement PayPal a réussi mais la confirmation a échoué. Contactez-nous.'
  }
}

function handlePayPalError(error: string) {
  logger.error('PayPal payment failed:', error)
  errorMessage.value = error
  isProcessing.value = false
}

function handlePayPalCancel() {
  logger.log('PayPal payment cancelled by user')
  errorMessage.value = 'Paiement PayPal annulé'
  isProcessing.value = false
}

function handleDepositModalClose() {
  // If user closes the modal without confirming, redirect back to booking
  logger.log('Deposit modal closed without confirmation')
  router.push({ name: 'booking' })
}

function formatPrice(amount: number): string {
  return `${amount.toFixed(2)}€`
}

onMounted(async () => {
  isLoading.value = true
  
  try {
    // 1. Load payment configuration from backend
    logger.log('Loading payment configuration...')
    const paymentConfig = await loadConfig()
    
    if (paymentConfig) {
      stripePublishableKey.value = getStripeKey()
      paypalClientId.value = getPayPalClientId()
      paypalMode.value = getPayPalMode()
      
      logger.log('Payment config loaded:', {
        stripeEnabled: isStripeEnabled(),
        paypalEnabled: isPayPalEnabled(),
        paypalMode: paypalMode.value
      })
    } else {
      logger.warn('Failed to load payment config')
    }

    // 2. Load deposit configuration
    logger.log('Loading deposit configuration...')
    await loadDepositConfig()
    
    // 3. Check if this is a deposit payment (from query param)
    isDepositPayment.value = route.query.deposit === 'true'
    
    // 4. Check if we need to reload apartment data (missing images or pricePerNight)
    const needsReload = !bookingStore.apartment || 
                        !bookingStore.apartment.images || 
                        bookingStore.apartment.images.length === 0 ||
                        !bookingStore.apartment.pricePerNight
    
    if (needsReload) {
      logger.log('Reloading apartment data...')
      const apartmentId = route.query.apartmentId || bookingStore.apartment?.id
      
      if (apartmentId) {
        // Load apartments if not already loaded
        if (apartmentsStore.apartments.length === 0) {
          logger.log('Fetching apartments from API...')
          await apartmentsStore.fetchApartments()
        }
        
        // Find the apartment by ID
        const apartment = apartmentsStore.apartments.find(
          apt => apt.id === parseInt(apartmentId as string)
        )
        
        if (apartment) {
          logger.log('Apartment found:', apartment.name)
          
          // Replace the entire apartment object to ensure all data is present
          bookingStore.apartment = apartment
          
          logger.log('Apartment data updated in store')
        } else {
          logger.warn('Apartment not found with ID:', apartmentId)
        }
      } else {
        logger.warn('No apartment ID available')
      }
    } else {
      logger.log('Apartment data already complete')
    }
    
    // Validate booking data
    if (!bookingStore.checkIn || !bookingStore.checkOut) {
      logger.warn('Missing booking dates - redirecting to booking page')
      router.push({ name: 'booking' })
      return
    }
    
    // 5. Calculate deposit if needed (AFTER apartment data is loaded)
    if (isDepositPayment.value && isDepositEnabled.value) {
      logger.log('Deposit payment mode enabled')
      
      // S'assurer que le montant total est bien calculé
      const actualTotal = bookingStore.calculatedTotalPrice
      
      logger.log('Booking details for deposit calculation:', {
        total: actualTotal,
        nightCount: bookingStore.nightCount,
        basePrice: bookingStore.basePrice,
        comfortOptions: bookingStore.comfortOptionsTotal,
        discount: bookingStore.promoCodeDiscount,
        apartment: bookingStore.apartment?.name,
        pricePerNight: bookingStore.apartment?.pricePerNight
      })
      
      // Vérifier que le total est valide
      if (!actualTotal || actualTotal <= 0) {
        logger.error('Invalid total amount for deposit calculation:', actualTotal)
        errorMessage.value = 'Erreur: Montant total invalide. Veuillez retourner à la page de réservation.'
        return
      }
      
      // Calculate deposit amount
      const depositCalc = await calculateDeposit(actualTotal)
      if (depositCalc) {
        depositAmount.value = depositCalc.deposit_amount
        remainingAmount.value = depositCalc.remaining_amount
        
        logger.log('Deposit calculated successfully:', {
          total: actualTotal,
          deposit: depositAmount.value,
          remaining: remainingAmount.value,
          percentage: depositCalc.deposit_percentage
        })
        
        // Show deposit modal
        showDepositModal.value = true
      } else {
        logger.error('Failed to calculate deposit')
        errorMessage.value = 'Erreur lors du calcul du dépôt de garantie.'
      }
    }
    
    logger.log('Booking summary:', {
      apartment: bookingStore.apartment?.name,
      checkIn: bookingStore.checkIn?.toLocaleDateString(),
      checkOut: bookingStore.checkOut?.toLocaleDateString(),
      nights: bookingStore.nightCount,
      basePrice: bookingStore.basePrice,
      comfortOptions: bookingStore.selectedComfortOptions.length,
      total: bookingStore.calculatedTotalPrice
    })

    // Set booking step
    bookingStore.step = 2

    // Initialize reCAPTCHA
    await initRecaptcha()
  } catch (error) {
    logger.error('Error loading payment page:', error)
    errorMessage.value = 'Erreur lors du chargement de la page de paiement.'
  } finally {
    isLoading.value = false
  }
})
</script>
