<template>
  <DefaultLayout>
    <div class="w-full">
      <!-- Hero Section with Search Box -->
      <HeroSection>
        <template #search-box>
          <SearchBoxAlt @search="handleSearch" />
        </template>
      </HeroSection>

      <!-- Apartments Section -->
      <section class="section-aligned py-16 md:py-24 bg-gradient-to-b from-[#F9F8F6] to-[#F5F4F2]">
        <div class="section-content">
          <!-- Header -->
          <div class="text-center mb-12 md:mb-16">
            <h2 class="text-[32px] leading-[24px] text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
              Nos <span class="italic text-[#0b6087]" style="font-family: 'Silver Garden', serif; font-weight: 700; font-style: italic; font-size: 32px; line-height: 24px;">Appartements</span>
            </h2>
            <div class="flex justify-center px-4">
              <p class="text-[16px] md:text-[24px] leading-[24px] text-gray-700 text-center" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
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

            <!-- Navigation Buttons -->
            <button
              v-if="currentSlide > 0"
              @click="scrollPrev"
              class="absolute left-2 md:-left-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-[0_4px_12px_rgba(0,0,0,0.15)] flex items-center justify-center hover:shadow-[0_6px_16px_rgba(0,0,0,0.2)] transition-all duration-300 z-10 group"
              aria-label="Appartement précédent"
            >
              <svg 
                class="w-4 h-4 md:w-5 md:h-5 text-gray-700 group-hover:text-[#0D9488] transition-colors" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>

            <button
              v-if="currentSlide < featuredApartments.length - 1"
              @click="scrollNext"
              class="absolute right-2 md:-right-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-[0_4px_12px_rgba(0,0,0,0.15)] flex items-center justify-center hover:shadow-[0_6px_16px_rgba(0,0,0,0.2)] transition-all duration-300 z-10 group"
              aria-label="Appartement suivant"
            >
              <svg 
                class="w-4 h-4 md:w-5 md:h-5 text-gray-700 group-hover:text-[#0D9488] transition-colors" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
              </svg>
            </button>

            <!-- Dots Navigation -->
            <div class="flex justify-center gap-2 mt-6 md:hidden">
              <button
                v-for="(apartment, index) in featuredApartments"
                :key="apartment.id"
                @click="scrollToSlide(index)"
                class="transition-all duration-300"
                :class="[
                  currentSlide === index 
                    ? 'w-8 h-2 bg-[#0b6087] rounded-full' 
                    : 'w-2 h-2 bg-gray-300 rounded-full hover:bg-gray-400'
                ]"
                :aria-label="`Aller à l'appartement ${index + 1}`"
              />
            </div>

            <!-- Scroll Hint (visible uniquement au chargement sur mobile) -->
            <div 
              v-if="showScrollHint && currentSlide === 0"
              class="md:hidden absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none animate-bounce"
            >
              <div class="bg-[#0b6087] text-white px-3 py-2 rounded-lg shadow-lg text-sm flex items-center gap-2">
                <span>Glissez</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Spa Section -->
      <SpaSection />

      <!-- Services Section -->
      <ServicesSection />

      <!-- Reviews Section -->
      <ReviewsSection />

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
import SearchBoxAlt from '@/components/home/SearchBoxAlt.vue'
import ApartmentCard from '@/components/home/ApartmentCard.vue'
import SpaSection from '@/components/home/SpaSection.vue'
import ServicesSection from '@/components/home/ServicesSection.vue'
import ReviewsSection from '@/components/home/ReviewsSection.vue'
import LocationSection from '@/components/home/LocationSection.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import SocialSection from '@/components/home/SocialSection.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import { useApartments } from '@/composables/useApartments'
import { useSEO } from '@/composables/useSEO'

const { apartments, loading, error, fetchApartments } = useApartments()
const { setMetaTags, setStructuredData, getOrganizationSchema } = useSEO()

const featuredApartments = ref<any[]>([])
const carouselContainer = ref<HTMLElement | null>(null)
const currentSlide = ref(0)
const showScrollHint = ref(true)

const handleSearch = (params: any) => {
  console.log('Search params:', params)
  // Search handling is done by SearchBox component navigation
}

const scrollNext = () => {
  if (carouselContainer.value) {
    const scrollAmount = carouselContainer.value.offsetWidth
    carouselContainer.value.scrollBy({ left: scrollAmount, behavior: 'smooth' })
  }
}

const scrollPrev = () => {
  if (carouselContainer.value) {
    const scrollAmount = carouselContainer.value.offsetWidth
    carouselContainer.value.scrollBy({ left: -scrollAmount, behavior: 'smooth' })
  }
}

const scrollToSlide = (index: number) => {
  if (carouselContainer.value) {
    const scrollAmount = carouselContainer.value.offsetWidth * index
    carouselContainer.value.scrollTo({ left: scrollAmount, behavior: 'smooth' })
  }
}

const handleScroll = () => {
  if (carouselContainer.value) {
    const scrollLeft = carouselContainer.value.scrollLeft
    const containerWidth = carouselContainer.value.offsetWidth
    const newSlide = Math.round(scrollLeft / containerWidth)
    currentSlide.value = newSlide
    
    // Masquer l'indicateur de scroll après la première interaction
    if (scrollLeft > 0) {
      showScrollHint.value = false
    }
  }
}

// Masquer l'indicateur de scroll après 3 secondes
setTimeout(() => {
  showScrollHint.value = false
}, 3000)

onMounted(async () => {
  // SEO Meta Tags
  setMetaTags({
    title: 'Kaylia Suite Home - Appartements de Luxe & SPA à Yaoundé',
    description: 'Découvrez nos appartements de standing et notre SPA exclusif à Yaoundé. Confort, élégance et services premium pour un séjour inoubliable au Cameroun.',
    keywords: 'appartement luxe Yaoundé, location appartement Yaoundé, SPA Yaoundé, hébergement haut standing Cameroun, suite luxe Yaoundé',
    type: 'website',
    image: `${import.meta.env.VITE_APP_URL || 'https://kayliasuitehome.com'}/images/og-home.jpg`
  })

  // Structured Data
  setStructuredData(getOrganizationSchema())

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
