import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export interface Toast {
  id: string
  message: string
  type: 'success' | 'error' | 'warning' | 'info'
  duration?: number
}

export const useUIStore = defineStore('ui', () => {
  // State
  const mobileMenuOpen = ref<boolean>(false)
  const loading = ref<boolean>(false)
  const toasts = ref<Toast[]>([])
  const loadingMessage = ref<string>('')

  // Getters
  const hasActiveToasts = computed(() => {
    return toasts.value.length > 0
  })

  const isLoading = computed(() => {
    return loading.value
  })

  // Actions
  const showToast = (
    message: string, 
    type: 'success' | 'error' | 'warning' | 'info' = 'info',
    duration: number = 5000
  ) => {
    const id = `toast-${Date.now()}-${Math.random()}`
    
    const toast: Toast = {
      id,
      message,
      type,
      duration
    }
    
    toasts.value.push(toast)
    
    // Auto-remove toast after duration
    if (duration > 0) {
      setTimeout(() => {
        removeToast(id)
      }, duration)
    }
    
    return id
  }

  const removeToast = (id: string) => {
    const index = toasts.value.findIndex(t => t.id === id)
    if (index !== -1) {
      toasts.value.splice(index, 1)
    }
  }

  const clearAllToasts = () => {
    toasts.value = []
  }

  const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
  }

  const openMobileMenu = () => {
    mobileMenuOpen.value = true
  }

  const closeMobileMenu = () => {
    mobileMenuOpen.value = false
  }

  const setLoading = (isLoading: boolean, message: string = '') => {
    loading.value = isLoading
    loadingMessage.value = message
  }

  const startLoading = (message: string = 'Loading...') => {
    loading.value = true
    loadingMessage.value = message
  }

  const stopLoading = () => {
    loading.value = false
    loadingMessage.value = ''
  }

  // Convenience methods for different toast types
  const showSuccess = (message: string, duration?: number) => {
    return showToast(message, 'success', duration)
  }

  const showError = (message: string, duration?: number) => {
    return showToast(message, 'error', duration)
  }

  const showWarning = (message: string, duration?: number) => {
    return showToast(message, 'warning', duration)
  }

  const showInfo = (message: string, duration?: number) => {
    return showToast(message, 'info', duration)
  }

  return {
    // State
    mobileMenuOpen,
    loading,
    toasts,
    loadingMessage,
    
    // Getters
    hasActiveToasts,
    isLoading,
    
    // Actions
    showToast,
    removeToast,
    clearAllToasts,
    toggleMobileMenu,
    openMobileMenu,
    closeMobileMenu,
    setLoading,
    startLoading,
    stopLoading,
    showSuccess,
    showError,
    showWarning,
    showInfo
  }
})
