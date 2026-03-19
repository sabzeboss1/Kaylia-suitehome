/**
 * Booking Type Definitions
 * 
 * TypeScript interfaces and types for booking-related data structures
 */

import type { Apartment } from './apartment'

export interface BookingState {
  apartment: Apartment | null
  checkIn: Date | null
  checkOut: Date | null
  guests: number
  promoCode: string
  addOns: AddOn[]
  customerInfo: CustomerInfo | null
  totalPrice: number
  step: 1 | 2 | 3
}

export interface CustomerInfo {
  firstName: string
  lastName: string
  email: string
  phone: string
  country: string
  specialRequests?: string
}

export interface AddOn {
  id: number
  name: string
  price: number
  quantity: number
}

export type PaymentMethod = 'credit_card' | 'sepa' | 'paypal' | 'apple_pay'
