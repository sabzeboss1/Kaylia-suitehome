<template>
  <section :id="sectionId" :class="['py-16 md:py-20', bgClass]">
    <div class="container mx-auto px-6 md:px-20">
      <div v-if="showHeader" class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl mb-4">
          <span class="font-bold text-gray-900">Les</span>
          <span class="font-serif italic text-[#287395]"> équipements</span>
        </h2>
        <p class="text-base text-gray-700 font-light max-w-3xl mx-auto">
          Votre confort est pensé dans les moindres détails afin de rendre votre séjour le plus agréable.
        </p>
      </div>

      <!-- Equipment Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-8 md:gap-10 max-w-6xl mx-auto">
        <div v-for="equipment in equipmentList" :key="equipment.name" class="flex items-center gap-3">
          <div class="w-12 h-12 border border-gray-300 rounded flex items-center justify-center flex-shrink-0 bg-white p-2">
            <img 
              :src="equipment.icon" 
              :alt="equipment.name"
              class="w-full h-full object-contain"
            />
          </div>
          <span class="text-sm text-gray-900">{{ equipment.name }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  sectionId?: string
  bgClass?: string
  showHeader?: boolean
}

withDefaults(defineProps<Props>(), {
  sectionId: 'equipements',
  bgClass: 'bg-white',
  showHeader: true
})

// Equipment list - 17 items in exact order with real icons
const equipmentList = ref([
  { name: 'Literie de luxe', icon: '/images/équipements/Group 1779.ico' },
  { name: 'Vaisselles', icon: '/images/équipements/Group 1780.ico' },
  { name: 'Machine à café', icon: '/images/équipements/Group-1776.ico' },
  { name: 'Four', icon: '/images/équipements/Four.ico' },
  { name: 'Savon et Shampooing', icon: '/images/équipements/Savon-et-Shampoing.ico' },
  { name: 'Climatisation', icon: '/images/équipements/Climatisation.ico' },
  { name: 'Fer à repasser', icon: '/images/équipements/Fer-à-repasser.ico' },
  { name: 'Four Micro-ondes', icon: '/images/équipements/Four-micro-ondes.ico' },
  { name: 'Bouilloire', icon: '/images/équipements/Bouilloire.ico' },
  { name: 'TV', icon: '/images/équipements/TV.ico' },
  { name: 'Lave-vaisselle', icon: '/images/équipements/Lave vaisselle.ico' },
  { name: 'Chaise bébé', icon: '/images/équipements/Chaise bébé.ico' },
  { name: 'Escalier', icon: '/images/équipements/Escalier.ico' },
  { name: 'Cuisine équipée', icon: '/images/équipements/Cuisine équipée.ico' },
  { name: 'Réfrigérateur', icon: '/images/équipements/Frigo.ico' },
  { name: 'WiFi', icon: '/images/équipements/Wifi.ico' },
  { name: 'Machine à laver', icon: '/images/équipements/Machine à laver.ico' }
])
</script>
