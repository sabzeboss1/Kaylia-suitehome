<template>
  <DefaultLayout>
    <div class="studio-page">
    <!-- Hero Section with Building Image -->
    <section 
      class="relative h-[40vh] md:h-[50vh] bg-cover bg-center flex items-center hero-section pt-20 md:pt-24"
    >
      <div class="container mx-auto px-6 md:px-20">
        <h1 class="text-white font-serif text-3xl md:text-5xl font-light leading-tight max-w-3xl">
          Le studio Chez Kaylia Suite Home<br>s'adapte à votre séjour
        </h1>
      </div>
    </section>

    <!-- Gallery Section with Auto-Sliding Images - Full Width with Peek Effect -->
    <ImageCarousel :images="studioImages" bg-class="bg-[#e8dcc8]" />

    <!-- Info Bar with Reservation -->
    <StudioInfoBar 
      :capacity="studioData.capacity"
      :surface="studioData.surface"
      :bed-description="studioData.bedDescription"
      :floor="studioData.floor"
      :price="studioData.price"
      @reserve="openReservationModal"
    />

    <!-- Description and FAQ Section -->
    <section class="bg-white py-12 md:py-16">
      <div class="container mx-auto px-6 md:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
          <!-- Left Column - Description & Video (60%) -->
          <div class="lg:col-span-7">
            <StudioDescription 
              :title="studioData.descriptionTitle"
              :description="studioData.description"
              :video-url="studioData.videoUrl"
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
    <EquipmentSection section-id="equipements" />

    <!-- Services Section -->
    <section class="bg-[#22333b] text-white py-12 md:py-20 px-6 md:px-20">
      <div class="text-center mb-12 md:mb-16">
        <h2 class="text-[32px] leading-[24px] font-semibold mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
          Nos <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Services</span>
        </h2>
        <p class="text-[16px] leading-[24px] font-light text-gray-300 max-w-3xl mx-auto" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
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
      :apartment-id="999"
      apartment-name="Studio Kaylia Suite Home"
      :booking-data="bookingData"
      @close="closeReservationModal"
      @submit="handleReservationSubmit"
    />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ImageCarousel from '@/components/common/ImageCarousel.vue'
import StudioInfoBar from '@/components/studio/StudioInfoBar.vue'
import StudioDescription from '@/components/studio/StudioDescription.vue'
import StudioFAQ from '@/components/studio/StudioFAQ.vue'
import EquipmentSection from '@/components/common/EquipmentSection.vue'
import ReservationBanner from '@/components/home/ReservationBanner.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
import BookingReservationModal from '@/components/booking/BookingReservationModal.vue'

// Studio images for carousel
const studioImages = ref([
  '/images/studio/studio1.jpg',
  '/images/studio/studio2.jpg',
  '/images/studio/studio3.jpg',
  '/images/studio/studio4.jpg',
  '/images/studio/hero.jpg'
])

// Reservation modal state
const isReservationModalOpen = ref(false)
const bookingData = ref<any>({})

// Studio data
const studioData = ref({
  capacity: 2,
  surface: 40,
  bedDescription: '1 lit King Size',
  floor: '1er étage',
  price: 70,
  descriptionTitle: 'Un studio pensé pour\nvotre confort',
  description: 'Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus. Cum praesertium necessitatibus et quas temetur est rerum excepturi. Cum quas recusandae qui quis dolore est dicta voluptatum nerum itaque vel inventore laudantium non cupiditate aut...',
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

// Services
const services = ref([
  { name: 'Wi-Fi haut débit', icon: '/images/équipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/équipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/équipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/équipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/équipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/équipements/Climatisation.ico' }
])

// Reservation modal handlers
const openReservationModal = () => {
  bookingData.value = {
    checkIn: new Date(),
    checkOut: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000), // 7 days later
    guests: studioData.value.capacity,
    price: studioData.value.price
  }
  isReservationModalOpen.value = true
}

const closeReservationModal = () => {
  isReservationModalOpen.value = false
}

const handleReservationSubmit = (data: any) => {
  console.log('Studio reservation submitted:', data)
  // Le modal gère déjà la redirection vers la page de paiement
}

// Fetch studio data from API
onMounted(async () => {
  // TODO: Fetch studio data from API
  // const response = await apiClient.get('/apartments/studio')
  // Update studioData, studioImages, etc. with API response
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
