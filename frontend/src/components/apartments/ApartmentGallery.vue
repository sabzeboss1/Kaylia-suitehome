<template>
  <section class="gallery-section">
    <div class="gallery-container">
      <!-- Header -->
      <div class="gallery-header">
        <h2 class="gallery-title">
          Galerie <span class="gallery-title-accent">photos</span>
        </h2>
        <p class="gallery-subtitle">{{ subtitle }}</p>
      </div>

      <!-- Gallery Grid -->
      <div class="gallery-grid">
        <!-- Large Image - Left -->
        <div class="gallery-main-image">
          <img 
            :src="displayedImage.url" 
            :alt="displayedImage.alt"
            class="gallery-image"
          />
          
          <!-- Navigation Buttons -->
          <div class="gallery-nav-buttons">
            <button
              @click="navigatePrev"
              class="gallery-nav-btn"
              aria-label="Image précédente"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <button
              @click="navigateNext"
              class="gallery-nav-btn"
              aria-label="Image suivante"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Right Column - 3 Thumbnails -->
        <div class="gallery-thumbnails">
          <!-- Thumbnail 1 - Simple Image -->
          <div class="gallery-thumbnail">
            <img 
              :src="thumbnails[0]?.url" 
              :alt="thumbnails[0]?.alt"
              class="gallery-image"
            />
          </div>

          <!-- Thumbnail 2 - View All Photos -->
          <div 
            class="gallery-thumbnail gallery-thumbnail-overlay"
            @click="openPhotoGallery"
          >
            <img 
              :src="thumbnails[1]?.url" 
              :alt="thumbnails[1]?.alt"
              class="gallery-image"
            />
            <div class="gallery-overlay">
              <div class="gallery-overlay-content">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="gallery-overlay-text">Voir les</p>
                <p class="gallery-overlay-number">{{ totalPhotos }} photos</p>
              </div>
            </div>
          </div>

          <!-- Thumbnail 3 - View Video -->
          <div 
            class="gallery-thumbnail gallery-thumbnail-overlay"
            @click="openVideoModal"
          >
            <img 
              :src="thumbnails[2]?.url" 
              :alt="thumbnails[2]?.alt"
              class="gallery-image"
            />
            <div class="gallery-overlay">
              <div class="gallery-overlay-content">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="gallery-overlay-text">Voir la vidéo</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Photo Gallery Modal -->
    <Teleport to="body">
      <div v-if="showPhotoModal" class="gallery-modal" @click="closeModals">
        <div class="gallery-modal-content" @click.stop>
          <button @click="closeModals" class="gallery-modal-close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
          
          <h3 class="gallery-modal-title">Galerie Photos ({{ totalPhotos }} photos)</h3>
          
          <div class="gallery-modal-grid">
            <div v-for="(image, index) in allImages" :key="index" class="gallery-modal-item">
              <img :src="image.url" :alt="image.alt" class="gallery-modal-image" />
            </div>
          </div>
        </div>
      </div>

      <!-- Video Modal -->
      <div v-if="showVideoModal" class="gallery-modal" @click="closeModals">
        <div class="gallery-modal-content gallery-modal-video" @click.stop>
          <button @click="closeModals" class="gallery-modal-close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
          
          <h3 class="gallery-modal-title">Vidéo de présentation</h3>
          
          <div class="gallery-video-container">
            <p class="text-gray-600 text-center">Vidéo de présentation à venir...</p>
            <!-- Vous pouvez ajouter un iframe YouTube/Vimeo ici -->
          </div>
        </div>
      </div>
    </Teleport>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

interface Thumbnail {
  url: string
  alt: string
}

interface Props {
  mainImage?: string
  mainImageAlt?: string
  thumbnails?: Thumbnail[]
  totalPhotos?: number
  subtitle?: string
}

const props = withDefaults(defineProps<Props>(), {
  mainImage: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80',
  mainImageAlt: 'Immeuble Kaylia Suite Home',
  thumbnails: () => [
    { url: 'https://images.unsplash.com/photo-1556912173-46c336c7fd55?w=400&q=80', alt: 'Cuisine équipée' },
    { url: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80', alt: 'Salon moderne' },
    { url: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&q=80', alt: 'Salle de bain' }
  ],
  totalPhotos: 57,
  subtitle: 'Retrouvez nos appartements disponibles par rapport à vos dates de séjour.'
})

const emit = defineEmits<{
  'view-all-photos': []
  'view-video': []
  'navigate-prev': []
  'navigate-next': []
}>()

// Carousel state
const currentImageIndex = ref(0)

// All images for carousel
const allImages = computed(() => {
  return [
    { url: props.mainImage, alt: props.mainImageAlt },
    ...props.thumbnails
  ]
})

// Current displayed image
const displayedImage = computed(() => allImages.value[currentImageIndex.value])

// Navigation handlers
const navigatePrev = () => {
  currentImageIndex.value = (currentImageIndex.value - 1 + allImages.value.length) % allImages.value.length
  emit('navigate-prev')
}

const navigateNext = () => {
  currentImageIndex.value = (currentImageIndex.value + 1) % allImages.value.length
  emit('navigate-next')
}

// Modal state
const showPhotoModal = ref(false)
const showVideoModal = ref(false)

const openPhotoGallery = () => {
  showPhotoModal.value = true
  emit('view-all-photos')
}

const openVideoModal = () => {
  showVideoModal.value = true
  emit('view-video')
}

const closeModals = () => {
  showPhotoModal.value = false
  showVideoModal.value = false
}
</script>

<style scoped>
/* Container */
.gallery-section {
  background-color: white;
  padding: 2rem 0;
}

.gallery-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  color: #333;
}

@media (min-width: 768px) {
  .gallery-container {
    padding: 0 2rem;
  }
}

/* Header */
.gallery-header {
  text-align: center;
  margin-bottom: 2rem;
}

@media (min-width: 768px) {
  .gallery-header {
    margin-bottom: 2.5rem;
  }
}

.gallery-title {
  font-size: 24px;
  font-weight: 700;
  color: #000;
  margin: 0 0 8px 0;
}

@media (min-width: 768px) {
  .gallery-title {
    font-size: 32px;
  }
}

.gallery-title-accent {
  color: #4A90E2;
  font-style: italic;
  font-weight: 400;
}

.gallery-subtitle {
  font-size: 14px;
  color: #666;
  margin: 0;
  padding: 0 1rem;
}

@media (min-width: 768px) {
  .gallery-subtitle {
    font-size: 32px;
    padding: 0;
  }
}

/* Grid Layout */
.gallery-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 12px;
  align-items: start;
}

@media (min-width: 768px) {
  .gallery-grid {
    grid-template-columns: 2fr 1fr;
    gap: 42px;
  }
}

/* Main Image */
.gallery-main-image {
  position: relative;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  border-radius: 12px;
  width: 100%;
  height: auto;
}

@media (min-width: 768px) {
  .gallery-main-image {
    aspect-ratio: 4 / 3;
    height: 600px;
  }
}

.gallery-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Navigation Buttons */
.gallery-nav-buttons {
  position: absolute;
  bottom: 12px;
  right: 12px;
  display: flex;
  gap: 8px;
}

@media (min-width: 768px) {
  .gallery-nav-buttons {
    bottom: 20px;
    right: 20px;
    gap: 12px;
  }
}

.gallery-nav-btn {
  width: 36px;
  height: 36px;
  background-color: white;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

@media (min-width: 768px) {
  .gallery-nav-btn {
    width: 40px;
    height: 40px;
  }
}

.gallery-nav-btn:hover {
  background-color: #f5f5f5;
  transform: scale(1.05);
}

/* Thumbnails Column */
.gallery-thumbnails {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}

@media (min-width: 768px) {
  .gallery-thumbnails {
    display: grid;
    grid-template-rows: repeat(3, 1fr);
    grid-template-columns: 1fr;
    gap: 12px;
    height: 600px;
  }
}

.gallery-thumbnail {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  cursor: pointer;
  aspect-ratio: 1 / 1;
  width: 100%;
  height: auto;
}

@media (min-width: 768px) {
  .gallery-thumbnail {
    aspect-ratio: auto;
    height: 100%;
    border-radius: 12px;
  }
}

.gallery-thumbnail-overlay:hover .gallery-image {
  filter: brightness(1.1);
}

.gallery-thumbnail .gallery-image {
  transition: filter 0.3s ease;
}

/* Overlay */
.gallery-overlay {
  position: absolute;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
}

.gallery-thumbnail-overlay:hover .gallery-overlay {
  background-color: rgba(0, 0, 0, 0.6);
}

.gallery-overlay-content {
  text-align: center;
  color: white;
}

.gallery-overlay-text {
  font-size: 14px;
  font-weight: 700;
  margin: 0;
}

@media (min-width: 768px) {
  .gallery-overlay-text {
    font-size: 18px;
  }
}

.gallery-overlay-number {
  font-size: 14px;
  font-weight: 700;
  margin: 0;
}

@media (min-width: 768px) {
  .gallery-overlay-number {
    font-size: 18px;
  }
}

.gallery-overlay-content svg {
  width: 32px;
  height: 32px;
}

@media (min-width: 768px) {
  .gallery-overlay-content svg {
    width: 48px;
    height: 48px;
  }
}

/* Modals */
.gallery-modal {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
  overflow-y: auto;
}

.gallery-modal-content {
  background-color: white;
  border-radius: 12px;
  max-width: 1200px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  padding: 40px 30px 30px;
}

.gallery-modal-video {
  max-width: 900px;
}

.gallery-modal-close {
  position: absolute;
  top: 15px;
  right: 15px;
  width: 40px;
  height: 40px;
  background-color: white;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  z-index: 10;
}

.gallery-modal-close:hover {
  background-color: #f5f5f5;
  transform: scale(1.1);
}

.gallery-modal-title {
  font-size: 24px;
  font-weight: 700;
  color: #333;
  margin-bottom: 30px;
  text-align: center;
}

.gallery-modal-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

.gallery-modal-item {
  aspect-ratio: 4 / 3;
  overflow: hidden;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.gallery-modal-item:hover {
  transform: scale(1.05);
}

.gallery-modal-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallery-video-container {
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f5f5f5;
  border-radius: 8px;
}

@media (max-width: 768px) {
  .gallery-modal-content {
    padding: 50px 20px 20px;
  }
  
  .gallery-modal-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 12px;
  }
}
</style>
