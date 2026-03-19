<template>
  <DefaultLayout>
    <div class="home-page">
      <!-- Hero Section with Search Box -->
      <HeroSection>
        <template #search-box>
          <SearchBox @search="handleSearch" />
        </template>
      </HeroSection>

      <!-- Apartments Section -->
      <section class="py-16 md:py-24 px-6 md:px-12 lg:px-20 bg-gradient-to-b from-[#F9F8F6] to-[#F5F4F2]">
        <div class="max-w-7xl mx-auto">
          <!-- Header -->
          <div class="text-center mb-12 md:mb-16">
            <h2 class="text-[32px] leading-[24px] text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
              Nos <span class="italic text-[#0b6087]" style="font-family: 'Silver Garden', serif; font-weight: 700; font-style: italic; font-size: 32px; line-height: 24px;">Appartements</span>
            </h2>
            <div class="flex justify-center">
              <p class="text-[24px] leading-[24px] text-gray-700 whitespace-nowrap" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
                Découvrez nos appartements de standing conçus pour votre confort et votre bien-être.
              </p>
            </div>
          </div>

          <!-- Loading State -->
          <div v-if="loading" class="text-center py-12">
            <LoadingSpinner />
          </div>

          <!-- Error State -->
          <div v-else-if="error" class="text-center py-12 text-red-600">
            {{ error }}
          </div>

          <!-- Apartments Carousel -->
          <div v-else class="relative">
            <div 
              ref="carouselContainer"
              class="flex gap-6 overflow-x-auto scroll-smooth pb-4 scrollbar-hide snap-x snap-mandatory"
              @scroll="handleScroll"
            >
              <div 
                v-for="apartment in featuredApartments" 
                :key="apartment.id"
                class="flex-shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] snap-start"
              >
                <ApartmentCard :apartment="apartment" />
              </div>
            </div>

            <!-- Navigation Button (Right) -->
            <button
              v-if="showNavButton"
              @click="scrollNext"
              class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-[0_4px_12px_rgba(0,0,0,0.15)] items-center justify-center hover:shadow-[0_6px_16px_rgba(0,0,0,0.2)] transition-all duration-300 z-10 group"
              aria-label="Appartement suivant"
            >
              <svg 
                class="w-5 h-5 text-gray-700 group-hover:text-[#0D9488] transition-colors" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </div>
      </section>

      <!-- Spa Section -->
      <SpaSection />

      <!-- Services Section -->
      <ServicesSection />

      <!-- Location Section -->
      <LocationSection />

      <!-- Newsletter Section -->
      <NewsletterSection />

      <!-- Reservation Banner -->
      <ReservationBanner />

      <!-- Social Section -->
      <SocialSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import HeroSection from '@/components/home/HeroSection.vue'
import SearchBox from '@/components/home/SearchBox.vue'
import ApartmentCard from '@/components/home/ApartmentCard.vue'
import SpaSection from '@/components/home/SpaSection.vue'
import ServicesSection from '@/components/home/ServicesSection.vue'
import LocationSection from '@/components/home/LocationSection.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import SocialSection from '@/components/home/SocialSection.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import { useApartments } from '@/composables/useApartments'

const { apartments, loading, error, fetchApartments } = useApartments()

const featuredApartments = ref<any[]>([])
const carouselContainer = ref<HTMLElement | null>(null)
const showNavButton = computed(() => featuredApartments.value.length > 3)

const handleSearch = (params: any) => {
  console.log('Search params:', params)
  // Search handling is done by SearchBox component navigation
}

const scrollNext = () => {
  if (carouselContainer.value) {
    const scrollAmount = carouselContainer.value.offsetWidth * 0.8
    carouselContainer.value.scrollBy({ left: scrollAmount, behavior: 'smooth' })
  }
}

const handleScroll = () => {
  // Optional: Add scroll position tracking for multiple navigation buttons
}

onMounted(async () => {
  try {
    await fetchApartments()
    // Get first 3 apartments as featured
    featuredApartments.value = apartments.value.slice(0, 3)
  } catch (e) {
    console.error('Failed to load apartments:', e)
  }
})
</script>

<style scoped>
/* Hide scrollbar but keep functionality */
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
