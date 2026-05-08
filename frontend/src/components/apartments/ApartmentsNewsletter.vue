<template>
  <section class="newsletter-section bg-[#F2F4F3] py-12 md:py-16 px-6 my-[42px]">
    <div class="max-w-4xl mx-auto text-center">
      <!-- Title -->
      <h2 class="text-[32px] leading-[32px] font-semibold text-gray-900 mb-4" style="font-family: 'Poppins', sans-serif;">
        Inscrivez-vous à notre <span class="text-[#0B6087]">newsletter</span> et recevez nos codes promos
      </h2>
      
      <!-- Description -->
      <p class="text-[24px] leading-[24px] font-light text-gray-700 mb-8" style="font-family: 'Rounded Mplus 1c', sans-serif;">
        Recevez des offres exclusives et restez informé de nos actualités.
      </p>

      <!-- Form -->
      <form @submit.prevent="handleSubmit" class="max-w-2xl mx-auto">
        <div class="flex flex-col md:flex-row gap-3 mb-4">
          <input
            v-model="email"
            type="email"
            placeholder="Votre adresse email"
            required
            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B6087] text-gray-900"
          />
          <button
            type="submit"
            :disabled="loading"
            class="px-8 py-3 bg-[#0B6087] text-white rounded-lg font-medium transition-all duration-300 hover:bg-[#094d6b] disabled:opacity-50 disabled:cursor-not-allowed"
            :style="loading ? 'background-color: #6B9FB0' : ''"
          >
            {{ loading ? 'Inscription...' : "S'inscrire" }}
          </button>
        </div>

        <!-- Consent Checkbox -->
        <div class="flex items-start gap-2 text-left">
          <input
            v-model="consent"
            type="checkbox"
            id="newsletter-consent"
            required
            class="mt-1 w-4 h-4 text-[#0B6087] border-gray-300 rounded focus:ring-[#0B6087]"
          />
          <label for="newsletter-consent" class="text-sm text-gray-700">
            En cochant cette case, je consens à l'utilisation des informations fournies à des fins de marketing par e-mail.
          </label>
        </div>
      </form>

      <!-- Success Message -->
      <div v-if="successMessage" class="mt-4 p-4 bg-green-100 text-green-800 rounded-lg">
        {{ successMessage }}
      </div>

      <!-- Error Message -->
      <div v-if="errorMessage" class="mt-4 p-4 bg-red-100 text-red-800 rounded-lg">
        {{ errorMessage }}
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useNewsletter } from '@/composables/useNewsletter'

const { subscribe, loading, error, success } = useNewsletter()

const email = ref('')
const consent = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const handleSubmit = async () => {
  if (!consent.value) {
    errorMessage.value = 'Veuillez accepter les conditions pour continuer.'
    return
  }

  successMessage.value = ''
  errorMessage.value = ''

  await subscribe({
    email: email.value,
    consent: consent.value
  })

  if (success.value) {
    successMessage.value = 'Merci pour votre inscription ! Vous recevrez bientôt nos offres exclusives.'
    email.value = ''
    consent.value = false
  } else if (error.value) {
    errorMessage.value = error.value
  }
}
</script>

<style scoped>
/* Responsive adjustments */
@media (max-width: 768px) {
  h2 {
    font-size: 24px;
    line-height: 28px;
  }
  
  p {
    font-size: 18px;
    line-height: 22px;
  }
}
</style>
