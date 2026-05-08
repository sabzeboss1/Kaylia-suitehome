<template>
  <header 
    class="fixed top-0 left-0 right-0 z-50 text-white transition-all duration-300 border-b-2 border-white/30"
    :class="getHeaderClass"
  >
    <!-- ===== MOBILE HEADER (visible only on mobile) ===== -->
    <div class="md:hidden flex items-center justify-between px-3 h-[62px] border-b border-white/40 max-w-full">
      <!-- Left: Hamburger menu -->
      <button 
        class="z-10 flex-shrink-0 w-10 h-10 flex items-center justify-center"
        :class="shouldBeTransparent && !isScrolled ? 'text-gray-900' : 'text-white'"
        @click="toggleMobileMenu"
        aria-label="Ouvrir le menu"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          <line x1="3" y1="8" x2="21" y2="8"/>
          <line x1="3" y1="14" x2="21" y2="14"/>
          <line x1="3" y1="20" x2="21" y2="20"/>
        </svg>
      </button>

      <!-- Center: Mobile Logo (flexbox centered) -->
      <router-link 
        to="/" 
        class="flex-1 flex justify-center items-center mx-2"
      >
        <img 
          :src="mobileLogoSrc" 
          alt="Kaylia Suite Home" 
          class="h-9 w-auto object-contain drop-shadow-md max-w-[120px]"
        />
      </router-link>

      <!-- Right: Réserver CTA button (caché sur la page réserver) -->
      <router-link 
        v-if="route.path !== '/reserver'"
        to="/reserver" 
        class="z-10 flex-shrink-0 h-9 bg-[#0B6087] hover:bg-[#094d6b] active:bg-[#073d57] text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm whitespace-nowrap"
      >
        Réserver
      </router-link>
      <!-- Spacer pour équilibrer quand on est sur /reserver -->
      <div v-else class="w-10 flex-shrink-0"></div>
    </div>

    <!-- ===== DESKTOP HEADER (visible only on md+) ===== -->
    <nav class="hidden md:flex max-w-7xl mx-auto px-8 py-4 items-center justify-between">
      <!-- Logo à l'extrême gauche -->
      <div class="flex items-center">
        <router-link to="/" class="flex items-center">
          <img 
            :src="shouldBeTransparent && !isScrolled ? '/images/logoblack.png' : '/images/logo.png'" 
            alt="Kaylia Suite Home" 
            class="h-16 w-auto object-contain" 
          />
        </router-link>
      </div>

      <!-- Menu Navigation + CTA groupés à droite -->
      <div class="flex items-center gap-8">
        <!-- Navigation Menu (Desktop) -->
        <ul class="flex items-center space-x-6 lg:space-x-8 text-base font-medium" style="font-family: 'Poppins', sans-serif; line-height: 24px;" :class="shouldBeTransparent && !isScrolled ? 'text-gray-900' : 'text-white'">
          <li class="relative group">
            <button 
              @click="toggleApartmentsMenu"
              class="hover:text-gray-300 flex items-center transition"
              :class="{ 'text-gray-300': isActiveRoute('/appartements') || isActiveRoute('/studio') }"
            >
              Nos Appartements
              <svg 
                class="w-3.5 h-3.5 ml-1.5 transition-transform"
                :class="{ 'rotate-180': showApartmentsMenu }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
                stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <!-- Dropdown Menu -->
            <div 
              v-show="showApartmentsMenu"
              class="absolute left-0 top-full mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-lg py-2 z-50"
            >
              <router-link 
                to="/nos-appartements" 
                class="block px-4 py-2 hover:bg-gray-100 transition"
                @click="showApartmentsMenu = false"
              >
                Tous les appartements
              </router-link>
              <router-link 
                to="/studio" 
                class="block px-4 py-2 hover:bg-gray-100 transition"
                @click="showApartmentsMenu = false"
              >
                Chambre
              </router-link>
            </div>
          </li>

          <li>
            <router-link 
              to="/spa" 
              class="hover:text-gray-300 transition"
              :class="{ 'text-gray-300': isActiveRoute('/spa') }"
            >
              SPA
            </router-link>
          </li>
          <li>
            <router-link to="/histoire" class="hover:text-gray-300 transition">
              Notre Histoire
            </router-link>
          </li>
          <li>
            <router-link 
              to="/contact" 
              class="hover:text-gray-300 transition"
              :class="{ 'text-gray-300': isActiveRoute('/contact') }"
            >
              Contact
            </router-link>
          </li>
        </ul>

        <!-- Language Selector -->
        <div class="relative">
          <button 
            class="flex items-center hover:text-gray-300 transition text-base font-medium"
            style="font-family: 'Poppins', sans-serif; line-height: 24px;"
            :class="shouldBeTransparent && !isScrolled ? 'text-gray-900' : 'text-white'"
            @click="toggleLanguageMenu"
            :disabled="isTranslating"
          >
            <span :class="{ 'opacity-50': isTranslating }">{{ displayLanguage }}</span>
            <svg 
              v-if="!isTranslating"
              class="w-3 h-3 ml-1 transition-transform"
              :class="{ 'rotate-180': showLanguageMenu }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
            <svg 
              v-else
              class="w-3 h-3 ml-1 animate-spin"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </button>
          <!-- Language Dropdown -->
          <div 
            v-show="showLanguageMenu"
            class="absolute right-0 top-full mt-2 w-16 bg-white text-gray-900 rounded-lg shadow-lg py-1 z-50"
          >
            <button 
              @click="changeLanguage('FR')"
              class="block w-full text-left px-3 py-1.5 text-xs hover:bg-gray-100 transition"
              :class="{ 'bg-gray-100 font-semibold': displayLanguage === 'FR' }"
              :disabled="isTranslating"
            >
              FR
            </button>
            <button 
              @click="changeLanguage('EN')"
              class="block w-full text-left px-3 py-1.5 text-xs hover:bg-gray-100 transition"
              :class="{ 'bg-gray-100 font-semibold': displayLanguage === 'EN' }"
              :disabled="isTranslating"
            >
              EN
            </button>
          </div>
        </div>

        <!-- CTA Button - Bleu canard/pétrole -->
        <router-link 
          to="/reserver" 
          class="min-h-[44px] bg-[#0B6087] hover:bg-[#094d6b] active:bg-[#073d57] text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm flex items-center"
        >
          Réserver
        </router-link>
      </div>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useUIStore } from '@/stores/ui'
import { useTranslation } from '@/composables/useTranslation'

const route = useRoute()
const uiStore = useUIStore()
const { currentLanguage, isTranslating, changeLanguage: translateTo } = useTranslation()

const isScrolled = ref(false)
const showApartmentsMenu = ref(false)
const showLanguageMenu = ref(false)

// Display language code
const displayLanguage = computed(() => currentLanguage.value.toUpperCase())

// Check if current route should have dark background
const shouldHaveDarkBackground = computed(() => {
  return false // Plus utilisé, toutes les pages avec fond sombre utilisent shouldBeTransparent
})

// Check if current route should have transparent background
const shouldBeTransparent = computed(() => {
  return route.path === '/reserver' || route.path === '/paiement' || route.path === '/spa' || route.path === '/contact'
})

// Get logo source based on route
const mobileLogoSrc = computed(() => {
  if (shouldBeTransparent.value) {
    return '/images/logomobileblack.png'
  }
  return '/images/logomobile.png'
})

// Get header class based on route and scroll
const getHeaderClass = computed(() => {
  // Transparent on /reserver and /paiement
  if (shouldBeTransparent.value && !isScrolled.value) {
    return 'bg-transparent'
  }
  // Toujours avec fond sombre au scroll ou sur certaines pages
  if (isScrolled.value || shouldHaveDarkBackground.value) {
    return 'bg-[#2c3e50] shadow-lg'
  }
  // Transparent par défaut
  return 'bg-transparent'
})

// Check if route is active
const isActiveRoute = (path: string) => {
  return route.path === path
}

// Toggle mobile menu
const toggleMobileMenu = () => {
  uiStore.toggleMobileMenu()
}

// Toggle apartments dropdown
const toggleApartmentsMenu = () => {
  showApartmentsMenu.value = !showApartmentsMenu.value
  showLanguageMenu.value = false
}

// Toggle language menu
const toggleLanguageMenu = () => {
  showLanguageMenu.value = !showLanguageMenu.value
  showApartmentsMenu.value = false
}

// Change language
const changeLanguage = async (lang: 'FR' | 'EN') => {
  showLanguageMenu.value = false
  const langCode = lang.toLowerCase() as 'fr' | 'en'
  await translateTo(langCode)
}

// Close dropdowns when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  const target = event.target as HTMLElement
  if (!target.closest('.relative')) {
    showApartmentsMenu.value = false
    showLanguageMenu.value = false
  }
}

// Handle scroll for sticky header effect
const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.logo-text {
  font-family: 'Montserrat', sans-serif;
  font-weight: 300;
}

/* Ensure dropdowns appear above other content */
.relative {
  position: relative;
}
</style>
