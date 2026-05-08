<template>
  <div class="bg-[#e8dcc8] rounded-xl shadow-lg p-6 md:p-8 w-full">
    <!-- Title -->
    <h3 
      class="text-gray-900 mb-6 md:mb-8"
      style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 24px; line-height: 24px; letter-spacing: 0px;"
    >
      Horaires d'ouverture
    </h3>
    
    <!-- Hours List -->
    <div class="space-y-0">
      <div 
        v-for="(day, index) in openingHours" 
        :key="day.dayOfWeek"
        :class="[
          'flex justify-between items-center py-2.5 md:py-3.5',
          index < openingHours.length - 1 ? 'border-b border-gray-300' : ''
        ]"
      >
        <!-- Day Name -->
        <span 
          class="text-gray-800"
          style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
        >
          {{ day.dayOfWeek }}
        </span>
        
        <!-- Hours -->
        <span 
          class="text-gray-800"
          style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; letter-spacing: 0px;"
        >
          {{ day.isClosed ? 'Fermé' : `${day.openTime} - ${day.closeTime}` }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface OpeningHour {
  dayOfWeek: string
  openTime: string
  closeTime: string
  isClosed: boolean
}

interface Props {
  openingHours?: OpeningHour[]
}

withDefaults(defineProps<Props>(), {
  openingHours: () => [
    { dayOfWeek: 'Lundi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Mardi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Mercredi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Jeudi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Vendredi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Samedi', openTime: '10:00', closeTime: '20:00', isClosed: false },
    { dayOfWeek: 'Dimanche', openTime: '10:00', closeTime: '17:00', isClosed: false }
  ]
})
</script>
