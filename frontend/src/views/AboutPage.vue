<template>
  <DefaultLayout>
    <div class="about-page">
      <!-- Hero Section -->
      <section class="relative h-[45vh] md:h-[55vh] bg-cover bg-center flex items-center hero-section pt-[62px] md:pt-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/65 to-black/55"></div>
        <div class="max-w-7xl mx-auto px-8 w-full relative z-10">
          <h1 class="text-white text-3xl md:text-[40px] md:leading-[48px] font-medium leading-tight max-w-4xl" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
            Notre <span class="italic" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Histoire</span>
          </h1>
          <p class="text-white text-sm md:text-[16px] leading-relaxed font-normal mt-4 max-w-2xl" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
            Une passion pour l'hospitalité et l'excellence
          </p>
        </div>
      </section>

      <!-- Story Section -->
      <section class="bg-white py-16 md:py-24">
        <div class="container-aligned">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left - Image -->
            <div class="order-2 lg:order-1">
              <img 
                src="/images/apartments/apart1.jpg" 
                alt="Kaylia Suite Home" 
                class="w-full h-[400px] md:h-[500px] object-cover rounded-2xl shadow-xl"
              />
            </div>
            
            <!-- Right - Content -->
            <div class="order-1 lg:order-2">
              <h2 class="text-2xl md:text-[40px] leading-tight font-bold text-gray-900 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                L'origine de <span class="text-[#1c5d78]">Kaylia Suite Home</span>
              </h2>
              <div class="space-y-4 text-sm md:text-[16px] leading-relaxed font-normal text-gray-600" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
                <p>
                  Fondée en 2020, Kaylia Suite Home est née d'une vision simple mais ambitieuse : 
                  offrir à Yaoundé un lieu d'hébergement qui allie le confort d'un chez-soi au luxe 
                  d'un hôtel haut de gamme.
                </p>
                <p>
                  Notre nom, "Kaylia", évoque la beauté et l'élégance, des valeurs que nous nous 
                  efforçons d'incarner dans chaque détail de nos appartements et de nos services.
                </p>
                <p>
                  Depuis nos débuts, nous avons accueilli des centaines de voyageurs, qu'ils soient 
                  en déplacement professionnel ou en quête de détente, et nous sommes fiers d'avoir 
                  créé un espace où chacun se sent comme chez soi.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Values Section -->
      <section class="bg-[#e8dcc8] py-16 md:py-24">
        <div class="container-aligned">
          <div class="text-center mb-12 md:mb-16">
            <h2 class="text-2xl md:text-[40px] leading-tight font-bold text-gray-900 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
              Nos <span class="italic text-[#1c5d78]" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Valeurs</span>
            </h2>
            <p class="text-sm md:text-[16px] leading-relaxed font-normal text-gray-600 max-w-2xl mx-auto" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
              Ce qui guide notre engagement envers l'excellence
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <!-- Value 1 -->
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow">
              <div class="w-14 h-14 md:w-16 md:h-16 bg-[#1c5d78] rounded-full flex items-center justify-center mb-4 md:mb-6 mx-auto">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              <h3 class="text-xl md:text-2xl leading-tight font-bold text-gray-900 mb-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Excellence</h3>
              <p class="text-sm md:text-[16px] leading-relaxed font-normal text-gray-600 text-center" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
                Nous nous engageons à offrir des services et des installations de la plus haute qualité, 
                dépassant constamment les attentes de nos clients.
              </p>
            </div>

            <!-- Value 2 -->
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow">
              <div class="w-14 h-14 md:w-16 md:h-16 bg-[#1c5d78] rounded-full flex items-center justify-center mb-4 md:mb-6 mx-auto">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </div>
              <h3 class="text-xl md:text-2xl leading-tight font-bold text-gray-900 mb-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Hospitalité</h3>
              <p class="text-sm md:text-[16px] leading-relaxed font-normal text-gray-600 text-center" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
                Chaque client est accueilli avec chaleur et attention. Nous créons une atmosphère 
                où chacun se sent valorisé et pris en charge.
              </p>
            </div>

            <!-- Value 3 -->
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow">
              <div class="w-14 h-14 md:w-16 md:h-16 bg-[#1c5d78] rounded-full flex items-center justify-center mb-4 md:mb-6 mx-auto">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
              </div>
              <h3 class="text-xl md:text-2xl leading-tight font-bold text-gray-900 mb-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Authenticité</h3>
              <p class="text-sm md:text-[16px] leading-relaxed font-normal text-gray-600 text-center" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
                Nous restons fidèles à notre identité camerounaise tout en offrant des standards 
                internationaux de confort et de service.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Team Section -->
      <section class="bg-white py-16 md:py-24">
        <div class="container-aligned">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left - Content -->
            <div>
              <h2 class="text-2xl md:text-[40px] leading-tight font-bold text-gray-900 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Une équipe <span class="italic text-[#1c5d78]" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">passionnée</span>
              </h2>
              <div class="space-y-4 text-sm md:text-[16px] leading-relaxed font-normal text-gray-600" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
                <p>
                  Derrière Kaylia Suite Home se trouve une équipe dévouée de professionnels de 
                  l'hospitalité qui partagent une passion commune : créer des expériences mémorables 
                  pour nos clients.
                </p>
                <p>
                  De notre personnel d'accueil à notre équipe de maintenance, en passant par nos 
                  thérapeutes du SPA, chaque membre de notre équipe est formé pour offrir un service 
                  personnalisé et attentionné.
                </p>
                <p>
                  Nous croyons que ce sont les petites attentions qui font toute la différence, et 
                  notre équipe s'efforce chaque jour de dépasser vos attentes.
                </p>
              </div>
            </div>

            <!-- Right - Image -->
            <div>
              <img 
                src="/images/studio/studio2.jpg" 
                alt="Notre équipe" 
                class="w-full h-[400px] md:h-[500px] object-cover rounded-2xl shadow-xl"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Stats Section -->
      <section class="bg-[#1c5d78] py-16 md:py-20">
        <div class="container-aligned">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">2020</div>
              <div class="text-white/80 text-sm md:text-base" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">Année de création</div>
            </div>

            <!-- Stat 2 -->
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">500+</div>
              <div class="text-white/80 text-sm md:text-base" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">Clients satisfaits</div>
            </div>

            <!-- Stat 3 -->
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">4,9</div>
              <div class="text-white/80 text-sm md:text-base" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">Note moyenne</div>
            </div>

            <!-- Stat 4 -->
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">24/7</div>
              <div class="text-white/80 text-sm md:text-base" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">Service disponible</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Vision Section -->
      <section class="bg-[#b8a088] py-16 md:py-24">
        <div class="container-aligned">
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-[40px] leading-tight font-bold text-gray-900 mb-6 md:mb-8" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
              Notre <span class="italic text-[#1c5d78]" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Vision</span>
            </h2>
            <p class="text-gray-900 text-sm md:text-[16px] leading-relaxed font-normal mb-6 md:mb-8" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
              Devenir la référence en matière d'hébergement haut de gamme à Yaoundé, reconnue pour 
              son excellence, son authenticité et son engagement envers le bien-être de ses clients.
            </p>
            <p class="text-gray-900 text-sm md:text-[16px] leading-relaxed font-normal" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
              Nous aspirons à créer un espace où le luxe rencontre la convivialité, où chaque séjour 
              devient une expérience inoubliable, et où nos clients se sentent véritablement chez eux.
            </p>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-white py-16 md:py-20">
        <div class="container-aligned text-center">
          <h2 class="text-2xl md:text-[40px] leading-tight font-bold text-gray-900 mb-4 md:mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Prêt à vivre l'expérience <span class="italic text-[#1c5d78]" style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Kaylia</span> ?
          </h2>
          <p class="text-sm md:text-[16px] leading-relaxed font-normal text-gray-600 mb-6 md:mb-8 max-w-2xl mx-auto" style="font-family: 'Rounded Mplus 1c', sans-serif; font-weight: 400;">
            Découvrez nos appartements et laissez-nous vous offrir un séjour exceptionnel
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <router-link 
              to="/appartements" 
              class="bg-[#1c5d78] hover:bg-[#164a5f] text-white px-8 py-4 rounded-lg text-base font-medium transition-all duration-200 inline-block"
            >
              Découvrir nos appartements
            </router-link>
            <router-link 
              to="/contact" 
              class="bg-white hover:bg-gray-50 text-[#1c5d78] border-2 border-[#1c5d78] px-8 py-4 rounded-lg text-base font-medium transition-all duration-200 inline-block"
            >
              Nous contacter
            </router-link>
          </div>
        </div>
      </section>

      <!-- Newsletter Section -->
      <NewsletterSection />
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import NewsletterSection from '@/components/home/NewsletterSection.vue'
</script>

<style scoped>
.hero-section {
  background-image: url('/images/apartments/hero.jpg');
  background-size: cover;
  background-position: center;
}
</style>
