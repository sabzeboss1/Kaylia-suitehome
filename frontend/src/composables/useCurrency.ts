import { ref, computed } from 'vue'

export type Currency = 'EUR' | 'USD' | 'GBP' | 'XAF'

interface CurrencyInfo {
  code: Currency
  symbol: string
  rate: number // Taux de conversion depuis EUR
}

const currencies: Record<Currency, CurrencyInfo> = {
  EUR: { code: 'EUR', symbol: '€', rate: 1 },
  USD: { code: 'USD', symbol: '$', rate: 1.08 }, // 1 EUR = 1.08 USD (approximatif)
  GBP: { code: 'GBP', symbol: '£', rate: 0.86 }, // 1 EUR = 0.86 GBP (approximatif)
  XAF: { code: 'XAF', symbol: 'FCFA', rate: 655.957 } // 1 EUR = 655.957 XAF (taux fixe)
}

const selectedCurrency = ref<Currency>('EUR')

export function useCurrency() {
  const currentCurrency = computed(() => currencies[selectedCurrency.value])

  /**
   * Convert amount from EUR to selected currency
   */
  const convertFromEUR = (amountInEUR: number): number => {
    return amountInEUR * currentCurrency.value.rate
  }

  /**
   * Convert amount from selected currency to EUR
   */
  const convertToEUR = (amount: number): number => {
    return amount / currentCurrency.value.rate
  }

  /**
   * Format price with currency symbol
   */
  const formatPrice = (amountInEUR: number, showDecimals: boolean = false): string => {
    const convertedAmount = convertFromEUR(amountInEUR)
    const currency = currentCurrency.value

    // Format based on currency
    if (currency.code === 'XAF') {
      // FCFA: no decimals, space before symbol
      return `${Math.round(convertedAmount).toLocaleString('fr-FR')} ${currency.symbol}`
    } else if (currency.code === 'EUR') {
      // EUR: symbol after, with or without decimals
      const formatted = showDecimals 
        ? convertedAmount.toFixed(2)
        : Math.round(convertedAmount).toString()
      return `${formatted}${currency.symbol}`
    } else {
      // USD, GBP: symbol before, with or without decimals
      const formatted = showDecimals 
        ? convertedAmount.toFixed(2)
        : Math.round(convertedAmount).toString()
      return `${currency.symbol}${formatted}`
    }
  }

  /**
   * Set currency
   */
  const setCurrency = (currency: Currency) => {
    selectedCurrency.value = currency
  }

  /**
   * Get available currencies
   */
  const availableCurrencies = computed(() => Object.values(currencies))

  return {
    selectedCurrency,
    currentCurrency,
    convertFromEUR,
    convertToEUR,
    formatPrice,
    setCurrency,
    availableCurrencies
  }
}
