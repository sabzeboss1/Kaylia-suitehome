<template>
  <section class="apartment-hero-section relative pt-[62px] md:pt-20">
    <!-- 1. Background Image with Title -->
    <div class="hero-background relative h-[500px] md:h-[600px]">
      <!-- Background Image -->
      <div class="absolute inset-0">
        <img
          src="/images/apartments/hero.jpg"
          alt="Immeuble Kaylia Suite Home"
          class="w-full h-full object-cover"
        />
        <!-- Dark overlay for text readability -->
        <div class="absolute inset-0 bg-black/60"></div>
      </div>

      <!-- Hero Title -->
      <div class="relative h-full container mx-auto px-6 md:px-12 lg:px-20 flex items-center pb-28 md:pb-32">
        <div class="max-w-2xl">
          <h1 class="text-white text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">
            Des appartements de haut standing pour rendre votre séjour inoubliable !
          </h1>
        </div>
      </div>
    </div>

    <!-- 2. Image Carousel Section (Overlapping) -->
    <div class="carousel-section relative -mt-24 md:-mt-28 z-10">
      <ImageCarousel :images="carouselImages" bg-class="bg-[#A8927A]" />
    </div>

    <!-- 3. Info Bar (White Background) -->
    <div class="info-bar bg-white py-6 md:py-8 border-b border-gray-200">
      <div class="container mx-auto px-6 md:px-12 lg:px-20">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
          <!-- Left: Property Info -->
          <div class="flex flex-wrap justify-center md:justify-start gap-6 md:gap-8">
            <!-- Location -->
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <span class="text-sm text-gray-700">Quartier Jouvence, Yaoundé</span>
            </div>

            <!-- Apartments Count -->
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
              </div>
              <span class="text-sm text-gray-700">7 appartements</span>
            </div>

            <!-- Capacity -->
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </div>
              <span class="text-sm text-gray-700">1 à 4 personnes</span>
            </div>

            <!-- Apartment Types -->
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 border border-gray-300 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
              </div>
              <span class="text-sm text-gray-700">du T1 au T3</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 4. Navigation Menu (Beige Background) - Sticky -->
    <div class="navigation-menu bg-[#A8927A] py-4 sticky top-[62px] md:top-20 z-20 shadow-md">
      <div class="container mx-auto px-6 md:px-12 lg:px-20">
        <nav class="flex flex-wrap gap-6 md:gap-8">
          <a
            v-for="(link, index) in navLinks"
            :key="index"
            :href="link.href"
            @click.prevent="scrollToSection(link.href)"
            :class="[
              'text-white text-sm md:text-base transition-all pb-2 cursor-pointer',
              link.active ? 'border-b-2 border-gray-900 font-medium' : 'hover:opacity-80'
            ]"
          >
            {{ link.label }}
          </a>
        </nav>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import ImageCarousel from '@/components/common/ImageCarousel.vue'

interface CarouselImage {
  url: string
  alt: string
}

interface Props {
  images?: CarouselImage[]
}

const props = withDefaults(defineProps<Props>(), {
  images: () => []
})

// Use provided images or fallback to defaults
const carouselImages = computed(() => {
  if (props.images && props.images.length > 0) {
    return props.images
  }
  
  // Fallback images
  return [
    { url: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80', alt: 'Salon' },
    { url: 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80', alt: 'Chambre' },
    { url: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', alt: 'Piscine' },
    { url: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80', alt: 'Cuisine' },
    { url: 'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80', alt: 'Salle de bain' },
  ]
})

// Navigation links
const navLinks = ref([
  { label: 'Nos Appartements disponibles', href: '#appartements', active: true },
  { label: 'Les équipements', href: '#equipements', active: false },
  { label: 'Nos services', href: '#services', active: false },
  { label: 'Galerie photos', href: '#galerie', active: false },
  { label: 'F.A.Q', href: '#faq', active: false },
])

const scrollToSection = (href: string) => {
  const sectionId = href.replace('#', '')
  const element = document.getElementById(sectionId)
  
  if (element) {
    const offset = 80 // Offset pour la barre sticky
    const elementPosition = element.getBoundingClientRect().top
    const offsetPosition = elementPosition + window.pageYOffset - offset
    
    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    })
  }
}
</script>
