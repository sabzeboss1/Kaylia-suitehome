<template>
  <div class="bg-transparent border-2 border-white rounded-lg p-4 md:p-6">
    <div class="flex items-center gap-1 mb-3 md:mb-4">
      <span class="text-white text-lg md:text-xl font-semibold">{{ review.rating.toFixed(1) }}</span>
      <span class="text-white text-lg md:text-xl">★</span>
    </div>
    <p class="text-white text-xs md:text-sm leading-relaxed mb-3 md:mb-4">
      {{ review.comment }}
    </p>
    <p class="text-white text-xs opacity-80">
      {{ formatDate(review.date) }}
    </p>
  </div>
</template>

<script setup lang="ts">
interface Review {
  id: number
  rating: number
  comment: string
  date: string
}

interface Props {
  review: Review
}

defineProps<Props>()

const formatDate = (dateString: string): string => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}
</script>
