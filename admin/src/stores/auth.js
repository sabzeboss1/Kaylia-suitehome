import { defineStore } from 'pinia'
import apiClient from '../api/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    isAuthenticated: !!localStorage.getItem('token'),
  }),

  getters: {
    currentUser: (state) => state.user,
    isLoggedIn: (state) => state.isAuthenticated,
    userRole: (state) => state.user?.role || null,
  },

  actions: {
    async login(email, password) {
      try {
        const response = await apiClient.post('/auth/login', {
          email,
          password,
        })

        const { token, user } = response.data.data

        this.token = token
        this.user = user
        this.isAuthenticated = true

        localStorage.setItem('token', token)
        
        // Set default authorization header for all future requests
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`

        return { success: true }
      } catch (error) {
        console.error('Login error:', error)
        
        // Handle different error types
        let message = 'La connexion a échoué'
        
        if (error.message) {
          // Network error or transformed error from axios interceptor
          message = error.message
        } else if (error.response?.data?.message) {
          // API error message
          message = error.response.data.message
        } else if (error.response?.data?.error?.message) {
          // Alternative error format
          message = error.response.data.error.message
        }
        
        return {
          success: false,
          message: message,
        }
      }
    },

    async logout() {
      try {
        if (this.token) {
          await apiClient.post('/auth/logout')
        }
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.token = null
        this.user = null
        this.isAuthenticated = false
        localStorage.removeItem('token')
        delete apiClient.defaults.headers.common['Authorization']
      }
    },

    async refreshToken() {
      try {
        const response = await apiClient.post('/auth/refresh')
        const { token } = response.data.data

        this.token = token
        localStorage.setItem('token', token)
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`

        return { success: true }
      } catch (error) {
        // If refresh fails, logout the user
        this.logout()
        return { success: false }
      }
    },

    async fetchUser() {
      try {
        const response = await apiClient.get('/auth/me')
        this.user = response.data.data
        return { success: true }
      } catch (error) {
        return { success: false }
      }
    },

    initializeAuth() {
      if (this.token) {
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        this.fetchUser()
      }
    },
  },
})
