<template>
  <div class="border-2 border-gray-800 rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-3">
      {{ service.name }}
    </h3>
    <p v-if="service.subtitle" class="text-sm text-gray-600 italic mb-3">
      {{ service.subtitle }}
    </p>
    <p class="text-sm text-gray-700 mb-4 leading-relaxed">
      {{ service.description }}
    </p>
    <div class="flex items-center justify-end">
      <span class="text-2xl font-bold text-gray-900">
        {{ formatPrice(service.price) }}
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Service {
  id: number
  name: string
  subtitle?: string
  description: string
  price: number
  duration?: number
  category: 'appointment' | 'event'
}

interface Props {
  service: Service
}

defineProps<Props>()

const formatPrice = (price: number): string => {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR'
  }).format(price)
}
</script>
