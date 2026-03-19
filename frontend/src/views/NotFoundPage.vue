<template>
  <div class="min-h-screen flex items-center justify-center bg-white-smoke px-4">
    <div class="max-w-2xl w-full text-center">
      <!-- Error code -->
      <h1 class="text-9xl font-serif font-bold text-deep-slate-blue mb-4">
        404
      </h1>

      <!-- Title -->
      <h2 class="text-3xl font-serif font-semibold text-gray-900 mb-4">
        Page non trouvée
      </h2>

      <!-- Description -->
      <p class="text-gray-600 mb-8 max-w-md mx-auto">
        Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
      </p>

      <!-- Actions -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button
          @click="goBack"
          class="px-6 py-3 border-2 border-deep-slate-blue text-deep-slate-blue rounded-lg hover:bg-deep-slate-blue hover:text-white transition-colors"
        >
          Retour
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
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const goBack = () => {
  if (window.history.length > 1) {
    router.back()
  } else {
    router.push('/')
  }
}
</script>
