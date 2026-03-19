<template>
  <DefaultLayout>
    <div class="spa-page">
      <!-- Hero Section with Gallery -->
      <SpaHero 
        :rating="4.9" 
        :review-count="17"
        @show-events="activeTab = 'events'"
        @show-appointments="activeTab = 'rdv'"
      />

      <!-- Tabs Section - Services and Events -->
      <section class="bg-white py-12 md:py-16">
        <div class="container mx-auto px-6 md:px-20">
          <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-16">
            <!-- Left Column - Tabs and Content -->
            <div>
              <SpaTabs :default-tab="activeTab" @tab-change="handleTabChange">
                <!-- Prendre RDV Tab Content -->
                <template #rdv>
                  <div v-if="loading" class="flex justify-center py-12">
                    <LoadingSpinner />
                  </div>
                  <div v-else-if="error" class="text-center py-12 text-red-600">
                    {{ error }}
                  </div>
                  <div v-else class="space-y-4">
                    <SpaServiceCard 
                      v-for="service in appointmentServices" 
                      :key="service.id"
                      :service="service"
                    />
                  </div>
                </template>

                <!-- Évènements Tab Content -->
                <template #events>
                  <div v-if="loading" class="flex justify-center py-12">
                    <LoadingSpinner />
                  </div>
                  <div v-else-if="error" class="text-center py-12 text-red-600">
                    {{ error }}
                  </div>
                  <div v-else class="space-y-4">
                    <SpaServiceCard 
                      v-for="service in eventServices" 
                      :key="service.id"
                      :service="service"
                    />
                  </div>
                </template>
              </SpaTabs>
            </div>

            <!-- Right Column - Rating & Hours -->
            <div class="flex flex-col">
              <div class="space-y-4 max-w-md ml-auto">
                <SpaRating 
                  :overall-rating="4.9"
                  :review-count="17"
                  :rating-details="ratingDetails"
                />
                <SpaHours :opening-hours="openingHours" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Reviews Section -->
      <section class="bg-[#b8a088] py-12 md:py-16">
        <div class="container mx-auto px-6 md:px-20">
          <!-- Title -->
          <div class="text-center mb-12">
            <h2 class="text-[32px] leading-[24px] font-semibold text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
              Avis <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">clients</span>
            </h2>
            <p class="text-[16px] leading-[24px] font-light text-white" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
              Nos clients ont aussi profité du SPA. Votre satisfaction est notre principale préoccupation.
            </p>
          </div>

          <!-- Reviews Grid -->
          <div class="relative max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
              <ReviewCard 
                v-for="review in displayedReviews" 
                :key="review.id"
                :review="review"
              />
            </div>

            <!-- Navigation Arrows -->
            <div class="flex justify-center gap-3">
              <button 
                @click="previousReviews"
                :disabled="currentReviewPage === 0"
                class="w-12 h-12 bg-primary-blue hover:bg-[#086780] text-white rounded-full flex items-center justify-center transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
              </button>
              <button 
                @click="nextReviews"
                :disabled="currentReviewPage >= Math.ceil(reviews.length / reviewsPerPage) - 1"
                class="w-12 h-12 bg-primary-blue hover:bg-[#086780] text-white rounded-full flex items-center justify-center transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Newsletter Section -->
      <NewsletterSection />

      <!-- Instagram Section -->
      <SocialSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import SpaHero from '@/components/spa/SpaHero.vue'
import SpaTabs from '@/components/spa/SpaTabs.vue'
import SpaServiceCard from '@/components/spa/SpaServiceCard.vue'
import SpaRating from '@/components/spa/SpaRating.vue'
import SpaHours from '@/components/spa/SpaHours.vue'
import ReviewCard from '@/components/spa/ReviewCard.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import SocialSection from '@/components/home/SocialSection.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import { useSpa } from '@/composables/useSpa'

// Active tab state
const activeTab = ref<'rdv' | 'events'>('rdv')

// Spa data from composable
const { services, openingHours: apiOpeningHours, loading, error, fetchServices, fetchOpeningHours } = useSpa()

// Gallery images
const galleryImages = ref([
  'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1200&q=80',
  'https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=600&q=80',
  'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&q=80',
  'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=600&q=80'
])

// Rating details
const ratingDetails = ref([
  { label: 'Accueil', score: 4.9 },
  { label: 'Propreté', score: 4.9 },
  { label: 'Cadre & Ambiance', score: 4.9 },
  { label: 'Qualité de la prestation', score: 5.0 }
])

// Default opening hours (fallback if API fails)
const defaultOpeningHours = [
  { dayOfWeek: 'Lundi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Mardi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Mercredi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Jeudi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Vendredi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Samedi', openTime: '10:00', closeTime: '20:00', isClosed: false },
  { dayOfWeek: 'Dimanche', openTime: '10:00', closeTime: '17:00', isClosed: false }
]

// Default services (fallback if API fails)
const defaultServices = [
  {
    id: 1,
    name: 'Spa - 1h Non Privatisé',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 10.00,
    duration: 60,
    category: 'appointment' as const
  },
  {
    id: 2,
    name: 'Spa - 2h Non Privatisé',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 20.00,
    duration: 120,
    category: 'appointment' as const
  },
  {
    id: 3,
    name: 'Spa - 1h Non Privatisé en Duo',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 30.00,
    duration: 60,
    category: 'appointment' as const
  },
  {
    id: 4,
    name: 'Spa - 2h Non Privatisé en Duo',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 50.00,
    duration: 120,
    category: 'appointment' as const
  },
  {
    id: 5,
    name: 'Spa - 2h Privatisé - Anniversaire 5-10 personnes',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 70.00,
    duration: 120,
    category: 'event' as const
  },
  {
    id: 6,
    name: 'Spa - 2h Privatisé - Pack Romance',
    subtitle: 'Une bouteille de champagne et un panier gourmand (fruits & spécialités artisanales)',
    description: 'Cette prestation ne peut pas être réservée en ligne. Merci de nous contacter sur WhatsApp au : +237 000 000 000',
    price: 60.00,
    duration: 120,
    category: 'event' as const
  }
]

// Mock reviews data
const reviews = ref([
  {
    id: 1,
    rating: 4.9,
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '2025-10-24'
  },
  {
    id: 2,
    rating: 4.9,
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '2025-10-24'
  },
  {
    id: 3,
    rating: 4.9,
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '2025-10-24'
  },
  {
    id: 4,
    rating: 4.9,
    comment: 'Prise en charge rapide, chaleureuse et bienveillante, prestation à la hauteur des attentes pour une première expérience chez Kaylia Suite Home',
    date: '2025-10-24'
  },
  {
    id: 5,
    rating: 5.0,
    comment: 'Excellent service et cadre magnifique. Une expérience inoubliable!',
    date: '2025-10-20'
  },
  {
    id: 6,
    rating: 4.8,
    comment: 'Très bonne prestation, personnel accueillant et professionnel.',
    date: '2025-10-18'
  }
])

// Reviews pagination
const currentReviewPage = ref(0)
const reviewsPerPage = 4

const displayedReviews = computed(() => {
  const start = currentReviewPage.value * reviewsPerPage
  return reviews.value.slice(start, start + reviewsPerPage)
})

const nextReviews = () => {
  if (currentReviewPage.value < Math.ceil(reviews.value.length / reviewsPerPage) - 1) {
    currentReviewPage.value++
  }
}

const previousReviews = () => {
  if (currentReviewPage.value > 0) {
    currentReviewPage.value--
  }
}

// Computed properties for services
const appointmentServices = computed(() => {
  if (services.value.length > 0) {
    return services.value.filter(s => s.category === 'appointment')
  }
  return defaultServices.filter(s => s.category === 'appointment')
})

const eventServices = computed(() => {
  if (services.value.length > 0) {
    return services.value.filter(s => s.category === 'event')
  }
  return defaultServices.filter(s => s.category === 'event')
})

// Computed property for opening hours
const openingHours = computed(() => {
  return apiOpeningHours.value.length > 0 ? apiOpeningHours.value : defaultOpeningHours
})

// Tab change handler
const handleTabChange = (tab: 'rdv' | 'events') => {
  activeTab.value = tab
}

// Fetch data on mount
onMounted(async () => {
  try {
    await Promise.all([
      fetchServices(),
      fetchOpeningHours()
    ])
  } catch (err) {
    console.error('Failed to fetch spa data:', err)
    // Fallback to default data (already handled in computed properties)
  }
})
</script>
