<template>
  <div>
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Les équipements</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="(item, index) in equipment"
        :key="index"
        class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200"
      >
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-gray-50 rounded p-2">
          <img 
            :src="getEquipmentIcon(item)" 
            :alt="item"
            class="w-full h-full object-contain"
          />
        </div>
        <span class="text-sm text-gray-700">{{ item }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  equipment: string[]
}

defineProps<Props>()

const getEquipmentIcon = (equipment: string): string => {
  const equipmentLower = equipment.toLowerCase()
  
  // Mapping ANGLAIS → ICÔNE (les noms viennent de la base de données en anglais)
  const iconMap: Record<string, string> = {
    // Noms anglais de la base de données
    'wifi': '/images/équipements/Wifi.ico',
    'tv': '/images/équipements/TV.ico',
    'kitchen': '/images/équipements/Cuisine équipée.ico',
    'air conditioning': '/images/équipements/Climatisation.ico',
    'parking': '/images/équipements/Maison.ico',
    'washing machine': '/images/équipements/Machine à laver.ico',
    'balcony': '/images/équipements/Maison.ico',
    'microwave': '/images/équipements/Four-micro-ondes.ico',
    'refrigerator': '/images/équipements/Frigo.ico',
    'coffee maker': '/images/équipements/Group-1776.ico',
    'iron': '/images/équipements/Fer-à-repasser.ico',
    'hair dryer': '/images/équipements/Group-1777.ico',
    'safe': '/images/équipements/Sécurité.ico',
    'desk': '/images/équipements/Group 1780.ico',
    'wardrobe': '/images/équipements/Group 1780.ico',
    'dishwasher': '/images/équipements/Lave vaisselle.ico',
    'oven': '/images/équipements/Four.ico',
    'kettle': '/images/équipements/Bouilloire.ico',
    'baby chair': '/images/équipements/Chaise bébé.ico',
    'stairs': '/images/équipements/Escalier.ico',
    'luxury bedding': '/images/équipements/Group 1779.ico',
    'dishes': '/images/équipements/Group 1780.ico',
    'soap and shampoo': '/images/équipements/Savon-et-Shampoing.ico'
  }
  
  // Chercher une correspondance exacte d'abord
  if (iconMap[equipmentLower]) {
    return iconMap[equipmentLower]
  }
  
  // Puis chercher une correspondance partielle
  for (const [key, icon] of Object.entries(iconMap)) {
    if (equipmentLower.includes(key) || key.includes(equipmentLower)) {
      return icon
    }
  }
  
  // Icône par défaut
  return '/images/équipements/Vector.ico'
}
</script>

<style scoped>
/* Ensure consistent sizing for equipment items */
.grid > div {
  min-height: 60px;
}
</style>
