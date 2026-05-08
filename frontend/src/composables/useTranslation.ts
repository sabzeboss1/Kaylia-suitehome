import { ref, onMounted } from 'vue'
import { googleTranslate, type SupportedLanguage } from '@/utils/googleTranslate'

export function useTranslation() {
  const currentLanguage = ref<SupportedLanguage>('fr')
  const isTranslating = ref(false)

  onMounted(async () => {
    // Initialize Google Translate
    await googleTranslate.init()
    
    // Get current language
    currentLanguage.value = googleTranslate.getCurrentLanguage()
    
    // If saved language is English, apply it
    if (currentLanguage.value === 'en') {
      isTranslating.value = true
      try {
        await googleTranslate.changeLanguage('en')
      } catch (error) {
        console.error('[useTranslation] Error applying saved language:', error)
      } finally {
        isTranslating.value = false
      }
    }
  })

  const changeLanguage = async (lang: SupportedLanguage) => {
    if (lang === currentLanguage.value) return

    isTranslating.value = true
    
    try {
      await googleTranslate.changeLanguage(lang)
      currentLanguage.value = lang
      
      // Wait a bit for translation to complete
      await new Promise(resolve => setTimeout(resolve, 1000))
    } catch (error) {
      console.error('[useTranslation] Translation error:', error)
    } finally {
      isTranslating.value = false
    }
  }

  const resetLanguage = async () => {
    await googleTranslate.reset()
    currentLanguage.value = 'fr'
  }

  return {
    currentLanguage,
    isTranslating,
    changeLanguage,
    resetLanguage
  }
}
