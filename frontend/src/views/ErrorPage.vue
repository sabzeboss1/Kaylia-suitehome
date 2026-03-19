<template>
  <div class="min-h-screen flex items-center justify-center bg-white-smoke px-4">
    <div class="max-w-2xl w-full text-center">
      <!-- Error code -->
      <h1 class="text-9xl font-serif font-bold text-red-600 mb-4">
        500
      </h1>

      <!-- Title -->
      <h2 class="text-3xl font-serif font-semibold text-gray-900 mb-4">
        Erreur du serveur
      </h2>

      <!-- Description -->
      <p class="text-gray-600 mb-8 max-w-md mx-auto">
        Une erreur inattendue s'est produite. Nos équipes ont été notifiées et travaillent à résoudre le problème.
      </p>

      <!-- Actions -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button
          @click="retry"
          class="px-6 py-3 border-2 border-deep-slate-blue text-deep-slate-blue rounded-lg hover:bg-deep-slate-blue hover:text-white transition-colors"
        >
          Réessayer
        </button>
        <router-link
          to="/"
          class="px-6 py-3 bg-deep-slate-blue text-white rounded-lg hover:bg-relic-blue transition-colors"
        >
          Retour à l'accueil
        </router-link>
      </div>

      <!-- Illustration -->
      <div class="mt-12">
        <svg
          class="w-64 h-64 mx-auto text-gray-300"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
          />
        </svg>
      </div>

      <!-- Error details (development only) -->
      <div v-if="isDev && errorDetails" class="mt-8 text-left">
        <details class="bg-red-50 border border-red-200 rounded-lg p-4">
          <summary class="cursor-pointer font-semibold text-red-800 mb-2">
            Détails de l'erreur (développement)
          </summary>
          <pre class="text-xs text-red-700 overflow-auto">{{ errorDetails }}</pre>
        </details>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  errorDetails?: string
}

defineProps<Props>()
const isDev = import.meta.env.DEV

const retry = () => {
  window.location.reload()
}
</script>
