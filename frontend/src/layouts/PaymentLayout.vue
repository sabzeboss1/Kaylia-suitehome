<template>
  <div class="min-h-screen bg-white flex flex-col">
    <!-- Payment Header - Minimal Design -->
    <header class="sticky top-0 z-50 bg-white border-b border-[#d4c4b0]">
      <!-- Mobile Header -->
      <div class="md:hidden">
        <!-- Logo centré -->
        <div class="flex items-center justify-center py-4">
          <router-link to="/" class="flex items-center hover:opacity-80 transition-opacity">
            <img 
              src="/images/logomobileblack.png" 
              alt="Kaylia Suite Home" 
              class="h-9 w-auto object-contain"
            />
          </router-link>
        </div>
        
        <!-- Barre du bas: Globe + Langue + Devise -->
        <div class="flex items-center justify-end gap-3 px-6 py-3 border-t border-[#d4c4b0]">
          <!-- Globe Icon -->
          <svg 
            class="w-5 h-5 text-gray-700" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
            stroke-width="1.5"
          >
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              d="M12 21a9 9 0 100-18 9 9 0 000 18zM3.6 9h16.8M3.6 15h16.8M12 3c1.5 2.5 2.3 5.5 2.3 9s-.8 6.5-2.3 9M12 3c-1.5 2.5-2.3 5.5-2.3 9s.8 6.5 2.3 9"
            />
          </svg>
          
          <!-- Language Text -->
          <span class="text-sm text-gray-700">FR - FR</span>
          
          <!-- Currency Button -->
          <button class="px-4 py-1.5 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50 transition">
            EUR
          </button>
        </div>
      </div>
      
      <!-- Desktop Header -->
      <div class="hidden md:block py-5 md:py-6">
        <div class="container mx-auto px-6 md:px-12 max-w-7xl">
          <div class="flex items-center justify-between">
            <!-- Logo - Left -->
            <router-link to="/" class="flex items-center hover:opacity-80 transition-opacity">
              <img 
                src="/images/logoblack.png" 
                alt="Kaylia Suite Home" 
                class="h-16 md:h-20 w-auto object-contain"
              />
            </router-link>

          <!-- Language Selector - Right -->
          <button 
            class="flex items-center gap-2 hover:text-gray-600 transition-colors group"
            @click="toggleLanguageMenu"
          >
            <!-- Globe Icon - Minimalist wireframe style -->
            <svg 
              class="w-5 h-5 text-gray-700 group-hover:text-gray-600 transition-colors" 
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
              stroke-width="1.5"
            >
              <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                d="M12 21a9 9 0 100-18 9 9 0 000 18zM3.6 9h16.8M3.6 15h16.8M12 3c1.5 2.5 2.3 5.5 2.3 9s-.8 6.5-2.3 9M12 3c-1.5 2.5-2.3 5.5-2.3 9s.8 6.5 2.3 9"
              />
            </svg>
            <!-- Language Text -->
            <span 
              class="text-sm font-normal text-gray-700 group-hover:text-gray-600 transition-colors"
              style="font-family: 'Montserrat', 'Inter', sans-serif;"
            >
              FR - FR
            </span>
          </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const showLanguageMenu = ref(false)

const toggleLanguageMenu = () => {
  showLanguageMenu.value = !showLanguageMenu.value
  // Future implementation: show language dropdown
  console.log('Language selector clicked')
}
</script>
