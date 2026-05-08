<template>
  <Teleport to="body">
    <Transition name="modal">
      <div 
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
        @click.self="closeModal"
      >
        <div 
          class="bg-[#2c3e50] rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative"
          @click.stop
        >
          <!-- Close Button -->
          <button 
            @click="closeModal"
            class="absolute top-3 right-3 md:top-4 md:right-4 w-8 h-8 md:w-10 md:h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition z-10"
          >
            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <!-- Form Content -->
          <div class="p-4 md:p-8 lg:p-12">
            <!-- Error Message -->
            <Transition name="fade">
              <div v-if="showError" class="mb-4 md:mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex gap-3">
                  <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-red-800">{{ errorMessage }}</p>
                  </div>
                  <button 
                    @click="showError = false"
                    type="button"
                    class="text-red-400 hover:text-red-600 transition"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </Transition>

            <form @submit.prevent="handleSubmit" class="space-y-4 md:space-y-6">
              <!-- Nom et Prénom -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                  <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                    Nom (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.lastName"
                    type="text"
                    placeholder="Votre nom"
                    required
                    class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] text-sm md:text-base"
                  />
                </div>
                <div>
                  <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                    Prénom (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.firstName"
                    type="text"
                    placeholder="Votre prénom"
                    required
                    class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] text-sm md:text-base"
                  />
                </div>
              </div>

              <!-- Email et Téléphone -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                  <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                    Adresse mail (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.email"
                    type="email"
                    placeholder="ex : nom.mail@hotmail.fr"
                    required
                    class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] text-sm md:text-base"
                  />
                </div>
                <div>
                  <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                    Numéro de téléphone (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.phone"
                    type="tel"
                    placeholder="ex : 06 00 00 00 00"
                    required
                    class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] text-sm md:text-base"
                  />
                </div>
              </div>

              <!-- Nationalité -->
              <div>
                <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                  Nationalité
                </label>
                <input 
                  v-model="formData.nationality"
                  type="text"
                  placeholder="Votre nationalité"
                  class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] text-sm md:text-base"
                />
              </div>

              <!-- Demandes spéciales -->
              <div>
                <label class="block text-white text-xs md:text-sm mb-1 md:mb-2">
                  Demandes spéciales
                </label>
                <textarea 
                  v-model="formData.specialRequests"
                  rows="3"
                  placeholder="Entrez votre message"
                  class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] resize-none text-sm md:text-base"
                ></textarea>
              </div>

              <!-- Info Box for Pay on Site -->
              <div v-if="isPayOnSite" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                  <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                  <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Dépôt de garantie requis</p>
                    <p>Pour sécuriser votre réservation, un dépôt de garantie sera requis. Le solde restant sera à régler sur place lors de votre arrivée.</p>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="flex justify-center pt-2 md:pt-4">
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="bg-[#b8a088] hover:bg-[#a89078] text-white px-8 py-3 md:px-16 md:py-4 rounded-lg text-base md:text-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed w-full md:w-auto"
                >
                  {{ isSubmitting ? 'Traitement...' : buttonText }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import { useReservation } from '@/composables/useReservation'
import { logger } from '@/utils/logger'

interface Props {
  isOpen: boolean
  apartmentId?: number
  apartmentName?: string
  bookingData?: any
}

const props = defineProps<Props>()
const emit = defineEmits<{
  'close': []
  'submit': [data: any]
}>()

const router = useRouter()
const bookingStore = useBookingStore()
const { createReservation, loading: reservationLoading } = useReservation()

const formData = ref({
  lastName: '',
  firstName: '',
  email: '',
  phone: '',
  nationality: '',
  specialRequests: ''
})

const isSubmitting = ref(false)
const errorMessage = ref('')
const showError = ref(false)

// Detect if pay on site (rate ID 2)
const isPayOnSite = computed(() => {
  return props.bookingData?.selectedRateId === 2
})

// Dynamic button text
const buttonText = computed(() => {
  return isPayOnSite.value ? 'Continuer vers le paiement' : 'Procéder au paiement'
})

const closeModal = () => {
  emit('close')
}

const handleSubmit = async () => {
  // Réinitialiser les erreurs
  errorMessage.value = ''
  showError.value = false
  isSubmitting.value = true
  
  try {
    // Validation des champs requis
    if (!formData.value.firstName || !formData.value.lastName || !formData.value.email || !formData.value.phone) {
      errorMessage.value = 'Veuillez remplir tous les champs obligatoires.'
      showError.value = true
      isSubmitting.value = false
      return
    }
    
    // Validation de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(formData.value.email)) {
      errorMessage.value = 'Veuillez entrer une adresse email valide.'
      showError.value = true
      isSubmitting.value = false
      return
    }
    
    // Préparer les données de réservation complètes
    const reservationData = {
      ...formData.value,
      apartmentId: props.apartmentId,
      apartmentName: props.apartmentName,
      ...props.bookingData
    }
    
    // Mettre à jour le store pour passer le guard de navigation
    bookingStore.apartment = {
      id: props.apartmentId || 1,
      name: props.apartmentName || 'Appartement',
      slug: '',
      type: 'studio',
      description: '',
      capacity: 2,
      surface: 0,
      bedrooms: 0,
      beds: [],
      floor: '',
      pricePerNight: 0,
      images: [],
      equipments: [],
      comfortOptions: []
    } as any
    
    bookingStore.customerInfo = {
      firstName: formData.value.firstName,
      lastName: formData.value.lastName,
      email: formData.value.email,
      phone: formData.value.phone,
      country: formData.value.nationality || '',
      specialRequests: formData.value.specialRequests
    }
    
    // Mettre à jour les dates si disponibles
    if (props.bookingData?.checkIn) {
      bookingStore.checkIn = props.bookingData.checkIn
    }
    if (props.bookingData?.checkOut) {
      bookingStore.checkOut = props.bookingData.checkOut
    }
    if (props.bookingData?.guests) {
      bookingStore.guests = props.bookingData.guests
    }
    
    // Émettre l'événement avec les données
    emit('submit', reservationData)
    
    // Si paiement sur place: rediriger vers la page de paiement avec dépôt
    if (isPayOnSite.value) {
      logger.log('🏠 Redirecting to payment page with deposit...')
      
      // Fermer le modal
      closeModal()
      
      // Rediriger vers la page de paiement avec le paramètre deposit=true
      await router.push({
        name: 'payment',
        query: {
          type: 'apartment',
          apartmentId: props.apartmentId?.toString(),
          deposit: 'true'
        }
      })
    } else {
      // Tarif flexible: aller à la page paiement
      logger.log('💳 Redirecting to payment page...')
      
      // Simuler un délai pour l'API
      await new Promise(resolve => setTimeout(resolve, 500))
      
      // Fermer le modal
      closeModal()
      
      // Rediriger vers la page de paiement
      await router.push({
        name: 'payment',
        query: {
          type: 'apartment',
          apartmentId: props.apartmentId?.toString()
        }
      })
    }
  } catch (error: any) {
    logger.error('❌ Erreur lors de la soumission:', error)
    
    // Log détaillé pour le débogage
    if (error.response) {
      logger.error('📋 Response status:', error.response.status)
      logger.error('📋 Response data:', error.response.data)
    }
    
    // Construire un message d'erreur clair pour l'utilisateur
    let userMessage = 'Une erreur est survenue lors de la réservation.'
    let technicalDetails = ''
    
    // Extraire le message d'erreur de l'API
    if (error.response?.data) {
      const apiError = error.response.data
      
      // Erreur de validation (422)
      if (error.response.status === 422) {
        if (apiError.errors) {
          // Afficher la première erreur de validation
          const firstErrorKey = Object.keys(apiError.errors)[0]
          const firstError = Object.values(apiError.errors)[0]
          userMessage = Array.isArray(firstError) ? firstError[0] : firstError
          technicalDetails = `Champ: ${firstErrorKey}`
          
          // Traduire les messages courants
          if (userMessage.includes('not available')) {
            userMessage = 'Cet appartement n\'est pas disponible pour les dates sélectionnées.'
          } else if (userMessage.includes('after or equal to today')) {
            userMessage = 'La date d\'arrivée doit être aujourd\'hui ou dans le futur.'
          } else if (userMessage.includes('after:check_in_date')) {
            userMessage = 'La date de départ doit être après la date d\'arrivée.'
          }
        } else if (apiError.message) {
          userMessage = apiError.message
        } else {
          userMessage = 'Les données saisies sont invalides. Veuillez vérifier vos informations.'
        }
      }
      // Erreur serveur (500)
      else if (error.response.status === 500) {
        userMessage = 'Une erreur serveur est survenue. Veuillez réessayer dans quelques instants.'
        technicalDetails = apiError.message || 'Internal Server Error'
      }
      // Erreur d'authentification (401)
      else if (error.response.status === 401) {
        userMessage = 'Session expirée. Veuillez rafraîchir la page.'
      }
      // Erreur de disponibilité
      else if (apiError.message?.includes('not available') || apiError.message?.includes('disponible')) {
        userMessage = 'Cet appartement n\'est pas disponible pour les dates sélectionnées. Veuillez choisir d\'autres dates.'
      }
      // Message générique de l'API
      else if (apiError.message) {
        userMessage = apiError.message
      }
    }
    // Erreur réseau
    else if (error.message?.includes('Network Error') || error.message?.includes('ERR_CONNECTION')) {
      userMessage = 'Impossible de contacter le serveur. Vérifiez votre connexion internet.'
    }
    // Message d'erreur direct
    else if (error.message) {
      userMessage = error.message
    }
    
    // Afficher l'erreur avec détails techniques en mode dev
    if (import.meta.env.DEV && technicalDetails) {
      errorMessage.value = `${userMessage}\n\nDétails: ${technicalDetails}`
    } else {
      errorMessage.value = userMessage
    }
    
    showError.value = true
    
    // Faire défiler vers le haut du modal pour voir l'erreur
    setTimeout(() => {
      const modalContent = document.querySelector('.bg-\\[\\#2c3e50\\]')
      if (modalContent) {
        modalContent.scrollTop = 0
      }
    }, 100)
  } finally {
    isSubmitting.value = false
  }
}

// Helper function to format date for API
function formatDateForAPI(date: Date | null | undefined): string {
  if (!date) return new Date().toISOString().split('T')[0]
  
  const d = new Date(date)
  const year = d.getFullYear()
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

// Réinitialiser le formulaire quand le modal se ferme
watch(() => props.isOpen, (newValue) => {
  if (!newValue) {
    formData.value = {
      lastName: '',
      firstName: '',
      email: '',
      phone: '',
      nationality: '',
      specialRequests: ''
    }
    errorMessage.value = ''
    showError.value = false
  }
})
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .bg-\[#2c3e50\],
.modal-leave-active .bg-\[#2c3e50\] {
  transition: transform 0.3s ease;
}

.modal-enter-from .bg-\[#2c3e50\],
.modal-leave-to .bg-\[#2c3e50\] {
  transform: scale(0.9);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
