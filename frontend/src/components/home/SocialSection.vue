<template>
  <section class="bg-white py-12 md:py-20">
    <!-- Header Section -->
    <div class="text-center mb-8 px-6">
      <h2 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
        Suivez-nous sur <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Instagram</span>
      </h2>
      <p class="text-[16px] leading-[24px] text-gray-700" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">@kayliasuitehome</p>
    </div>

    <!-- Instagram Slider -->
    <div class="relative px-6 md:px-12">
      <div 
        ref="sliderContainer"
        class="flex gap-4 overflow-x-auto scroll-smooth pb-4 scrollbar-hide snap-x snap-mandatory"
      >
        <a 
          v-for="(post, index) in instagramPosts" 
          :key="index"
          :href="post.link"
          target="_blank"
          rel="noopener noreferrer"
          class="instagram-post relative overflow-hidden group cursor-pointer flex-shrink-0 w-[280px] md:w-[320px] lg:w-[350px] snap-start"
        >
          <LazyImage
            :src="post.image"
            :alt="post.alt"
            container-class="w-full h-full"
            image-class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
          />
          
          <!-- Overlay avec texte sur hover -->
          <div 
            v-if="post.overlay"
            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
          >
            <div class="text-white text-center">
              <p class="font-serif text-lg md:text-xl mb-2" v-if="post.overlay.title">
                {{ post.overlay.title }}
              </p>
              <p class="text-sm" v-if="post.overlay.description">
                {{ post.overlay.description }}
              </p>
            </div>
          </div>
        </a>
      </div>

      <!-- Navigation Buttons -->
      <button
        @click="scrollPrev"
        class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 rounded-full shadow-lg items-center justify-center hover:bg-white transition-all duration-300 z-10 group"
        aria-label="Image précédente"
      >
        <svg 
          class="w-5 h-5 text-gray-700 group-hover:text-[#4a7c8c] transition-colors" 
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

      <button
        @click="scrollNext"
        class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 rounded-full shadow-lg items-center justify-center hover:bg-white transition-all duration-300 z-10 group"
        aria-label="Image suivante"
      >
        <svg 
          class="w-5 h-5 text-gray-700 group-hover:text-[#4a7c8c] transition-colors" 
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import LazyImage from '@/components/common/LazyImage.vue'

interface InstagramPost {
  image: string
  alt: string
  link: string
  overlay?: {
    title?: string
    description?: string
  }
}

const sliderContainer = ref<HTMLElement | null>(null)

// Mock Instagram posts - À remplacer par de vraies données de l'API Instagram
const instagramPosts = ref<InstagramPost[]>([
  {
    image: '/images/instagram/image1.png',
    alt: 'Un espace pur, une atmosphère apaisée pour vous détendre',
    link: 'https://instagram.com/kayliasuitehome',
    overlay: {
      title: 'SUITE HOME',
      description: 'Un espace pur, une atmosphère apaisée pour vous détendre.'
    }
  },
  {
    image: '/images/instagram/image2.png',
    alt: 'Je recommande l\'Appart-Hôtel Kaylia Suite Home à 100%',
    link: 'https://instagram.com/kayliasuitehome',
    overlay: {
      title: 'KAYLIA SUITE HOME',
      description: 'Je recommande l\'Appart-Hôtel Kaylia Suite Home à 100%. Le lieu est digne des plus grands hôtels. À la fois spacieux et très chaleureux.'
    }
  },
  {
    image: '/images/instagram/image3.jpg',
    alt: 'Chambre confortable avec literie de qualité',
    link: 'https://instagram.com/kayliasuitehome',
    overlay: {
      description: 'Le personnel est très accueillant et à l\'écoute ce qui a rendu notre séjour encore plus agréable.'
    }
  },
  {
    image: '/images/instagram/image4.png',
    alt: 'Nous vous accueillons dans notre Appart-hôtel',
    link: 'https://instagram.com/kayliasuitehome',
    overlay: {
      title: 'KAYLIA SUITE HOME',
      description: 'Nous vous accueillons dans notre Appart-hôtel avec des appartements spacieux pour un séjour agréable en famille.'
    }
  },
  {
    image: '/images/instagram/image1.png',
    alt: 'Découvrez nos espaces élégants et confortables',
    link: 'https://instagram.com/kayliasuitehome',
    overlay: {
      title: 'CONFORT & ÉLÉGANCE',
      description: 'Des espaces pensés pour votre bien-être et votre confort.'
    }
  }
])

const scrollPrev = () => {
  if (sliderContainer.value) {
    const scrollAmount = sliderContainer.value.offsetWidth * 0.8
    sliderContainer.value.scrollBy({ left: -scrollAmount, behavior: 'smooth' })
  }
}

const scrollNext = () => {
  if (sliderContainer.value) {
    const scrollAmount = sliderContainer.value.offsetWidth * 0.8
    sliderContainer.value.scrollBy({ left: scrollAmount, behavior: 'smooth' })
  }
}
</script>

<style scoped>
.instagram-post {
  aspect-ratio: 1;
  height: 280px;
}

@media (min-width: 768px) {
  .instagram-post {
    height: 320px;
  }
}

@media (min-width: 1024px) {
  .instagram-post {
    height: 350px;
  }
}

/* Hide scrollbar but keep functionality */
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
