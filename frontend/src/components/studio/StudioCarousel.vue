<template>
  <div class="relative">
    <!-- Main Carousel Container -->
    <div class="studio-carousel relative overflow-hidden">
      <!-- Slides Container -->
      <div 
        ref="carouselContainer"
        class="flex transition-transform duration-500 ease-in-out touch-pan-y" 
        :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
      >
        <!-- Slides -->
        <div 
          v-for="(image, index) in images" 
          :key="index" 
          class="min-w-full relative"
        >
          <LazyImage
            :src="image"
            :alt="`Studio image ${index + 1}`"
            container-class="relative h-[400px] md:h-[450px]"
            image-class="w-full h-full object-cover"
          >
            <template #overlay>
              <!-- KAYLIA Logo Overlay -->
              <div class="absolute top-6 left-1/2 transform -translate-x-1/2 text-center">
                <div class="font-serif text-3xl md:text-4xl tracking-[0.3em] text-gray-800">
                  KAYLIA
                </div>
                <div class="text-xs tracking-[0.4em] text-gray-600 mt-1">
                  SUITE HOME
                </div>
              </div>
            </template>
          </LazyImage>
        </div>
      </div>

      <!-- Navigation Arrows with proper touch targets (min 44x44px) -->
      <button 
        @click="prevSlide"
        class="absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 min-w-[44px] min-h-[44px] w-11 h-11 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition active:scale-95 z-10"
        aria-label="Previous slide"
      >
        <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <button 
        @click="nextSlide"
        class="absolute right-4 md:right-8 top-1/2 transform -translate-y-1/2 min-w-[44px] min-h-[44px] w-11 h-11 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition active:scale-95 z-10"
        aria-label="Next slide"
      >
        <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>

      <!-- Dots Indicator with proper touch targets -->
      <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-10">
        <button 
          v-for="(_, index) in images" 
          :key="index"
          @click="goToSlide(index)"
          class="min-w-[44px] min-h-[44px] p-3 flex items-center justify-center"
          :aria-label="`Go to slide ${index + 1}`"
        >
          <span
            class="block w-2 h-2 rounded-full bg-white transition"
            :class="currentSlide === index ? 'opacity-100' : 'opacity-50 hover:opacity-100'"
          ></span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useSwipe } from '@/composables/useSwipe'
import LazyImage from '@/components/common/LazyImage.vue'

interface Props {
  images: string[]
  autoplay?: boolean
  interval?: number
}

const props = withDefaults(defineProps<Props>(), {
  autoplay: true,
  interval: 5000
})

const currentSlide = ref(0)
const carouselContainer = ref<HTMLElement | null>(null)
let autoplayTimer: number | null = null

// Setup swipe gestures
useSwipe(carouselContainer, {
  onSwipeLeft: () => nextSlide(),
  onSwipeRight: () => prevSlide(),
  threshold: 50
})

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % props.images.length
}

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + props.images.length) % props.images.length
}

const goToSlide = (index: number) => {
  currentSlide.value = index
}

// Keyboard navigation
const handleKeydown = (e: KeyboardEvent) => {
  if (e.key === 'ArrowLeft') {
    prevSlide()
  } else if (e.key === 'ArrowRight') {
    nextSlide()
  }
}

// Auto-play
const startAutoplay = () => {
  if (props.autoplay && props.images.length > 1) {
    autoplayTimer = window.setInterval(() => {
      nextSlide()
    }, props.interval)
  }
}

const stopAutoplay = () => {
  if (autoplayTimer) {
    clearInterval(autoplayTimer)
    autoplayTimer = null
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeydown)
  startAutoplay()
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
  stopAutoplay()
})
</script>
