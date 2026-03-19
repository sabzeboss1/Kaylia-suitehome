<template>
  <div class="relative" ref="dropdownRef">
    <!-- Notification Button -->
    <button 
      @click="toggleDropdown"
      class="relative p-2 rounded-lg text-navy-400 hover:text-navy-700 hover:bg-surface-100 transition-colors"
    >
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
      </svg>
      <span 
        v-if="notificationsStore.hasUnread" 
        class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"
      ></span>
      <span 
        v-if="notificationsStore.unreadCount > 0" 
        class="absolute -top-1 -right-1 min-w-[18px] h-[18px] flex items-center justify-center bg-red-500 text-white text-[10px] font-bold rounded-full px-1"
      >
        {{ notificationsStore.unreadCount > 9 ? '9+' : notificationsStore.unreadCount }}
      </span>
    </button>

    <!-- Dropdown -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95 -translate-y-1"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 -translate-y-1"
    >
      <div
        v-if="isOpen"
        class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-lg border border-surface-200 z-50 max-h-[500px] flex flex-col"
      >
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-surface-100">
          <h3 class="text-sm font-semibold text-navy-800">Notifications</h3>
          <button
            v-if="notificationsStore.notifications.length > 0"
            @click="markAllAsRead"
            class="text-xs text-gold-600 hover:text-gold-700 font-medium"
          >
            Tout marquer comme lu
          </button>
        </div>

        <!-- Loading -->
        <div v-if="notificationsStore.loading" class="flex items-center justify-center py-8">
          <svg class="animate-spin h-6 w-6 text-gold-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>

        <!-- Notifications List -->
        <div v-else-if="notificationsStore.notifications.length > 0" class="overflow-y-auto flex-1">
          <router-link
            v-for="notification in notificationsStore.notifications"
            :key="notification.id"
            :to="notification.link"
            @click="handleNotificationClick(notification)"
            class="flex items-start gap-3 px-4 py-3 hover:bg-surface-50 transition-colors border-b border-surface-50 last:border-b-0"
            :class="{ 'bg-blue-50/30': !notification.read }"
          >
            <!-- Icon -->
            <div 
              class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center"
              :class="{
                'bg-blue-100 text-blue-600': notification.color === 'blue',
                'bg-green-100 text-green-600': notification.color === 'green',
                'bg-yellow-100 text-yellow-600': notification.color === 'yellow',
                'bg-red-100 text-red-600': notification.color === 'red',
              }"
            >
              <svg v-if="notification.icon === 'calendar'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
              </svg>
              <svg v-else-if="notification.icon === 'mail'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
              </svg>
              <svg v-else-if="notification.icon === 'star'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
              </svg>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-2">
                <p class="text-sm font-medium text-navy-800">{{ notification.title }}</p>
                <span 
                  v-if="!notification.read" 
                  class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-1"
                ></span>
              </div>
              <p class="text-sm text-navy-500 mt-0.5">{{ notification.message }}</p>
              <p class="text-xs text-navy-400 mt-1">{{ notification.time }}</p>
            </div>
          </router-link>
        </div>

        <!-- Empty State -->
        <div v-else class="flex flex-col items-center justify-center py-12 px-4">
          <svg class="w-16 h-16 text-navy-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
          <p class="text-sm text-navy-500 font-medium">Aucune notification</p>
          <p class="text-xs text-navy-400 mt-1">Vous êtes à jour !</p>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useNotificationsStore } from '../stores/notifications'

const notificationsStore = useNotificationsStore()
const isOpen = ref(false)
const dropdownRef = ref<HTMLElement | null>(null)

let refreshInterval: number | null = null

const toggleDropdown = async () => {
  isOpen.value = !isOpen.value
  if (isOpen.value && notificationsStore.notifications.length === 0) {
    await notificationsStore.fetchNotifications()
  }
}

const handleNotificationClick = (notification: any) => {
  notificationsStore.markAsRead(notification.id)
  isOpen.value = false
}

const markAllAsRead = () => {
  notificationsStore.markAllAsRead()
}

const handleClickOutside = (event: MouseEvent) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  
  // Fetch initial counts
  notificationsStore.fetchCounts()
  
  // Refresh counts every 30 seconds
  refreshInterval = window.setInterval(() => {
    notificationsStore.fetchCounts()
  }, 30000)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
  if (refreshInterval) {
    clearInterval(refreshInterval)
  }
})
</script>
