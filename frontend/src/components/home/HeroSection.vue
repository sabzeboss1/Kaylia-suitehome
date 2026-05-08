<template>
  <section class="hero relative h-[100vh] flex flex-col text-white overflow-hidden pt-[62px] md:pt-20">
    <!-- Video Background -->
    <div v-if="heroMedia?.type === 'video'" class="absolute inset-0 z-0">
      <!-- YouTube -->
      <iframe 
        v-if="isYouTube(heroMedia.url)"
        :src="getYouTubeEmbed(heroMedia.url) + '?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playlist=' + getYouTubeId(heroMedia.url)"
        class="absolute inset-0 w-[300%] h-[300%] -top-[100%] -left-[100%] pointer-events-none"
        frameborder="0"
        allow="autoplay; encrypted-media"
      ></iframe>
      
      <!-- Vimeo -->
      <iframe 
        v-else-if="isVimeo(heroMedia.url)"
        :src="getVimeoEmbed(heroMedia.url) + '?autoplay=1&muted=1&loop=1&background=1&controls=0'"
        class="absolute inset-0 w-[300%] h-[300%] -top-[100%] -left-[100%] pointer-events-none"
        frameborder="0"
        allow="autoplay; fullscreen"
      ></iframe>
      
      <!-- Direct Video -->
      <video 
        v-else
        :src="heroMedia.url"
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 w-full h-full object-cover"
      >
        Votre navigateur ne supporte pas la lecture de vidéos.
      </video>
      
      <!-- Overlay -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/50"></div>
    </div>

    <!-- Image Background (default or fallback) -->
    <div 
      v-if="!heroMedia || heroMedia.type === 'image'"
      class="absolute inset-0 z-0 bg-cover bg-center"
      :style="{ backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(${getImageUrl()})` }"
    ></div>

    <!-- Content (always on top) -->
    <div class="flex flex-col h-full py-8 md:py-12 justify-center gap-12 md:gap-16 relative z-10">
      <!-- Title and text block - aligned with logo on desktop, centered on mobile -->
      <div class="max-w-7xl mx-auto px-3 md:px-8 w-full text-center md:text-left">
        <h1 class="hero-title text-[24px] leading-[32px] md:text-[40px] md:leading-[48px] mb-6 font-medium animate-fade-in-up">
          KAYLIA SUITE HOME<br>
          L'ART du Confort &<br class="md:hidden">
          du Luxe à Yaoundé
        </h1>
        
        <p class="hero-tagline text-[16px] leading-[24px] md:text-[32px] lg:text-[36px] md:leading-[48px] tracking-normal font-normal italic animate-fade-in-up">
          {{ heroTagline || 'Vivez une expérience unique, mémorable et chaleureuse' }}
        </p>
      </div>
      
      <!-- Search box - centered -->
      <div class="w-full flex justify-center relative z-50">
        <slot name="search-box"></slot>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from '@/utils/api'

const heroMedia = ref<{ type: 'image' | 'video', url: string } | null>(null)
const heroTitle = ref('')
const heroSubtitle = ref('')
const heroTagline = ref('')

const defaultImage = '/images/hero/herohome.jpg'

const isYouTube = (url: string) => url?.includes('youtube.com') || url?.includes('youtu.be')
const isVimeo = (url: string) => url?.includes('vimeo.com')

const getYouTubeId = (url: string) => {
  const match = url?.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/)
  return match ? match[1] : ''
}

const getYouTubeEmbed = (url: string) => {
  const id = getYouTubeId(url)
  return id ? `https://www.youtube.com/embed/${id}` : ''
}

const getVimeoEmbed = (url: string) => {
  const match = url?.match(/vimeo\.com\/(\d+)/)
  return match ? `https://player.vimeo.com/video/${match[1]}` : ''
}

const getImageUrl = () => {
  if (heroMedia.value?.type === 'image' && heroMedia.value.url) {
    const url = heroMedia.value.url
    
    // If URL starts with http, use it directly
    if (url.startsWith('http')) {
      return url
    }
    
    // If URL starts with 'images/', it's in the public folder (default image)
    if (url.startsWith('images/')) {
      const finalUrl = `/${url}`
      console.log('🎯 Public folder image detected:', url, '→', finalUrl)
      return finalUrl
    }
    
    // Otherwise, it's an uploaded image in storage
    const cleanUrl = url.startsWith('/') ? url.substring(1) : url
    const finalUrl = `${import.meta.env.VITE_API_BASE_URL.replace('/api', '')}/storage/${cleanUrl}`
    console.log('🎯 Storage image detected:', url, '→', finalUrl)
    return finalUrl
  }
  return defaultImage
}

onMounted(async () => {
  try {
    // Load hero content
    const response = await axios.get('/content/home')
    const content = response.data?.data || response.data
    
    // Parse hero background (media_choice)
    if (content?.hero_background) {
      const parsed = typeof content.hero_background === 'string' 
        ? JSON.parse(content.hero_background) 
        : content.hero_background
      
      heroMedia.value = parsed
    }
    
    // Load text content
    heroTitle.value = content?.hero_title || ''
    heroSubtitle.value = content?.hero_subtitle || ''
    heroTagline.value = content?.hero_tagline || ''
  } catch (error) {
    console.error('Failed to load hero content:', error)
    // Use defaults
  }
})
</script>

<style scoped>
/* Hero Typography Styles */
.hero-title {
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  letter-spacing: 0;
}

.hero-tagline {
  font-family: 'Cormorant Garamond', 'Playfair Display', serif;
  font-weight: 400;
  letter-spacing: 0;
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out forwards;
}

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
</style>