<template>
  <!-- Backdrop -->
  <Transition name="fade">
    <div 
      v-if="isOpen"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
      @click="close"
    ></div>
  </Transition>

  <!-- Mobile Menu Drawer -->
  <Transition name="slide">
    <div 
      v-if="isOpen"
      class="fixed top-0 right-0 h-full w-80 max-w-[85vw] bg-[#1a2332] text-white z-50 md:hidden overflow-y-auto"
      @touchstart="handleTouchStart"
      @touchmove="handleTouchMove"
      @touchend="handleTouchEnd"
    >
      <!-- Header -->
      <div class="flex items-center justify-between p-4 border-b border-gray-700">
        <h2 class="text-xl font-serif tracking-wider">Menu</h2>
        <button 
          @click="close"
          class="p-2 hover:bg-gray-700 rounded transition"
          aria-label="Close menu"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Menu Items -->
      <nav class="p-4">
        <ul class="space-y-1">
          <!-- Nos Appartements -->
          <li>
            <button
              @click="toggleSubmenu('apartments')"
              class="w-full flex items-center justify-between py-3 px-4 hover:bg-gray-700 rounded transition"
            >
              <span>Nos Appartements</span>
              <svg 
                class="w-5 h-5 transition-transform duration-200"
                :class="{ 'rotate-180': openSubmenu === 'apartments' }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <!-- Submenu -->
            <Transition name="expand">
              <ul v-if="openSubmenu === 'apartments'" class="ml-4 mt-1 space-y-1">
                <li>
                  <router-link 
                    to="/nos-appartements" 
                    @click="close"
                    class="block py-2 px-4 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded transition"
                  >
                    Tous les appartements
                  </router-link>
                </li>
                <li>
                  <router-link 
                    to="/studio" 
                    @click="close"
                    class="block py-2 px-4 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded transition"
                  >
                    Chambre
                  </router-link>
                </li>
              </ul>
            </Transition>
          </li>

          <!-- Notre SPA -->
          <li>
            <router-link 
              to="/spa" 
              @click="close"
              class="block py-3 px-4 hover:bg-gray-700 rounded transition"
            >
              Notre SPA
            </router-link>
          </li>

          <!-- Notre Histoire -->
          <li>
            <router-link 
              to="/histoire" 
              @click="close"
              class="block py-3 px-4 hover:bg-gray-700 rounded transition"
            >
              Notre Histoire
            </router-link>
          </li>

          <!-- Contact -->
          <li>
            <router-link 
              to="/contact" 
              @click="close"
              class="block py-3 px-4 hover:bg-gray-700 rounded transition"
            >
              Contact
            </router-link>
          </li>
        </ul>

        <!-- CTA Button -->
        <div class="mt-6">
          <router-link 
            to="/reserver" 
            @click="close"
            class="block w-full bg-[#0b6087] hover:bg-[#094d6b] text-white text-center px-6 py-3 rounded transition"
          >
            Réserver
          </router-link>
        </div>

        <!-- Language Selector -->
        <div class="mt-4 pt-4 border-t border-gray-700">
          <button class="flex items-center justify-between w-full py-2 px-4 hover:bg-gray-700 rounded transition">
            <span class="text-sm">Langue: Français</span>
            <span class="text-sm font-semibold">FR</span>
          </button>
        </div>
      </nav>
    </div>
  </Transition>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useUIStore } from '@/stores/ui'

const router = useRouter()
const uiStore = useUIStore()

const isOpen = ref(false)
const openSubmenu = ref<string | null>(null)

// Touch gesture handling
let touchStartX = 0
let touchStartY = 0

const handleTouchStart = (e: TouchEvent) => {
  if (e.touches[0]) {
    touchStartX = e.touches[0].clientX
    touchStartY = e.touches[0].clientY
  }
}

const handleTouchMove = (e: TouchEvent) => {
  if (!e.touches[0]) return
  
  // Prevent scrolling when swiping
  const touchCurrentX = e.touches[0].clientX
  const touchCurrentY = e.touches[0].clientY
  const diffX = touchCurrentX - touchStartX
  const diffY = Math.abs(touchCurrentY - touchStartY)
  
  // If horizontal swipe is more significant than vertical
  if (Math.abs(diffX) > diffY && diffX > 50) {
    e.preventDefault()
  }
}

const handleTouchEnd = (e: TouchEvent) => {
  if (!e.changedTouches[0]) return
  
  const touchEndX = e.changedTouches[0].clientX
  const diff = touchEndX - touchStartX
  
  // If swipe right more than 100px, close menu
  if (diff > 100) {
    close()
  }
}

// Toggle submenu
const toggleSubmenu = (menu: string) => {
  openSubmenu.value = openSubmenu.value === menu ? null : menu
}

// Close menu
const close = () => {
  uiStore.closeMobileMenu()
  openSubmenu.value = null
}

// Watch store state
watch(() => uiStore.mobileMenuOpen, (newValue) => {
  isOpen.value = newValue
  
  // Prevent body scroll when menu is open
  if (newValue) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

// Close menu on route change
router.afterEach(() => {
  if (isOpen.value) {
    close()
  }
})
</script>

<style scoped>
/* Fade transition for backdrop */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Slide transition for drawer */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(100%);
}

/* Expand transition for submenus */
.expand-enter-active,
.expand-leave-active {
  transition: all 0.2s ease;
  overflow: hidden;
}

.expand-enter-from,
.expand-leave-to {
  opacity: 0;
  max-height: 0;
}

.expand-enter-to,
.expand-leave-from {
  opacity: 1;
  max-height: 200px;
}
</style>
