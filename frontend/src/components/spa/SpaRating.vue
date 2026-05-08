<template>
  <div class="bg-[#e8dcc8] rounded-xl shadow-lg overflow-hidden w-full">
    <!-- Title -->
    <div class="px-6 pt-6 pb-4">
      <h3 
        class="text-gray-900"
        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px; letter-spacing: 0px;"
      >
        Note
      </h3>
    </div>
    
    <!-- Rating Content -->
    <div class="flex border border-gray-300 rounded-lg mx-4 overflow-hidden">
      <!-- Left Block - Overall Rating (Dark Blue) -->
      <div class="bg-[#0B6087] text-white flex items-center justify-center w-24 md:w-32 py-8 md:py-10 flex-shrink-0">
        <span class="text-4xl md:text-5xl font-bold">{{ overallRating.toFixed(1).replace('.', ',') }}</span>
      </div>
      
      <!-- Right Block - Rating Details (Light Beige/Off-white) -->
      <div class="flex-1 bg-[#f5f0e8] px-3 md:px-6 py-4 md:py-6">
        <div class="space-y-2 md:space-y-2.5">
          <div 
            v-for="detail in ratingDetails" 
            :key="detail.label"
            class="flex items-center justify-between gap-2"
          >
            <span 
              class="text-gray-800 whitespace-nowrap"
              style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
            >
              {{ detail.label }} :
            </span>
            <span 
              class="text-gray-900 whitespace-nowrap"
              style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
            >
              {{ detail.score.toFixed(1).replace('.', ',') }} ★
            </span>
          </div>
        </div>
        
        <!-- Bottom Text inside right block -->
        <div class="mt-3 md:mt-4 pt-2 md:pt-3 border-t border-gray-300">
          <p 
            class="text-gray-700"
            style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
          >
            {{ reviewCount }} clients ont donné leur avis
          </p>
        </div>
      </div>
    </div>
    
    <!-- Spacing at bottom -->
    <div class="pb-4"></div>
  </div>
</template>

<script setup lang="ts">
interface RatingDetail {
  label: string
  score: number
}

interface Props {
  overallRating?: number
  reviewCount?: number
  ratingDetails?: RatingDetail[]
}

withDefaults(defineProps<Props>(), {
  overallRating: 4.9,
  reviewCount: 17,
  ratingDetails: () => [
    { label: 'Accueil', score: 4.9 },
    { label: 'Propreté', score: 4.9 },
    { label: 'Cadre & Ambiance', score: 4.9 },
    { label: 'Qualité de la prestation', score: 5.0 }
  ]
})
</script>
