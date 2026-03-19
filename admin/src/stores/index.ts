/**
 * Pinia Stores Index
 * 
 * Central export point for all Pinia stores
 */

export { useAuthStore } from './auth.js'
export { useBookingStore } from './booking'
export { useApartmentsStore } from './apartments'
export { useSpaStore } from './spa'
export { useUIStore } from './ui'

// Re-export types
export type { Toast } from './ui'
