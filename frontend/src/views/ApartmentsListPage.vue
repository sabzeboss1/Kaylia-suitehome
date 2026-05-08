<template>
  <DefaultLayout>
    <div class="apartments-list-page bg-[#f9f9f9] min-h-screen">
      <!-- Hero Section -->
      <section 
        class="relative h-[45vh] md:h-[55vh] bg-cover bg-center flex items-center hero-section pt-[62px] md:pt-20"
      >
        <div class="max-w-7xl mx-auto px-8 w-full">
          <h1 class="text-white text-2xl md:text-[40px] md:leading-[48px] font-medium leading-tight max-w-3xl" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
            Des appartements de haut standing pour rendre votre séjour inoubliable !
          </h1>
        </div>
      </section>

      <!-- Image Carousel Section - Random images from gallery -->
      <ImageCarousel 
        v-if="!loading && carouselImages.length > 0"
        :images="carouselImages"
        :show-controls="true"
        bg-class="bg-[#D2C8BC]"
      />

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

      <!-- Global Section: Carousel + Info + Button (Only once, not per apartment) -->
      <div v-else>
        <!-- Apartments List -->
        <div id="appartements" class="py-12 md:py-16">
        <div 
          v-for="(apartment, index) in apartments" 
          :key="apartment.id"
          class="mb-16 last:mb-0"
        >
          <!-- Mobile Layout - Simplified -->
          <div class="md:hidden bg-white rounded-2xl shadow-lg overflow-hidden mx-4">
            <!-- Title -->
            <div class="text-center py-4 px-6 border-b border-gray-200">
              <h2 class="text-xl font-semibold text-gray-900">
                {{ apartment.name }}
              </h2>
            </div>

            <!-- Image Carousel -->
            <div class="relative bg-gray-100">
              <img 
                :src="getApartmentImages(apartment)[currentSlides[index] || 0]" 
                :alt="`${apartment.name} - Image ${(currentSlides[index] || 0) + 1}`"
                class="w-full h-[250px] object-cover"
              />
              
              <!-- Navigation Arrows -->
              <div v-if="getApartmentImages(apartment).length > 1" class="absolute inset-0 flex items-center justify-between px-3 pointer-events-none">
                <button 
                  @click="previousSlide(index)"
                  class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition active:scale-95 pointer-events-auto"
                  aria-label="Image précédente"
                >
                  <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                  </svg>
                </button>
                <button 
                  @click="nextSlide(index)"
                  class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition active:scale-95 pointer-events-auto"
                  aria-label="Image suivante"
                >
                  <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Features - Horizontal -->
            <div class="flex justify-center items-center gap-4 py-4 px-4 border-b border-gray-200 flex-wrap">
              <!-- Capacity -->
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                  <img :src="`${backendUrl}/images/equipements/Personne.ico`" alt="Capacité" class="w-4 h-4 object-contain" />
                </div>
                <span class="text-xs text-gray-700">{{ apartment.capacity }} pers.</span>
              </div>

              <!-- Surface -->
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                  <img :src="`${backendUrl}/images/equipements/Maison.ico`" alt="Surface" class="w-4 h-4 object-contain" />
                </div>
                <span class="text-xs text-gray-700">{{ apartment.surface }}m²</span>
              </div>

              <!-- Beds -->
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                  <img :src="`${backendUrl}/images/equipements/Group 1779.ico`" alt="Lits" class="w-4 h-4 object-contain" />
                </div>
                <span class="text-xs text-gray-700">{{ getBedDescription(apartment) }}</span>
              </div>
            </div>

            <!-- Reserve Button -->
            <div class="p-6">
              <button 
                @click="handleReserve(apartment)"
                class="w-full bg-[#0b6087] hover:bg-[#094d6b] text-white font-medium px-6 py-3 rounded-lg transition-all duration-300 active:scale-95"
              >
                Réserver
              </button>
            </div>
          </div>

          <!-- Desktop Layout -->
          <div class="hidden md:block w-full">
            <!-- Title Section -->
            <div class="text-center mb-8 px-6">
              <h2 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Appartement <span class="italic text-[#0B6087]" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">{{ apartment.name || apartment.id }}</span>
              </h2>
              <p class="text-[24px] leading-[24px] font-light text-gray-500" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">{{ apartment.description || 'Découvrez le studio' }}</p>
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
                    <img :src="`${backendUrl}/images/equipements/Personne.ico`" alt="Capacité" class="w-5 h-5 object-contain" />
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.capacity }} personnes</span>
                </div>

                <!-- Surface -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <img :src="`${backendUrl}/images/equipements/Maison.ico`" alt="Surface" class="w-5 h-5 object-contain" />
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.surface }}m²</span>
                </div>

                <!-- Bed -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <img :src="`${backendUrl}/images/equipements/Group 1779.ico`" alt="Lits" class="w-5 h-5 object-contain" />
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ getBedDescription(apartment) }}</span>
                </div>

                <!-- Floor -->
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 border-2 border-gray-800 rounded flex items-center justify-center flex-shrink-0">
                    <img :src="`${backendUrl}/images/equipements/Escalier.ico`" alt="Étage" class="w-5 h-5 object-contain" />
                  </div>
                  <span class="text-sm font-medium text-gray-800">{{ apartment.floor || '2er étage' }}</span>
                </div>
              </div>

              <!-- Price and Button - Combined block -->
              <div class="flex items-stretch overflow-hidden rounded-lg shadow-md">
                <!-- Price Badge - Left side -->
                <div class="bg-[#b39a85] text-white px-6 py-3 flex items-center">
                  <p class="text-sm font-medium whitespace-nowrap">À partir de {{ apartment.pricePerNight }}€</p>
                </div>
                <!-- Reserve Button - Right side -->
                <button 
                  @click="handleReserve(apartment)"
                  class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-6 py-3 font-medium transition flex items-center"
                >
                  Réserver
                </button>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Description and FAQ Section -->
      <section class="bg-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            <!-- Left Column - Description & Video (60%) -->
            <div class="lg:col-span-7">
              <StudioDescription 
                :title="descriptionData.title"
                :description="descriptionData.description"
                :video-url="descriptionData.videoUrl"
              />
            </div>

            <!-- Right Column - FAQ (40%) -->
            <div class="lg:col-span-5 lg:ml-auto max-w-lg">
              <StudioFAQ :items="faqItems" />
            </div>
          </div>
        </div>
      </section>

      <!-- Equipment Section -->
      <EquipmentSection section-id="équipements" />

      <!-- Services Section -->
      <section class="bg-[#22333b] text-white py-12 md:py-20 full-width-aligned">
        <div class="text-center mb-12 md:mb-16">
          <h2 class="text-[32px] leading-[24px] font-semibold text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
            Nos <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Services</span>
          </h2>
          <p class="text-base leading-6 md:text-[24px] md:leading-[24px] text-gray-300 mx-auto max-w-xs md:max-w-none md:whitespace-nowrap" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; letter-spacing: 0;">
            Profitez d'un séjour sans compromis avec nos services premium conçu pour votre confort.
          </p>
        </div>

        <div class="grid grid-cols-3 gap-6 md:gap-12 max-w-4xl mx-auto">
          <div 
            v-for="(service, index) in services" 
            :key="index"
            class="text-center"
          >
            <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full mx-auto mb-3 md:mb-4 flex items-center justify-center p-4 md:p-5">
              <img 
                :src="service.icon" 
                :alt="service.name"
                class="w-8 h-8 md:w-10 md:h-10 object-contain"
              />
            </div>
            <h3 class="text-[8px] leading-[100%] md:text-[16px] md:leading-[100%] font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600; letter-spacing: 0;">{{ service.name }}</h3>
            <div class="w-12 h-[2px] bg-[#A8927D] mx-auto mt-6"></div>
          </div>
        </div>
      </section>

      <!-- Reservation Banner -->
      <ReservationBanner />

      <!-- Newsletter Section -->
      <ApartmentsNewsletter />
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { logger } from '@/utils/logger'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import EquipmentSection from '@/components/common/EquipmentSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import ApartmentsNewsletter from '@/components/apartments/ApartmentsNewsletter.vue'
import ImageCarousel from '@/components/common/ImageCarousel.vue'
import StudioDescription from '@/components/studio/StudioDescription.vue'
import StudioFAQ from '@/components/studio/StudioFAQ.vue'
import { useApartmentsStore } from '@/stores/apartments'
import { useBookingStore } from '@/stores/booking'
import { useSEO } from '@/composables/useSEO'
import type { Apartment } from '@/stores/apartments'

const apartmentsStore = useApartmentsStore()
const bookingStore = useBookingStore()
const router = useRouter()
const route = useRoute()
const { setMetaTags, setStructuredData, getBreadcrumbSchema } = useSEO()

// Backend URL
const backendUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'

// State
const loading = ref(false)
const currentSlides = ref<number[]>([])

// Computed - all apartments
const apartments = computed(() => apartmentsStore.apartments)

// Carousel images - random selection from all apartment images
const carouselImages = computed(() => {
  if (apartments.value.length === 0) {
    return []
  }

  const images: Array<{ url: string; alt: string }> = []
  const backendUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'
  
  // Collecter toutes les images de tous les appartements
  for (const apartment of apartments.value) {
    if (apartment.images && apartment.images.length > 0) {
      for (const image of apartment.images) {
        let imageUrl: string
        
        // Handle string URLs
        if (typeof image === 'string') {
          imageUrl = image
        } else {
          // Handle image objects
          imageUrl = image.image_url || image.url || ''
        }
        
        if (!imageUrl) continue
        
        const fullUrl = imageUrl.startsWith('http') ? imageUrl : `${backendUrl}${imageUrl}`
        
        images.push({
          url: fullUrl,
          alt: `${apartment.name} - Photo`
        })
      }
    }
  }

  // Mélanger les images de manière aléatoire
  const shuffled = images.sort(() => Math.random() - 0.5)
  
  // Retourner 10-12 images pour le carrousel
  return shuffled.slice(0, 12)
})

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

// Carousel navigation
const nextSlide = (apartmentIndex: number) => {
  const apartment = apartments.value[apartmentIndex]
  if (!apartment) return
  
  const images = getApartmentImages(apartment)
  
  // Pour mobile: navigation image par image
  if (window.innerWidth < 768) {
    if (currentSlides.value[apartmentIndex] !== undefined && currentSlides.value[apartmentIndex] < images.length - 1) {
      currentSlides.value[apartmentIndex]++
    }
  } else {
    // Pour desktop: slide par 3 images
    const maxSlides = Math.max(0, images.length - 3)
    if (currentSlides.value[apartmentIndex] !== undefined && currentSlides.value[apartmentIndex] < maxSlides) {
      currentSlides.value[apartmentIndex]++
    }
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
  { name: 'Wi-Fi haut débit', icon: `${backendUrl}/images/equipements/Wifi.ico` },
  { name: 'Sécurité 24/7', icon: `${backendUrl}/images/equipements/Sécurité.ico` },
  { name: 'SPA & Bien-être', icon: `${backendUrl}/images/equipements/SPA.ico` },
  { name: 'Conciergerie', icon: `${backendUrl}/images/equipements/Conciergerie.ico` },
  { name: 'Cuisine Équipée', icon: `${backendUrl}/images/equipements/Cuisine équipée.ico` },
  { name: 'Climatisation', icon: `${backendUrl}/images/equipements/Climatisation.ico` }
])

// Description data
const descriptionData = ref({
  title: 'Des appartements pensés pour\nvotre confort',
  description: 'Nos appartements de standing offrent un cadre exceptionnel pour votre séjour à Yaoundé. Chaque espace a été conçu avec soin pour allier élégance, confort et fonctionnalité. Profitez d\'équipements haut de gamme, d\'une décoration raffinée et de services premium pour un séjour inoubliable.',
  videoUrl: undefined as string | undefined
})

// FAQ items
const faqItems = ref([
  {
    question: 'Comment accéder à mon appartement le jour de mon arrivée ?',
    answer: 'Vous recevrez toutes les instructions d\'accès par email 24h avant votre arrivée. Un code d\'accès personnel vous sera fourni pour entrer dans la résidence et votre appartement.'
  },
  {
    question: 'Le ménage est-il fait tous les jours ?',
    answer: 'Le ménage est effectué avant votre arrivée et après votre départ. Pour les séjours de plus de 7 jours, un service de ménage hebdomadaire est inclus.'
  },
  {
    question: 'Y a-t-il une bagagerie dans la résidence ?',
    answer: 'Oui, nous disposons d\'une bagagerie sécurisée gratuite. Vous pouvez déposer vos bagages avant le check-in ou après le check-out.'
  },
  {
    question: 'Peut-on arriver avant 15h ?',
    answer: 'Le check-in standard est à partir de 15h. Un early check-in peut être possible selon la disponibilité de l\'appartement, moyennant un supplément.'
  },
  {
    question: 'Peut-on partir après 10h ?',
    answer: 'Le check-out standard est à 10h. Un late check-out peut être organisé selon la disponibilité, moyennant un supplément.'
  },
  {
    question: 'Y-a-t-il une personne sur place 24h/24 ?',
    answer: 'Oui, notre service de sécurité est présent 24h/24 et 7j/7. Notre équipe de conciergerie est également joignable à tout moment.'
  },
  {
    question: 'Est-ce que la résidence dispose de la climatisation ?',
    answer: 'Oui, tous nos appartements sont équipés de la climatisation réversible pour votre confort optimal.'
  },
  {
    question: 'Y-a-t-il un ascenseur dans l\'immeuble ?',
    answer: 'Oui, la résidence dispose d\'un ascenseur moderne et spacieux pour faciliter l\'accès à tous les étages.'
  }
])

// Fetch apartments data
onMounted(async () => {
  // SEO Meta Tags
  setMetaTags({
    title: 'Nos Appartements de Luxe - Kaylia Suite Home Yaoundé',
    description: 'Découvrez notre collection d\'appartements haut standing à Yaoundé. Studios et appartements équipés, climatisés avec services premium. Réservez votre séjour dès maintenant.',
    keywords: 'appartements Yaoundé, location meublée Yaoundé, studio luxe Cameroun, hébergement Yaoundé centre-ville',
    type: 'website'
  })

  // Breadcrumb structured data
  setStructuredData(getBreadcrumbSchema([
    { name: 'Accueil', url: '/' },
    { name: 'Nos Appartements', url: '/nos-appartements' }
  ]))

  loading.value = true
  try {
    await apartmentsStore.fetchApartments()
    
    // Initialize current slides for each apartment
    currentSlides.value = new Array(apartments.value.length).fill(0)
  } catch (error) {
    logger.error('Failed to load apartments:', error)
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
  background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), 
                    url('/images/apartments/hero.jpg');
  background-size: cover;
  background-position: center;
}
</style>
