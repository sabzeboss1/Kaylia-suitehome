<template>
  <div class="bg-[#e8dcc8] rounded-xl shadow-lg overflow-hidden w-full">
    <!-- Title -->
    <div class="px-6 pt-6 pb-4">
      <h3 class="text-xl font-semibold text-gray-900">Note</h3>
    </div>
    
    <!-- Rating Content -->
    <div class="flex border border-gray-300 rounded-lg mx-4 overflow-hidden">
      <!-- Left Block - Overall Rating (Dark Blue) -->
      <div class="bg-[#1a7a8f] text-white flex items-center justify-center w-32 py-10">
        <span class="text-5xl font-bold">{{ overallRating.toFixed(1).replace('.', ',') }}</span>
      </div>
      
      <!-- Right Block - Rating Details (Light Beige/Off-white) -->
      <div class="flex-1 bg-[#f5f0e8] px-6 py-6">
        <div class="space-y-2.5">
          <div 
            v-for="detail in ratingDetails" 
            :key="detail.label"
            class="flex items-center justify-between text-sm"
          >
            <span class="text-gray-800">{{ detail.label }} :</span>
            <span class="font-semibold text-gray-900">{{ detail.score.toFixed(1).replace('.', ',') }} ★</span>
          </div>
        </div>
        
        <!-- Bottom Text inside right block -->
        <div class="mt-4 pt-3 border-t border-gray-300">
          <p class="text-sm text-gray-700">
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
