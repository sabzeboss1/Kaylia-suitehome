<template>
  <DefaultLayout>
    <!-- Message de redirection si aucun appartement sélectionné -->
    <div v-if="!apartment" class="min-h-screen flex items-center justify-center bg-gray-50">
      <div class="max-w-md w-full mx-auto px-6 py-12 text-center">
        <div class="mb-6">
          <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-serif text-gray-900 mb-3">Aucun appartement sélectionné</h2>
        <p class="text-gray-600 mb-6">
          Vous devez d'abord choisir un appartement avant de pouvoir réserver.
        </p>
        <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-6">
          <svg class="animate-spin h-5 w-5 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span>Redirection vers nos appartements...</span>
        </div>
        <button 
          @click="router.push({ name: 'apartments-list' })"
          class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition"
        >
          Voir nos appartements
          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Contenu normal de la page si un appartement est sélectionné -->
    <template v-else>
    <!-- Booking Hero Section -->
    <BookingHero
      :current-step="1"
      :images="apartmentImages"
      :capacity="apartment?.capacity || 4"
      :surface="apartment?.surface || 40"
      :beds="apartment?.beds || []"
      :floor="apartment?.floor || '4e étage'"
    />

    <!-- Main Content Section -->
    <section class="bg-white py-12 md:py-16 overflow-x-hidden">
      <div class="container-aligned">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-8 lg:items-start lg:justify-between">
          <!-- Left Column - Apartment Details (order-2 on mobile, order-1 on desktop) -->
          <div class="w-full lg:w-[650px] xl:w-[700px] space-y-12 order-2 lg:order-1">
            <!-- 1. Description -->
            <div>
              <h2 class="text-3xl font-semibold text-gray-800 mb-4">
                {{ apartment?.name || 'Appartement X' }}
              </h2>
              <p class="text-base text-gray-600 leading-relaxed max-w-3xl">
                {{ apartment?.description || defaultDescription }}
              </p>
            </div>

            <!-- 2. Les équipements -->
            <BookingEquipmentList :equipment="apartment?.equipment || []" />

            <!-- 3. Autour de vous -->
            <div v-if="nearbyAttractions.length > 0">
              <h3 class="text-2xl font-semibold text-gray-800 mb-6">
                Autour de vous
              </h3>
              <ul class="space-y-3 max-w-2xl">
                <li
                  v-for="(attraction, index) in nearbyAttractions"
                  :key="index"
                  class="flex items-start gap-3 text-base text-gray-600"
                >
                  <span class="text-gray-400 mt-1">•</span>
                  <span>{{ attraction }}</span>
                </li>
              </ul>
            </div>

            <!-- 4. Vidéo -->
            <div v-if="apartmentVideoUrl">
              <h3 class="text-2xl font-semibold text-gray-800 mb-6">Vidéo</h3>
              <div class="rounded-xl overflow-hidden aspect-video shadow-lg">
                <!-- YouTube -->
                <iframe
                  v-if="isYouTubeUrl(apartmentVideoUrl)"
                  :src="getYouTubeEmbedUrl(apartmentVideoUrl)"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                  class="w-full h-full"
                  title="Vidéo de présentation de l'appartement"
                ></iframe>
                
                <!-- Vimeo -->
                <iframe
                  v-else-if="isVimeoUrl(apartmentVideoUrl)"
                  :src="getVimeoEmbedUrl(apartmentVideoUrl)"
                  frameborder="0"
                  allow="autoplay; fullscreen; picture-in-picture"
                  allowfullscreen
                  class="w-full h-full"
                  title="Vidéo de présentation de l'appartement"
                ></iframe>
                
                <!-- Direct Video -->
                <video
                  v-else-if="isDirectVideoUrl(apartmentVideoUrl)"
                  :src="apartmentVideoUrl"
                  controls
                  class="w-full h-full bg-black"
                >
                  Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                
                <!-- Fallback -->
                <div v-else class="bg-gray-100 flex items-center justify-center h-full">
                  <div class="text-center p-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Format de vidéo non supporté</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column - Booking Panel (order-1 on mobile, order-2 on desktop) -->
          <div class="w-full lg:w-[380px] xl:w-[400px] lg:flex-shrink-0 order-1 lg:order-2">
            <BookingPanel
              :apartment-name="apartment?.name || 'Appartement X'"
              :check-in="checkIn"
              :check-out="checkOut"
              :max-capacity="apartment?.capacity || 4"
              :comfort-options="comfortOptions"
              :wine-options="wineOptions"
              :rates="rates"
              :base-price="apartment?.pricePerNight || apartment?.price_per_night || 192"
              :promo-message="promoMessage"
              :promo-message-type="promoMessageType"
              :promo-discount="bookingStore.promoCodeDiscount"
              @next="handleNext"
              @update:guests="handleGuestsUpdate"
              @update:selected-options="handleOptionsUpdate"
              @update:selected-rate="handleRateUpdate"
              @update:dates="handleDatesUpdate"
              @apply-promo="handlePromoCode"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Promotional Section -->
    <section class="bg-[#b8a088] py-16 md:py-20">
      <div class="container-aligned text-center">
        <h2 
          class="text-[28px] md:text-[40px] text-[#3d3d3d]" 
          style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.3; letter-spacing: 0px; text-align: center;"
        >
          Réserver chez nous c'est la garantis d'un <span class="italic text-white" style="font-family: 'Playfair Display', serif; font-style: italic;">service personnalisé</span> et des <span class="italic text-white" style="font-family: 'Playfair Display', serif; font-style: italic;">tarifs avantageux.</span>
        </h2>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-[#fafafa] py-16 md:py-20">
      <div class="container-aligned text-center">
        <!-- Titre avec newsletter en couleur et police différente - UNE SEULE LIGNE -->
        <h2 
          class="text-[32px] text-[#1a1a1a] whitespace-nowrap" 
          style="font-family: 'Poppins', sans-serif; font-weight: 600; line-height: 32px; letter-spacing: 0px; text-align: center;"
        >
          Inscrivez-vous à notre <span class="text-[#0B6087]" style="font-family: 'Silver Garden', cursive; font-weight: 700;">newsletter</span> et recevez nos codes promos
        </h2>
        
        <!-- Sous-titre -->
        <p class="text-[18px] md:text-[20px] leading-relaxed font-light text-[#4a4a4a] mb-10 mt-4">
          Recevez des offres exclusives et restez informé de nos actualités.
        </p>

        <!-- Newsletter Form - Flexbox horizontal sur desktop -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-stretch mb-6">
          <input
            type="email"
            v-model="newsletterEmail"
            placeholder="Votre adresse email"
            class="w-full sm:flex-1 sm:max-w-[400px] px-5 py-3.5 bg-white border border-[#0B6087] rounded-lg text-base text-gray-900 placeholder-gray-400 outline-none focus:border-[#0B6087] focus:ring-2 focus:ring-[#0B6087]/20 transition-all"
          />
          <button
            @click="subscribeNewsletter"
            :disabled="newsletterLoading || !newsletterConsent"
            :class="[
              'w-full sm:w-auto px-10 py-3.5 rounded-lg text-base font-medium transition-all text-white shadow-sm',
              newsletterLoading ? 'bg-[#6B9FB0] cursor-wait' : 'bg-[#0B6087] hover:bg-[#094d6b] hover:shadow-md',
              !newsletterConsent && !newsletterLoading ? 'opacity-50 cursor-not-allowed' : ''
            ]"
          >
            {{ newsletterLoading ? 'Envoi...' : "S'inscrire" }}
          </button>
        </div>

        <!-- Success/Error Message -->
        <div v-if="newsletterMessage" class="mb-6">
          <p
            :class="[
              'text-sm font-medium',
              newsletterSuccess ? 'text-green-600' : 'text-red-600'
            ]"
          >
            {{ newsletterMessage }}
          </p>
        </div>

        <!-- Consent Checkbox - Aligné à gauche -->
        <div class="flex items-start justify-start gap-3 text-left max-w-3xl mx-auto">
          <input
            type="checkbox"
            id="newsletter-consent"
            v-model="newsletterConsent"
            class="mt-1 w-4 h-4 flex-shrink-0 border border-gray-400 rounded cursor-pointer accent-[#0B6087]"
          />
          <label for="newsletter-consent" class="text-[13px] text-[#4a4a4a] leading-relaxed cursor-pointer">
            En cochant cette case, je consens à l'utilisation des informations
            fournies à des fins de marketing par e-mail.
          </label>
        </div>
      </div>
    </section>

    <!-- Booking Reservation Modal -->
    <BookingReservationModal 
      :is-open="isReservationModalOpen"
      :apartment-id="apartment?.id"
      :apartment-name="apartment?.name"
      :booking-data="bookingData"
      @close="closeReservationModal"
      @submit="handleReservationSubmit"
    />
    </template>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import { useNewsletter } from '@/composables/useNewsletter'
import { useComfortOptions } from '@/composables/useComfortOptions'
import { useReservation } from '@/composables/useReservation'
import { logger } from '@/utils/logger'
import { getImageUrl } from '@/utils/imageUrl'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import BookingHero from '@/components/booking/BookingHero.vue'
import BookingEquipmentList from '@/components/booking/BookingEquipmentList.vue'
import BookingPanel from '@/components/booking/BookingPanel.vue'
import BookingReservationModal from '@/components/booking/BookingReservationModal.vue'

const router = useRouter()
const bookingStore = useBookingStore()
const { subscribe, loading: newsletterLoading, error: newsletterError, success: newsletterSuccess } = useNewsletter()
const { fetchOptions } = useComfortOptions()

// Récupérer l'appartement depuis le store
const apartment = computed(() => bookingStore.apartment)

// Rediriger vers la page d'accueil si aucun appartement n'est sélectionné
onMounted(() => {
  if (!apartment.value) {
    logger.warn('No apartment selected, redirecting to apartments page')
    // Rediriger vers la page de recherche d'appartements après un court délai
    setTimeout(() => {
      router.push({ name: 'apartments-list' })
    }, 2000)
    return
  }
  
  // Set booking step
  bookingStore.step = 1

  // Load comfort options from API
  loadComfortOptions()
})

const apartmentImages = computed(() => {
  if (!apartment.value?.images || apartment.value.images.length === 0) {
    return [
      '/images/reserver/studio1.jpg',
      '/images/reserver/studio2.jpg',
      '/images/reserver/studio3.jpg',
      '/images/reserver/studio4.jpg'
    ]
  }
  
  return apartment.value.images.map((img: any) => {
    if (typeof img === 'string') return img
    const url = img.image_url || img.thumbnail_url
    return getImageUrl(url)
  })
})

const nearbyAttractions = computed(() => {
  return (apartment.value as any)?.nearbyAttractions || (apartment.value as any)?.nearby_attractions || []
})

// Video URL - handle both camelCase and snake_case
const apartmentVideoUrl = computed(() => {
  return (apartment.value as any)?.videoUrl || (apartment.value as any)?.video_url || null
})

const comfortOptions = ref<any[]>([])
const wineOptions = ref<any[]>([])

// Rates computed based on apartment price
const rates = computed(() => {
  const basePrice = apartment.value?.pricePerNight || apartment.value?.price_per_night || 192
  
  return [
    {
      id: 1,
      name: 'Tarif flexible',
      description:
        'Payez en ligne maintenant et bénéficiez d\'une annulation gratuite jusqu\'à 48h avant votre arrivée. Idéal pour planifier votre séjour en toute sérénité.',
      pricePerNight: basePrice
    },
    {
      id: 2,
      name: 'Tarif - paiement sur place',
      description:
        'Réservez maintenant et payez directement à votre arrivée. Aucun paiement en ligne requis. Parfait pour une réservation rapide et sans engagement immédiat.',
      pricePerNight: Math.round(basePrice * 0.9) // 10% de réduction pour paiement sur place
    }
  ]
})

const defaultDescription =
  'Lorem ipsum dolor sit amet. Et adipisci neque eos quam temporis est voluptatem consequatur qui laboris tempore. Rem voluptatem voluptatem et voluptatem voluptatem qui voluptatem voluptatem. Qui voluptatem voluptatem et voluptatem praesentium aut rerum facilis qui ut eos consequatur. Eum quasi voluptatem voluptatem sed dolor sed dicta voluptatem sed eos ipsum et voluptatem voluptatem non aperiam aut.'

// Newsletter
const newsletterEmail = ref('')
const newsletterConsent = ref(false)
const newsletterMessage = ref('')

// Video helper methods
const isYouTubeUrl = (url: string) => {
  if (!url) return false
  return url.includes('youtube.com') || url.includes('youtu.be')
}

const isVimeoUrl = (url: string) => {
  if (!url) return false
  return url.includes('vimeo.com')
}

const isDirectVideoUrl = (url: string) => {
  if (!url) return false
  return /\.(mp4|webm|ogg)$/i.test(url)
}

const getYouTubeEmbedUrl = (url: string) => {
  if (!url) return ''
  const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://www.youtube.com/embed/${videoId}` : ''
}

const getVimeoEmbedUrl = (url: string) => {
  if (!url) return ''
  const match = url.match(/vimeo\.com\/(\d+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://player.vimeo.com/video/${videoId}` : ''
}

// Reservation modal state
const isReservationModalOpen = ref(false)
const bookingData = ref<any>({})
const selectedRateId = ref(1) // Track selected rate
const selectedComfortOptions = ref<number[]>([]) // Track selected options

// Booking dates - from store with proper defaults
const checkIn = computed(() => {
  if (bookingStore.checkIn) return bookingStore.checkIn
  // Default: tomorrow (to avoid "past date" errors)
  const tomorrow = new Date()
  tomorrow.setDate(tomorrow.getDate() + 1)
  return tomorrow
})

const checkOut = computed(() => {
  if (bookingStore.checkOut) return bookingStore.checkOut
  // Default: 7 days from check-in
  const defaultDate = new Date(checkIn.value)
  defaultDate.setDate(defaultDate.getDate() + 7)
  return defaultDate
})

function handleGuestsUpdate(guests: { adults: number; children: number }) {
  bookingStore.guests = guests.adults + guests.children
}

function handleOptionsUpdate(selectedOptions: number[]) {
  // Update booking store with selected options
  selectedComfortOptions.value = selectedOptions
  logger.log('Selected options:', selectedOptions)
}

function handleRateUpdate(rateId: number) {
  // Update booking store with selected rate
  selectedRateId.value = rateId
  logger.log('Selected rate:', rateId)
}

const promoMessage = ref('')
const promoMessageType = ref<'success' | 'error'>('success')

function handlePromoCode(code: string) {
  // Validate promo code with API
  logger.log('Applying promo code:', code)
  
  // Reset message
  promoMessage.value = ''
  
  // Call API to validate promo code
  validatePromoCodeAsync(code)
}

async function validatePromoCodeAsync(code: string) {
  try {
    const { validatePromoCode } = useReservation()
    
    // Calculate total nights
    const totalNights = bookingStore.nightCount
    const totalAmount = bookingStore.calculatedTotalPrice
    
    logger.log('Validating promo code:', { code, totalNights, totalAmount })
    
    const result = await validatePromoCode(code, totalNights, totalAmount)
    
    logger.log('Promo code validation result:', result)
    
    if (result && result.valid) {
      // Apply discount to store
      bookingStore.promoCode = code
      bookingStore.applyPromoCode(result.discount || 0)
      
      logger.log('✅ Promo code applied:', { code, discount: result.discount })
      
      // Show success message
      promoMessage.value = `Code promo appliqué! Réduction de ${(result.discount || 0).toFixed(2)}€`
      promoMessageType.value = 'success'
      
      // Clear message after 5 seconds
      setTimeout(() => {
        promoMessage.value = ''
      }, 5000)
    } else {
      // Show error
      const errorMsg = result?.error || 'Code promo invalide ou expiré'
      logger.error('❌ Invalid promo code:', errorMsg)
      
      promoMessage.value = errorMsg
      promoMessageType.value = 'error'
      
      // Reset promo code
      bookingStore.promoCode = ''
      bookingStore.applyPromoCode(0)
      
      // Clear message after 5 seconds
      setTimeout(() => {
        promoMessage.value = ''
      }, 5000)
    }
  } catch (error: any) {
    logger.error('❌ Failed to validate promo code:', error)
    
    // Extract error message
    let errorMessage = 'Erreur lors de la validation du code promo'
    
    if (error.response?.data?.error?.message) {
      errorMessage = error.response.data.error.message
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    } else if (error.message) {
      errorMessage = error.message
    }
    
    promoMessage.value = errorMessage
    promoMessageType.value = 'error'
    
    // Reset promo code
    bookingStore.promoCode = ''
    bookingStore.applyPromoCode(0)
    
    // Clear message after 5 seconds
    setTimeout(() => {
      promoMessage.value = ''
    }, 5000)
  }
}

function handleDatesUpdate(dates: { checkIn: Date; checkOut: Date }) {
  // Update booking store with new dates
  bookingStore.checkIn = dates.checkIn
  bookingStore.checkOut = dates.checkOut
  logger.log('Dates updated:', dates)
}

function handleNext() {
  // Préparer les données de réservation
  bookingData.value = {
    checkIn: checkIn.value,
    checkOut: checkOut.value,
    guests: bookingStore.guests,
    promoCode: bookingStore.promoCode,
    selectedRateId: selectedRateId.value,
    selectedOptions: selectedComfortOptions.value
  }
  
  // Ouvrir le modal de réservation au lieu de naviguer directement
  isReservationModalOpen.value = true
}

function closeReservationModal() {
  isReservationModalOpen.value = false
}

function handleReservationSubmit(data: any) {
  logger.log('Reservation submitted:', data)
  // Le modal gère déjà la redirection vers la page de paiement
}

async function subscribeNewsletter() {
  newsletterMessage.value = ''
  
  if (!newsletterEmail.value) {
    newsletterMessage.value = 'Veuillez entrer votre adresse email'
    return
  }
  
  if (!newsletterConsent.value) {
    newsletterMessage.value = 'Veuillez accepter les conditions pour continuer'
    return
  }

  try {
    await subscribe({ email: newsletterEmail.value })
    newsletterMessage.value = 'Merci pour votre inscription !'
    newsletterEmail.value = ''
    newsletterConsent.value = false
  } catch (e) {
    newsletterMessage.value = newsletterError.value || 'Une erreur est survenue. Veuillez réessayer.'
  }
}

async function loadComfortOptions() {
  try {
    const response = await fetchOptions()
    logger.log('🔍 API Response:', response)
    
    // Default images by category
    const defaultImages: Record<string, string> = {
      cleaning: '/images/options/cleaning-default.svg',
      wine: '/images/options/wine-default.svg',
      confectionery: '/images/options/confectionery-default.svg',
      other: '/images/options/other-default.svg'
    }
    
    // Transform API data to match BookingPanel props format
    const transformOption = (option: any) => {
      // Use image_url if available, otherwise use category default
      let imageUrl = option.image_url || defaultImages[option.category] || defaultImages.other
      
      // Ensure the image URL is absolute
      if (imageUrl && !imageUrl.startsWith('http')) {
        imageUrl = imageUrl.startsWith('/') ? imageUrl : `/${imageUrl}`
      }
      
      const transformed = {
        id: option.id,
        name: option.name,
        price: option.price / 100, // Convert from cents to euros
        priceUnit: option.price_type === 'per_night' ? '/nuit' : '',
        image: imageUrl,
        category: option.category === 'cleaning' ? 'comfort' : 'wine'
      }
      logger.log('✨ Transformed option:', transformed)
      return transformed
    }
    
    // Separate cleaning options (comfort) and wine/confectionery options
    const allOptions = response.data
    logger.log('📦 All options from API:', allOptions)
    
    comfortOptions.value = allOptions
      .filter((opt: any) => opt.category === 'cleaning')
      .map(transformOption)
    
    wineOptions.value = allOptions
      .filter((opt: any) => ['wine', 'confectionery'].includes(opt.category))
      .map(transformOption)
    
    logger.log('🛋️ Comfort options:', comfortOptions.value)
    logger.log('🍷 Wine options:', wineOptions.value)
  } catch (error) {
    logger.error('❌ Failed to load comfort options:', error)
  }
}
</script>
