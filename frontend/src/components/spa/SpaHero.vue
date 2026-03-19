<template>
  <section class="bg-[#d2c8bc] py-20 md:py-32">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
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
        <div class="flex gap-3 mt-6 md:mt-0">
          <button 
            @click="$emit('show-events')"
            class="bg-transparent hover:bg-gray-900/5 text-gray-900 border border-gray-900 px-6 py-2.5 rounded text-sm font-medium transition-colors"
          >
            Événements
          </button>
          <button 
            @click="$emit('show-appointments')"
            class="bg-[#10648c] hover:bg-[#0d5273] text-white px-6 py-2.5 rounded text-sm font-medium transition-colors"
          >
            Prendre RDV
          </button>
        </div>
      </div>

      <!-- Gallery Section - Asymmetric Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Large Image - Left (65-70%) -->
        <div class="lg:col-span-2 relative overflow-hidden rounded-xl">
          <img 
            :src="mainImage" 
            alt="Grande piscine intérieure du spa" 
            class="w-full h-[400px] md:h-[500px] lg:h-[600px] object-cover"
          />
        </div>

        <!-- Small Images - Right (30-35%) -->
        <div class="lg:col-span-1 flex flex-col gap-4 md:gap-6">
          <div 
            v-for="(image, index) in sideImages" 
            :key="index"
            class="relative overflow-hidden rounded-xl"
          >
            <img 
              :src="image" 
              :alt="`Spa ${index === 0 ? 'Jacuzzi' : index === 1 ? 'Transats' : 'Petit bassin'}`" 
              class="w-full h-[120px] md:h-[150px] lg:h-[192px] object-cover"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
interface Props {
  rating?: number
  reviewCount?: number
  mainImage?: string
  sideImages?: string[]
}

const props = withDefaults(defineProps<Props>(), {
  rating: 4.9,
  reviewCount: 17,
  mainImage: '/images/spa/grand.jpg',
  sideImages: () => [
    '/images/spa/petit1.jpg',
    '/images/spa/petit2.jpg',
    '/images/spa/petit3.jpg'
  ]
})

defineEmits<{
  'show-events': []
  'show-appointments': []
}>()
</script>
