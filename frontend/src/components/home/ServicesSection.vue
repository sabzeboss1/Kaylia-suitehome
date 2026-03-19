<template>
  <section class="bg-[#22333b] text-white py-12 md:py-20 px-6 md:px-20">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-[32px] leading-[24px] font-semibold text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
        Nos <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Services</span>
      </h2>
      <p class="text-[16px] leading-[24px] font-light text-gray-300 max-w-3xl mx-auto" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 300;">
        Profitez d'un séjour sans compromis avec nos services premium conçus pour votre confort.
      </p>
    </div>

    <div class="grid grid-cols-3 gap-6 md:gap-12 max-w-4xl mx-auto">
      <div 
        v-for="service in services" 
        :key="service.name"
        class="text-center"
      >
        <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full mx-auto mb-3 md:mb-4 flex items-center justify-center p-3 md:p-4">
          <img 
            :src="service.icon" 
            :alt="service.name"
            class="w-full h-full object-contain"
          />
        </div>
        <h3 class="text-xs md:text-sm font-medium">{{ service.name }}</h3>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const services = [
  { name: 'Wi-Fi haut débit', icon: '/images/équipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/équipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/équipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/équipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/équipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/équipements/Climatisation.ico' }
]
</script>
