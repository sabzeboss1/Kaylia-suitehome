<template>
  <section class="bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-20">
      <div class="text-center mb-12">
        <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
          Les <span class="text-primary-blue italic">équipements</span>
        </h2>
        <p class="text-base text-gray-600 font-light max-w-3xl mx-auto">
          Votre confort est pensé dans les moindres détails afin de rendre votre séjour le plus agréable.
        </p>
      </div>

      <!-- Equipment Grid -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-6xl mx-auto">
        <div 
          v-for="(item, index) in equipment" 
          :key="index"
          class="flex flex-col items-center text-center"
        >
          <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3 p-2">
            <img 
              :src="getEquipmentIcon(item.icon)" 
              :alt="item.name"
              class="w-full h-full object-contain"
            />
          </div>
          <span class="text-sm text-gray-800">{{ item.name }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
interface EquipmentItem {
  name: string
  icon: string
}

interface Props {
  equipment: EquipmentItem[]
}

const props = defineProps<Props>()

// Mapping des noms d'icônes vers les fichiers locaux
const getEquipmentIcon = (iconName: string): string => {
  const iconMap: Record<string, string> = {
    'luxury-bedding': '/images/equipements/Group 1779.ico',
    'dishes': '/images/equipements/Group 1780.ico',
    'coffee-machine': '/images/equipements/Group-1776.ico',
    'oven': '/images/equipements/Four.ico',
    'soap-shampoo': '/images/equipements/Savon-et-Shampoing.ico',
    'air-conditioning': '/images/equipements/Climatisation.ico',
    'iron': '/images/equipements/Fer-à-repasser.ico',
    'microwave': '/images/equipements/Four-micro-ondes.ico',
    'kettle': '/images/equipements/Bouilloire.ico',
    'tv': '/images/equipements/TV.ico',
    'dishwasher': '/images/equipements/Lave vaisselle.ico',
    'baby-chair': '/images/equipements/Chaise bébé.ico',
    'stairs': '/images/equipements/Escalier.ico',
    'equipped-kitchen': '/images/equipements/Cuisine équipée.ico',
    'refrigerator': '/images/equipements/Frigo.ico',
    'wifi': '/images/equipements/Wifi.ico',
    'washing-machine': '/images/equipements/Machine à laver.ico'
  }

  return iconMap[iconName] || '/images/equipements/Vector.ico'
}
</script>

<style scoped>
.primary-blue {
  color: #4a7c8c;
}
</style>
