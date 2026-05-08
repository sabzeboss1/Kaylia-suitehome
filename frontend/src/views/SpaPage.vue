<template>
  <DefaultLayout>
    <div class="spa-page">
      <!-- Hero Section with Gallery -->
      <SpaHero 
        :rating="4.9" 
        :review-count="17"
        @show-events="scrollToTabs('events')"
        @show-appointments="scrollToTabs('rdv')"
      />

      <!-- Tabs Section - Services and Events -->
      <section id="spa-tabs" class="section-aligned bg-white py-12 md:py-16">
        <div class="section-content">
          <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8 lg:gap-16">
            <!-- Right Column - Rating & Hours (First on mobile, second on desktop) -->
            <div class="flex flex-col lg:order-2">
              <div class="space-y-2 w-full lg:max-w-md lg:ml-auto">
                <SpaRating 
                  :overall-rating="4.9"
                  :review-count="17"
                  :rating-details="ratingDetails"
                />
                <SpaHours :opening-hours="openingHours" />
              </div>
            </div>

            <!-- Left Column - Tabs and Content (Second on mobile, first on desktop) -->
            <div class="lg:order-1">
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
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { logger } from '@/utils/logger'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import SpaHero from '@/components/spa/SpaHero.vue'
import SpaTabs from '@/components/spa/SpaTabs.vue'
import SpaServiceCard from '@/components/spa/SpaServiceCard.vue'
import SpaRating from '@/components/spa/SpaRating.vue'
import SpaHours from '@/components/spa/SpaHours.vue'
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
const carouselTrack = ref<HTMLElement | null>(null)
const currentOffset = ref(0)
const cardWidth = 320 // Width of each card + gap
const autoScrollInterval = ref<number | null>(null)
const isAutoScrollPaused = ref(false)

// Create infinite loop by tripling the reviews array
const infiniteReviews = computed(() => {
  return [...reviews.value, ...reviews.value, ...reviews.value]
})

const scrollNext = () => {
  const maxOffset = reviews.value.length * cardWidth
  currentOffset.value += cardWidth
  
  // Reset to start when reaching the end of first set
  if (currentOffset.value >= maxOffset) {
    setTimeout(() => {
      currentOffset.value = 0
    }, 500)
  }
}

const scrollPrev = () => {
  if (currentOffset.value <= 0) {
    // Jump to end of first set
    currentOffset.value = (reviews.value.length - 1) * cardWidth
  } else {
    currentOffset.value -= cardWidth
  }
}

const pauseAutoScroll = () => {
  isAutoScrollPaused.value = true
  if (autoScrollInterval.value) {
    clearInterval(autoScrollInterval.value)
    autoScrollInterval.value = null
  }
}

const resumeAutoScroll = () => {
  isAutoScrollPaused.value = false
  startAutoScroll()
}

const startAutoScroll = () => {
  if (autoScrollInterval.value) {
    clearInterval(autoScrollInterval.value)
  }
  
  autoScrollInterval.value = window.setInterval(() => {
    if (!isAutoScrollPaused.value) {
      scrollNext()
    }
  }, 3000) // Auto-scroll every 3 seconds
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

// Scroll to tabs section
const scrollToTabs = (tab: 'rdv' | 'events') => {
  activeTab.value = tab
  
  // Wait for next tick to ensure tab is changed
  setTimeout(() => {
    const tabsSection = document.getElementById('spa-tabs')
    if (tabsSection) {
      const headerOffset = 80 // Offset pour le header fixe
      const elementPosition = tabsSection.getBoundingClientRect().top
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      })
    }
  }, 100)
}

// Fetch data on mount
onMounted(async () => {
  try {
    await Promise.all([
      fetchServices(),
      fetchOpeningHours()
    ])
    
    // Start auto-scroll for reviews
    startAutoScroll()
  } catch (err) {
    logger.error('Failed to fetch spa data:', err)
    // Fallback to default data (already handled in computed properties)
  }
})

onUnmounted(() => {
  // Clean up auto-scroll interval
  if (autoScrollInterval.value) {
    clearInterval(autoScrollInterval.value)
  }
})
</script>
