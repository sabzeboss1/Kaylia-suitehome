import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { SpaService, SpaReservation } from '../types'
import { useSpa as useSpaComposable } from '../composables/useSpa'
import apiClient from '../api/axios'

interface SpaOpeningHours {
  day: string
  open: string
  close: string
  closed: boolean
}

interface SpaReview {
  id: number
  customerName: string
  rating: number
  comment: string
  date: string
  serviceName?: string
}

export const useSpaStore = defineStore('spa', () => {
  // State
  const services = ref<SpaService[]>([])
  const openingHours = ref<SpaOpeningHours[]>([])
  const reviews = ref<SpaReview[]>([])
  const rating = ref<number>(0)
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)

  // Composable for API calls
  const { 
    fetchServices: fetchServicesAPI,
    createSpaReservation: createSpaReservationAPI,
    loading: apiLoading,
    error: apiError
  } = useSpaComposable()

  // Getters
  const servicesByCategory = computed(() => {
    return {
      appointments: services.value.filter((s: SpaService) => s.category === 'appointment'),
      events: services.value.filter((s: SpaService) => s.category === 'event')
    }
  })

  const appointmentServices = computed(() => {
    return services.value.filter((s: SpaService) => s.category === 'appointment')
  })

  const eventServices = computed(() => {
    return services.value.filter((s: SpaService) => s.category === 'event')
  })

  const averageRating = computed(() => {
    if (reviews.value.length === 0) return 0
    const sum = reviews.value.reduce((acc, review) => acc + review.rating, 0)
    return Math.round((sum / reviews.value.length) * 10) / 10
  })

  const reviewCount = computed(() => {
    return reviews.value.length
  })

  const todayOpeningHours = computed(() => {
    const today = new Date().toLocaleDateString('en-US', { weekday: 'long' })
    return openingHours.value.find(h => h.day === today)
  })

  // Actions
  const fetchServices = async () => {
    loading.value = true
    error.value = null

    try {
      await fetchServicesAPI()
      services.value = useSpaComposable().services.value
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch spa services'
      console.error('Error in spa store:', e)
    } finally {
      loading.value = false
    }
  }

  const fetchOpeningHours = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/spa/opening-hours')
      openingHours.value = response.data.data
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch opening hours'
      console.error('Error fetching opening hours:', e)
    } finally {
      loading.value = false
    }
  }

  const fetchReviews = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/spa/reviews')
      reviews.value = response.data.data
      
      // Update rating if provided
      if (response.data.meta?.average_rating) {
        rating.value = response.data.meta.average_rating
      } else {
        rating.value = averageRating.value
      }
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch reviews'
      console.error('Error fetching reviews:', e)
    } finally {
      loading.value = false
    }
  }

  const createReservation = async (reservation: SpaReservation) => {
    loading.value = true
    error.value = null

    try {
      const result = await createSpaReservationAPI(reservation)
      return result
    } catch (e: any) {
      error.value = e.message || 'Failed to create spa reservation'
      console.error('Error creating spa reservation:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const getServiceById = (id: number): SpaService | undefined => {
    return services.value.find((s: SpaService) => s.id === id)
  }

  const getServicesByCategory = (category: 'appointment' | 'event'): SpaService[] => {
    return services.value.filter((s: SpaService) => s.category === category)
  }

  const isOpenNow = (): boolean => {
    const now = new Date()
    const currentDay = now.toLocaleDateString('en-US', { weekday: 'long' })
    const currentTime = now.toTimeString().slice(0, 5) // HH:MM format
    
    const todayHours = openingHours.value.find(h => h.day === currentDay)
    
    if (!todayHours || todayHours.closed) {
      return false
    }
    
    return currentTime >= todayHours.open && currentTime <= todayHours.close
  }

  const fetchAllSpaData = async () => {
    loading.value = true
    error.value = null

    try {
      await Promise.all([
        fetchServices(),
        fetchOpeningHours(),
        fetchReviews()
      ])
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch spa data'
      console.error('Error fetching spa data:', e)
    } finally {
      loading.value = false
    }
  }

  return {
    // State
    services,
    openingHours,
    reviews,
    rating,
    loading,
    error,
    
    // Getters
    servicesByCategory,
    appointmentServices,
    eventServices,
    averageRating,
    reviewCount,
    todayOpeningHours,
    
    // Actions
    fetchServices,
    fetchOpeningHours,
    fetchReviews,
    createReservation,
    getServiceById,
    getServicesByCategory,
    isOpenNow,
    fetchAllSpaData
  }
})
