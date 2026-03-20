<template>
  <header 
    class="fixed top-0 left-0 right-0 z-50 text-white transition-all duration-300"
    :class="shouldHaveDarkBackground ? 'bg-[#2c3e50] shadow-lg' : (isScrolled ? 'bg-[#1a2c3e]/90 backdrop-blur-sm shadow-lg' : 'bg-transparent')"
  >
    <!-- ===== MOBILE HEADER (visible only on mobile) ===== -->
    <div class="relative md:hidden flex items-center justify-between px-4 h-[62px] border-b border-white/40">
      <!-- Left: Hamburger menu -->
      <button 
        class="z-10 min-w-[44px] min-h-[44px] flex items-center justify-center text-white"
        @click="toggleMobileMenu"
        aria-label="Ouvrir le menu"
      >
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          <line x1="3" y1="8" x2="21" y2="8"/>
          <line x1="3" y1="14" x2="21" y2="14"/>
          <line x1="3" y1="20" x2="21" y2="20"/>
        </svg>
      </button>

      <!-- Center: Mobile Logo (absolute centered) -->
      <router-link 
        to="/" 
        class="absolute inset-x-0 flex justify-center items-center pointer-events-auto"
      >
        <img 
          src="/images/logomobile.png" 
          alt="Kaylia Suite Home" 
          class="h-11 w-auto object-contain drop-shadow-md"
        />
      </router-link>

      <!-- Right: Réserver CTA button -->
      <router-link 
        to="/reserver" 
        class="z-10 min-h-[40px] bg-[#0b6087] hover:bg-[#094d6b] active:bg-[#073d57] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center whitespace-nowrap shadow-sm"
      >
        Réserver
      </router-link>
    </div>

    <!-- ===== DESKTOP HEADER (visible only on md+) ===== -->
    <nav class="hidden md:flex container mx-auto px-8 py-3 items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center">
        <router-link to="/" class="flex items-center">
          <img src="/images/logo.png" alt="Kaylia Suite Home" class="h-14 w-auto object-contain" />
        </router-link>
      </div>

      <!-- Navigation Menu (Desktop) -->
      <ul class="flex items-center space-x-6 lg:space-x-8 text-sm font-normal text-white">
        <li class="relative group">
          <button 
            @click="toggleApartmentsMenu"
            class="hover:text-gray-300 flex items-center transition"
            :class="{ 'text-gray-300': isActiveRoute('/appartements') || isActiveRoute('/studio') }"
          >
            Nos Appartements
            <svg 
              class="w-4 h-4 ml-1 transition-transform"
              :class="{ 'rotate-180': showApartmentsMenu }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
            Notre SPA
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

      <!-- Language & CTA -->
      <div class="flex items-center space-x-4">
        <!-- Language Selector -->
        <div class="relative">
          <button 
            class="flex items-center hover:text-gray-300 transition text-xs text-white"
            @click="toggleLanguageMenu"
          >
            {{ currentLanguage }}
            <svg 
              class="w-3 h-3 ml-0.5 transition-transform"
              :class="{ 'rotate-180': showLanguageMenu }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
              :class="{ 'bg-gray-100 font-semibold': currentLanguage === 'FR' }"
            >
              FR
            </button>
            <button 
              @click="changeLanguage('EN')"
              class="block w-full text-left px-3 py-1.5 text-xs hover:bg-gray-100 transition"
              :class="{ 'bg-gray-100 font-semibold': currentLanguage === 'EN' }"
            >
              EN
            </button>
          </div>
        </div>

        <!-- CTA Button -->
        <router-link 
          to="/reserver" 
          class="min-h-[44px] bg-[#0b6087] hover:bg-[#094d6b] text-white px-6 py-2 rounded text-sm font-normal transition flex items-center"
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

const route = useRoute()
const uiStore = useUIStore()

const isScrolled = ref(false)
const currentLanguage = ref('FR')
const showApartmentsMenu = ref(false)
const showLanguageMenu = ref(false)

// Check if current route should have dark background
const shouldHaveDarkBackground = computed(() => {
  return route.path === '/contact' || route.path === '/spa'
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
const changeLanguage = (lang: 'FR' | 'EN') => {
  currentLanguage.value = lang
  showLanguageMenu.value = false
  // Future implementation: update i18n locale
  console.log('Language changed to:', lang)
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
