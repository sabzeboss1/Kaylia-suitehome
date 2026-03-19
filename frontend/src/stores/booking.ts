import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'
import type { Apartment } from './apartments'

export interface CustomerInfo {
  firstName: string
  lastName: string
  email: string
  phone?: string
  country?: string
  specialRequests?: string
}

export interface SelectedComfortOption {
  id: number
  name: string
  price: number
  quantity: number
  price_type: 'per_night' | 'one_time'
}

export interface PriceBreakdown {
  basePrice: number
  comfortOptionsTotal: number
  discount: number
  total: number
}

export const useBookingStore = defineStore('booking', () => {
  // Helper function to load from localStorage
  const loadFromStorage = <T>(key: string, defaultValue: T): T => {
    try {
      const stored = localStorage.getItem(`booking_${key}`)
      if (stored) {
        const parsed = JSON.parse(stored)
        // Convert date strings back to Date objects
        if (key === 'checkIn' || key === 'checkOut') {
          return parsed ? new Date(parsed) : defaultValue
        }
        return parsed
      }
    } catch (e) {
      console.error(`Failed to load ${key} from localStorage:`, e)
    }
    return defaultValue
  }

  // Helper function to save to localStorage
  const saveToStorage = (key: string, value: any) => {
    try {
      localStorage.setItem(`booking_${key}`, JSON.stringify(value))
    } catch (e) {
      console.error(`Failed to save ${key} to localStorage:`, e)
    }
  }

  // State with localStorage persistence
  const apartment = ref<Apartment | null>(loadFromStorage('apartment', null))
  const checkIn = ref<Date | null>(loadFromStorage('checkIn', null))
  const checkOut = ref<Date | null>(loadFromStorage('checkOut', null))
  const guests = ref(loadFromStorage('guests', 2))
  const promoCode = ref(loadFromStorage('promoCode', ''))
  const promoCodeDiscount = ref(loadFromStorage('promoCodeDiscount', 0))
  const customerInfo = ref<CustomerInfo | null>(loadFromStorage('customerInfo', null))
  const totalPrice = ref(loadFromStorage('totalPrice', 0))
  const step = ref<1 | 2 | 3>(loadFromStorage('step', 1))
  const selectedComfortOptions = ref<SelectedComfortOption[]>(loadFromStorage('selectedComfortOptions', []))
  const confirmationNumber = ref<string | null>(loadFromStorage('confirmationNumber', null))

  // Watch for changes and persist to localStorage
  watch(apartment, (value) => saveToStorage('apartment', value))
  watch(checkIn, (value) => saveToStorage('checkIn', value))
  watch(checkOut, (value) => saveToStorage('checkOut', value))
  watch(guests, (value) => saveToStorage('guests', value))
  watch(promoCode, (value) => saveToStorage('promoCode', value))
  watch(promoCodeDiscount, (value) => saveToStorage('promoCodeDiscount', value))
  watch(customerInfo, (value) => saveToStorage('customerInfo', value))
  watch(totalPrice, (value) => saveToStorage('totalPrice', value))
  watch(step, (value) => saveToStorage('step', value))
  watch(selectedComfortOptions, (value) => saveToStorage('selectedComfortOptions', value), { deep: true })
  watch(confirmationNumber, (value) => saveToStorage('confirmationNumber', value))

  // Getters
  const nightCount = computed(() => {
    if (!checkIn.value || !checkOut.value) return 0
    const diffTime = Math.abs(checkOut.value.getTime() - checkIn.value.getTime())
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return diffDays
  })

  const basePrice = computed(() => {
    if (!apartment.value || nightCount.value === 0) return 0
    return apartment.value.pricePerNight * nightCount.value
  })

  const comfortOptionsTotal = computed(() => {
    return selectedComfortOptions.value.reduce((sum, option) => {
      const optionPrice = option.price_type === 'per_night' 
        ? option.price * option.quantity * nightCount.value
        : option.price * option.quantity
      return sum + optionPrice
    }, 0)
  })

  const calculatedTotalPrice = computed(() => {
    return basePrice.value + comfortOptionsTotal.value - promoCodeDiscount.value
  })

  const priceBreakdown = computed<PriceBreakdown>(() => ({
    basePrice: basePrice.value,
    comfortOptionsTotal: comfortOptionsTotal.value,
    discount: promoCodeDiscount.value,
    total: calculatedTotalPrice.value
  }))

  // Actions
  function addComfortOption(option: SelectedComfortOption) {
    const existingIndex = selectedComfortOptions.value.findIndex(o => o.id === option.id)
    if (existingIndex >= 0) {
      selectedComfortOptions.value[existingIndex].quantity += option.quantity
    } else {
      selectedComfortOptions.value.push(option)
    }
  }

  function removeComfortOption(optionId: number) {
    selectedComfortOptions.value = selectedComfortOptions.value.filter(o => o.id !== optionId)
  }

  function updateComfortOptionQuantity(optionId: number, quantity: number) {
    const option = selectedComfortOptions.value.find(o => o.id === optionId)
    if (option) {
      if (quantity <= 0) {
        removeComfortOption(optionId)
      } else {
        option.quantity = quantity
      }
    }
  }

  function applyPromoCode(discount: number) {
    promoCodeDiscount.value = discount
  }

  function reset() {
    apartment.value = null
    checkIn.value = null
    checkOut.value = null
    guests.value = 2
    promoCode.value = ''
    promoCodeDiscount.value = 0
    customerInfo.value = null
    totalPrice.value = 0
    step.value = 1
    selectedComfortOptions.value = []
    confirmationNumber.value = null
    
    // Clear localStorage
    try {
      const keys = ['apartment', 'checkIn', 'checkOut', 'guests', 'promoCode', 'promoCodeDiscount', 
                    'customerInfo', 'totalPrice', 'step', 'selectedComfortOptions', 'confirmationNumber']
      keys.forEach(key => localStorage.removeItem(`booking_${key}`))
    } catch (e) {
      console.error('Failed to clear booking data from localStorage:', e)
    }
  }

  return {
    // State
    apartment,
    checkIn,
    checkOut,
    guests,
    promoCode,
    promoCodeDiscount,
    customerInfo,
    totalPrice,
    step,
    selectedComfortOptions,
    confirmationNumber,
    // Getters
    nightCount,
    basePrice,
    comfortOptionsTotal,
    calculatedTotalPrice,
    priceBreakdown,
    // Actions
    addComfortOption,
    removeComfortOption,
    updateComfortOptionQuantity,
    applyPromoCode,
    reset
  }
})
