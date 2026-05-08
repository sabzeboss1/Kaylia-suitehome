<template>
  <section class="section-aligned bg-white py-16 md:py-24">
    <div class="section-content">
      <!-- Two Column Layout with Flexbox -->
      <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12 lg:gap-16">
        
        <!-- Left Column: Image -->
        <div class="w-full md:w-1/2">
          <LazyImage
            :src="spaImageUrl"
            alt="SPA & Bien-être"
            container-class="spa-image-container"
            image-class="w-full h-80 md:h-96 lg:h-[450px] object-cover rounded-lg"
          />
        </div>
        
        <!-- Right Column: Content -->
        <div class="w-full md:w-1/2">
          <!-- Title -->
          <h2 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
            Le SPA & Bien-être 
          </h2>
          
          <!-- Description -->
          <p class="text-[16px] leading-[24px] text-gray-600 mb-6" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
            Plongez dans un univers de détente et de relaxation. Notre espace bien-être vous offre une parenthèse de sérénité au cœur de Yaoundé.
          </p>
          
          <!-- Bullet List -->
          <ul class="space-y-3 mb-8 ml-5">
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Piscine avec coin détente</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Jacuzzi</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Sauna Finlandais traditionnel</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Massages et soins personnalisés</span>
            </li>
          </ul>

          <!-- CTA Button -->
          <div class="flex justify-center md:justify-start">
            <button 
              @click="navigateToSpa"
              class="w-full md:w-auto bg-[#a68f7b] hover:bg-[#96806c] text-white px-8 py-3.5 rounded text-base font-medium transition-colors duration-300 mt-4"
            >
              Découvrir le SPA
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import LazyImage from '@/components/common/LazyImage.vue'

const router = useRouter()

// Image URL - peut être configuré dynamiquement depuis le backend
const spaImageUrl = computed(() => {
  return '/images/spa/Spahome.jpg'
})

const navigateToSpa = () => {
  router.push({ name: 'spa' })
}
</script>

<style scoped>
.spa-image-container {
  position: relative;
}

/* Fallback background for lazy loading */
.spa-image-container::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, #e5e5e5 0%, #d4d4d4 100%);
  border-radius: 0.5rem;
  z-index: -1;
}
</style>
