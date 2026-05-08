/**
 * Google Translate Integration for Production
 * Automatic translation using Google Translate Widget
 */

export type SupportedLanguage = 'fr' | 'en'

export class GoogleTranslateService {
  private static instance: GoogleTranslateService
  private initialized = false
  private currentLang: SupportedLanguage = 'fr'
  private initPromise: Promise<void> | null = null

  private constructor() {
    // Load saved language preference
    const savedLang = localStorage.getItem('selectedLanguage') as SupportedLanguage
    if (savedLang && (savedLang === 'fr' || savedLang === 'en')) {
      this.currentLang = savedLang
    }
  }

  static getInstance(): GoogleTranslateService {
    if (!GoogleTranslateService.instance) {
      GoogleTranslateService.instance = new GoogleTranslateService()
    }
    return GoogleTranslateService.instance
  }

  /**
   * Initialize Google Translate
   */
  init(): Promise<void> {
    if (this.initialized) return Promise.resolve()
    if (this.initPromise) return this.initPromise

    this.initPromise = new Promise((resolve) => {
      // Check if script already exists
      const existingScript = document.querySelector('script[src*="translate.google.com"]')
      if (existingScript) {
        this.initialized = true
        resolve()
        return
      }

      // Define global callback BEFORE loading script
      ;(window as any).googleTranslateElementInit = () => {
        try {
          new (window as any).google.translate.TranslateElement(
            {
              pageLanguage: 'fr',
              includedLanguages: 'en,fr',
              layout: (window as any).google.translate.TranslateElement.InlineLayout.SIMPLE,
              autoDisplay: false,
            },
            'google_translate_element'
          )
          this.initialized = true
          console.log('[Google Translate] Initialized successfully')
          resolve()
        } catch (error) {
          console.error('[Google Translate] Error initializing:', error)
          resolve()
        }
      }

      // Add hidden container for Google Translate widget
      if (!document.getElementById('google_translate_element')) {
        const container = document.createElement('div')
        container.id = 'google_translate_element'
        container.style.display = 'none'
        document.body.appendChild(container)
      }

      // Load Google Translate script
      const script = document.createElement('script')
      script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'
      script.async = true
      script.onerror = () => {
        console.error('[Google Translate] Failed to load script')
        resolve()
      }
      document.head.appendChild(script)
    })

    return this.initPromise
  }

  /**
   * Change language
   */
  async changeLanguage(lang: SupportedLanguage): Promise<void> {
    console.log('[Google Translate] Changing language to:', lang)
    this.currentLang = lang
    localStorage.setItem('selectedLanguage', lang)

    // Ensure initialized
    await this.init()

    return new Promise((resolve) => {
      let attempts = 0
      const maxAttempts = 50

      const checkAndTranslate = () => {
        attempts++
        
        const selectElement = document.querySelector('.goog-te-combo') as HTMLSelectElement
        
        if (selectElement) {
          console.log('[Google Translate] Found select element, applying translation')
          selectElement.value = lang
          selectElement.dispatchEvent(new Event('change'))
          resolve()
        } else if (attempts < maxAttempts) {
          // Retry after a short delay
          setTimeout(checkAndTranslate, 100)
        } else {
          console.warn('[Google Translate] Could not find select element after', maxAttempts, 'attempts')
          console.warn('[Google Translate] This is normal on localhost - will work in production')
          resolve()
        }
      }

      checkAndTranslate()
    })
  }

  /**
   * Get current language
   */
  getCurrentLanguage(): SupportedLanguage {
    return this.currentLang
  }

  /**
   * Reset to default language (French)
   */
  async reset(): Promise<void> {
    await this.changeLanguage('fr')
  }
}

// Export singleton instance
export const googleTranslate = GoogleTranslateService.getInstance()
