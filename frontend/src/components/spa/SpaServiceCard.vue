<template>
  <div class="border-2 border-gray-800 rounded-lg p-4 md:p-6">
    <!-- Titre du service -->
    <h3 
      class="text-gray-900 mb-2 md:mb-3"
      style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px; letter-spacing: 0px;"
    >
      {{ service.name }}
    </h3>
    
    <!-- Sous-titre (optionnel) -->
    <p 
      v-if="service.subtitle" 
      class="text-gray-600 italic mb-2 md:mb-3"
      style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 14px; line-height: 20px;"
    >
      {{ service.subtitle }}
    </p>
    
    <!-- Description du service -->
    <p 
      class="text-gray-700 mb-3 md:mb-4"
      style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
    >
      {{ service.description }}
    </p>
    
    <!-- Prix -->
    <div class="flex items-center justify-end">
      <span 
        class="text-gray-900"
        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px; letter-spacing: 0px;"
      >
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
