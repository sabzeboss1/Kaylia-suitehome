<template>
  <div class="video-preview rounded-lg overflow-hidden border border-navy-100 bg-black">
    <!-- YouTube -->
    <iframe 
      v-if="isYouTube" 
      :src="getYouTubeEmbed" 
      class="w-full aspect-video" 
      frameborder="0" 
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    ></iframe>
    
    <!-- Vimeo -->
    <iframe 
      v-else-if="isVimeo" 
      :src="getVimeoEmbed" 
      class="w-full aspect-video" 
      frameborder="0" 
      allow="autoplay; fullscreen; picture-in-picture"
      allowfullscreen
    ></iframe>
    
    <!-- Direct Video -->
    <video 
      v-else-if="isDirect" 
      :src="url" 
      controls 
      class="w-full aspect-video bg-black"
    >
      Votre navigateur ne supporte pas la lecture de vidéos.
    </video>
    
    <!-- Invalid URL -->
    <div 
      v-else 
      class="w-full aspect-video bg-navy-50 flex flex-col items-center justify-center text-navy-400 text-sm"
    >
      <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
      </svg>
      <p>URL vidéo invalide</p>
      <p class="text-xs mt-1">YouTube, Vimeo, ou fichier direct (.mp4, .webm)</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  url: {
    type: String,
    required: true
  }
})

const isYouTube = computed(() => 
  props.url?.includes('youtube.com') || props.url?.includes('youtu.be')
)

const isVimeo = computed(() => 
  props.url?.includes('vimeo.com')
)

const isDirect = computed(() => 
  /\.(mp4|webm|ogg)$/i.test(props.url)
)

const getYouTubeEmbed = computed(() => {
  if (!props.url) return ''
  const match = props.url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://www.youtube.com/embed/${videoId}` : ''
})

const getVimeoEmbed = computed(() => {
  if (!props.url) return ''
  const match = props.url.match(/vimeo\.com\/(\d+)/)
  const videoId = match ? match[1] : ''
  return videoId ? `https://player.vimeo.com/video/${videoId}` : ''
})
</script>

<style scoped>
.aspect-video {
  aspect-ratio: 16 / 9;
}
</style>
