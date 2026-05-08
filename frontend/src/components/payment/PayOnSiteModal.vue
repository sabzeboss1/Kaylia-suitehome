<template>
  <Teleport to="body">
    <Transition name="modal">
      <div 
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
        @click.self="closeModal"
      >
        <div 
          class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative"
          @click.stop
        >
          <!-- Close Button -->
          <button 
            @click="closeModal"
            class="absolute top-4 right-4 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition z-10"
          >
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <!-- Form Content -->
          <div class="p-8 md:p-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Payer sur place</h2>
            <p class="text-gray-600 mb-6">
              Veuillez remplir vos informations pour confirmer votre réservation. Le paiement sera effectué à votre arrivée.
            </p>

            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Nom et Prénom -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">
                    Nom <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="formData.lastName"
                    type="text"
                    placeholder="Votre nom"
                    required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition"
                  />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">
                    Prénom <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="formData.firstName"
                    type="text"
                    placeholder="Votre prénom"
                    required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition"
                  />
                </div>
              </div>

              <!-- Email et Téléphone -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">
                    Adresse email <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="formData.email"
                    type="email"
                    placeholder="nom.mail@exemple.fr"
                    required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition"
                  />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">
                    Téléphone <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="formData.phone"
                    type="tel"
                    placeholder="06 00 00 00 00"
                    required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition"
                  />
                </div>
              </div>

              <!-- Nationalité -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">
                  Nationalité
                </label>
                <input 
                  v-model="formData.nationality"
                  type="text"
                  placeholder="Votre nationalité"
                  class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition"
                />
              </div>

              <!-- Demandes spéciales -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">
                  Demandes spéciales
                </label>
                <textarea 
                  v-model="formData.specialRequests"
                  rows="4"
                  placeholder="Entrez vos demandes spéciales (optionnel)"
                  class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-blue transition resize-none"
                ></textarea>
              </div>

              <!-- Info Box -->
              <div class="bg-[#A8927D]/10 border border-[#A8927D]/30 rounded-lg p-4">
                <div class="flex gap-3">
                  <svg class="w-5 h-5 text-[#0B6087] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <div class="text-sm text-gray-800">
                    <p class="font-medium mb-1">Paiement à l'arrivée</p>
                    <p>Vous recevrez un email de confirmation. Le paiement complet sera effectué lors de votre arrivée à l'établissement.</p>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="flex gap-4 pt-4">
                <button 
                  type="button"
                  @click="closeModal"
                  class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-4 rounded-lg text-lg font-medium transition-all duration-200"
                >
                  Annuler
                </button>
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="flex-1 bg-[#0b6087] hover:bg-[#094d6b] text-white px-6 py-4 rounded-lg text-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isSubmitting ? 'Traitement...' : 'Confirmer la réservation' }}
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

interface Props {
  isOpen: boolean
}

const props = defineProps<Props>()
const emit = defineEmits<{
  'close': []
  'submit': [data: any]
}>()

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
    // Émettre l'événement avec les données
    emit('submit', {
      ...formData.value,
      paymentMethod: 'pay_on_site'
    })
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
    isSubmitting.value = false
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

.modal-enter-active > div > div,
.modal-leave-active > div > div {
  transition: transform 0.3s ease;
}

.modal-enter-from > div > div,
.modal-leave-to > div > div {
  transform: scale(0.9);
}
</style>
