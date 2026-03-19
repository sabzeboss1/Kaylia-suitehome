import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor to add token to all requests
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Error transformation utilities
export const transformApiError = (error) => {
  if (!error.response) {
    return {
      message: 'Network error. Please check your connection.',
      type: 'network',
      errors: {}
    }
  }

  const { status, data } = error.response

  switch (status) {
    case 400:
      return {
        message: data.error?.message || data.message || 'Bad request',
        type: 'validation',
        errors: data.error?.details || data.errors || {}
      }
    case 401:
      return {
        message: 'Unauthorized. Please login again.',
        type: 'auth',
        errors: {}
      }
    case 403:
      return {
        message: 'Access forbidden',
        type: 'forbidden',
        errors: {}
      }
    case 404:
      return {
        message: data.message || 'Resource not found',
        type: 'not_found',
        errors: {}
      }
    case 422:
      return {
        message: data.message || 'Validation failed',
        type: 'validation',
        errors: data.errors || {}
      }
    case 500:
      return {
        message: 'Server error. Please try again later.',
        type: 'server',
        errors: {}
      }
    default:
      return {
        message: data.message || 'An error occurred',
        type: 'unknown',
        errors: data.errors || {}
      }
  }
}

// Response interceptor to handle errors globally
apiClient.interceptors.response.use(
  (response) => {
    // Keep the full response structure but make data easier to access
    // Don't transform, just return as-is for compatibility
    return response
  },
  async (error) => {
    const originalRequest = error.config

    // If 401 and not already retried, try to refresh token
    if (error.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true

      try {
        const response = await axios.post(`${API_BASE_URL}/auth/refresh`)
        const { token } = response.data.data

        localStorage.setItem('token', token)
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`
        originalRequest.headers.Authorization = `Bearer ${token}`

        return apiClient(originalRequest)
      } catch (refreshError) {
        // Refresh failed, logout user
        localStorage.removeItem('token')
        window.location.href = '/login'
        return Promise.reject(transformApiError(refreshError))
      }
    }

    // Transform error before rejecting
    return Promise.reject(transformApiError(error))
  }
)

export default apiClient

