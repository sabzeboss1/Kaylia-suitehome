<template>
  <section class="bg-[#f2f4f3] py-16 md:py-20 px-6 md:px-12 text-center">
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <h2 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
        Inscrivez-vous à notre <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">newsletter</span> et recevez nos codes promos
      </h2>
      
      <p class="text-[16px] leading-[24px] font-light text-gray-700 mb-10" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
        Recevez des offres exclusives et restez informé de nos actualités.
      </p>
      
      <!-- Form -->
      <form @submit.prevent="handleSubmit" class="max-w-2xl mx-auto">
        <!-- Line 1: Email Input and Submit Button -->
        <div class="flex flex-col sm:flex-row gap-3 mb-6">
          <input 
            v-model="email"
            type="email" 
            placeholder="Votre adresse email" 
            required
            class="flex-1 px-5 py-3.5 bg-white border-2 border-[#0b6087] rounded text-base text-gray-900 placeholder-gray-400 outline-none focus:border-[#094d6b] transition-colors"
          >
          <button 
            type="submit"
            :disabled="loading || !consent"
            class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-8 py-3.5 rounded text-base font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap"
          >
            {{ loading ? 'Envoi...' : "S'inscrire" }}
          </button>
        </div>

        <!-- Line 2: Consent Checkbox -->
        <div class="flex items-start justify-center gap-3 text-left">
          <input 
            v-model="consent"
            type="checkbox" 
            id="newsletter-consent" 
            class="mt-1 w-4 h-4 flex-shrink-0 border border-gray-700 rounded cursor-pointer accent-[#0b6087]"
          >
          <label 
            for="newsletter-consent" 
            class="text-sm text-gray-700 leading-relaxed cursor-pointer"
          >
            En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
          </label>
        </div>
      </form>

      <!-- Success/Error Messages -->
      <transition name="fade">
        <div v-if="successMessage" class="mt-6 p-4 bg-green-50 border border-green-200 rounded text-green-700 text-sm">
          {{ successMessage }}
        </div>
      </transition>
      
      <transition name="fade">
        <div v-if="errorMessage" class="mt-6 p-4 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
          {{ errorMessage }}
        </div>
      </transition>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useNewsletter } from '@/composables/useNewsletter'

const { subscribe, loading, error } = useNewsletter()

const email = ref('')
const consent = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const handleSubmit = async () => {
  if (!consent.value) {
    errorMessage.value = 'Veuillez accepter les conditions pour continuer.'
    setTimeout(() => {
      errorMessage.value = ''
    }, 3000)
    return
  }

  successMessage.value = ''
  errorMessage.value = ''

  try {
    await subscribe({ email: email.value })
    successMessage.value = 'Merci pour votre inscription ! Vous recevrez bientôt nos offres exclusives.'
    email.value = ''
    consent.value = false
    
    // Clear success message after 5 seconds
    setTimeout(() => {
      successMessage.value = ''
    }, 5000)
  } catch (e) {
    errorMessage.value = error.value || 'Une erreur est survenue. Veuillez réessayer.'
    
    // Clear error message after 5 seconds
    setTimeout(() => {
      errorMessage.value = ''
    }, 5000)
  }
}
</script>

<style scoped>
/* Fade transition for messages */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
