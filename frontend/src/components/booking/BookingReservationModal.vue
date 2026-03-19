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
            class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition z-10"
          >
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <!-- Form Content -->
          <div class="p-8 md:p-12">
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Nom et Prénom -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-white text-sm mb-2">
                    Nom (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.lastName"
                    type="text"
                    placeholder="Votre nom"
                    required
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8]"
                  />
                </div>
                <div>
                  <label class="block text-white text-sm mb-2">
                    Prénom (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.firstName"
                    type="text"
                    placeholder="Votre prénom"
                    required
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8]"
                  />
                </div>
              </div>

              <!-- Email et Téléphone -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-white text-sm mb-2">
                    Adresse mail (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.email"
                    type="email"
                    placeholder="ex : nom.mail@hotmail.fr"
                    required
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8]"
                  />
                </div>
                <div>
                  <label class="block text-white text-sm mb-2">
                    Numéro de téléphone (Obligatoire)
                  </label>
                  <input 
                    v-model="formData.phone"
                    type="tel"
                    placeholder="ex : 06 00 00 00 00 ou +237 000"
                    required
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8]"
                  />
                </div>
              </div>

              <!-- Nationalité -->
              <div>
                <label class="block text-white text-sm mb-2">
                  Nationalité
                </label>
                <input 
                  v-model="formData.nationality"
                  type="text"
                  placeholder="Votre nationalité"
                  class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8]"
                />
              </div>

              <!-- Demandes spéciales -->
              <div>
                <label class="block text-white text-sm mb-2">
                  Demandes spéciales
                </label>
                <textarea 
                  v-model="formData.specialRequests"
                  rows="4"
                  placeholder="Entrez votre message"
                  class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#17a2b8] resize-none"
                ></textarea>
              </div>

              <!-- Submit Button -->
              <div class="flex justify-center pt-4">
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="bg-[#b8a088] hover:bg-[#a89078] text-white px-16 py-4 rounded-lg text-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isSubmitting ? 'Traitement...' : 'Procéder au paiement' }}
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
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useBookingStore } from '@/stores/booking'

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

const formData = ref({
  lastName: '',
  firstName: '',
  email: '',
  phone: '',
  nationality: '',
  specialRequests: ''
})

const isSubmitting = ref(false)

const closeModal = () => {
  emit('close')
}

const handleSubmit = async () => {
  isSubmitting.value = true
  
  try {
    // Préparer les données de réservation complètes
    const reservationData = {
      ...formData.value,
      apartmentId: props.apartmentId,
      apartmentName: props.apartmentName,
      ...props.bookingData // Inclure les données de réservation (dates, options, etc.)
    }
    
    // Mettre à jour le store pour passer le guard de navigation
    // Note: Set minimal apartment object here, PaymentPage will reload full data
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
    
    // Simuler un délai pour l'API (à remplacer par un vrai appel API)
    await new Promise(resolve => setTimeout(resolve, 500))
    
    // Rediriger vers la page de paiement avec les données
    await router.push({
      name: 'payment',
      query: {
        type: 'apartment',
        apartmentId: props.apartmentId?.toString()
      }
    })
    
    // Fermer le modal
    closeModal()
  } catch (error) {
    console.error('Erreur lors de la soumission:', error)
    alert('Une erreur est survenue. Veuillez réessayer.')
  } finally {
    isSubmitting.value = false
  }
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
</style>
