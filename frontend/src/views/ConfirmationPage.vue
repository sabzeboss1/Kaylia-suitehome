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
            Votre réservation est <span class="text-primary-blue">validée.</span>
          </h1>
          
          <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
            Merci pour votre réservation chez Kaylia Suite Home, nous sommes ravis de vous accueillir prochainement.
          </p>
          
          <p class="text-base text-gray-700 mb-8">
            Si vous avez des questions, n'hésitez pas à nous contacter.
          </p>

          <!-- Booking Reference Number -->
          <div v-if="bookingReference" class="bg-white rounded-lg p-6 mb-8 shadow-sm">
            <p class="text-sm text-gray-600 mb-2">Numéro de réservation</p>
            <p class="text-2xl font-semibold text-gray-900">{{ bookingReference }}</p>
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
            <a href="mailto:contact@kayliasuitehome.com" class="text-gray-700 hover:text-primary-blue transition">
              contact@kayliasuitehome.com
            </a>
          </div>

          <!-- WhatsApp -->
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-gray-900 mb-3">WhatsApp</h3>
            <a href="https://wa.me/237000000000" class="text-gray-700 hover:text-primary-blue transition">
              +237 00 00 00 00
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
import { useRouter } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import { useReservation } from '@/composables/useReservation'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ProgressSteps from '@/components/booking/ProgressSteps.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'

const router = useRouter()
const bookingStore = useBookingStore()
const { downloadInvoice } = useReservation()

// Use confirmation number from store or generate mock for development
const bookingReference = computed(() => bookingStore.confirmationNumber || 'KSH-2024-001234')
const isDownloading = ref(false)

async function downloadInvoiceHandler() {
  if (!bookingStore.confirmationNumber) {
    alert('La fonctionnalité de téléchargement de facture sera bientôt disponible.')
    return
  }

  isDownloading.value = true
  try {
    // Extract reservation ID from confirmation number (format: KSH-000123)
    const reservationId = parseInt(bookingStore.confirmationNumber.split('-')[1])
    await downloadInvoice(reservationId)
  } catch (error: any) {
    console.error('Failed to download invoice:', error)
    alert('Erreur lors du téléchargement de la facture. Veuillez réessayer.')
  } finally {
    isDownloading.value = false
  }
}

function returnToHome() {
  // Reset booking store and navigate to home
  bookingStore.reset()
  router.push({ name: 'home' })
}

onMounted(() => {
  // Check if booking data exists
  if (!bookingStore.apartment) {
    // For development, allow access without booking data
    // In production, uncomment the redirect:
    // router.push({ name: 'home' })
    // return
  }

  // Set booking step
  bookingStore.step = 3
})
</script>
