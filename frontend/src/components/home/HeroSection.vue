<template>
  <section class="hero relative h-[85vh] flex flex-col text-white overflow-hidden">
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
      v-else 
      class="absolute inset-0 z-0 bg-cover bg-center"
      :style="{ backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(${getImageUrl()})` }"
    ></div>

    <!-- Content (always on top) -->
    <div class="container mx-auto px-6 md:px-20 flex flex-col h-full py-8 md:py-12 justify-center gap-12 md:gap-16 lg:gap-20 relative z-10">
      <!-- Title and text -->
      <div class="w-full">
        <div class="max-w-[761px] animate-fade-in-up text-center md:text-left">
          <h1 class="hero-title text-[32px] md:text-[40px] leading-[40px] md:leading-[48px] mb-6 font-medium">
            KAYLIA SUITE HOME<br>
            L'ART du Confort &<br class="md:hidden">
            du Luxe à Yaoundé
          </h1>
          
          <p class="hero-tagline text-[24px] md:text-[32px] lg:text-[36px] leading-[36px] md:leading-[48px] tracking-normal font-normal italic">
            {{ heroTagline || 'Vivez une expérience unique, mémorable et chaleureuse' }}
          </p>
        </div>
      </div>
      
      <!-- Search box -->
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
    if (heroMedia.value.url.startsWith('http')) {
      return heroMedia.value.url
    }
    // Remove leading slash if present to avoid double slash
    const cleanUrl = heroMedia.value.url.startsWith('/') ? heroMedia.value.url.substring(1) : heroMedia.value.url
    return `${import.meta.env.VITE_API_BASE_URL.replace('/api', '')}/storage/${cleanUrl}`
  }
  return defaultImage
}

onMounted(async () => {
  try {
    // Load hero content
    const response = await axios.get('/content/home')
    const content = response.data.data
    
    // Parse hero background (media_choice)
    if (content.hero_background) {
      heroMedia.value = typeof content.hero_background === 'string' 
        ? JSON.parse(content.hero_background) 
        : content.hero_background
    }
    
    // Load text content
    heroTitle.value = content.hero_title || ''
    heroSubtitle.value = content.hero_subtitle || ''
    heroTagline.value = content.hero_tagline || ''
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