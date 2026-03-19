<template>
  <div 
    ref="imageContainer"
    class="lazy-image-container relative overflow-hidden bg-gray-100"
    :class="containerClass"
  >
    <!-- Blur placeholder -->
    <div 
      v-if="!isLoaded && showPlaceholder"
      class="absolute inset-0 bg-gradient-to-br from-gray-200 to-gray-300 animate-pulse"
    ></div>
    
    <!-- Actual image -->
    <img
      v-show="isLoaded"
      ref="imageElement"
      :data-src="src"
      :data-srcset="srcset"
      :alt="alt"
      :class="imageClass"
      class="w-full h-full transition-opacity duration-300"
      :style="{ opacity: isLoaded ? 1 : 0 }"
      @load="handleLoad"
      @error="handleError"
    />
    
    <!-- Overlay slot for content on top of image -->
    <slot name="overlay"></slot>
    
    <!-- Error state -->
    <div 
      v-if="hasError"
      class="absolute inset-0 flex items-center justify-center bg-gray-200 text-gray-500"
    >
      <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

interface Props {
  src: string
  srcset?: string
  alt: string
  containerClass?: string
  imageClass?: string
  showPlaceholder?: boolean
  rootMargin?: string
}

const props = withDefaults(defineProps<Props>(), {
  containerClass: '',
  imageClass: 'object-cover',
  showPlaceholder: true,
  rootMargin: '50px'
})

const imageContainer = ref<HTMLElement | null>(null)
const imageElement = ref<HTMLImageElement | null>(null)
const isLoaded = ref(false)
const hasError = ref(false)
let observer: IntersectionObserver | null = null

const handleLoad = () => {
  isLoaded.value = true
}

const handleError = () => {
  hasError.value = true
  isLoaded.value = true
}

const loadImage = () => {
  if (!imageElement.value) return
  
  const img = imageElement.value
  const src = img.getAttribute('data-src')
  const srcset = img.getAttribute('data-srcset')
  
  if (src) {
    img.src = src
  }
  if (srcset) {
    img.srcset = srcset
  }
}

onMounted(() => {
  if (!imageContainer.value || !imageElement.value) return
  
  // Use Intersection Observer for lazy loading
  if ('IntersectionObserver' in window) {
    observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            loadImage()
            if (observer && imageContainer.value) {
              observer.unobserve(imageContainer.value)
            }
          }
        })
      },
      {
        rootMargin: props.rootMargin
      }
    )
    
    observer.observe(imageContainer.value)
  } else {
    // Fallback for browsers without Intersection Observer
    loadImage()
  }
})

onUnmounted(() => {
  if (observer && imageContainer.value) {
    observer.unobserve(imageContainer.value)
  }
})
</script>

<style scoped>
.lazy-image-container {
  position: relative;
}
</style>
