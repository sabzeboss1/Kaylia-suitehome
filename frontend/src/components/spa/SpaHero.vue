<template>
  <section class="bg-[#d2c8bc] pt-[62px] md:pt-20 pb-12 md:pb-16">
    <div class="container-aligned pt-32 md:pt-40">
      <!-- Header Section -->
      <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-8 md:mb-12">
        <!-- Left: Title and Rating -->
        <div>
          <h1 class="text-2xl md:text-3xl lg:text-4xl font-sans text-gray-900 mb-2 tracking-wide uppercase">
            KAYLIA SUITE HOME - Le SPA
          </h1>
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-gray-900 text-sm">{{ rating }} ({{ reviewCount }} avis)</span>
          </div>
        </div>
        
        <!-- Right: Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 mt-6 md:mt-0">
          <button 
            @click="$emit('show-events')"
            class="bg-transparent hover:bg-gray-900/5 text-gray-900 border border-gray-900 px-4 md:px-6 py-2.5 rounded text-sm font-medium transition-colors"
          >
            Événements
          </button>
          <button 
            @click="$emit('show-appointments')"
            class="bg-[#10648c] hover:bg-[#0d5273] text-white px-4 md:px-6 py-2.5 rounded text-sm font-medium transition-colors"
          >
            Prendre RDV
          </button>
        </div>
      </div>

      <!-- Gallery Section - Exact Figma Dimensions -->
      <div class="flex flex-col lg:flex-row gap-6 lg:gap-[61px]">
        <!-- Large Image - Left (908px width, 703px height) -->
        <div class="flex-shrink-0 lg:w-[908px] relative overflow-hidden rounded-[5px] group cursor-pointer">
          <img 
            :src="getImageUrl(galleryImages.mainImage)" 
            alt="Grande piscine intérieure du spa" 
            class="w-full h-[300px] md:h-[400px] lg:h-[703px] object-cover transition-all duration-300 group-hover:scale-105"
          />
          <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
        </div>

        <!-- Small Images - Right (316px width, 702px total height) - Stack of 3 with 30px gap -->
        <div class="flex-shrink-0 lg:w-[316px] grid grid-cols-3 lg:grid-cols-1 gap-3 lg:gap-[30px]">
          <div 
            v-for="(image, index) in galleryImages.sideImages" 
            :key="index"
            class="relative overflow-hidden rounded-[5px] group cursor-pointer"
          >
            <img 
              :src="getImageUrl(image)" 
              :alt="`Spa ${index === 0 ? 'Jacuzzi' : index === 1 ? 'Transats' : 'Petit bassin'}`" 
              class="w-full h-[100px] md:h-[120px] lg:h-[214px] object-cover transition-all duration-300 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface Props {
  rating?: number
  reviewCount?: number
}

const props = withDefaults(defineProps<Props>(), {
  rating: 4.9,
  reviewCount: 17
})

defineEmits<{
  'show-events': []
  'show-appointments': []
}>()

// Gallery images from API
const galleryImages = ref({
  mainImage: '/images/spa/grand.jpg',
  sideImages: [
    '/images/spa/petit1.jpg',
    '/images/spa/petit2.jpg',
    '/images/spa/petit3.jpg'
  ]
})

// Load gallery images from API
const loadGalleryImages = async () => {
  try {
    const apiBaseUrl = import.meta.env.VITE_API_BASE_URL
    const response = await axios.get(`${apiBaseUrl}/content/spa`)
    
    if (response.data.success && response.data.data) {
      const content = response.data.data
      
      // Update images if they exist in the API response
      if (content.hero_main_image) {
        galleryImages.value.mainImage = content.hero_main_image
      }
      
      const sideImages = []
      if (content.hero_side_image_1) sideImages.push(content.hero_side_image_1)
      if (content.hero_side_image_2) sideImages.push(content.hero_side_image_2)
      if (content.hero_side_image_3) sideImages.push(content.hero_side_image_3)
      
      if (sideImages.length > 0) {
        galleryImages.value.sideImages = sideImages
      }
    }
  } catch (error) {
    console.error('Failed to load SPA gallery images:', error)
    // Keep default images on error
  }
}

// Helper to get full image URL
const getImageUrl = (url: string) => {
  if (!url) return ''
  if (url.startsWith('http')) return url
  
  const apiBaseUrl = import.meta.env.VITE_API_BASE_URL
  const cleanUrl = url.startsWith('/') ? url.substring(1) : url
  return apiBaseUrl.replace('/api', '') + '/storage/' + cleanUrl
}

onMounted(() => {
  loadGalleryImages()
})
</script>
