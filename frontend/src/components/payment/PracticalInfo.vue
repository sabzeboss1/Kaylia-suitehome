<template>
  <div class="bg-white rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations pratiques</h2>

    <div class="space-y-4">
      <!-- Location -->
      <div class="flex items-start gap-3">
        <svg
          class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
            clip-rule="evenodd"
          />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">Comment s'y rendre</p>
          <p class="text-sm text-gray-600">{{ address }}</p>
        </div>
      </div>

      <!-- Apartment Selector -->
      <select
        v-model="selectedApartment"
        class="w-full px-4 py-3 border border-gray-300 rounded text-sm text-gray-700 outline-none focus:border-primary-blue transition"
      >
        <option :value="apartmentName">{{ apartmentName }}</option>
      </select>

      <!-- Apartment Images -->
      <div class="grid grid-cols-3 gap-2 mt-4">
        <div
          v-for="(image, index) in displayImages"
          :key="index"
          class="aspect-video rounded overflow-hidden bg-gray-200"
        >
          <img
            :src="image"
            :alt="`${apartmentName} - Image ${index + 1}`"
            class="w-full h-full object-cover"
            @error="handleImageError"
          />
        </div>
      </div>

      <!-- Confirmation Number -->
      <div class="flex items-start gap-3">
        <svg
          class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
            clip-rule="evenodd"
          />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">
            Numéro de confirmation de la réservation
          </p>
          <p class="text-sm text-gray-600">{{ confirmationNumber }}</p>
        </div>
      </div>

      <!-- Number of Guests -->
      <div class="flex items-start gap-3">
        <svg
          class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
          />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">Nombre de clients</p>
          <p class="text-sm text-gray-600">{{ guests }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="bg-white rounded-lg p-6 mt-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Nous contacter</h2>

    <div class="space-y-4">
      <!-- Website -->
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z"
            clip-rule="evenodd"
          />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">Site Web</p>
          <a
            href="https://www.kayliasuitehome.com"
            class="text-sm text-gray-600 hover:text-primary-blue"
            >www.kayliasuitehome.com</a
          >
        </div>
      </div>

      <!-- Email -->
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">E-mail</p>
          <a
            href="mailto:contact@kayliasuitehome.com"
            class="text-sm text-gray-600 hover:text-primary-blue"
            >contact@kayliasuitehome.com</a
          >
        </div>
      </div>

      <!-- WhatsApp -->
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
          <path
            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
          />
        </svg>
        <div>
          <p class="text-sm font-semibold text-gray-900">WhatsApp</p>
          <a href="tel:+237000000000" class="text-sm text-gray-600 hover:text-primary-blue"
            >+237 00 00 00 00</a
          >
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Note -->
  <div class="text-center text-xs text-gray-500 leading-relaxed mt-6">
    <p>
      Ce site est protégé par reCAPTCHA et les
      <a href="#" class="text-primary-blue hover:underline"
        >Politique de confidentialité et Conditions d'utilisation</a
      >
      de Google s'appliquent. Pour plus d'information, veuillez visiter
      <a href="#" class="text-primary-blue hover:underline"
        >Avis de confidentialité de Mews</a
      >
    </p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

interface Props {
  apartmentName: string
  address?: string
  confirmationNumber?: string
  guests: number
  apartmentImages?: string[]
}

const props = withDefaults(defineProps<Props>(), {
  address: 'Quartier Jouvence, Yaoundé Cameroun',
  confirmationNumber: '123',
  apartmentImages: () => []
})

const selectedApartment = ref(props.apartmentName)

// Display images with fallback to placeholder
const displayImages = computed(() => {
  if (props.apartmentImages && props.apartmentImages.length > 0) {
    return props.apartmentImages.slice(0, 3)
  }
  // Fallback placeholder images
  return [
    'https://via.placeholder.com/400x225/e5e7eb/9ca3af?text=Image+1',
    'https://via.placeholder.com/400x225/e5e7eb/9ca3af?text=Image+2',
    'https://via.placeholder.com/400x225/e5e7eb/9ca3af?text=Image+3'
  ]
})

function handleImageError(event: Event) {
  const img = event.target as HTMLImageElement
  img.src = 'https://via.placeholder.com/400x225/e5e7eb/9ca3af?text=No+Image'
}
</script>
