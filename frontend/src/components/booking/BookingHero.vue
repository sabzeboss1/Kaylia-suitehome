<template>
  <section class="booking-hero bg-[#d2c8bc] pt-[62px] md:pt-20 pb-12 md:pb-16">
    <div class="container mx-auto px-6 md:px-12 lg:px-20 pt-8 md:pt-4">
      <!-- 1. Progress Steps (Fil d'Ariane) -->
      <div class="flex items-center gap-8 md:gap-12 mb-8">
        <div
          v-for="(step, index) in steps"
          :key="index"
          class="flex items-center gap-3"
          :class="{ 'opacity-40': currentStep < index + 1 }"
        >
          <!-- Icon -->
          <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
            <svg
              v-if="step.id === 'tarif'"
              class="w-10 h-10 text-gray-900"
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
              class="w-10 h-10 text-gray-900"
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
              class="w-10 h-10 text-gray-900"
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
          <span class="text-base font-medium text-gray-900">
            {{ step.label }}
          </span>
        </div>
      </div>

    </div>

    <!-- 2. Image Carousel - Full Width -->
    <div class="relative mb-8">
      <!-- Carousel Container - Full Width -->
      <div class="flex items-center overflow-hidden">
        <!-- Left Image (Partially visible with fade) -->
        <div class="hidden lg:block w-1/4 relative flex-shrink-0 pr-3">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#d2c8bc] z-10 pointer-events-none"></div>
          <img
            :src="images[getPrevIndex()]"
            :alt="`Image ${getPrevIndex() + 1}`"
            class="w-full h-64 object-cover rounded-xl opacity-60"
          />
        </div>

        <!-- Center Images (2 visible) -->
        <div class="flex gap-6 w-full lg:w-1/2 flex-shrink-0">
          <div class="w-1/2">
            <img
              :src="images[currentIndex]"
              :alt="`Image ${currentIndex + 1}`"
              class="w-full h-80 md:h-96 object-cover rounded-xl"
            />
          </div>
          <div class="w-1/2">
            <img
              :src="images[getNextIndex()]"
              :alt="`Image ${getNextIndex() + 1}`"
              class="w-full h-80 md:h-96 object-cover rounded-xl"
            />
          </div>
        </div>

        <!-- Right Image (Partially visible with fade) -->
        <div class="hidden lg:block w-1/4 relative flex-shrink-0 pl-3">
          <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-[#d2c8bc] z-10 pointer-events-none"></div>
          <img
            :src="images[getNextNextIndex()]"
            :alt="`Image ${getNextNextIndex() + 1}`"
            class="w-full h-64 object-cover rounded-xl opacity-60"
          />
        </div>
      </div>
    </div>

    <div class="container mx-auto px-6 md:px-12 lg:px-20">

      <!-- 3. Info Bar with Features and Controls -->
      <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <!-- Left: Apartment Features -->
        <div class="flex flex-wrap justify-center md:justify-start gap-6 md:gap-8">
          <!-- Capacity -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900">{{ capacity }} personnes</span>
          </div>

          <!-- Surface -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900">{{ surface }}m²</span>
          </div>

          <!-- Beds -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900">{{ bedsText }}</span>
          </div>

          <!-- Floor -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <span class="text-sm text-gray-900">{{ floor }}</span>
          </div>
        </div>

        <!-- Right: Carousel Navigation -->
        <div class="flex gap-3 flex-shrink-0">
          <button
            @click="prevSlide"
            class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors"
            aria-label="Image précédente"
          >
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <button
            @click="nextSlide"
            class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors"
            aria-label="Image suivante"
          >
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

function getNextNextIndex(): number {
  return (currentIndex.value + 2) % props.images.length
}
</script>
