import axios, { type AxiosError, type InternalAxiosRequestConfig } from 'axios'

// Error transformation utilities
export interface ApiError {
  message: string
  status?: number
  errors?: Record<string, string[]>
}

export function transformError(error: AxiosError): ApiError {
  if (error.response) {
    const status = error.response.status
    const data = error.response.data as any
    
    // Handle validation errors (422)
    if (status === 422 && data.errors) {
      return {
        message: data.message || 'Validation failed',
        status,
        errors: data.errors
      }
    }
    
    // Handle other errors with custom messages
    const errorMessages: Record<number, string> = {
      400: 'Bad request. Please check your input.',
      401: 'Unauthorized. Please log in.',
      403: 'Access forbidden.',
      404: 'Resource not found.',
      409: 'Conflict. The resource already exists.',
      500: 'Server error. Please try again later.',
      503: 'Service unavailable. Please try again later.'
    }
    
    return {
      message: data.message || errorMessages[status] || 'An error occurred',
      status
    }
  } else if (error.request) {
    return {
      message: 'Network error. Please check your connection.',
      status: 0
    }
  } else {
    return {
      message: error.message || 'An unexpected error occurred',
      status: 0
    }
  }
}

export function getErrorMessage(error: unknown): string {
  if (axios.isAxiosError(error)) {
    const apiError = transformError(error)
    return apiError.message
  }
  if (error instanceof Error) {
    return error.message
  }
  return 'An unexpected error occurred'
}

export function getValidationErrors(error: unknown): Record<string, string[]> | null {
  if (axios.isAxiosError(error)) {
    const apiError = transformError(error)
    return apiError.errors || null
  }
  return null
}

// Create axios instance with base configuration
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  timeout: 30000
})

// Request interceptor
apiClient.interceptors.request.use(
  (config: InternalAxiosRequestConfig) => {
    // Add auth token if available
    const token = localStorage.getItem('auth_token')
    if (token && config.headers) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error: AxiosError) => {
    console.error('Request error:', error)
    return Promise.reject(error)
  }
)

// Response interceptor
apiClient.interceptors.response.use(
  (response) => {
    // Return the data directly for successful responses
    return response.data
  },
  (error: AxiosError) => {
    // Transform and log errors
    const apiError = transformError(error)
    
    // Log errors in development
    if (import.meta.env.DEV) {
      console.error('API Error:', {
        message: apiError.message,
        status: apiError.status,
        errors: apiError.errors,
        url: error.config?.url,
        method: error.config?.method
      })
    }
    
    // Handle specific error cases
    if (error.response) {
      const status = error.response.status
      
      switch (status) {
        case 401:
          // Unauthorized - clear token
          localStorage.removeItem('auth_token')
          // Note: Toast notification will be shown by the component/composable
          break
        case 403:
          // Forbidden
          console.error('Access forbidden')
          break
        case 404:
          // Not found - let component handle it
          break
        case 422:
          // Validation error - let the component handle it
          break
        case 500:
        case 503:
          // Server errors - log for monitoring
          console.error('Server error occurred:', apiError.message)
          break
      }
    } else if (error.request) {
      // Network error
      console.error('Network error - no response received')
    }
    
    return Promise.reject(error)
  }
)

export default apiClient
