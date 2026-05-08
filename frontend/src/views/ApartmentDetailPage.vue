<template>
  <DefaultLayout>
    <div class="apartment-detail-page">
    <!-- Hero Section with Building Image -->
    <section 
      class="relative h-[40vh] md:h-[50vh] bg-cover bg-center flex items-center hero-section pt-[62px] md:pt-20"
    >
      <div class="container mx-auto px-6 md:px-20">
        <h1 class="text-white font-serif text-3xl md:text-5xl font-light leading-tight max-w-3xl">
          {{ apartmentData.name }}<br>s'adapte à votre séjour
        </h1>
      </div>
    </section>

    <!-- Gallery Section with Auto-Sliding Images - Full Width with Peek Effect -->
    <ImageCarousel :images="apartmentImages" bg-class="bg-[#e8dcc8]" />

    <!-- Info Bar with Reservation -->
    <StudioInfoBar 
      :capacity="apartmentData.capacity"
      :surface="apartmentData.surface"
      :bed-description="apartmentData.bedDescription"
      :floor="apartmentData.floor"
      :price="apartmentData.price"
      @reserve="openReservationModal"
    />

    <!-- Description and FAQ Section -->
    <section class="bg-white py-12 md:py-16">
      <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
          <!-- Left Column - Description & Video (60%) -->
          <div class="lg:col-span-7">
            <StudioDescription 
              :title="apartmentData.descriptionTitle"
              :description="apartmentData.description"
              :video-url="apartmentData.videoUrl"
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
    <section class="bg-[#1e3a3f] text-white py-12 md:py-20 px-6 md:px-20">
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

    <!-- Booking Reservation Modal -->
    <BookingReservationModal 
      :is-open="isReservationModalOpen"
      :apartment-id="apartmentData.id"
      :apartment-name="apartmentData.name"
      :booking-data="bookingData"
      @close="closeReservationModal"
      @submit="handleReservationSubmit"
    />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ImageCarousel from '@/components/common/ImageCarousel.vue'
import StudioInfoBar from '@/components/studio/StudioInfoBar.vue'
import StudioDescription from '@/components/studio/StudioDescription.vue'
import StudioFAQ from '@/components/studio/StudioFAQ.vue'
import EquipmentSection from '@/components/common/EquipmentSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import BookingReservationModal from '@/components/booking/BookingReservationModal.vue'
import apiClient from '@/utils/api'
import { useSEO } from '@/composables/useSEO'

const route = useRoute()
const { setMetaTags, setStructuredData, getApartmentSchema, getBreadcrumbSchema } = useSEO()

// Apartment images for carousel
const apartmentImages = ref<string[]>([])

// Reservation modal state
const isReservationModalOpen = ref(false)
const bookingData = ref<any>({})

// Loading state
const loading = ref(true)

// Apartment data
const apartmentData = ref({
  id: 0,
  name: '',
  slug: '',
  capacity: 2,
  surface: 40,
  bedDescription: '1 lit King Size',
  floor: '1er étage',
  price: 70,
  descriptionTitle: 'Un appartement pensé pour\nvotre confort',
  description: '',
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

// Equipment items - Removed, now using EquipmentSection component

// Services
const services = ref([
  { name: 'Wi-Fi haut débit', icon: '/images/equipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/equipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/equipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/equipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/equipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/equipements/Climatisation.ico' }
])

// Reservation modal handlers
const openReservationModal = () => {
  bookingData.value = {
    checkIn: new Date(),
    checkOut: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000), // 7 days later
    guests: apartmentData.value.capacity,
    price: apartmentData.value.price
  }
  isReservationModalOpen.value = true
}

const closeReservationModal = () => {
  isReservationModalOpen.value = false
}

const handleReservationSubmit = (data: any) => {
  console.log('Apartment reservation submitted:', data)
  // Le modal gère déjà la redirection vers la page de paiement
}

// Fetch apartment data from API
onMounted(async () => {
  const slug = route.params.slug as string
  
  try {
    loading.value = true
    const response = await apiClient.get(`/apartments/${slug}`)
    const apartment = response.data
    
    // Update apartment data
    apartmentData.value = {
      id: apartment.id,
      name: apartment.name,
      slug: apartment.slug,
      capacity: apartment.capacity,
      surface: apartment.surface,
      bedDescription: apartment.beds?.[0] ? `${apartment.beds[0].count} lit${apartment.beds[0].count > 1 ? 's' : ''} ${apartment.beds[0].type}` : '1 lit King Size',
      floor: apartment.floor,
      price: apartment.pricePerNight,
      descriptionTitle: `${apartment.name}\npensé pour votre confort`,
      description: apartment.description,
      videoUrl: apartment.videoUrl
    }

    // SEO Meta Tags - UTILISER LES DONNÉES DU BACKEND
    const firstImage = apartment.images?.[0]
    const imageUrl = firstImage ? 
      (typeof firstImage === 'string' ? firstImage : 
        (firstImage.image_url?.startsWith('http') ? firstImage.image_url : 
          `http://localhost:8000${firstImage.image_url}`)) : 
      undefined

    // Utiliser les champs SEO du backend si disponibles, sinon générer automatiquement
    const seoTitle = apartment.metaTitle || `${apartment.name} - Appartement de Luxe à Yaoundé | Kaylia Suite Home`
    const seoDescription = apartment.metaDescription || apartment.description || `Réservez ${apartment.name}, un appartement de ${apartment.surface}m² pouvant accueillir ${apartment.capacity} personnes. Équipé, climatisé avec services premium à Yaoundé.`
    const seoKeywords = apartment.metaKeywords || `${apartment.name}, appartement ${apartment.surface}m² Yaoundé, location ${apartment.capacity} personnes Yaoundé`
    const seoImage = apartment.ogImage || imageUrl

    setMetaTags({
      title: seoTitle,
      description: seoDescription,
      keywords: seoKeywords,
      type: 'product',
      image: seoImage
    })

    // Structured Data
    setStructuredData([
      getApartmentSchema(apartment),
      getBreadcrumbSchema([
        { name: 'Accueil', url: '/' },
        { name: 'Nos Appartements', url: '/nos-appartements' },
        { name: apartment.name, url: `/appartements/${apartment.slug}` }
      ])
    ])
    
    // Update images
    if (apartment.images && apartment.images.length > 0) {
      apartmentImages.value = apartment.images.map((img: any) => {
        const url = img.image_url || img
        return url.startsWith('/') ? `http://localhost:8000${url}` : url
      })
    } else {
      // Fallback images
      apartmentImages.value = [
        '/images/studio/studio1.jpg',
        '/images/studio/studio2.jpg',
        '/images/studio/studio3.jpg',
        '/images/studio/studio4.jpg',
        '/images/studio/hero.jpg'
      ]
    }
    
  } catch (error) {
    console.error('Failed to load apartment:', error)
    // Use default data
    apartmentImages.value = [
      '/images/studio/studio1.jpg',
      '/images/studio/studio2.jpg',
      '/images/studio/studio3.jpg',
      '/images/studio/studio4.jpg',
      '/images/studio/hero.jpg'
    ]
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.hero-section {
  background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                    url('/images/studio/hero.jpg');
  background-size: cover;
  background-position: center;
}
</style>
