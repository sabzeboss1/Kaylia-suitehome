<template>
  <div class="min-h-screen flex flex-col bg-white-smoke">
    <!-- Minimal Header -->
    <header class="bg-white shadow-sm">
      <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo -->
        <router-link to="/" class="text-xl font-serif tracking-wider leading-tight text-obsidian-black">
          KAYLIA<br>
          <span class="text-xs font-light tracking-widest">SUITE HOME</span>
        </router-link>
        
        <!-- Help Link -->
        <a 
          href="#" 
          class="text-sm text-gray-600 hover:text-gray-900 transition flex items-center"
        >
          <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Besoin d'aide ?
        </a>
      </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex-grow">
      <slot />
    </main>
    
    <!-- Minimal Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 gap-4">
          <p>© {{ currentYear }} Kaylia Suite Home</p>
          <div class="flex space-x-6">
            <a href="#" class="hover:text-gray-900 transition">
              Mentions légales
            </a>
            <a href="#" class="hover:text-gray-900 transition">
              Politique de confidentialité
            </a>
            <a href="#" class="hover:text-gray-900 transition">
              CGV
            </a>
          </div>
        </div>
      </div>
    </footer>
    
    <!-- Loading Overlay -->
    <LoadingSpinner 
      v-if="uiStore.loading" 
      fullScreen 
      size="lg"
      text="Traitement en cours..."
    />
    
    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <TransitionGroup name="toast">
        <div
          v-for="toast in uiStore.toasts"
          :key="toast.id"
          class="px-6 py-4 rounded-lg shadow-lg max-w-sm"
          :class="toastClass(toast.type)"
        >
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg 
                v-if="toast.type === 'success'" 
                class="w-5 h-5" 
                fill="currentColor" 
                viewBox="0 0 20 20"
              >
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <svg 
                v-else-if="toast.type === 'error'" 
                class="w-5 h-5" 
                fill="currentColor" 
                viewBox="0 0 20 20"
              >
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
              <svg 
                v-else-if="toast.type === 'warning'" 
                class="w-5 h-5" 
                fill="currentColor" 
                viewBox="0 0 20 20"
              >
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              <svg 
                v-else 
                class="w-5 h-5" 
                fill="currentColor" 
                viewBox="0 0 20 20"
              >
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-3 flex-1">
              <p class="text-sm font-medium">{{ toast.message }}</p>
            </div>
            <button
              @click="uiStore.removeToast(toast.id)"
              class="ml-4 flex-shrink-0 inline-flex text-gray-400 hover:text-gray-500"
            >
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
              </svg>
            </button>
          </div>
        </div>
      </TransitionGroup>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import { useUIStore } from '@/stores/ui'
import type { Toast } from '@/stores/ui'

const uiStore = useUIStore()
const currentYear = computed(() => new Date().getFullYear())

const toastClass = (type: Toast['type']) => {
  const classes = {
    success: 'bg-green-50 text-green-800 border border-green-200',
    error: 'bg-red-50 text-red-800 border border-red-200',
    warning: 'bg-yellow-50 text-yellow-800 border border-yellow-200',
    info: 'bg-blue-50 text-blue-800 border border-blue-200'
  }
  return classes[type]
}
</script>

<style scoped>
/* Toast transitions */
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100px);
}

.toast-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>
