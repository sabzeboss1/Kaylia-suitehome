<template>
  <header 
    class="fixed top-0 right-0 z-10 h-16 bg-white/80 backdrop-blur-xl border-b border-surface-100 transition-all duration-300"
    :style="{ left: sidebarCollapsed ? '72px' : '256px' }"
  >
    <div class="flex items-center justify-between h-full px-6">
      <!-- Left: Sidebar toggle + Breadcrumb -->
      <div class="flex items-center gap-4">
        <button
          @click="$emit('toggleSidebar')"
          class="p-2 rounded-lg text-navy-400 hover:text-navy-700 hover:bg-surface-100 transition-colors lg:hidden"
        >
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm">
          <router-link to="/" class="text-navy-400 hover:text-navy-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
          </router-link>
          <svg class="w-3.5 h-3.5 text-navy-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
          <span class="text-navy-700 font-medium">{{ currentPageTitle }}</span>
        </nav>
      </div>

      <!-- Right: Actions + User -->
      <div class="flex items-center gap-3">
        <!-- Search -->
        <div class="hidden md:flex items-center bg-surface-50 rounded-lg border border-surface-200 px-3 py-2 w-64 focus-within:ring-2 focus-within:ring-gold-400/30 focus-within:border-gold-500 transition-all">
          <svg class="w-4 h-4 text-navy-300 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          <input 
            type="text" 
            placeholder="Rechercher..."
            class="bg-transparent w-full text-sm text-navy-700 placeholder-navy-300 focus:outline-none"
          />
          <kbd class="hidden lg:inline-flex items-center px-1.5 py-0.5 text-[10px] font-medium text-navy-300 bg-white border border-surface-200 rounded">⌘K</kbd>
        </div>

        <!-- Notifications -->
        <NotificationDropdown />

        <!-- Divider -->
        <div class="w-px h-8 bg-surface-200"></div>

        <!-- User Menu -->
        <div class="relative" ref="userMenuRef">
          <button
            @click="toggleUserMenu"
            class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-surface-50 transition-colors"
          >
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-navy-800 to-navy-900 flex items-center justify-center text-white text-sm font-semibold ring-2 ring-gold-500/20">
              {{ userInitials }}
            </div>
            <div class="hidden sm:block text-left">
              <div class="text-sm font-medium text-navy-800 leading-tight">{{ userName }}</div>
              <div class="text-xs text-navy-400">{{ userRoleDisplay }}</div>
            </div>
            <svg
              class="w-4 h-4 text-navy-300 transition-transform duration-200"
              :class="{ 'rotate-180': isUserMenuOpen }"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95 -translate-y-1"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-1"
          >
            <div
              v-if="isUserMenuOpen"
              class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-surface-200 py-1 z-50"
            >
              <div class="px-4 py-3 border-b border-surface-100">
                <p class="text-sm font-semibold text-navy-800">{{ userName }}</p>
                <p class="text-xs text-navy-400 mt-0.5">{{ userRoleDisplay }}</p>
              </div>
              <div class="py-1">
                <router-link
                  to="/settings"
                  class="flex items-center gap-3 px-4 py-2.5 text-sm text-navy-600 hover:bg-surface-50 transition-colors"
                  @click="isUserMenuOpen = false"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Paramètres
                </router-link>
              </div>
              <div class="border-t border-surface-100 py-1">
                <button
                  @click="handleLogout"
                  class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                >
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                  </svg>
                  Déconnexion
                </button>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import NotificationDropdown from './NotificationDropdown.vue'

defineProps({
  sidebarCollapsed: {
    type: Boolean,
    default: false
  }
})

defineEmits(['toggleSidebar'])

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)

const pageTitles = {
  '/': 'Dashboard',
  '/apartments': 'Appartements',
  '/reservations': 'Réservations',
  '/customers': 'Clients',
  '/spa/services': 'Services SPA',
  '/spa/reservations': 'Réservations SPA',
  '/reviews': 'Avis',
  '/promo-codes': 'Codes Promo',
  '/comfort-options': 'Options Confort',
  '/contact-messages': 'Messages',
  '/newsletter': 'Newsletter',
  '/content': 'Contenu',
  '/settings': 'Paramètres',
  '/users': 'Utilisateurs',
  '/activity-logs': 'Journaux'
}

const currentPageTitle = computed(() => {
  const path = route.path
  for (const [key, value] of Object.entries(pageTitles)) {
    if (path === key || (key !== '/' && path.startsWith(key))) {
      return value
    }
  }
  return 'Page'
})

const userName = computed(() => {
  if (authStore.user) {
    return authStore.user.name || authStore.user.email
  }
  return 'User'
})

const userInitials = computed(() => {
  if (authStore.user?.name) {
    const names = authStore.user.name.split(' ')
    return names.map(n => n[0]).join('').toUpperCase().slice(0, 2)
  }
  return 'U'
})

const userRoleDisplay = computed(() => {
  const role = authStore.userRole
  if (role === 'super_admin') return 'Super Admin'
  if (role === 'admin') return 'Admin'
  if (role === 'editor') return 'Éditeur'
  return role
})

const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value
}

const handleLogout = async () => {
  await authStore.logout()
  router.push({ name: 'Login' })
}

const handleClickOutside = (event) => {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    isUserMenuOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
