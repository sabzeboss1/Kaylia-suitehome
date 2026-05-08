<template>
  <section class="bg-[#a8927d] text-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-3 md:px-8">
      <!-- Header -->
      <h2 class="text-3xl md:text-4xl mb-4 text-center">
        <span class="font-bold text-white">Réservez</span>  
        <span class="font-serif italic text-gray-900"> sur notre site</span>
      </h2>
      
      <p class="text-base leading-6 font-light mb-12 text-white max-w-3xl mx-auto text-center" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300; letter-spacing: 0;">
        Réservez directement sur le site Kaylia Suite Home pour profiter d'avantages exclusifs lors de votre séjour dans notre appart'hôtel
      </p>

      <!-- Benefits Grid - 3 columns on mobile, horizontal on desktop -->
      <div class="grid grid-cols-3 gap-4 md:flex md:flex-wrap md:justify-between md:gap-y-8 mb-12">
        <div 
          v-for="(benefit, index) in benefits" 
          :key="benefit.name"
          class="flex flex-col items-center gap-4 md:gap-3"
          :class="{ 'col-start-1': index === 3, 'col-start-2': index === 4 }"
        >
          <!-- Icon Circle -->
          <div class="w-12 h-12 md:w-20 md:h-20 bg-[#2c3e50] rounded-full flex items-center justify-center shadow-lg p-2.5 md:p-4">
            <img 
              :src="benefit.icon" 
              :alt="benefit.name"
              class="w-full h-full object-contain filter brightness-0 invert"
            />
          </div>
          
          <!-- Benefit Title -->
          <h3 class="text-[8px] leading-[12px] md:text-base md:leading-none font-semibold text-white text-center" style="font-family: Poppins; letter-spacing: 0%;">
            {{ benefit.name }}
          </h3>
        </div>
      </div>

      <!-- Footer CTA -->
      <p class="text-base font-normal mb-8 text-white text-center leading-none max-w-xl mx-auto" style="font-family: Ruluko; letter-spacing: 0%;">
        Vivez une expérience unique et authentique en réservant maintenant pour des souvenirs mémorables
      </p>

      <div class="flex justify-center">
        <button 
          @click="navigateToBooking"
          class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-12 py-3.5 rounded text-base font-normal transition-colors duration-300"
        >
          Réserver
        </button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const benefits = [
  { name: 'Meilleur Tarif Garanti', icon: '/images/rdv/Meilleur tarif garentie.ico' },
  { name: 'Offres exclusives', icon: '/images/rdv/Lit.ico' },
  { name: 'Flexibilité', icon: '/images/rdv/Flexibilité.ico' },
  { name: 'Service client personnalisé', icon: '/images/rdv/Service client personnalisé.ico' },
  { name: 'Accueil sur mesure', icon: '/images/rdv/Accueil sur mesure.ico' }
]

const navigateToBooking = () => {
  // Scroll to the top of the page where the search filter is located
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}
</script>

<style scoped>
/* Ensure proper spacing and alignment */
@media (min-width: 768px) {
  .flex-wrap > div {
    flex: 0 1 auto;
  }
}
</style>
