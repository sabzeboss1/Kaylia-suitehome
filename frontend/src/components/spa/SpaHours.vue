<template>
  <div class="bg-[#e8dcc8] rounded-xl shadow-lg p-8 w-full">
    <h3 class="text-xl font-semibold text-gray-900 mb-8">Horaires d'ouverture</h3>
    <div class="space-y-0">
      <div 
        v-for="(day, index) in openingHours" 
        :key="day.dayOfWeek"
        :class="[
          'flex justify-between items-center py-3.5',
          index < openingHours.length - 1 ? 'border-b border-gray-300' : ''
        ]"
      >
        <span class="text-gray-800 font-medium">{{ day.dayOfWeek }}</span>
        <span class="text-gray-800">
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
