/**
 * Apartment Type Definitions
 * 
 * TypeScript interfaces and types for apartment-related data structures
 */

export interface Apartment {
  id: number
  name: string
  slug: string
  type: 'studio' | 't2' | 't3'
  description: string
  capacity: number
  surface: number
  bedrooms: number
  beds: Array<{
    type: string
    count: number
  }>
  floor: string
  pricePerNight: number
  images: string[]
  equipment: string[]
  services: string[]
  rating: number
  reviewCount: number
  featured: boolean
}

export interface ApartmentFilters {
  guests?: number | null
  bedrooms?: number | null
  checkIn?: Date | null
  checkOut?: Date | null
  type?: 'studio' | 't2' | 't3' | null
  minPrice?: number | null
  maxPrice?: number | null
}

export interface DateRange {
  startDate: Date
  endDate: Date
}

export interface SearchParams {
  checkIn: Date | null
  checkOut: Date | null
  guests: number
  promoCode?: string
}
