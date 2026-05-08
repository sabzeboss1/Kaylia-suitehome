<template>
  <!-- Widget activé avec code -->
  <section v-if="isEnabled && embedCode" class="bg-[#A8927D] py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
      <!-- Widget Container -->
      <div class="max-w-6xl mx-auto" v-html="embedCode"></div>
    </div>
  </section>

  <!-- Fallback : Toujours afficher les avis statiques si pas de widget configuré -->
  <section v-else class="bg-[#A8927D] py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
          <h2 class="mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 32px; line-height: 24px; letter-spacing: 0px; text-align: center;">
            <span class="text-white">Avis </span>
            <span class="text-[#0B6087]">clients</span>
          </h2>
          <p class="text-white" style="font-family: 'M PLUS Rounded 1c', sans-serif; font-weight: 400; font-size: 24px; line-height: 24px; letter-spacing: 0px; text-align: center;">
            Nos clients ont aussi profité du SPA. Votre satisfaction est notre principale préoccupation.
          </p>
        </div>

        <!-- Reviews Carousel Container -->
        <div class="relative">
          <!-- Reviews Carousel (all screens) -->
          <div class="overflow-hidden">
            <div 
              class="flex transition-transform duration-300 ease-in-out gap-6"
              :style="{ transform: `translateX(-${currentSlide * slideWidth}%)` }"
            >
              <div 
                v-for="(review, index) in sampleReviews" 
                :key="index" 
                class="flex-shrink-0"
                :class="{
                  'w-full': true,
                  'md:w-[calc(50%-12px)]': true,
                  'lg:w-[calc(25%-18px)]': true
                }"
              >
                <div class="bg-white/10 backdrop-blur-sm border border-white/30 rounded-lg p-6 hover:bg-white/20 transition-all duration-300 h-full">
                  <!-- Rating -->
                  <div class="flex items-center gap-2 mb-4">
                    <span class="text-2xl font-semibold text-white">{{ review.rating }}</span>
                    <span class="text-yellow-400 text-xl">★</span>
                  </div>
                  
                  <!-- Comment -->
                  <p class="text-white/90 mb-4" style="font-family: 'M PLUS Rounded 1c', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px; letter-spacing: 0px;">
                    {{ review.comment }}
                  </p>
                  
                  <!-- Date -->
                  <p class="text-xs text-white/70">
                    {{ review.date }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="flex justify-center gap-4 mt-8">
            <button
              @click="prevSlide"
              :disabled="currentSlide === 0"
              class="w-12 h-12 bg-[#0B6087] hover:bg-[#094d6b] text-white rounded-full flex items-center justify-center transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
              aria-label="Avis précédent"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>
            <button
              @click="nextSlide"
              :disabled="currentSlide >= maxSlides - cardsPerView"
              class="w-12 h-12 bg-[#0B6087] hover:bg-[#094d6b] text-white rounded-full flex items-center justify-center transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
              aria-label="Avis suivant"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, onUnmounted } from 'vue'
import apiClient from '@/utils/api'

const isEnabled = ref(false)
const embedCode = ref('')
const currentSlide = ref(0)
const windowWidth = ref(0)

const isDev = computed(() => import.meta.env.DEV)

const sampleReviews = [
  {
    rating: '4,9',
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '24/10/2025'
  },
  {
    rating: '4,9',
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '24/10/2025'
  },
  {
    rating: '4,9',
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '24/10/2025'
  },
  {
    rating: '4,9',
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '24/10/2025'
  },
  {
    rating: '4,8',
    comment: 'Excellent séjour dans un cadre magnifique. Le personnel est aux petits soins et l\'appartement est parfaitement équipé.',
    date: '15/09/2025'
  },
  {
    rating: '5,0',
    comment: 'Expérience inoubliable ! Le spa est un véritable havre de paix. Je recommande sans hésitation.',
    date: '03/08/2025'
  }
]

const maxSlides = computed(() => sampleReviews.length)

// Nombre de cartes visibles selon la taille d'écran
const cardsPerView = computed(() => {
  if (windowWidth.value >= 1024) return 4 // Desktop: 4 cartes
  if (windowWidth.value >= 768) return 2  // Tablet: 2 cartes
  return 1 // Mobile: 1 carte
})

// Largeur du slide en pourcentage
const slideWidth = computed(() => {
  return 100 / cardsPerView.value
})

const nextSlide = () => {
  if (currentSlide.value < maxSlides.value - cardsPerView.value) {
    currentSlide.value++
  }
}

const prevSlide = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
  }
}

const updateWindowWidth = () => {
  windowWidth.value = window.innerWidth
  // Reset slide si on dépasse le max après resize
  if (currentSlide.value > maxSlides.value - cardsPerView.value) {
    currentSlide.value = Math.max(0, maxSlides.value - cardsPerView.value)
  }
}

const loadWidget = async () => {
  try {
    const response = await apiClient.get('/settings/public')
    const settings = response.data.data || response.data

    isEnabled.value = settings.reviews_widget_enabled === '1' || settings.reviews_widget_enabled === true
    embedCode.value = settings.reviews_widget_embed_code || ''
  } catch (error) {
    console.error('Error loading reviews widget:', error)
  }
}

onMounted(() => {
  loadWidget()
  updateWindowWidth()
  window.addEventListener('resize', updateWindowWidth)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateWindowWidth)
})
</script>

<style scoped>
/* Ensure widget scripts load properly */
:deep(script) {
  display: block;
}
</style>
