<template>
  <div class="image-carousel-section relative">
    <div :class="['py-8 md:py-12', bgClass]">
      <!-- Carousel Container - Full Width -->
      <div 
        ref="carouselRef"
        class="flex gap-4 md:gap-6 overflow-x-auto scroll-smooth scrollbar-hide snap-x snap-mandatory px-6 md:px-12 lg:px-20"
      >
        <div
          v-for="(image, index) in images"
          :key="index"
          class="flex-shrink-0 w-[280px] md:w-[350px] lg:w-[400px] snap-center"
        >
          <img
            :src="image.url || image"
            :alt="image.alt || `Image ${index + 1}`"
            class="w-full h-[200px] md:h-[250px] object-cover rounded-xl shadow-lg"
          />
        </div>
      </div>
    </div>

    <!-- Navigation Buttons (Optional) -->
    <div v-if="showControls" class="absolute top-1/2 left-0 right-0 -translate-y-1/2 pointer-events-none">
      <div class="container mx-auto px-6 md:px-12 lg:px-20 flex justify-between">
        <button
          @click="scrollCarousel('left')"
          class="w-12 h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:border-gray-400 transition-colors pointer-events-auto shadow-lg"
          aria-label="Image précédente"
        >
          <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
        <button
          @click="scrollCarousel('right')"
          class="w-12 h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:border-gray-400 transition-colors pointer-events-auto shadow-lg"
          aria-label="Image suivante"
        >
          <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface CarouselImage {
  url?: string
  alt?: string
}

interface Props {
  images: (CarouselImage | string)[]
  bgClass?: string
  showControls?: boolean
}

withDefaults(defineProps<Props>(), {
  bgClass: 'bg-[#A8927A]',
  showControls: false
})

const carouselRef = ref<HTMLElement | null>(null)

const scrollCarousel = (direction: 'left' | 'right') => {
  if (!carouselRef.value) return
  
  const scrollAmount = 350
  const currentScroll = carouselRef.value.scrollLeft
  
  if (direction === 'left') {
    carouselRef.value.scrollTo({
      left: currentScroll - scrollAmount,
      behavior: 'smooth'
    })
  } else {
    carouselRef.value.scrollTo({
      left: currentScroll + scrollAmount,
      behavior: 'smooth'
    })
  }
}
</script>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
