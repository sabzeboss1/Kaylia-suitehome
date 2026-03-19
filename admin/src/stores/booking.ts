import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Apartment, BookingState, CustomerInfo, AddOn } from '../types'
import { useBooking as useBookingComposable } from '../composables/useBooking'

// Helper function to calculate difference in days
const differenceInDays = (endDate: Date, startDate: Date): number => {
  const diffTime = endDate.getTime() - startDate.getTime()
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
}

export const useBookingStore = defineStore('booking', () => {
  // State
  const apartment = ref<Apartment | null>(null)
  const checkIn = ref<Date | null>(null)
  const checkOut = ref<Date | null>(null)
  const guests = ref<number>(2)
  const promoCode = ref<string>('')
  const addOns = ref<AddOn[]>([])
  const customerInfo = ref<CustomerInfo | null>(null)
  const totalPrice = ref<number>(0)
  const step = ref<1 | 2 | 3>(1)

  // Composable for API calls
  const { createReservation, validatePromoCode: validatePromoCodeAPI, promoCodeDiscount } = useBookingComposable()

  // Getters
  const nightCount = computed(() => {
    if (!checkIn.value || !checkOut.value) return 0
    return differenceInDays(checkOut.value, checkIn.value)
  })

  const basePrice = computed(() => {
    if (!apartment.value) return 0
    return apartment.value.pricePerNight * nightCount.value
  })

  const addOnsTotal = computed(() => {
    return addOns.value.reduce((sum: number, addon: AddOn) => sum + (addon.price * addon.quantity), 0)
  })

  const discountAmount = computed(() => {
    return promoCodeDiscount.value || 0
  })

  const finalPrice = computed(() => {
    return basePrice.value + addOnsTotal.value - discountAmount.value
  })

  // Actions
  const selectApartment = async (selectedApartment: Apartment) => {
    apartment.value = selectedApartment
    updateTotalPrice()
  }

  const setDates = (checkInDate: Date, checkOutDate: Date) => {
    checkIn.value = checkInDate
    checkOut.value = checkOutDate
    updateTotalPrice()
  }

  const setGuests = (guestCount: number) => {
    guests.value = guestCount
  }

  const addAddOn = (addon: AddOn) => {
    const existingIndex = addOns.value.findIndex((a: AddOn) => a.id === addon.id)
    if (existingIndex >= 0) {
      addOns.value[existingIndex].quantity += addon.quantity
    } else {
      addOns.value.push(addon)
    }
    updateTotalPrice()
  }

  const removeAddOn = (addonId: number) => {
    addOns.value = addOns.value.filter((a: AddOn) => a.id !== addonId)
    updateTotalPrice()
  }

  const updateAddOnQuantity = (addonId: number, quantity: number) => {
    const addon = addOns.value.find((a: AddOn) => a.id === addonId)
    if (addon) {
      addon.quantity = quantity
      updateTotalPrice()
    }
  }

  const setCustomerInfo = (info: CustomerInfo) => {
    customerInfo.value = info
  }

  const setPromoCode = (code: string) => {
    promoCode.value = code
  }

  const validatePromoCode = async (code: string) => {
    if (!apartment.value || !checkIn.value || !checkOut.value) {
      throw new Error('Missing booking information')
    }

    const checkInStr = checkIn.value.toISOString().split('T')[0]
    const checkOutStr = checkOut.value.toISOString().split('T')[0]

    const result = await validatePromoCodeAPI(code, apartment.value.id, checkInStr, checkOutStr)
    
    if (result.valid) {
      promoCode.value = code
      updateTotalPrice()
    }
    
    return result
  }

  const updateTotalPrice = () => {
    totalPrice.value = finalPrice.value
  }

  const nextStep = () => {
    if (step.value < 3) {
      step.value = (step.value + 1) as 1 | 2 | 3
    }
  }

  const previousStep = () => {
    if (step.value > 1) {
      step.value = (step.value - 1) as 1 | 2 | 3
    }
  }

  const setStep = (newStep: 1 | 2 | 3) => {
    step.value = newStep
  }

  const submitReservation = async () => {
    if (!apartment.value || !checkIn.value || !checkOut.value || !customerInfo.value) {
      throw new Error('Missing required booking information')
    }

    const reservationData = {
      apartment_id: apartment.value.id,
      check_in: checkIn.value.toISOString().split('T')[0],
      check_out: checkOut.value.toISOString().split('T')[0],
      guests: guests.value,
      customer_info: customerInfo.value,
      promo_code: promoCode.value || undefined,
      add_ons: addOns.value.map((addon: AddOn) => ({
        id: addon.id,
        quantity: addon.quantity
      }))
    }

    const result = await createReservation(reservationData)
    return result
  }

  const resetBooking = () => {
    apartment.value = null
    checkIn.value = null
    checkOut.value = null
    guests.value = 2
    promoCode.value = ''
    addOns.value = []
    customerInfo.value = null
    totalPrice.value = 0
    step.value = 1
  }

  return {
    // State
    apartment,
    checkIn,
    checkOut,
    guests,
    promoCode,
    addOns,
    customerInfo,
    totalPrice,
    step,
    
    // Getters
    nightCount,
    basePrice,
    addOnsTotal,
    discountAmount,
    finalPrice,
    
    // Actions
    selectApartment,
    setDates,
    setGuests,
    addAddOn,
    removeAddOn,
    updateAddOnQuantity,
    setCustomerInfo,
    setPromoCode,
    validatePromoCode,
    updateTotalPrice,
    nextStep,
    previousStep,
    setStep,
    submitReservation,
    resetBooking
  }
})
