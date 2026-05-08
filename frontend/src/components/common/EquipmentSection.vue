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
      <div class="grid grid-cols-3 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-8 lg:gap-10 max-w-6xl mx-auto">
        <div v-for="equipment in equipmentList" :key="equipment.name" class="flex flex-col md:flex-row items-center gap-2 md:gap-3">
          <div class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded flex items-center justify-center flex-shrink-0 bg-white p-2">
            <img 
              :src="equipment.icon" 
              :alt="equipment.name"
              class="w-full h-full object-contain"
            />
          </div>
          <span class="text-xs md:text-sm text-gray-900 text-center md:text-left">{{ equipment.name }}</span>
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
  sectionId: 'équipements',
  bgClass: 'bg-white',
  showHeader: true
})

// Equipment list - 17 items in exact order with real icons
const equipmentList = ref([
  { name: 'Literie de luxe', icon: '/images/equipements/Group 1779.ico' },
  { name: 'Vaisselles', icon: '/images/equipements/Group 1780.ico' },
  { name: 'Machine à café', icon: '/images/equipements/Group-1776.ico' },
  { name: 'Four', icon: '/images/equipements/Four.ico' },
  { name: 'Savon et Shampooing', icon: '/images/equipements/Savon-et-Shampoing.ico' },
  { name: 'Climatisation', icon: '/images/equipements/Climatisation.ico' },
  { name: 'Fer à repasser', icon: '/images/equipements/Fer-à-repasser.ico' },
  { name: 'Four Micro-ondes', icon: '/images/equipements/Four-micro-ondes.ico' },
  { name: 'Bouilloire', icon: '/images/equipements/Bouilloire.ico' },
  { name: 'TV', icon: '/images/equipements/TV.ico' },
  { name: 'Lave-vaisselle', icon: '/images/equipements/Lave vaisselle.ico' },
  { name: 'Chaise bébé', icon: '/images/equipements/Chaise bébé.ico' },
  { name: 'Escalier', icon: '/images/equipements/Escalier.ico' },
  { name: 'Cuisine équipée', icon: '/images/equipements/Cuisine équipée.ico' },
  { name: 'Réfrigérateur', icon: '/images/equipements/Frigo.ico' },
  { name: 'WiFi', icon: '/images/equipements/Wifi.ico' },
  { name: 'Machine à laver', icon: '/images/equipements/Machine à laver.ico' }
])
</script>
