/**
 * API Type Definitions
 * 
 * TypeScript interfaces and types for API responses and error handling
 */

export interface ApiResponse<T> {
  data: T
  message?: string
  errors?: Record<string, string[]>
}

export interface PaginatedResponse<T> {
  data: T[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

export interface ApiError {
  message: string
  errors?: Record<string, string[]>
  status?: number
}

export interface ValidationError {
  field: string
  messages: string[]
}
