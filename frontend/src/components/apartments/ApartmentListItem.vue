<template>
  <div class="apartment-card bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in-up" :class="staggerClass">
    <!-- Mobile Layout -->
    <div class="md:hidden">
      <!-- Image with Logo KAYLIA and Navigation -->
      <div class="relative bg-gray-100">
        <LazyImage
          :src="currentImage"
          :srcset="`${currentImage}?w=600 600w, ${currentImage}?w=1200 1200w`"
          :alt="apartment.name"
          container-class="w-full"
          image-class="w-full h-[280px] object-cover"
        >
          <template #overlay>
            <!-- Kaylia Logo Overlay -->
            <div class="absolute top-4 left-4 font-display text-xl text-white drop-shadow-lg">
              <div class="font-bold tracking-wider">KAYLIA</div>
              <div class="text-[10px] tracking-widest opacity-90">SUITE HOME</div>
            </div>
            
            <!-- Navigation Arrows - bottom right -->
            <div v-if="apartment.images && apartment.images.length > 1" class="absolute bottom-3 right-3 flex gap-2">
              <button 
                @click.stop="previousImage"
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-50 transition active:scale-95"
                aria-label="Previous image"
              >
                <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
              </button>
              <button 
                @click.stop="nextImage"
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-50 transition active:scale-95"
                aria-label="Next image"
              >
                <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </button>
            </div>
          </template>
        </LazyImage>
      </div>

      <!-- Content -->
      <div class="p-6">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          {{ apartment.name }}
        </h2>
        
        <!-- Features Grid 2x2 -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <!-- Capacity -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <span class="text-sm text-gray-800">{{ apartment.capacity }} personnes</span>
          </div>

          <!-- Surface -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
              </svg>
            </div>
            <span class="text-sm text-gray-800">{{ apartment.surface }}m²</span>
          </div>

          <!-- Beds -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <span class="text-sm text-gray-800">{{ bedsDescription }}</span>
          </div>

          <!-- Floor -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 border border-gray-800 rounded flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <span class="text-sm text-gray-800">{{ apartment.floor }}</span>
          </div>
        </div>

        <!-- Description -->
        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
          {{ apartment.description }}
        </p>

        <!-- Price -->
        <div class="mb-6">
          <div class="text-sm text-gray-500 mb-1">À partir de</div>
          <div class="text-3xl font-bold text-gray-900">
            {{ apartment.pricePerNight }}€<span class="text-lg font-normal text-gray-600">/Nuit</span>
          </div>
          <div class="text-sm text-gray-500 mt-1">{{ totalPrice }}€, au total ({{ nightCount }} nuits)</div>
        </div>

        <!-- Button -->
        <button 
          @click="handleReserve"
          class="w-full border-2 border-[#0b6087] text-[#0b6087] font-semibold px-6 py-3 rounded-lg hover:bg-[#0b6087] hover:text-white transition-all duration-300 active:scale-95"
        >
          Sélectionner
        </button>
      </div>
    </div>

    <!-- Desktop Layout -->
    <div class="hidden md:grid md:grid-cols-5 gap-0">
      <!-- Image Gallery -->
      <div class="md:col-span-2 relative image-container bg-gray-100">
        <LazyImage
          :src="currentImage"
          :srcset="`${currentImage}?w=600 600w, ${currentImage}?w=1200 1200w`"
          :alt="apartment.name"
          container-class="w-full h-full"
          image-class="w-full h-full object-cover"
        >
          <template #overlay>
            <!-- Kaylia Logo Overlay -->
            <div class="absolute top-4 left-4 font-display text-2xl text-white drop-shadow-lg">
              <div class="font-bold tracking-wider">KAYLIA</div>
              <div class="text-xs tracking-widest opacity-90">LUXURY LIVING</div>
            </div>
            
            <!-- Image counter - top right -->
            <div v-if="apartment.images && apartment.images.length > 1" class="absolute top-4 right-4 bg-black bg-opacity-60 text-white text-xs px-3 py-1 rounded-full">
              {{ currentImageIndex + 1 }} / {{ apartment.images.length }}
            </div>
            
            <!-- Navigation Arrows - bottom right, side by side -->
            <div v-if="apartment.images && apartment.images.length > 1" class="absolute bottom-4 right-4 flex gap-2">
              <button 
                @click.stop="previousImage"
                class="nav-arrow min-w-[44px] min-h-[44px] w-11 h-11 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg hover:bg-opacity-100 transition active:scale-95"
                aria-label="Previous image"
              >
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
              </button>
              <button 
                @click.stop="nextImage"
                class="nav-arrow min-w-[44px] min-h-[44px] w-11 h-11 bg-white bg-opacity-80 rounded-full flex items-center justify-center shadow-lg hover:bg-opacity-100 transition active:scale-95"
                aria-label="Next image"
              >
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </button>
            </div>
          </template>
        </LazyImage>
      </div>

      <!-- Content -->
      <div class="md:col-span-3 p-8 md:p-10">
        <h2 class="text-[40px] leading-[24px] font-bold text-gray-900 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
          {{ apartment.name }}
        </h2>
        
        <!-- Features -->
        <div class="flex flex-wrap gap-4 mb-6">
          <!-- Capacity -->
          <div class="flex items-center space-x-2 feature-icon">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
            </svg>
            <span class="text-gray-700 font-medium">{{ apartment.capacity }} personne{{ apartment.capacity > 1 ? 's' : '' }}</span>
          </div>
          
          <!-- Surface -->
          <div class="flex items-center space-x-2 feature-icon">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            <span class="text-gray-700 font-medium">{{ apartment.surface }}m²</span>
          </div>
          
          <!-- Beds -->
          <div class="flex items-center space-x-2 feature-icon">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
            </svg>
            <span class="text-gray-700 font-medium">{{ bedsDescription }}</span>
          </div>
          
          <!-- Floor -->
          <div class="flex items-center space-x-2 feature-icon">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-gray-700 font-medium">{{ apartment.floor }}</span>
          </div>
        </div>

        <!-- Description -->
        <p class="text-[16px] leading-[24px] font-normal text-gray-600 mb-8" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
          {{ apartment.description }}
        </p>

        <!-- Price and CTA -->
        <div class="mt-auto">
          <div class="mb-6">
            <div class="text-sm text-gray-500 mb-1 uppercase tracking-wider">À partir de</div>
            <div class="font-display text-4xl font-bold text-gray-900">
              {{ apartment.pricePerNight }}€<span class="text-2xl font-normal text-gray-600">/Nuit</span>
            </div>
            <div class="text-sm text-gray-500 mt-1">{{ totalPrice }}€, au total ({{ nightCount }} nuits)</div>
          </div>
          <button 
            @click="handleReserve"
            class="select-btn block w-full min-h-[56px] bg-white border-2 border-[#0b6087] text-[#0b6087] font-semibold px-8 py-4 rounded-lg hover:bg-[#0b6087] hover:text-white transition-all duration-300 active:scale-95 text-center text-lg"
          >
            Sélectionner
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBookingStore } from '@/stores/booking'
import type { Apartment } from '@/stores/apartments'
import LazyImage from '@/components/common/LazyImage.vue'

interface Props {
  apartment: Apartment
  index?: number
}

const props = withDefaults(defineProps<Props>(), {
  index: 0
})

const router = useRouter()
const route = useRoute()
const bookingStore = useBookingStore()

// Image carousel state
const currentImageIndex = ref(0)

// Computed properties
const currentImage = computed(() => {
  if (props.apartment.images && props.apartment.images.length > 0) {
    const image = props.apartment.images[currentImageIndex.value]
    return getImageUrl(image)
  }
  // Fallback placeholder image
  return '/images/apartments/apart5.jpg'
})

// Helper pour obtenir l'URL de l'image
const getImageUrl = (image: any): string => {
  if (!image) {
    return '/images/apartments/apart5.jpg'
  }
  
  // Si c'est déjà une string, la retourner
  if (typeof image === 'string') {
    return image
  }
  
  // Si c'est un objet avec thumbnail_url ou image_url
  const url = image.thumbnail_url || image.image_url
  if (!url) {
    return '/images/apartments/apart5.jpg'
  }
  
  // Si l'URL est relative, ajouter le backend URL
  if (url.startsWith('/')) {
    return `http://localhost:8000${url}`
  }
  
  return url
}

const bedsDescription = computed(() => {
  if (props.apartment.beds && props.apartment.beds.length > 0) {
    const bed = props.apartment.beds[0]
    if (bed) {
      return `${bed.count} lit${bed.count > 1 ? 's' : ''} ${bed.type}`
    }
  }
  return '1 lit king size'
})

const staggerClass = computed(() => {
  return `stagger-${props.index + 1}`
})

// Calculate total price
const totalPrice = computed(() => {
  return nightCount.value * props.apartment.pricePerNight
})

// Placeholder values - would come from booking context
const nightCount = computed(() => 28)

// Methods
const nextImage = () => {
  if (props.apartment.images && props.apartment.images.length > 0) {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.apartment.images.length
  }
}

const previousImage = () => {
  if (props.apartment.images && props.apartment.images.length > 0) {
    currentImageIndex.value = 
      currentImageIndex.value === 0 
        ? props.apartment.images.length - 1 
        : currentImageIndex.value - 1
  }
}

const handleReserve = () => {
  // Stocker les données de l'appartement dans le store
  bookingStore.apartment = props.apartment as any
  
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

</script>

<style scoped>
.apartment-card {
  opacity: 0;
  animation: fadeInUp 0.6s ease-out forwards;
}

.stagger-1 { animation-delay: 0.1s; }
.stagger-2 { animation-delay: 0.2s; }
.stagger-3 { animation-delay: 0.3s; }
.stagger-4 { animation-delay: 0.4s; }
.stagger-5 { animation-delay: 0.5s; }

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.font-display {
  font-family: 'Cormorant Garamond', serif;
}

.badge-premium {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.image-container {
  min-height: 280px;
}

@media (min-width: 768px) {
  .image-container {
    min-height: 320px;
  }
}

.nav-arrow:hover {
  transform: scale(1.1);
}

.select-btn:hover {
  box-shadow: 0 10px 25px rgba(45, 90, 95, 0.2);
}

.feature-icon {
  transition: transform 0.2s;
}

.feature-icon:hover {
  transform: translateY(-2px);
}
</style>
