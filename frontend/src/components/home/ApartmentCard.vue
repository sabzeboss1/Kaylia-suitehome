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
    // Connectivité
    'wifi': '/images/équipements/Wifi.ico',
    'wi-fi': '/images/équipements/Wifi.ico',
    'wi-fi haut débit': '/images/équipements/Wifi.ico',
    'internet': '/images/équipements/Wifi.ico',
    
    // Électronique
    'tv': '/images/équipements/TV.ico',
    'télévision': '/images/équipements/TV.ico',
    'television': '/images/équipements/TV.ico',
    'écran plat': '/images/équipements/TV.ico',
    
    // Cuisine
    'cuisine': '/images/équipements/Cuisine équipée.ico',
    'cuisine équipée': '/images/équipements/Cuisine équipée.ico',
    'kitchenette': '/images/équipements/Cuisine équipée.ico',
    'micro-ondes': '/images/équipements/Four-micro-ondes.ico',
    'four micro-ondes': '/images/équipements/Four-micro-ondes.ico',
    'four': '/images/équipements/Four.ico',
    'réfrigérateur': '/images/équipements/Frigo.ico',
    'frigo': '/images/équipements/Frigo.ico',
    'cafetière': '/images/équipements/Group-1776.ico',
    'machine à café': '/images/équipements/Group-1776.ico',
    'bouilloire': '/images/équipements/Bouilloire.ico',
    'lave-vaisselle': '/images/équipements/Lave vaisselle.ico',
    'lave vaisselle': '/images/équipements/Lave vaisselle.ico',
    
    // Confort
    'climatisation': '/images/équipements/Climatisation.ico',
    'air conditionné': '/images/équipements/Climatisation.ico',
    
    // Services
    'fer à repasser': '/images/équipements/Fer-à-repasser.ico',
    'lave-linge': '/images/équipements/Machine à laver.ico',
    'machine à laver': '/images/équipements/Machine à laver.ico',
    'sèche-linge': '/images/équipements/Machine à laver.ico',
    
    // Literie
    'lit king size': '/images/équipements/Group 1779.ico',
    'lit double': '/images/équipements/Group 1779.ico',
    'literie de luxe': '/images/équipements/Group 1779.ico',
    
    // Vaisselle
    'vaisselles': '/images/équipements/Group 1780.ico',
    'vaisselle': '/images/équipements/Group 1780.ico',
    
    // Autres
    'savon et shampooing': '/images/équipements/Savon-et-Shampoing.ico',
    'savon': '/images/équipements/Savon-et-Shampoing.ico',
    'shampoing': '/images/équipements/Savon-et-Shampoing.ico',
    'chaise bébé': '/images/équipements/Chaise bébé.ico',
    'escalier': '/images/équipements/Escalier.ico',
    'sécurité': '/images/équipements/Sécurité.ico',
    'sécurité 24/7': '/images/équipements/Sécurité.ico',
    'spa': '/images/équipements/SPA.ico',
    'spa & bien-être': '/images/équipements/SPA.ico',
    'conciergerie': '/images/équipements/Conciergerie.ico'
  }
  
  // Chercher une correspondance exacte ou partielle
  for (const [key, icon] of Object.entries(iconMap)) {
    if (equipmentLower === key || equipmentLower.includes(key)) {
      return icon
    }
  }
  
  // Icône par défaut - utiliser une icône générique
  return '/images/équipements/Vector.ico'
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
