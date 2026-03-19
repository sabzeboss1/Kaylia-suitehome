<template>
  <DefaultLayout>
    <div class="apartments-list-page bg-[#f9f9f9] min-h-screen">
      <!-- Hero Section with Search Box -->
      <section 
        class="relative h-[35vh] md:h-[40vh] bg-cover bg-center flex items-center hero-section"
      >
        <div class="container mx-auto px-6 md:px-20">
          <h1 class="text-white font-serif text-2xl md:text-4xl font-light leading-tight max-w-3xl">
            Les appartements T2 Chez Kaylia Suite Home conçus pour s'adapter à votre séjour
          </h1>
        </div>
      </section>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-teal-600"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="apartments.length === 0" class="text-center py-20">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <h3 class="text-2xl font-serif text-gray-900 mb-2">Aucun appartement disponible</h3>
        <p class="text-gray-600">Nos appartements seront bientôt disponibles</p>
      </div>

      <!-- Apartments List -->
      <div v-else class="py-12 md:py-16">
        <div 
          v-for="(apartment, index) in apartments" 
          :key="apartment.id"
          class="mb-16 last:mb-0"
        >
          <!-- Apartment Container - Full Width -->
          <div class="w-full">
            <!-- Title Section -->
            <div class="text-center mb-8 px-6">
              <h2 class="font-serif text-3xl md:text-4xl text-gray-900 mb-2">
                Appartement n°<span class="text-[#287395]">{{ apartment.name || apartment.id }}</span>
              </h2>
              <p class="text-gray-500 text-lg">{{ apartment.description || 'Découvrez le studio' }}</p>
            </div>

            <!-- Image Carousel - 3 images visible - Full Width -->
            <div class="relative mb-0">
              <div class="overflow-hidden">
                <div 
                  class="flex gap-0 transition-transform duration-500 ease-in-out"
                  :style="{ transform: `translateX(-${(currentSlides[index] || 0) * (100 / 3)}%)` }"
                >
                  <div 
                    v-for="(image, imgIndex) in getApartmentImages(apartment)"
                    :key="imgIndex"
                    class="flex-shrink-0"
                    style="width: 33.333%"
                  >
                    <img 
                      :src="image" 
                      :alt="`${apartment.name} - Image ${imgIndex + 1}`"
                      class="w-full h-[300px] md:h-[450px] object-cover"
                    />
                  </div>
                </div>
              </div>

              <!-- Navigation Arrows -->
              <button 
                v-if="getApartmentImages(apartment).length > 3"
                @click="previousSlide(index)"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-50 transition z-10"
                aria-label="Image précédente"
              >
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
              </button>
              <button 
                v-if="getApartmentImages(apartment).length > 3"
                @click="nextSlide(index)"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-50 transition z-10"
                aria-label="Image suivante"
              >
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </button>
            </div>

            <!-- Info Bar - Full Width -->
            <div class="bg-white shadow-sm p-4 md:p-6">
              <div class="max-w-7xl mx-auto px-6 flex flex-wrap items-center justify-between gap-4">
              <!-- Features -->
              <div class="flex flex-wrap items-center gap-4 md:gap-6">
                <!-- Capacity -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.capacity }} personnes</span>
                </div>

                <!-- Surface -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.surface }}m²</span>
                </div>

                <!-- Bed -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ getBedDescription(apartment) }}</span>
                </div>

                <!-- Floor -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.floor || '2er étage' }}</span>
                </div>
              </div>

              <!-- Price and Button -->
              <div class="flex items-center gap-3">
                <!-- Price Badge -->
                <div class="bg-[#b39a85] text-white px-6 py-3 rounded-lg">
                  <p class="text-sm font-medium">À partir de {{ apartment.pricePerNight }}€</p>
                </div>
                <!-- Reserve Button -->
                <button 
                  @click="handleReserve(apartment)"
                  class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-8 py-3 rounded-lg font-medium transition shadow-md"
                >
                  Réserver
                </button>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Equipment Section -->
      <EquipmentSection section-id="equipements" />

      <!-- Services Section -->
      <section class="bg-[#22333b] text-white py-12 md:py-20 px-6 md:px-20">
        <div class="text-center mb-12 md:mb-16">
          <h2 class="font-serif text-4xl md:text-5xl font-light mb-4">
            Nos <span class="italic">Services</span>
          </h2>
          <p class="text-base text-gray-300 font-light tracking-wide max-w-3xl mx-auto">
            Profitez d'un séjour sans compromis avec nos services premium conçus pour votre confort.
          </p>
        </div>

        <div class="grid grid-cols-3 gap-6 md:gap-12 max-w-4xl mx-auto">
          <div 
            v-for="(service, index) in services" 
            :key="index"
            class="text-center"
          >
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full mx-auto mb-3 sm:mb-4 flex items-center justify-center p-3 sm:p-4">
              <img 
                :src="service.icon" 
                :alt="service.name"
                class="w-full h-full object-contain"
              />
            </div>
            <h3 class="text-xs sm:text-sm font-medium">{{ service.name }}</h3>
          </div>
        </div>
      </section>

      <!-- Reservation Banner -->
      <ReservationBanner />

      <!-- Newsletter Section -->
      <NewsletterSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import EquipmentSection from '@/components/common/EquipmentSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import { useApartmentsStore } from '@/stores/apartments'
import { useBookingStore } from '@/stores/booking'
import type { Apartment } from '@/stores/apartments'

const apartmentsStore = useApartmentsStore()
const bookingStore = useBookingStore()
const router = useRouter()
const route = useRoute()

// State
const loading = ref(false)
const currentSlides = ref<number[]>([])

// Computed - all apartments
const apartments = computed(() => apartmentsStore.apartments)

// Get apartment images
const getApartmentImages = (apartment: Apartment) => {
  if (apartment.images && apartment.images.length > 0) {
    // Filter out invalid images and map to URLs
    const validImages = apartment.images
      .filter(img => {
        if (typeof img === 'string') return img
        return img && img.image_url
      })
      .map(img => {
        // Handle string URLs
        if (typeof img === 'string') {
          if (img.startsWith('http')) return img
          return `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}${img}`
        }
        // Handle image objects
        const imageUrl = img.image_url
        if (imageUrl.startsWith('http')) {
          return imageUrl
        }
        return `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}${imageUrl}`
      })
    
    if (validImages.length > 0) {
      return validImages
    }
  }
  
  // Fallback images if no valid images found
  return [
    '/images/apartments/apart1.jpg',
    '/images/apartments/apart2.jpg',
    '/images/apartments/apart3.jpg',
    '/images/apartments/apart4.jpg',
    '/images/apartments/apart1.jpg'
  ]
}

// Get bed description from beds array
const getBedDescription = (apartment: Apartment) => {
  if (apartment.beds && apartment.beds.length > 0) {
    const bedDescriptions = apartment.beds.map(bed => {
      const count = bed.count > 1 ? `${bed.count} lits` : '1 lit'
      const type = bed.type === 'king size' ? 'King Size' : bed.type === 'simple' ? 'simple' : bed.type
      return `${count} ${type}`
    })
    return bedDescriptions.join(', ')
  }
  return '1 lit King Size'
}

// Carousel navigation - slide by 3 images
const nextSlide = (apartmentIndex: number) => {
  const apartment = apartments.value[apartmentIndex]
  if (!apartment) return
  
  const images = getApartmentImages(apartment)
  const maxSlides = Math.max(0, images.length - 3)
  
  if (currentSlides.value[apartmentIndex] !== undefined && currentSlides.value[apartmentIndex] < maxSlides) {
    currentSlides.value[apartmentIndex]++
  }
}

const previousSlide = (apartmentIndex: number) => {
  if (currentSlides.value[apartmentIndex] !== undefined && currentSlides.value[apartmentIndex] > 0) {
    currentSlides.value[apartmentIndex]--
  }
}

// Handle reservation
const handleReserve = (apartment: Apartment) => {
  // Stocker les données de l'appartement dans le store
  bookingStore.apartment = apartment as any
  
  // Récupérer les dates et le nombre d'invités depuis les query params si disponibles
  if (route.query.checkIn) {
    bookingStore.checkIn = new Date(route.query.checkIn as string)
  }
  
  if (route.query.checkOut) {
    bookingStore.checkOut = new Date(route.query.checkOut as string)
  }
  
  if (route.query.guests) {
    bookingStore.guests = parseInt(route.query.guests as string)
  }
  
  // Rediriger vers la page de réservation
  router.push({ name: 'booking' })
}

// Services
const services = ref([
  { name: 'Wi-Fi haut débit', icon: '/images/équipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/équipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/équipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/équipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/équipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/équipements/Climatisation.ico' }
])

// Fetch apartments data
onMounted(async () => {
  loading.value = true
  try {
    await apartmentsStore.fetchApartments()
    
    // Initialize current slides for each apartment
    currentSlides.value = new Array(apartments.value.length).fill(0)
  } catch (error) {
    console.error('Failed to load apartments:', error)
  } finally {
    loading.value = false
  }
})

// Watch apartments to update slides when filtered
watch(apartments, (newApartments) => {
  currentSlides.value = new Array(newApartments.length).fill(0)
})
</script>

<style scoped>
.hero-section {
  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                    url('/images/apartments/hero.jpg');
  background-size: cover;
  background-position: center;
}
</style>
