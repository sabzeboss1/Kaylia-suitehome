<template>
  <DefaultLayout>
    <div class="apartments-page">
      <!-- Hero Section -->
      <ApartmentHero />

      <!-- Filter Section -->
      <ApartmentFilter />

      <!-- Apartments Listing -->
      <div class="max-w-7xl mx-auto px-6 py-16">
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-20">
          <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-teal-600"></div>
        </div>

        <!-- Empty State -->
        <div v-else-if="filteredApartments.length === 0" class="text-center py-20">
          <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          <h3 class="text-2xl font-serif text-gray-900 mb-2">Aucun appartement disponible</h3>
          <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
        </div>

        <!-- Apartments List -->
        <div v-else class="space-y-12">
          <ApartmentListItem
            v-for="(apartment, index) in filteredApartments"
            :key="apartment.id"
            :apartment="apartment"
            :index="index"
          />
        </div>
      </div>

      <!-- Equipment Section -->
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
            <div v-for="equipment in equipmentList" :key="equipment.name" class="flex flex-col items-center text-center">
              <div class="w-16 h-16 border-2 border-gray-800 rounded flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="equipment.icon"></path>
                </svg>
              </div>
              <span class="text-sm text-gray-800">{{ equipment.name }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section class="bg-[#1e3a3f] text-white py-12 md:py-20 px-6 md:px-20">
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
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-2xl text-gray-800">
              {{ service.icon }}
            </div>
            <h3 class="text-sm font-medium">{{ service.name }}</h3>
          </div>
        </div>
      </section>

      <!-- Gallery Photos Section -->
      <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto px-6 md:px-20">
          <div class="text-center mb-12">
            <h2 class="font-serif text-4xl md:text-5xl font-light text-gray-900 mb-4">
              Galerie <span class="text-primary-blue italic">photos</span>
            </h2>
            <p class="text-base text-gray-600 font-light">
              Découvrez nos appartements en images.
            </p>
          </div>

          <div class="flex flex-col lg:flex-row gap-3 max-w-7xl mx-auto">
            <!-- Large Image -->
            <div class="flex-1 lg:w-[70%] relative rounded-lg overflow-hidden h-96 lg:h-[650px]">
              <img 
                src="/images/apartments/apart1.jpg" 
                alt="Kaylia Suite Home Building" 
                class="w-full h-full object-cover"
              />
              <div class="absolute bottom-4 right-4 flex gap-2">
                <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                  <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                  </svg>
                </button>
                <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 transition">
                  <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Small Images -->
            <div class="flex flex-col gap-3 lg:w-[30%] lg:max-w-[280px]">
              <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px]">
                <img 
                  src="/images/apartments/apart2.jpg" 
                  alt="Cuisine moderne" 
                  class="w-full h-full object-cover"
                />
              </div>
              <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px] cursor-pointer group">
                <img 
                  src="/images/apartments/apart3.jpg" 
                  alt="Salon élégant" 
                  class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center group-hover:bg-opacity-70 transition">
                  <svg class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  <span class="text-white font-semibold">Voir toutes les photos</span>
                </div>
              </div>
              <div class="relative rounded-lg overflow-hidden h-40 lg:h-[210px]">
                <img 
                  src="/images/apartments/apart4.jpg" 
                  alt="Chambre confortable" 
                  class="w-full h-full object-cover"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <ApartmentFAQ />

      <!-- Newsletter Section -->
      <NewsletterSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ApartmentHero from '@/components/apartments/ApartmentHero.vue'
import ApartmentFilter from '@/components/apartments/ApartmentFilter.vue'
import ApartmentListItem from '@/components/apartments/ApartmentListItem.vue'
import ApartmentFAQ from '@/components/apartments/ApartmentFAQ.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import { useApartmentsStore } from '@/stores/apartments'

const route = useRoute()
const apartmentsStore = useApartmentsStore()

// State
const loading = ref(false)
const searchParams = ref({
  checkIn: route.query.checkIn as string || '',
  checkOut: route.query.checkOut as string || '',
  guests: route.query.guests ? parseInt(route.query.guests as string) : 0,
  priceRange: route.query.priceRange as string || ''
})

// Computed
const filteredApartments = computed(() => {
  let apartments = apartmentsStore.apartments
  
  console.log('Total apartments:', apartments.length)
  console.log('Search params:', searchParams.value)

  // Filter by guests
  if (searchParams.value.guests > 0) {
    apartments = apartments.filter(apt => apt.capacity >= searchParams.value.guests)
    console.log('After guests filter:', apartments.length)
  }

  // Filter by price range
  if (searchParams.value.priceRange) {
    const [min, max] = searchParams.value.priceRange.split('-').map(Number)
    apartments = apartments.filter(apt => apt.pricePerNight >= (min || 0) && apt.pricePerNight <= (max || Infinity))
    console.log('After price filter:', apartments.length)
  }

  // TODO: Filter by availability dates (checkIn/checkOut)
  // This would require an API call to check availability

  console.log('Final filtered apartments:', apartments.length)
  return apartments
})

// Equipment list
const equipmentList = ref([
  { name: 'Literie de luxe', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
  { name: 'Valiselles', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
  { name: 'Machine à café', icon: 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
  { name: 'Four', icon: 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z' },
  { name: 'Savon et Shampooing', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
  { name: 'Climatisation', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z' },
  { name: 'Fer à repasser', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
  { name: 'Four Micro-ondes', icon: 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
  { name: 'Bouilloire', icon: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z' },
  { name: 'TV', icon: 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
  { name: 'Lave-vaisselle', icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z' },
  { name: 'Chaise bébé', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
  { name: 'Escalier', icon: 'M13 10V3L4 14h7v7l9-11h-7z' },
  { name: 'Cuisine équipée', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
  { name: 'Réfrigérateur', icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' },
  { name: 'WiFi', icon: 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0' },
  { name: 'Machine à laver', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' }
])

// Services list
const servicesList = ref([
  { name: 'Wi-Fi haut débit', icon: '📶' },
  { name: 'Sécurité 24/7', icon: '🛡️' },
  { name: 'SPA & Bien-être', icon: '💆' },
  { name: 'Conciergerie', icon: '🔔' },
  { name: 'Cuisine Équipée', icon: '🍳' },
  { name: 'Climatisation', icon: '❄️' }
])

// Watch for query param changes
watch(() => route.query, (newQuery) => {
  searchParams.value = {
    checkIn: newQuery.checkIn as string || '',
    checkOut: newQuery.checkOut as string || '',
    guests: newQuery.guests ? parseInt(newQuery.guests as string) : 0,
    priceRange: newQuery.priceRange as string || ''
  }
}, { deep: true })

// Lifecycle
onMounted(async () => {
  loading.value = true
  try {
    await apartmentsStore.fetchApartments()
  } catch (error) {
    console.error('Failed to load apartments:', error)
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.primary-blue {
  color: #4a7c8c;
}
</style>
