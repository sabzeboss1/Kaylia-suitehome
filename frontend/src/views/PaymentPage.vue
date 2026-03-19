<template>
  <DefaultLayout>
    <!-- Payment Page -->
    <section v-if="isLoading" class="bg-gray-50 py-8 md:py-12">
      <div class="container mx-auto px-4 md:px-6 max-w-7xl">
        <div class="flex items-center justify-center py-20">
          <LoadingSpinner />
        </div>
      </div>
    </section>
    
    <section v-else class="bg-gray-50 py-8 md:py-12">
      <div class="container mx-auto px-4 md:px-6 max-w-7xl">
        <!-- Progress Steps -->
        <div class="flex items-center justify-center gap-4 md:gap-8 mb-8">
          <ProgressSteps :current-step="2" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Left Column - Payment Form -->
          <div>
            <!-- Currency Selection -->
            <CurrencySelector v-model="selectedCurrency" />

            <!-- Payment Method Selection -->
            <PaymentMethod
              v-model="selectedPaymentMethod"
              :total-amount="totalAmount"
              :is-processing="isProcessing"
              :show-pay-button="selectedPaymentMethod !== 'card'"
              @pay="handlePayment"
            />

            <!-- Stripe Card Element (only shown for card payment) -->
            <div v-if="selectedPaymentMethod === 'card' && paymentIntentClientSecret && stripePublishableKey" class="mt-6">
              <StripeCardElement
                :client-secret="paymentIntentClientSecret"
                :amount="totalAmount"
                :publishable-key="stripePublishableKey"
                @success="handleStripeSuccess"
                @error="handleStripeError"
              />
            </div>

            <!-- Loading message for Stripe -->
            <div v-else-if="selectedPaymentMethod === 'card' && !stripePublishableKey" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
              ⚠️ Configuration Stripe non disponible. Veuillez contacter l'administrateur.
            </div>

            <!-- PayPal Buttons (only shown for PayPal payment) -->
            <div v-if="selectedPaymentMethod === 'paypal' && paypalClientId && currentReservationId" class="mt-6">
              <PayPalButtons
                :client-id="paypalClientId"
                :amount="totalAmount"
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
            <div v-else-if="selectedPaymentMethod === 'paypal' && !currentReservationId && isProcessing" class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
              <div class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Préparation du paiement PayPal...</span>
              </div>
            </div>
          </div>

          <!-- Right Column - Summary -->
          <div class="space-y-6">
            <!-- Total -->
            <PriceBreakdown :total-price="totalAmount" />

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
    </section>
  </DefaultLayout>
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
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ProgressSteps from '@/components/booking/ProgressSteps.vue'
import CurrencySelector from '@/components/payment/CurrencySelector.vue'
import PaymentMethod from '@/components/payment/PaymentMethod.vue'
import StripeCardElement from '@/components/payment/StripeCardElement.vue'
import PayPalButtons from '@/components/payment/PayPalButtons.vue'
import PriceBreakdown from '@/components/booking/PriceBreakdown.vue'
import ReservationSummary from '@/components/payment/ReservationSummary.vue'
import PracticalInfo from '@/components/payment/PracticalInfo.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'

const router = useRouter()
const route = useRoute()
const bookingStore = useBookingStore()
const apartmentsStore = useApartmentsStore()
const { init: initRecaptcha, execute: executeRecaptcha } = useRecaptcha()
const { createReservation, checkAvailability } = useReservation()
const { initiatePayment, confirmPayment } = usePayment()
const { loadConfig, getStripeKey, getPayPalClientId, getPayPalMode, isStripeEnabled, isPayPalEnabled } = usePaymentConfig()

const isLoading = ref(true)
const isProcessing = ref(false)
const selectedCurrency = ref('EUR')
const selectedPaymentMethod = ref<'card' | 'sepa' | 'paypal' | 'applepay'>('card')
const errorMessage = ref<string | null>(null)
const stripePublishableKey = ref<string | null>(null)
const paypalClientId = ref<string | null>(null)
const paypalMode = ref<'sandbox' | 'live'>('sandbox')
const paymentIntentClientSecret = ref<string | null>(null)
const currentReservationId = ref<number | null>(null)

// Get dynamic data from booking store with safe defaults
const basePrice = computed(() => bookingStore.basePrice || 0)
const addOns = computed(() => bookingStore.selectedComfortOptions || [])
const discount = computed(() => bookingStore.promoCodeDiscount || 0)
const totalAmount = computed(() => bookingStore.calculatedTotalPrice || 0)

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
    alert(errorMessage.value)
    return
  }
  
  isProcessing.value = true
  errorMessage.value = null

  try {
    // 1. Vérifier la disponibilité avant de créer la réservation
    console.log('🔍 Checking availability...')
    const isAvailable = await checkAvailability(
      bookingStore.apartment.id,
      bookingStore.checkIn.toISOString().split('T')[0],
      bookingStore.checkOut.toISOString().split('T')[0]
    )

    if (!isAvailable) {
      errorMessage.value = 'Désolé, cet appartement n\'est plus disponible pour ces dates.'
      alert(errorMessage.value)
      isProcessing.value = false
      return
    }

    // 2. Get reCAPTCHA token
    console.log('🔐 Getting reCAPTCHA token...')
    const recaptchaToken = await executeRecaptcha('payment')

    // 3. Create reservation
    console.log('📝 Creating reservation...')
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
    console.log('✅ Reservation created:', reservation.id)
    currentReservationId.value = reservation.id

    // 4. Handle payment based on method
    if (method === 'card') {
      // For Stripe card payment
      console.log('💳 Initiating Stripe payment...')
      const paymentIntent = await initiatePayment(
        reservation.id,
        'card',
        recaptchaToken || undefined
      )
      console.log('✅ Payment intent created:', paymentIntent.id)
      
      // Store client secret for Stripe Elements
      paymentIntentClientSecret.value = paymentIntent.client_secret
      
      // Stripe Elements will handle the rest
      // isProcessing will be set to false in handleStripeSuccess or handleStripeError
    } else if (method === 'paypal') {
      // For PayPal, just wait for PayPal buttons to be clicked
      // The reservation is created, PayPal buttons will appear
      console.log('💳 Reservation created, waiting for PayPal payment...')
      isProcessing.value = false
    } else {
      // For other methods (SEPA, Apple Pay), simulate for now
      console.log('💰 Processing payment with method:', method)
      
      const paymentIntent = await initiatePayment(
        reservation.id,
        method,
        recaptchaToken || undefined
      )
      
      // Simulate payment processing
      await new Promise(resolve => setTimeout(resolve, 1500))

      // Confirm payment
      console.log('✅ Confirming payment...')
      const payment = await confirmPayment(paymentIntent.id)
      console.log('✅ Payment confirmed:', payment.id)

      // Store confirmation number and navigate
      bookingStore.confirmationNumber = `KSH-${reservation.id.toString().padStart(6, '0')}`
      bookingStore.step = 3
      router.push({ name: 'confirmation' })
    }
  } catch (error: any) {
    console.error('❌ Payment failed:', error)
    errorMessage.value = error.message || 'Le paiement a échoué. Veuillez réessayer.'
    alert(errorMessage.value)
    isProcessing.value = false
  }
}

async function handleStripeSuccess(paymentIntent: any) {
  try {
    console.log('✅ Stripe payment succeeded:', paymentIntent.id)
    
    // Confirm payment in our backend
    const payment = await confirmPayment(paymentIntent.id)
    console.log('✅ Payment confirmed in backend:', payment.id)

    // Store confirmation number
    if (currentReservationId.value) {
      bookingStore.confirmationNumber = `KSH-${currentReservationId.value.toString().padStart(6, '0')}`
    }
    bookingStore.step = 3

    // Navigate to confirmation
    router.push({ name: 'confirmation' })
  } catch (error: any) {
    console.error('❌ Failed to confirm payment:', error)
    errorMessage.value = 'Le paiement a réussi mais la confirmation a échoué. Contactez-nous.'
    alert(errorMessage.value)
  } finally {
    isProcessing.value = false
  }
}

function handleStripeError(error: string) {
  console.error('❌ Stripe payment failed:', error)
  errorMessage.value = error
  alert(errorMessage.value)
  isProcessing.value = false
}

async function handlePayPalSuccess(orderId: string, details: any) {
  try {
    console.log('✅ PayPal payment succeeded:', orderId)
    console.log('PayPal details:', details)
    
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
      
      console.log('✅ Payment confirmed in backend:', payment.id)

      // Store confirmation number
      bookingStore.confirmationNumber = `KSH-${currentReservationId.value.toString().padStart(6, '0')}`
      bookingStore.step = 3

      // Navigate to confirmation
      router.push({ name: 'confirmation' })
    }
  } catch (error: any) {
    console.error('❌ Failed to confirm PayPal payment:', error)
    errorMessage.value = 'Le paiement PayPal a réussi mais la confirmation a échoué. Contactez-nous.'
    alert(errorMessage.value)
  }
}

function handlePayPalError(error: string) {
  console.error('❌ PayPal payment failed:', error)
  errorMessage.value = error
  alert(errorMessage.value)
  isProcessing.value = false
}

function handlePayPalCancel() {
  console.log('⚠️ PayPal payment cancelled by user')
  errorMessage.value = 'Paiement PayPal annulé'
  isProcessing.value = false
}

onMounted(async () => {
  isLoading.value = true
  
  try {
    // 1. Load payment configuration from backend
    console.log('🔧 Loading payment configuration...')
    const paymentConfig = await loadConfig()
    
    if (paymentConfig) {
      stripePublishableKey.value = getStripeKey()
      paypalClientId.value = getPayPalClientId()
      paypalMode.value = getPayPalMode()
      
      console.log('✅ Payment config loaded:')
      console.log('   - Stripe enabled:', isStripeEnabled())
      console.log('   - Stripe key:', stripePublishableKey.value ? '✓' : '✗')
      console.log('   - PayPal enabled:', isPayPalEnabled())
      console.log('   - PayPal mode:', paypalMode.value)
    } else {
      console.warn('⚠️ Failed to load payment config')
    }

    // 2. Check if we need to reload apartment data (missing images or pricePerNight)
    const needsReload = !bookingStore.apartment || 
                        !bookingStore.apartment.images || 
                        bookingStore.apartment.images.length === 0 ||
                        !bookingStore.apartment.pricePerNight
    
    if (needsReload) {
      console.log('🔄 Reloading apartment data...')
      const apartmentId = route.query.apartmentId || bookingStore.apartment?.id
      
      if (apartmentId) {
        // Load apartments if not already loaded
        if (apartmentsStore.apartments.length === 0) {
          console.log('📥 Fetching apartments from API...')
          await apartmentsStore.fetchApartments()
        }
        
        // Find the apartment by ID
        const apartment = apartmentsStore.apartments.find(
          apt => apt.id === parseInt(apartmentId as string)
        )
        
        if (apartment) {
          console.log('✅ Apartment found:', apartment.name)
          console.log('   - Price per night:', apartment.pricePerNight, '€')
          console.log('   - Images count:', apartment.images?.length || 0)
          
          // Replace the entire apartment object to ensure all data is present
          bookingStore.apartment = apartment
          
          console.log('✅ Apartment data updated in store')
        } else {
          console.warn('⚠️ Apartment not found with ID:', apartmentId)
        }
      } else {
        console.warn('⚠️ No apartment ID available')
      }
    } else {
      console.log('✅ Apartment data already complete')
    }
    
    // Set default dates if not set (for testing)
    if (!bookingStore.checkIn) {
      const today = new Date()
      bookingStore.checkIn = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000) // +7 days
      console.log('✅ Check-in set to:', bookingStore.checkIn.toLocaleDateString())
    }
    
    if (!bookingStore.checkOut) {
      const checkIn = bookingStore.checkIn || new Date()
      bookingStore.checkOut = new Date(checkIn.getTime() + 3 * 24 * 60 * 60 * 1000) // +3 nights
      console.log('✅ Check-out set to:', bookingStore.checkOut.toLocaleDateString())
    }
    
    console.log('✅ Night count:', bookingStore.nightCount)
    
    // Add some test comfort options if none selected (for testing)
    if (bookingStore.selectedComfortOptions.length === 0) {
      bookingStore.addComfortOption({
        id: 1,
        name: 'Ménage quotidien - tout l\'appartement',
        price: 35,
        quantity: 1,
        price_type: 'per_night'
      })
      bookingStore.addComfortOption({
        id: 2,
        name: '1 Bouteille de vin rouge',
        price: 30,
        quantity: 1,
        price_type: 'one_time'
      })
      bookingStore.addComfortOption({
        id: 3,
        name: '1 panier gourmand',
        price: 25,
        quantity: 1,
        price_type: 'one_time'
      })
      console.log('✅ Test comfort options added')
    }

    // Set booking step
    bookingStore.step = 2

    // Initialize reCAPTCHA
    await initRecaptcha()
    
    // Log booking summary
    console.log('\n📊 BOOKING SUMMARY:')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('Apartment:', bookingStore.apartment?.name || 'N/A')
    console.log('Check-in:', bookingStore.checkIn?.toLocaleDateString() || 'N/A')
    console.log('Check-out:', bookingStore.checkOut?.toLocaleDateString() || 'N/A')
    console.log('Nights:', bookingStore.nightCount)
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('Base price:', bookingStore.basePrice, '€')
    console.log('Comfort options:', bookingStore.selectedComfortOptions.length)
    console.log('Options total:', bookingStore.comfortOptionsTotal, '€')
    console.log('Discount:', bookingStore.promoCodeDiscount, '€')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('TOTAL:', bookingStore.calculatedTotalPrice, '€')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
  } catch (error) {
    console.error('❌ Error loading payment page:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
