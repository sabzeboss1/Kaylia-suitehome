<template>
  <div class="bg-white rounded-lg overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.12)] transition-all duration-300">
    <!-- Image principale avec coins arrondis -->
    <LazyImage
      :src="getImageUrl(apartment.images?.[0])"
      :srcset="`${getImageUrl(apartment.images?.[0])}?w=400 400w, ${getImageUrl(apartment.images?.[0])}?w=800 800w`"
      :alt="apartment.name"
      container-class="apartment-image h-80 relative"
      image-class="w-full h-full object-cover"
    >
      <template #overlay>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/5"></div>
      </template>
    </LazyImage>
    
    <!-- Contenu de la carte -->
    <div class="p-5">
      <!-- Titre en gras -->
      <h3 class="text-[24px] leading-[24px] font-bold text-gray-900 mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
        {{ apartment.name }}
      </h3>
      
      <!-- Description courte en gris clair -->
      <p class="text-[16px] leading-[20px] text-gray-500 mb-3 line-clamp-2 min-h-[40px]" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
        {{ apartment.description }}
      </p>
      
      <!-- Section d'avis avec étoile dorée -->
      <div v-if="apartment.rating" class="flex items-center gap-2 mb-4">
        <span class="text-yellow-400 text-lg">⭐</span>
        <span class="text-sm font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif;">
          {{ Number(apartment.rating).toFixed(1) }}
        </span>
        <span class="text-sm text-gray-500" style="font-family: 'Rounded Mplus 1c', sans-serif;">
          ({{ apartment.reviewCount || 0 }} avis)
        </span>
      </div>
      
      <!-- Section Services : rangée d'icônes minimalistes encadrées -->
      <div v-if="displayedEquipment.length > 0" class="mb-5 flex items-center justify-between">
        <p class="text-sm font-medium text-gray-700" style="font-family: 'Poppins', sans-serif;">Services</p>
        <div class="flex gap-2">
          <div 
            v-for="(equipment, index) in displayedEquipment" 
            :key="index"
            class="w-10 h-10 bg-white border border-gray-300 rounded flex items-center justify-center hover:border-gray-400 transition-colors p-1.5"
            :title="equipment"
          >
            <img 
              :src="getEquipmentIcon(equipment)" 
              :alt="equipment"
              class="w-full h-full object-contain"
            />
          </div>
          <div 
            v-if="apartment.equipment && apartment.equipment.length > 4"
            class="w-10 h-10 bg-white border border-gray-300 rounded flex items-center justify-center text-xs font-semibold text-gray-600 hover:border-gray-400 transition-colors"
            style="font-family: 'Poppins', sans-serif;"
          >
            +{{ apartment.equipment.length - 4 }}
          </div>
        </div>
      </div>
      
      <!-- Séparation horizontale discrète -->
      <div class="border-t border-gray-200 mb-4"></div>
      
      <!-- Pied de carte : prix à gauche, lien "Découvrir" à droite -->
      <div class="flex justify-between items-center">
        <div class="text-[20px] leading-[24px] font-semibold text-gray-900" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
          À partir de {{ apartment.pricePerNight }}€
        </div>
        <button 
          @click="handleReserve"
          class="text-[#0b6087] hover:text-[#094d6b] text-[16px] leading-[16px] flex items-center gap-1.5 transition-colors font-normal" 
          style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;"
        >
          Découvrir  
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import type { Apartment } from '@/composables/useApartments'
import LazyImage from '@/components/common/LazyImage.vue'

interface Props {
  apartment: Apartment
}

const props = defineProps<Props>()

const router = useRouter()
const bookingStore = useBookingStore()

const displayedEquipment = computed(() => {
  return props.apartment.equipment?.slice(0, 4) || []
})

// Helper pour obtenir l'URL de l'image
const getImageUrl = (image: any): string => {
  // Si pas d'image, retourner une image par défaut
  if (!image) {
    return 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80'
  }
  
  // Si c'est déjà une string, la retourner
  if (typeof image === 'string') {
    return image
  }
  
  // Si c'est un objet avec thumbnail_url ou image_url
  const url = image.thumbnail_url || image.image_url
  if (!url) {
    return 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80'
  }
  
  // Si l'URL est relative, ajouter le backend URL
  if (url.startsWith('/')) {
    return `http://localhost:8000${url}`
  }
  
  return url
}

const getEquipmentIcon = (equipment: string): string => {
  const equipmentLower = equipment.toLowerCase()
  
  // Mapping des équipements vers des icônes du répertoire
  const iconMap: Record<string, string> = {
    // Connectivité (FR + EN)
    'wifi': '/images/equipements/Wifi.ico',
    'wi-fi': '/images/equipements/Wifi.ico',
    'wi-fi haut débit': '/images/equipements/Wifi.ico',
    'internet': '/images/equipements/Wifi.ico',
    
    // Électronique (FR + EN)
    'tv': '/images/equipements/TV.ico',
    'télévision': '/images/equipements/TV.ico',
    'television': '/images/equipements/TV.ico',
    'écran plat': '/images/equipements/TV.ico',
    
    // Cuisine (FR + EN)
    'cuisine': '/images/equipements/Cuisine équipée.ico',
    'cuisine équipée': '/images/equipements/Cuisine équipée.ico',
    'kitchen': '/images/equipements/Cuisine équipée.ico',
    'kitchenette': '/images/equipements/Cuisine équipée.ico',
    'micro-ondes': '/images/equipements/Four-micro-ondes.ico',
    'microwave': '/images/equipements/Four-micro-ondes.ico',
    'four micro-ondes': '/images/equipements/Four-micro-ondes.ico',
    'four': '/images/equipements/Four.ico',
    'oven': '/images/equipements/Four.ico',
    'réfrigérateur': '/images/equipements/Frigo.ico',
    'refrigerator': '/images/equipements/Frigo.ico',
    'frigo': '/images/equipements/Frigo.ico',
    'fridge': '/images/equipements/Frigo.ico',
    'cafetière': '/images/equipements/Group-1776.ico',
    'coffee maker': '/images/equipements/Group-1776.ico',
    'machine à café': '/images/equipements/Group-1776.ico',
    'bouilloire': '/images/equipements/Bouilloire.ico',
    'kettle': '/images/equipements/Bouilloire.ico',
    'lave-vaisselle': '/images/equipements/Lave vaisselle.ico',
    'lave vaisselle': '/images/equipements/Lave vaisselle.ico',
    'dishwasher': '/images/equipements/Lave vaisselle.ico',
    
    // Confort (FR + EN)
    'climatisation': '/images/equipements/Climatisation.ico',
    'air conditioning': '/images/equipements/Climatisation.ico',
    'air conditionné': '/images/equipements/Climatisation.ico',
    'a/c': '/images/equipements/Climatisation.ico',
    
    // Services (FR + EN)
    'fer à repasser': '/images/equipements/Fer-à-repasser.ico',
    'iron': '/images/equipements/Fer-à-repasser.ico',
    'lave-linge': '/images/equipements/Machine à laver.ico',
    'machine à laver': '/images/equipements/Machine à laver.ico',
    'washing machine': '/images/equipements/Machine à laver.ico',
    'sèche-linge': '/images/equipements/Group-1777.ico',
    'dryer': '/images/equipements/Group-1777.ico',
    
    // Literie (FR + EN)
    'lit king size': '/images/equipements/Group 1779.ico',
    'lit double': '/images/equipements/Group 1779.ico',
    'literie de luxe': '/images/equipements/Group 1779.ico',
    'king size bed': '/images/equipements/Group 1779.ico',
    'double bed': '/images/equipements/Group 1779.ico',
    
    // Vaisselle (FR + EN)
    'vaisselles': '/images/equipements/Group 1780.ico',
    'vaisselle': '/images/equipements/Group 1780.ico',
    'dishes': '/images/equipements/Group 1780.ico',
    
    // Hygiène (FR + EN)
    'savon et shampooing': '/images/equipements/Savon-et-Shampoing.ico',
    'savon': '/images/equipements/Savon-et-Shampoing.ico',
    'shampoing': '/images/equipements/Savon-et-Shampoing.ico',
    'hair dryer': '/images/equipements/Savon-et-Shampoing.ico',
    'sèche-cheveux': '/images/equipements/Savon-et-Shampoing.ico',
    
    // Famille (FR + EN)
    'chaise bébé': '/images/equipements/Chaise bébé.ico',
    'baby chair': '/images/equipements/Chaise bébé.ico',
    
    // Bâtiment (FR + EN)
    'escalier': '/images/equipements/Escalier.ico',
    'stairs': '/images/equipements/Escalier.ico',
    'balcon': '/images/equipements/Maison.ico',
    'balcony': '/images/equipements/Maison.ico',
    'terrasse': '/images/equipements/Maison.ico',
    'terrace': '/images/equipements/Maison.ico',
    
    // Mobilier (FR + EN)
    'bureau': '/images/equipements/Personne.ico',
    'desk': '/images/equipements/Personne.ico',
    'armoire': '/images/equipements/Maison.ico',
    'wardrobe': '/images/equipements/Maison.ico',
    
    // Sécurité & Services (FR + EN)
    'sécurité': '/images/equipements/Sécurité.ico',
    'sécurité 24/7': '/images/equipements/Sécurité.ico',
    'security': '/images/equipements/Sécurité.ico',
    'coffre-fort': '/images/equipements/Sécurité.ico',
    'safe': '/images/equipements/Sécurité.ico',
    'parking': '/images/equipements/Maison.ico',
    'spa': '/images/equipements/SPA.ico',
    'spa & bien-être': '/images/equipements/SPA.ico',
    'conciergerie': '/images/equipements/Conciergerie.ico',
    'concierge': '/images/equipements/Conciergerie.ico'
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
  
  // Icône par défaut - utiliser une icône générique
  return '/images/equipements/Vector.ico'
}

const handleReserve = () => {
  // Stocker les données de l'appartement dans le store
  bookingStore.apartment = props.apartment as any
  
  // Rediriger vers la page de réservation
  router.push({ name: 'booking' })
}
</script>

<style scoped>
.apartment-image {
  background: linear-gradient(to bottom, #e5e5e5 0%, #d4d4d4 100%);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
