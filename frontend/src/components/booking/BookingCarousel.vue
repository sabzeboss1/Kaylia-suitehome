<template>
  <div class="relative w-full py-8">
    <!-- Carousel Container -->
    <div class="flex items-center justify-center gap-4 px-4 md:px-8">
      <!-- Left Image (Partially visible) -->
      <div class="hidden md:block w-1/4 opacity-60">
        <img
          :src="images[getPrevIndex()]"
          :alt="`Image ${getPrevIndex() + 1}`"
          class="w-full h-64 object-cover rounded-2xl shadow-lg"
        />
      </div>

      <!-- Center Image (Main) -->
      <div class="w-full md:w-1/2">
        <img
          :src="images[currentIndex]"
          :alt="`Image ${currentIndex + 1}`"
          class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-2xl transition-transform duration-500"
        />
      </div>

      <!-- Right Image (Partially visible) -->
      <div class="hidden md:block w-1/4 opacity-60">
        <img
          :src="images[getNextIndex()]"
          :alt="`Image ${getNextIndex() + 1}`"
          class="w-full h-64 object-cover rounded-2xl shadow-lg"
        />
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="absolute right-4 md:right-12 bottom-4 flex gap-3 z-10">
      <button
        @click="prevSlide"
        class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out hover:scale-105"
        aria-label="Image précédente"
      >
        <svg
          class="w-5 h-5 text-gray-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          ></path>
        </svg>
      </button>
      <button
        @click="nextSlide"
        class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out hover:scale-105"
        aria-label="Image suivante"
      >
        <svg
          class="w-5 h-5 text-gray-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          ></path>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  images: string[]
}

const props = defineProps<Props>()

const currentIndex = ref(0)

function nextSlide() {
  currentIndex.value = (currentIndex.value + 1) % props.images.length
}

function prevSlide() {
  currentIndex.value =
    (currentIndex.value - 1 + props.images.length) % props.images.length
}

function getNextIndex(): number {
  return (currentIndex.value + 1) % props.images.length
}

function getPrevIndex(): number {
  return (currentIndex.value - 1 + props.images.length) % props.images.length
}
</script>
