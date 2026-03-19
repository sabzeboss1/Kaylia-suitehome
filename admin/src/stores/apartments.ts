import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Apartment, ApartmentFilters, DateRange } from '../types'
import { useApartments as useApartmentsComposable } from '../composables/useApartments'

export const useApartmentsStore = defineStore('apartments', () => {
  // State
  const apartments = ref<Apartment[]>([])
  const filters = ref<ApartmentFilters>({
    guests: null,
    bedrooms: null,
    checkIn: null,
    checkOut: null,
    type: null,
    minPrice: null,
    maxPrice: null
  })
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)

  // Composable for API calls
  const { 
    fetchApartments: fetchApartmentsAPI, 
    checkAvailability: checkAvailabilityAPI,
    loading: apiLoading,
    error: apiError
  } = useApartmentsComposable()

  // Getters
  const filteredApartments = computed(() => {
    let result = [...apartments.value]

    // Filter by guests
    if (filters.value.guests) {
      result = result.filter((apt: Apartment) => apt.capacity >= filters.value.guests!)
    }

    // Filter by bedrooms
    if (filters.value.bedrooms) {
      result = result.filter((apt: Apartment) => apt.bedrooms >= filters.value.bedrooms!)
    }

    // Filter by type
    if (filters.value.type) {
      result = result.filter((apt: Apartment) => apt.type === filters.value.type)
    }

    // Filter by price range
    if (filters.value.minPrice !== null) {
      result = result.filter((apt: Apartment) => apt.pricePerNight >= filters.value.minPrice!)
    }

    if (filters.value.maxPrice !== null) {
      result = result.filter((apt: Apartment) => apt.pricePerNight <= filters.value.maxPrice!)
    }

    return result
  })

  const featuredApartments = computed(() => {
    return apartments.value.filter((apt: Apartment) => apt.featured)
  })

  const apartmentsByType = computed(() => {
    return {
      studio: apartments.value.filter((apt: Apartment) => apt.type === 'studio'),
      t2: apartments.value.filter((apt: Apartment) => apt.type === 't2'),
      t3: apartments.value.filter((apt: Apartment) => apt.type === 't3')
    }
  })

  // Actions
  const fetchApartments = async (filterParams?: ApartmentFilters) => {
    loading.value = true
    error.value = null

    try {
      await fetchApartmentsAPI(filterParams)
      apartments.value = useApartmentsComposable().apartments.value
    } catch (e: any) {
      error.value = e.message || 'Failed to fetch apartments'
      console.error('Error in apartments store:', e)
    } finally {
      loading.value = false
    }
  }

  const checkAvailability = async (apartmentId: number, dates: DateRange) => {
    loading.value = true
    error.value = null

    try {
      const result = await checkAvailabilityAPI(apartmentId, dates)
      return result
    } catch (e: any) {
      error.value = e.message || 'Failed to check availability'
      console.error('Error checking availability:', e)
      throw e
    } finally {
      loading.value = false
    }
  }

  const getApartmentById = (id: number): Apartment | undefined => {
    return apartments.value.find((apt: Apartment) => apt.id === id)
  }

  const getApartmentBySlug = (slug: string): Apartment | undefined => {
    return apartments.value.find((apt: Apartment) => apt.slug === slug)
  }

  const setFilters = (newFilters: Partial<ApartmentFilters>) => {
    filters.value = {
      ...filters.value,
      ...newFilters
    }
  }

  const resetFilters = () => {
    filters.value = {
      guests: null,
      bedrooms: null,
      checkIn: null,
      checkOut: null,
      type: null,
      minPrice: null,
      maxPrice: null
    }
  }

  const setGuestsFilter = (guests: number | null) => {
    filters.value.guests = guests
  }

  const setBedroomsFilter = (bedrooms: number | null) => {
    filters.value.bedrooms = bedrooms
  }

  const setDatesFilter = (checkIn: Date | null, checkOut: Date | null) => {
    filters.value.checkIn = checkIn
    filters.value.checkOut = checkOut
  }

  const setTypeFilter = (type: 'studio' | 't2' | 't3' | null) => {
    filters.value.type = type
  }

  const setPriceRangeFilter = (minPrice: number | null, maxPrice: number | null) => {
    filters.value.minPrice = minPrice
    filters.value.maxPrice = maxPrice
  }

  return {
    // State
    apartments,
    filters,
    loading,
    error,
    
    // Getters
    filteredApartments,
    featuredApartments,
    apartmentsByType,
    
    // Actions
    fetchApartments,
    checkAvailability,
    getApartmentById,
    getApartmentBySlug,
    setFilters,
    resetFilters,
    setGuestsFilter,
    setBedroomsFilter,
    setDatesFilter,
    setTypeFilter,
    setPriceRangeFilter
  }
})
