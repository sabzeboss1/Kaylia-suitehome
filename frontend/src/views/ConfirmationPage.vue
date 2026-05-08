<template>
  <DefaultLayout>
    <!-- Confirmation Page -->
    <section class="bg-[#c9b5a0] pt-[62px] md:pt-20 pb-12 md:pb-16 min-h-[60vh]">
      <div class="container mx-auto px-6 md:px-20 max-w-4xl pt-8 md:pt-0">
        <!-- Progress Steps -->
        <div class="mb-12">
          <ProgressSteps :current-step="3" />
        </div>

        <!-- Confirmation Message -->
        <div class="text-center md:text-left mb-12">
          <h1 class="text-3xl md:text-4xl font-light text-gray-900 mb-8">
            {{ confirmationTitle }}
          </h1>
          
          <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
            {{ confirmationMessage }}
          </p>
          
          <!-- Pay on Site Notice -->
          <div v-if="isPayOnSite" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex gap-3">
              <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div class="text-left">
                <p class="text-base font-semibold text-blue-900 mb-2">Paiement à l'arrivée</p>
                <p class="text-sm text-blue-800">
                  Le paiement complet sera effectué lors de votre arrivée à l'établissement. 
                  Vous recevrez un email de confirmation avec tous les détails de votre réservation.
                </p>
              </div>
            </div>
          </div>
          
          <p class="text-base text-gray-700 mb-8">
            Si vous avez des questions, n'hésitez pas à nous contacter.
          </p>

          <!-- Booking Reference Number -->
          <div v-if="bookingReference" class="bg-white rounded-lg p-6 mb-8 shadow-sm">
            <p class="text-sm text-gray-600 mb-2">Numéro de réservation</p>
            <p class="text-2xl font-semibold text-gray-900">{{ bookingReference }}</p>
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
            <p class="text-sm text-red-600">{{ errorMessage }}</p>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
            <button
              @click="downloadInvoiceHandler"
              :disabled="isDownloading"
              class="px-8 py-3 bg-primary-blue text-white rounded text-sm font-medium hover:bg-opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <svg v-if="isDownloading" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ isDownloading ? 'Téléchargement...' : 'Télécharger la facture' }}</span>
            </button>
            <button
              @click="returnToHome"
              class="px-8 py-3 bg-white text-gray-900 border-2 border-gray-300 rounded text-sm font-medium hover:bg-gray-50 transition"
            >
              Retour à l'accueil
            </button>
          </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl">
          <!-- E-mail -->
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-gray-900 mb-3">E-mail</h3>
            <a :href="`mailto:${contactEmail}`" class="text-gray-700 hover:text-primary-blue transition">
              {{ contactEmail }}
            </a>
          </div>

          <!-- WhatsApp -->
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-gray-900 mb-3">WhatsApp</h3>
            <a :href="whatsappLink" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-primary-blue transition">
              {{ contactWhatsApp }}
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter Section -->
    <NewsletterSection />
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import { useReservation } from '@/composables/useReservation'
import { usePublicSettings } from '@/composables/usePublicSettings'
import { logger } from '@/utils/logger'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ProgressSteps from '@/components/booking/ProgressSteps.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'

const router = useRouter()
const route = useRoute()
const bookingStore = useBookingStore()
const { downloadInvoice, getReservation } = useReservation()
const { settings, fetchSettings } = usePublicSettings()

// Check if this is a pay on site reservation
const isPayOnSite = computed(() => route.query.type === 'pay_on_site')

// Use confirmation number from store or generate mock for development
const bookingReference = computed(() => bookingStore.confirmationNumber || 'KSH-2024-001234')
const isDownloading = ref(false)
const errorMessage = ref('')
const reservationId = ref<number | null>(null)

// Dynamic confirmation message
const confirmationTitle = computed(() => {
  return isPayOnSite.value 
    ? 'Votre réservation est confirmée.'
    : 'Votre réservation est validée.'
})

const confirmationMessage = computed(() => {
  return isPayOnSite.value
    ? 'Merci pour votre réservation chez Kaylia Suite Home. Le paiement sera effectué à votre arrivée.'
    : 'Merci pour votre réservation chez Kaylia Suite Home, nous sommes ravis de vous accueillir prochainement.'
})

// Contact info from settings
const contactEmail = computed(() => settings.value?.business_email || 'contact@kayliasuitehome.com')
const contactWhatsApp = computed(() => settings.value?.business_whatsapp || settings.value?.business_phone || '+237 00 00 00 00')
const whatsappLink = computed(() => {
  const phone = contactWhatsApp.value.replace(/\s+/g, '')
  return `https://wa.me/${phone}`
})

async function downloadInvoiceHandler() {
  // Get reservation ID from query parameter
  const resId = reservationId.value || (route.query.reservationId ? parseInt(route.query.reservationId as string) : null)
  
  if (!resId) {
    errorMessage.value = 'Numéro de réservation introuvable. Veuillez contacter le support.'
    return
  }

  isDownloading.value = true
  errorMessage.value = ''
  
  try {
    logger.log('📥 Downloading invoice for reservation:', resId)
    await downloadInvoice(resId)
    logger.log('✅ Invoice downloaded successfully')
  } catch (error: any) {
    logger.error('❌ Failed to download invoice:', error)
    errorMessage.value = 'Erreur lors du téléchargement de la facture. Veuillez réessayer ou contacter le support.'
  } finally {
    isDownloading.value = false
  }
}

function returnToHome() {
  // Reset booking store and navigate to home
  bookingStore.reset()
  router.push({ name: 'home' })
}

onMounted(async () => {
  // Settings are auto-loaded by usePublicSettings
  // Just ensure they're fetched
  if (!settings.value) {
    await fetchSettings()
  }
  
  // Get reservation ID from query if available
  if (route.query.reservationId) {
    reservationId.value = parseInt(route.query.reservationId as string)
    
    // Fetch reservation details
    try {
      const reservation = await getReservation(reservationId.value)
      if (reservation) {
        // Update booking store with reservation data
        bookingStore.confirmationNumber = `KSH-${reservation.id.toString().padStart(6, '0')}`
        logger.log('✅ Reservation loaded:', reservation)
      }
    } catch (error) {
      logger.error('Failed to load reservation:', error)
    }
  }

  // Check if booking data exists
  if (!bookingStore.apartment && !reservationId.value) {
    // For development, allow access without booking data
    // In production, uncomment the redirect:
    // router.push({ name: 'home' })
    // return
  }

  // Set booking step
  bookingStore.step = 3
})
</script>
