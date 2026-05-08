import { ref, computed } from 'vue'
import apiClient from '@/utils/api'
import { logger } from '@/utils/logger'

export interface DepositConfig {
  enabled: boolean
  percentage: number
  notice_title: string
  notice_message: string
}

export interface DepositCalculation {
  total_amount: number
  deposit_percentage: number
  deposit_amount: number
  remaining_amount: number
  deposit_enabled: boolean
}

export function useDepositPayment() {
  const loading = ref(false)
  const error = ref<string | null>(null)
  const config = ref<DepositConfig | null>(null)
  const calculation = ref<DepositCalculation | null>(null)

  /**
   * Load deposit configuration from backend
   */
  const loadConfig = async (): Promise<DepositConfig | null> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.get('/deposit/config')

      if (response.data.success) {
        config.value = response.data.data
        logger.log('Deposit config loaded:', config.value)
        return response.data.data
      } else {
        throw new Error(response.data.error?.message || 'Failed to load deposit config')
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to load deposit config'
      error.value = errorMessage
      logger.error('Failed to load deposit config:', errorMessage)
      
      // Return default config on error
      const defaultConfig: DepositConfig = {
        enabled: true,
        percentage: 25,
        notice_title: 'Dépôt de garantie requis',
        notice_message: 'Pour confirmer votre réservation, un dépôt de garantie est requis.'
      }
      config.value = defaultConfig
      return defaultConfig
    } finally {
      loading.value = false
    }
  }

  /**
   * Calculate deposit amount for a given total
   */
  const calculateDeposit = async (totalAmount: number): Promise<DepositCalculation | null> => {
    loading.value = true
    error.value = null

    try {
      const response = await apiClient.post('/deposit/calculate', {
        total_amount: totalAmount
      })

      if (response.data.success) {
        calculation.value = response.data.data
        logger.log('Deposit calculated:', calculation.value)
        return response.data.data
      } else {
        throw new Error(response.data.error?.message || 'Failed to calculate deposit')
      }
    } catch (e: any) {
      const errorMessage = e.response?.data?.error?.message || e.message || 'Failed to calculate deposit'
      error.value = errorMessage
      logger.error('Failed to calculate deposit:', errorMessage)
      
      // Calculate locally as fallback
      const percentage = config.value?.percentage || 25
      const depositAmount = Math.round((totalAmount * percentage) / 100 * 100) / 100
      const remainingAmount = totalAmount - depositAmount
      
      const fallbackCalculation: DepositCalculation = {
        total_amount: totalAmount,
        deposit_percentage: percentage,
        deposit_amount: depositAmount,
        remaining_amount: remainingAmount,
        deposit_enabled: config.value?.enabled ?? true
      }
      
      calculation.value = fallbackCalculation
      return fallbackCalculation
    } finally {
      loading.value = false
    }
  }

  /**
   * Check if deposit is enabled
   */
  const isDepositEnabled = computed(() => config.value?.enabled ?? true)

  /**
   * Get deposit percentage
   */
  const depositPercentage = computed(() => config.value?.percentage ?? 25)

  /**
   * Get deposit notice title
   */
  const noticeTitle = computed(() => config.value?.notice_title ?? 'Dépôt de garantie requis')

  /**
   * Get deposit notice message
   */
  const noticeMessage = computed(() => config.value?.notice_message ?? 'Pour confirmer votre réservation, un dépôt de garantie est requis.')

  /**
   * Format price with currency
   */
  const formatPrice = (amount: number, currency: string = '€'): string => {
    return `${amount.toFixed(2)}${currency}`
  }

  return {
    loading,
    error,
    config,
    calculation,
    isDepositEnabled,
    depositPercentage,
    noticeTitle,
    noticeMessage,
    loadConfig,
    calculateDeposit,
    formatPrice
  }
}
