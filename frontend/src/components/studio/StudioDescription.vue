<template>
  <div class="studio-description bg-white py-12 md:py-16 px-6 md:px-12 lg:px-16">
    <!-- Title -->
    <h2 class="title font-serif text-2xl md:text-3xl text-gray-900 mb-4 md:mb-6 leading-tight">
      Un studio pensé pour<br class="hidden md:block">votre confort
    </h2>

    <!-- Description -->
    <p class="description text-gray-600 text-sm md:text-base leading-relaxed max-w-[600px] mb-12 md:mb-16">
      {{ description }}
    </p>

    <!-- Video Section -->
    <div class="video-section">
      <h3 class="video-title font-serif text-xl md:text-2xl text-gray-900 mb-4 md:mb-6">
        Vidéo
      </h3>
      
      <!-- Video Placeholder -->
      <div 
        class="video-placeholder bg-gray-200 rounded-xl overflow-hidden aspect-video flex items-center justify-center cursor-pointer hover:bg-gray-300 transition-colors group relative"
        @click="handleVideoClick"
      >
        <!-- Play Icon -->
        <div class="play-icon-wrapper">
          <svg 
            class="w-20 h-20 md:w-24 md:h-24 text-gray-400 group-hover:text-gray-500 transition-colors" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
            stroke-width="1.5"
          >
            <circle cx="12" cy="12" r="10" stroke="currentColor" fill="none" />
            <path 
              d="M9.5 8.5l7 3.5-7 3.5V8.5z" 
              fill="currentColor" 
              stroke="none"
            />
          </svg>
        </div>

        <!-- Optional: Video iframe if videoUrl is provided -->
        <iframe
          v-if="videoUrl && isPlaying"
          :src="videoUrl"
          class="absolute inset-0 w-full h-full"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  title?: string
  description: string
  videoUrl?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Un studio pensé pour votre confort',
  description: 'Lorem ipsum dolor sit amet. Et adipisci rerum hic suscipit tempore aut quasi eligendi est Lorem temporibus aut voluptatibus officia id quasi verum. Est rerum illo aut adipisci suscipit vel voluptatibus natus.'
})

const isPlaying = ref(false)

const handleVideoClick = () => {
  if (props.videoUrl) {
    isPlaying.value = true
  } else {
    console.log('Aucune vidéo disponible')
  }
}
</script>

<style scoped>
.studio-description {
  text-align: left;
}

.title {
  font-family: 'Playfair Display', Georgia, serif;
  font-weight: 400;
  color: #1a1a1a;
}

.description {
  line-height: 1.7;
  color: #666;
}

.video-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-weight: 400;
  color: #1a1a1a;
}

.video-placeholder {
  position: relative;
  min-height: 300px;
}

.play-icon-wrapper {
  position: relative;
  z-index: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .studio-description {
    padding: 2rem 1.5rem;
  }
  
  .title {
    font-size: 1.5rem;
  }
  
  .description {
    font-size: 0.875rem;
  }
  
  .video-placeholder {
    min-height: 200px;
  }
}
</style>

