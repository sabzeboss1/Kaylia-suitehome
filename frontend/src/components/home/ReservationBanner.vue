<template>
  <section class="bg-[#a8927d] text-white py-16 md:py-20 px-6 md:px-12 text-center">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <h2 class="text-3xl md:text-4xl mb-4">
        <span class="font-bold text-white">Réservez</span>  
        <span class="font-serif italic text-[#0b6087]"> sur notre site</span>
      </h2>
      
      <p class="text-base md:text-lg font-light mb-12 text-white max-w-3xl mx-auto leading-relaxed">
        Réservez directement sur le site Kaylia Suite Home pour profiter d'avantages exclusifs lors de votre séjour dans notre appart'hôtel
      </p>

      <!-- Benefits Grid - Horizontal Layout -->
      <div class="flex flex-wrap justify-center gap-8 md:gap-12 mb-12 max-w-5xl mx-auto">
        <div 
          v-for="benefit in benefits" 
          :key="benefit.name"
          class="flex flex-col items-center w-32 md:w-36"
        >
          <!-- Icon Circle -->
          <div class="w-16 h-16 md:w-20 md:h-20 bg-[#2c3e50] rounded-full flex items-center justify-center mb-3 shadow-lg p-3.5 md:p-4">
            <img 
              :src="benefit.icon" 
              :alt="benefit.name"
              class="w-full h-full object-contain filter brightness-0 invert"
            />
          </div>
          
          <!-- Benefit Title -->
          <h3 class="text-xs md:text-sm font-bold text-white mb-2 text-center leading-tight">
            {{ benefit.name }}
          </h3>
          
          <!-- Separator Line -->
          <div class="w-10 h-0.5 bg-[#2c3e50]"></div>
        </div>
      </div>

      <!-- Footer CTA -->
      <p class="text-base md:text-lg font-light mb-8 text-white italic leading-relaxed">
        Vivez une expérience unique et authentique en réservant maintenant pour des souvenirs mémorables
      </p>

      <button 
        @click="navigateToBooking"
        class="bg-[#0b6087] hover:bg-[#094d6b] text-white px-12 py-3.5 rounded text-base font-normal transition-colors duration-300"
      >
        Réserver
      </button>
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
  router.push({ name: 'apartments' })
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
