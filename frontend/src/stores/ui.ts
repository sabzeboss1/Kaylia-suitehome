import { defineStore } from 'pinia'
import { ref } from 'vue'

export interface Toast {
  id: number
  message: string
  type: 'success' | 'error' | 'info' | 'warning'
  duration?: number
}

export const useUIStore = defineStore('ui', () => {
  // State
  const mobileMenuOpen = ref(false)
  const loading = ref(false)
  const toasts = ref<Toast[]>([])
  let toastIdCounter = 0

  // Actions
  function toggleMobileMenu() {
    mobileMenuOpen.value = !mobileMenuOpen.value
  }

  function closeMobileMenu() {
    mobileMenuOpen.value = false
  }

  function setLoading(value: boolean) {
    loading.value = value
  }

  function showToast(message: string, type: Toast['type'] = 'info', duration = 5000) {
    const id = ++toastIdCounter
    const toast: Toast = { id, message, type, duration }
    toasts.value.push(toast)

    if (duration > 0) {
      setTimeout(() => {
        removeToast(id)
      }, duration)
    }
  }

  function removeToast(id: number) {
    const index = toasts.value.findIndex(t => t.id === id)
    if (index > -1) {
      toasts.value.splice(index, 1)
    }
  }

  return {
    // State
    mobileMenuOpen,
    loading,
    toasts,
    // Actions
    toggleMobileMenu,
    closeMobileMenu,
    setLoading,
    showToast,
    removeToast
  }
})
