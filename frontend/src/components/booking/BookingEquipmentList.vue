<template>
  <div>
    <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4 md:mb-6">Les équipements</h3>
    <div class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
      <div
        v-for="(item, index) in equipment"
        :key="index"
        class="flex flex-col md:flex-row items-center gap-2 md:gap-3 px-1.5 md:px-4 py-2 md:py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200"
      >
        <div class="w-8 h-8 md:w-12 md:h-12 flex-shrink-0 flex items-center justify-center bg-gray-50 rounded p-1.5 md:p-2">
          <img 
            :src="getEquipmentIcon(item)" 
            :alt="item"
            class="w-full h-full object-contain"
          />
        </div>
        <span class="text-xs md:text-sm text-gray-700 text-center md:text-left">{{ item }}</span>
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
  
  // Mapping bilingue FR + EN → ICÔNE
  const iconMap: Record<string, string> = {
    // Connectivité (FR + EN)
    'wifi': '/images/équipements/Wifi.ico',
    'wi-fi': '/images/équipements/Wifi.ico',
    'wi-fi haut débit': '/images/équipements/Wifi.ico',
    'internet': '/images/équipements/Wifi.ico',
    
    // Électronique (FR + EN)
    'tv': '/images/équipements/TV.ico',
    'télévision': '/images/équipements/TV.ico',
    'television': '/images/équipements/TV.ico',
    'écran plat': '/images/équipements/TV.ico',
    
    // Cuisine (FR + EN)
    'cuisine': '/images/équipements/Cuisine équipée.ico',
    'cuisine équipée': '/images/équipements/Cuisine équipée.ico',
    'kitchen': '/images/équipements/Cuisine équipée.ico',
    'kitchenette': '/images/équipements/Cuisine équipée.ico',
    'micro-ondes': '/images/équipements/Four-micro-ondes.ico',
    'microwave': '/images/équipements/Four-micro-ondes.ico',
    'four micro-ondes': '/images/équipements/Four-micro-ondes.ico',
    'four': '/images/équipements/Four.ico',
    'oven': '/images/équipements/Four.ico',
    'réfrigérateur': '/images/équipements/Frigo.ico',
    'refrigerator': '/images/équipements/Frigo.ico',
    'frigo': '/images/équipements/Frigo.ico',
    'fridge': '/images/équipements/Frigo.ico',
    'cafetière': '/images/équipements/Group-1776.ico',
    'coffee maker': '/images/équipements/Group-1776.ico',
    'machine à café': '/images/équipements/Group-1776.ico',
    'bouilloire': '/images/équipements/Bouilloire.ico',
    'kettle': '/images/équipements/Bouilloire.ico',
    'lave-vaisselle': '/images/équipements/Lave vaisselle.ico',
    'lave vaisselle': '/images/équipements/Lave vaisselle.ico',
    'dishwasher': '/images/équipements/Lave vaisselle.ico',
    
    // Confort (FR + EN)
    'climatisation': '/images/équipements/Climatisation.ico',
    'air conditioning': '/images/équipements/Climatisation.ico',
    'air conditionné': '/images/équipements/Climatisation.ico',
    'a/c': '/images/équipements/Climatisation.ico',
    
    // Services (FR + EN)
    'fer à repasser': '/images/équipements/Fer-à-repasser.ico',
    'iron': '/images/équipements/Fer-à-repasser.ico',
    'lave-linge': '/images/équipements/Machine à laver.ico',
    'machine à laver': '/images/équipements/Machine à laver.ico',
    'washing machine': '/images/équipements/Machine à laver.ico',
    'sèche-linge': '/images/équipements/Group-1777.ico',
    'dryer': '/images/équipements/Group-1777.ico',
    
    // Literie (FR + EN)
    'lit king size': '/images/équipements/Group 1779.ico',
    'lit double': '/images/équipements/Group 1779.ico',
    'literie de luxe': '/images/équipements/Group 1779.ico',
    'king size bed': '/images/équipements/Group 1779.ico',
    'double bed': '/images/équipements/Group 1779.ico',
    'luxury bedding': '/images/équipements/Group 1779.ico',
    
    // Vaisselle (FR + EN)
    'vaisselles': '/images/équipements/Group 1780.ico',
    'vaisselle': '/images/équipements/Group 1780.ico',
    'dishes': '/images/équipements/Group 1780.ico',
    
    // Hygiène (FR + EN)
    'savon et shampooing': '/images/équipements/Savon-et-Shampoing.ico',
    'savon': '/images/équipements/Savon-et-Shampoing.ico',
    'shampoing': '/images/équipements/Savon-et-Shampoing.ico',
    'hair dryer': '/images/équipements/Savon-et-Shampoing.ico',
    'sèche-cheveux': '/images/équipements/Savon-et-Shampoing.ico',
    'soap and shampoo': '/images/équipements/Savon-et-Shampoing.ico',
    
    // Famille (FR + EN)
    'chaise bébé': '/images/équipements/Chaise bébé.ico',
    'baby chair': '/images/équipements/Chaise bébé.ico',
    
    // Bâtiment (FR + EN)
    'escalier': '/images/équipements/Escalier.ico',
    'stairs': '/images/équipements/Escalier.ico',
    'balcon': '/images/équipements/Maison.ico',
    'balcony': '/images/équipements/Maison.ico',
    'terrasse': '/images/équipements/Maison.ico',
    'terrace': '/images/équipements/Maison.ico',
    
    // Mobilier (FR + EN)
    'bureau': '/images/équipements/Personne.ico',
    'desk': '/images/équipements/Personne.ico',
    'armoire': '/images/équipements/Maison.ico',
    'wardrobe': '/images/équipements/Maison.ico',
    
    // Sécurité & Services (FR + EN)
    'sécurité': '/images/équipements/Sécurité.ico',
    'sécurité 24/7': '/images/équipements/Sécurité.ico',
    'security': '/images/équipements/Sécurité.ico',
    'coffre-fort': '/images/équipements/Sécurité.ico',
    'safe': '/images/équipements/Sécurité.ico',
    'parking': '/images/équipements/Maison.ico',
    'spa': '/images/équipements/SPA.ico',
    'spa & bien-être': '/images/équipements/SPA.ico',
    'conciergerie': '/images/équipements/Conciergerie.ico',
    'concierge': '/images/équipements/Conciergerie.ico'
  }
  
  // Chercher une correspondance exacte d'abord
  if (iconMap[equipmentLower]) {
    return iconMap[equipmentLower]
  }
  
  // Chercher une correspondance partielle
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
