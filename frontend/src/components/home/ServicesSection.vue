<template>
  <section class="bg-[#22333b] text-white py-12 md:py-20 full-width-aligned">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-[32px] leading-[24px] font-semibold text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
        Nos <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Services</span>
      </h2>
      <p class="text-base leading-6 md:text-[24px] md:leading-[24px] text-gray-300 mx-auto max-w-xs md:max-w-none md:whitespace-nowrap" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400; letter-spacing: 0;">
        Profitez d'un séjour sans compromis avec nos services premium conçu pour votre confort.
      </p>
    </div>

    <div class="grid grid-cols-3 gap-6 md:gap-12 max-w-4xl mx-auto">
      <div 
        v-for="service in services" 
        :key="service.name"
        class="text-center"
      >
        <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full mx-auto mb-3 md:mb-4 flex items-center justify-center p-4 md:p-5">
          <img 
            :src="service.icon" 
            :alt="service.name"
            class="w-8 h-8 md:w-10 md:h-10 object-contain"
          />
        </div>
        <h3 class="text-[8px] leading-[100%] md:text-[16px] md:leading-[100%] font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600; letter-spacing: 0;">{{ service.name }}</h3>
        <div class="w-12 h-[2px] bg-[#A8927D] mx-auto mt-6"></div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const services = [
  { name: 'Wi-Fi haut débit', icon: '/images/equipements/Wifi.ico' },
  { name: 'Sécurité 24/7', icon: '/images/equipements/Sécurité.ico' },
  { name: 'SPA & Bien-être', icon: '/images/equipements/SPA.ico' },
  { name: 'Conciergerie', icon: '/images/equipements/Conciergerie.ico' },
  { name: 'Cuisine Équipée', icon: '/images/equipements/Cuisine équipée.ico' },
  { name: 'Climatisation', icon: '/images/equipements/Climatisation.ico' }
]
</script>
