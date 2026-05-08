<template>
  <section class="booking-hero bg-[#d2c8bc] pb-8 md:pb-16 overflow-x-hidden" style="padding-top: 100px !important;">
    <div class="container mx-auto px-4 md:px-16 lg:px-20 max-w-full">
      <!-- 1. Progress Steps (Fil d'Ariane) -->
      <div class="flex items-center gap-4 md:gap-12 mb-6 md:mb-8">
        <div
          v-for="(step, index) in steps"
          :key="index"
          class="flex items-center gap-2 md:gap-3"
          :class="{ 'opacity-40': currentStep < index + 1 }"
        >
          <!-- Icon -->
          <div class="w-7 h-7 md:w-10 md:h-10 flex items-center justify-center flex-shrink-0">
            <svg
              v-if="step.id === 'tarif'"
              class="w-7 h-7 md:w-10 md:h-10 text-gray-900"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <svg
              v-else-if="step.id === 'recap'"
              class="w-7 h-7 md:w-10 md:h-10 text-gray-900"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
            <svg
              v-else
              class="w-7 h-7 md:w-10 md:h-10 text-gray-900"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <!-- Label -->
          <span class="text-xs md:text-base font-medium text-gray-900">
            {{ step.label }}
          </span>
        </div>
      </div>

    </div>

    <!-- 2. Image Carousel - Full Width -->
    <div class="relative mb-6 md:mb-8 overflow-x-hidden">
      <!-- Carousel Container - Full Width -->
      <div class="flex items-center justify-center overflow-hidden max-w-full gap-3 md:gap-6">
        <!-- Left Image (Partially visible with fade) -->
        <div class="hidden lg:block w-1/4 relative flex-shrink-0">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#d2c8bc] z-10 pointer-events-none"></div>
          <img
            :src="images[getPrevIndex()]"
            :alt="`Image ${getPrevIndex() + 1}`"
            class="w-full h-64 object-cover rounded-xl opacity-60"
          />
        </div>

        <!-- Center Image (Main - Single large image) -->
        <div class="w-full lg:w-1/2 flex-shrink-0">
          <img
            :src="images[currentIndex]"
            :alt="`Image ${currentIndex + 1}`"
            class="w-full h-48 md:h-80 lg:h-96 object-cover rounded-xl"
          />
        </div>

        <!-- Right Image (Partially visible with fade) -->
        <div class="hidden lg:block w-1/4 relative flex-shrink-0">
          <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-[#d2c8bc] z-10 pointer-events-none"></div>
          <img
            :src="images[getNextIndex()]"
            :alt="`Image ${getNextIndex() + 1}`"
            class="w-full h-64 object-cover rounded-xl opacity-60"
          />
        </div>
      </div>
    </div>

    <div class="container mx-auto px-4 md:px-12 lg:px-20 max-w-full">

      <!-- 3. Info Bar with Features and Controls -->
      <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-6 overflow-x-hidden">
        <!-- Left: Apartment Features -->
        <div class="grid grid-cols-2 md:flex md:flex-wrap justify-center md:justify-start gap-3 md:gap-8 w-full md:w-auto">
          <!-- Capacity -->
          <div class="flex items-center gap-2 md:gap-3">
            <div class="w-8 h-8 md:w-10 md:h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <img 
                :src="`${backendUrl}/images/equipements/Personne.ico`" 
                alt="Capacité" 
                class="w-4 h-4 md:w-5 md:h-5 object-contain"
              />
            </div>
            <span class="text-xs md:text-sm text-gray-900">{{ capacity }} pers.</span>
          </div>

          <!-- Surface -->
          <div class="flex items-center gap-2 md:gap-3">
            <div class="w-8 h-8 md:w-10 md:h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <img 
                :src="`${backendUrl}/images/equipements/Maison.ico`" 
                alt="Surface" 
                class="w-4 h-4 md:w-5 md:h-5 object-contain"
              />
            </div>
            <span class="text-xs md:text-sm text-gray-900">{{ surface }}m²</span>
          </div>

          <!-- Beds -->
          <div class="flex items-center gap-2 md:gap-3">
            <div class="w-8 h-8 md:w-10 md:h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <img 
                :src="`${backendUrl}/images/equipements/Group 1779.ico`" 
                alt="Lits" 
                class="w-4 h-4 md:w-5 md:h-5 object-contain"
              />
            </div>
            <span class="text-xs md:text-sm text-gray-900">{{ bedsText }}</span>
          </div>

          <!-- Floor -->
          <div class="flex items-center gap-2 md:gap-3">
            <div class="w-8 h-8 md:w-10 md:h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <img 
                :src="`${backendUrl}/images/equipements/Etage.ico`" 
                alt="Étage" 
                class="w-4 h-4 md:w-5 md:h-5 object-contain"
              />
            </div>
            <span class="text-xs md:text-sm text-gray-900">{{ floor }}</span>
          </div>
        </div>

        <!-- Right: Carousel Navigation -->
        <div class="flex gap-3 flex-shrink-0">
          <button
            @click="prevSlide"
            class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors"
            aria-label="Image précédente"
          >
            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <button
            @click="nextSlide"
            class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors"
            aria-label="Image suivante"
          >
            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

interface Props {
  currentStep: 1 | 2 | 3
  images: string[]
  capacity: number
  surface: number
  beds: Array<{ type: string; count: number }>
  floor: string
}

const props = defineProps<Props>()

// Backend URL for icons
const backendUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'

const steps = [
  { id: 'tarif', label: 'Tarif' },
  { id: 'recap', label: 'Récapitulatif' },
  { id: 'reserve', label: 'Réservé' }
]

const currentIndex = ref(0)

const bedsText = computed(() => {
  if (props.beds.length === 0) return 'Aucun lit'
  if (props.beds.length === 1) {
    const bed = props.beds[0]
    if (!bed) return 'Aucun lit'
    return `${bed.count} lit${bed.count > 1 ? 's' : ''} ${bed.type}`
  }
  return props.beds.map((bed) => `${bed.count} lit${bed.count > 1 ? 's' : ''} ${bed.type}`).join(', ')
})

function nextSlide() {
  currentIndex.value = (currentIndex.value + 1) % props.images.length
}

function prevSlide() {
  currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length
}

function getNextIndex(): number {
  return (currentIndex.value + 1) % props.images.length
}

function getPrevIndex(): number {
  return (currentIndex.value - 1 + props.images.length) % props.images.length
}
</script>
