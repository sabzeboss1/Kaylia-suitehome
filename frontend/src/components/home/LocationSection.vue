<template>
  <section class="section-aligned bg-white py-16 md:py-24">
    <div class="section-content">
      <!-- Two Column Layout with Flexbox (Reversed order from SPA section) -->
      <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12 lg:gap-16">
        
        <!-- Left Column: Map Card -->
        <div class="w-full md:w-1/2 order-2 md:order-1">
          <div class="map-card border border-gray-200 rounded-lg overflow-hidden">
            <iframe 
              width="100%" 
              height="100%" 
              frameborder="0" 
              scrolling="no" 
              marginheight="0" 
              marginwidth="0" 
              id="gmap_canvas" 
              src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=Monter%20jouvence%20yaound%C3%A9%20%20%20Yaound%C3%A9+()&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
              class="w-full h-80 md:h-96 lg:h-[450px]"
              title="Localisation Kaylia Suite Home"
            ></iframe>
          </div>
        </div>
        
        <!-- Right Column: Content -->
        <div class="w-full md:w-1/2 order-1 md:order-2">
          <!-- Title -->
          <h2 class="text-[32px] leading-[24px] font-semibold text-gray-900 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
            Localisation
          </h2>
          
          <!-- Description -->
          <p class="text-[16px] leading-[24px] text-gray-600 mb-6" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
            Idéalement situé dans le quartier calme et sécurisé de Jouvence, Kaylia Suite Home vous offre un accès privilégié aux attractions de la ville de Yaoundé, tout en vous garantissant tranquillité et sérénité.
          </p>
          
          <!-- Advantages List -->
          <ul class="space-y-3 mb-8 ml-5">
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>À 10 minutes du centre-ville de Yaoundé</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Quartier résidentiel calme et sécurisé</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Proche des commerces et restaurants</span>
            </li>
            <li class="flex items-start gap-3 text-base text-gray-700">
              <span class="text-gray-900 mt-1 flex-shrink-0">•</span>
              <span>Accès facile aux principales attractions touristiques</span>
            </li>
          </ul>

          <!-- CTA Button (Outlined Style) -->
          <div class="flex justify-center md:justify-start">
            <button 
              @click="openMap"
              class="w-full md:w-auto bg-transparent border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white px-8 py-3.5 rounded text-base font-medium transition-colors duration-300 mt-4"
            >
              Voir sur la carte
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const openMap = () => {
  // Ouvrir Google Maps dans un nouvel onglet
  window.open('https://maps.google.com/maps?q=Monter%20jouvence%20yaound%C3%A9%20%20%20Yaound%C3%A9', '_blank')
}
</script>

<style scoped>
.map-card {
  position: relative;
  box-shadow: none; /* Pas d'ombre portée visible */
}

/* Fallback background for iframe loading */
.map-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, #f5f5f5 0%, #e5e5e5 100%);
  z-index: -1;
}
</style>
