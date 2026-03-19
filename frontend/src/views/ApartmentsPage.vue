<template>
  <DefaultLayout>
    <div class="apartments-page">
      <!-- Hero Section -->
      <ApartmentHero :images="heroCarouselImages" />

      <!-- Filter Section -->
      <ApartmentFilter :search-results="results" :search-params="searchParams" />

      <!-- Apartments Listing -->
      <div id="appartements" class="max-w-7xl mx-auto px-6 py-16">
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-20">
          <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-teal-600"></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-20">
          <svg class="w-24 h-24 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <h3 class="text-2xl font-serif text-gray-900 mb-2">Erreur de recherche</h3>
          <p class="text-gray-600 mb-4">{{ error }}</p>
          <button @click="performSearch" class="px-6 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">
            Réessayer
          </button>
        </div>

        <!-- Empty State -->
        <div v-else-if="!results || results.apartments.length === 0" class="text-center py-20">
          <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          <h3 class="text-2xl font-serif text-gray-900 mb-2">Aucun appartement disponible</h3>
          <p class="text-gray-600">
            {{ searchParams.checkIn && searchParams.checkOut 
              ? 'Aucun appartement n\'est disponible pour ces dates' 
              : 'Essayez de modifier vos critères de recherche' }}
          </p>
        </div>

        <!-- Results -->
        <div v-else>
          <div class="space-y-12">
            <ApartmentListItem
              v-for="(apartment, index) in results.apartments"
              :key="apartment.id"
              :apartment="apartment"
              :index="index"
            />
          </div>
        </div>
      </div>

      <!-- Equipment Section -->
      <EquipmentSection />

      <!-- Services Section -->
      <section id="services" class="bg-[#22333b] text-white py-12 md:py-20 px-6 md:px-20">
        <div class="text-center mb-12 md:mb-16">
          <h2 class="font-serif text-4xl md:text-5xl font-light mb-4">
            Nos <span class="italic">Services</span>
          </h2>
          <p class="text-base text-gray-300 font-light tracking-wide max-w-3xl mx-auto">
            Profitez d'un séjour sans compromis avec nos services premium conçus pour votre confort.
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 max-w-4xl mx-auto">
          <div v-for="service in servicesList" :key="service.name" class="text-center">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center p-4">
              <img 
                :src="service.icon" 
                :alt="service.name"
                class="w-full h-full object-contain"
              />
            </div>
            <h3 class="text-sm font-medium">{{ service.name }}</h3>
          </div>
        </div>
      </section>

      <!-- Photo Gallery Section -->
      <div id="galerie">
        <ApartmentGallery 
        v-if="galleryImages.length > 0"
        :main-image="galleryImages[0]?.url"
        :main-image-alt="galleryImages[0]?.alt"
        :thumbnails="galleryImages.slice(1, 4)"
        :total-photos="totalPhotosCount"
        @view-all-photos="handleViewAllPhotos"
        @view-video="handleViewVideo"
        @navigate-prev="handleNavigatePrev"
        @navigate-next="handleNavigateNext"
      />
      </div>

      <!-- FAQ Section -->
      <div id="faq">
        <ApartmentFAQ />
      </div>

      <!-- Newsletter Section -->
      <NewsletterSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ApartmentHero from '@/components/apartments/ApartmentHero.vue'
import ApartmentFilter from '@/components/apartments/ApartmentFilter.vue'
import ApartmentListItem from '@/components/apartments/ApartmentListItem.vue'
import ApartmentGallery from '@/components/apartments/ApartmentGallery.vue'
import ApartmentFAQ from '@/components/apartments/ApartmentFAQ.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import EquipmentSection from '@/components/common/EquipmentSection.vue'
import { useApartmentSearch } from '@/composables/useApartmentSearch'
import type { SearchParams } from '@/composables/useApartmentSearch'

const route = useRoute()
const { loading, error, results, searchApartments } = useApartmentSearch()

// State
const searchParams = ref<SearchParams>({
  checkIn: route.query.checkIn as string || undefined,
  checkOut: route.query.checkOut as string || undefined,
  guests: route.query.guests ? parseInt(route.query.guests as string) : undefined,
})

// Parse price range if provided
if (route.query.priceRange) {
  const [min, max] = (route.query.priceRange as string).split('-').map(Number)
  if (min) searchParams.value.minPrice = min
  if (max) searchParams.value.maxPrice = max
}

// Gallery images computed from apartments
const galleryImages = computed(() => {
  if (!results.value?.apartments || results.value.apartments.length === 0) {
    // Fallback images si pas de résultats
    return [
      { url: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80', alt: 'Immeuble Kaylia Suite Home' },
      { url: 'https://images.unsplash.com/photo-1556912173-46c336c7fd55?w=400&q=80', alt: 'Cuisine équipée' },
      { url: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80', alt: 'Salon moderne' },
      { url: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&q=80', alt: 'Salle de bain' }
    ]
  }

  const images: Array<{ url: string; alt: string }> = []
  const backendUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'
  
  // Collecter les images de tous les appartements
  for (const apartment of results.value.apartments) {
    if (apartment.images && apartment.images.length > 0) {
      for (const image of apartment.images) {
        const imageUrl = image.url || image.image_url
        // Ajouter l'URL du backend si l'image est relative
        const fullUrl = imageUrl.startsWith('http') ? imageUrl : `${backendUrl}${imageUrl}`
        
        images.push({
          url: fullUrl,
          alt: `${apartment.name} - ${image.title || 'Photo'}`
        })
      }
    }
  }

  // Si pas assez d'images, ajouter des fallbacks
  while (images.length < 4) {
    images.push({
      url: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80',
      alt: 'Appartement Kaylia'
    })
  }

  return images.slice(0, 4)
})

// Hero carousel images - mélange des images des appartements
const heroCarouselImages = computed(() => {
  if (!results.value?.apartments || results.value.apartments.length === 0) {
    return []
  }

  const images: Array<{ url: string; alt: string }> = []
  const backendUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'
  
  // Collecter toutes les images de tous les appartements
  for (const apartment of results.value.apartments) {
    if (apartment.images && apartment.images.length > 0) {
      for (const image of apartment.images) {
        const imageUrl = image.url || image.image_url
        const fullUrl = imageUrl.startsWith('http') ? imageUrl : `${backendUrl}${imageUrl}`
        
        images.push({
          url: fullUrl,
          alt: `${apartment.name} - ${image.title || 'Photo'}`
        })
      }
    }
  }

  // Mélanger les images pour avoir une variété
  const shuffled = images.sort(() => Math.random() - 0.5)
  
  // Retourner les 8 premières images
  return shuffled.slice(0, 8)
})

// Total photos count
const totalPhotosCount = computed(() => {
  if (!results.value?.apartments) return 0
  
  return results.value.apartments.reduce((total, apartment) => {
    return total + (apartment.images?.length || 0)
  }, 0)
})

// Perform search
const performSearch = async () => {
  console.log('Performing search with params:', searchParams.value)
  await searchApartments(searchParams.value)
}

// Services list
const servicesList = ref([
  { name: 'Wi-Fi haut débit', icon: '/images/équipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/équipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/équipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/équipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/équipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/équipements/Climatisation.ico' }
])

// Watch for query param changes
watch(() => route.query, async (newQuery) => {
  searchParams.value = {
    checkIn: newQuery.checkIn as string || undefined,
    checkOut: newQuery.checkOut as string || undefined,
    guests: newQuery.guests ? parseInt(newQuery.guests as string) : undefined,
  }
  
  if (newQuery.priceRange) {
    const [min, max] = (newQuery.priceRange as string).split('-').map(Number)
    if (min) searchParams.value.minPrice = min
    if (max) searchParams.value.maxPrice = max
  }
  
  await performSearch()
}, { deep: true })

// Lifecycle
onMounted(async () => {
  await performSearch()
})

// Gallery handlers
const handleViewAllPhotos = () => {
  console.log('View all photos clicked')
  // TODO: Implement photo gallery modal
}

const handleViewVideo = () => {
  console.log('View video clicked')
  // TODO: Implement video modal
}

const handleNavigatePrev = () => {
  console.log('Navigate to previous image')
  // TODO: Implement image navigation
}

const handleNavigateNext = () => {
  console.log('Navigate to next image')
  // TODO: Implement image navigation
}
</script>

<style scoped>
.primary-blue {
  color: #4a7c8c;
}
</style>
