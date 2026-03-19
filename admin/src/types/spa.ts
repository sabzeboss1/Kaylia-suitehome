/**
 * Spa Type Definitions
 * 
 * TypeScript interfaces and types for spa-related data structures
 */

import type { CustomerInfo } from './booking'

export interface SpaService {
  id: number
  name: string
  description: string
  price: number
  duration: number
  category: 'appointment' | 'event'
  capacity?: number
}

export interface SpaReservation {
  serviceId: number
  date: Date
  time: string
  guests: number
  customerInfo: CustomerInfo
}
