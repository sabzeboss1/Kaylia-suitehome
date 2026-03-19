import { ref, onMounted, onUnmounted, type Ref } from 'vue'

export interface SwipeOptions {
  threshold?: number
  onSwipeLeft?: () => void
  onSwipeRight?: () => void
  onSwipeUp?: () => void
  onSwipeDown?: () => void
}

export function useSwipe(
  target: Ref<HTMLElement | null>,
  options: SwipeOptions = {}
) {
  const {
    threshold = 50,
    onSwipeLeft,
    onSwipeRight,
    onSwipeUp,
    onSwipeDown
  } = options

  const touchStartX = ref(0)
  const touchStartY = ref(0)
  const touchEndX = ref(0)
  const touchEndY = ref(0)
  const isSwiping = ref(false)

  const handleTouchStart = (e: TouchEvent) => {
    isSwiping.value = true
    touchStartX.value = e.touches[0]?.clientX || 0
    touchStartY.value = e.touches[0]?.clientY || 0
  }

  const handleTouchMove = (e: TouchEvent) => {
    if (!isSwiping.value) return
    touchEndX.value = e.touches[0]?.clientX || 0
    touchEndY.value = e.touches[0]?.clientY || 0
  }

  const handleTouchEnd = () => {
    if (!isSwiping.value) return
    
    const diffX = touchStartX.value - touchEndX.value
    const diffY = touchStartY.value - touchEndY.value
    const absDiffX = Math.abs(diffX)
    const absDiffY = Math.abs(diffY)

    // Determine if swipe is horizontal or vertical
    if (absDiffX > absDiffY) {
      // Horizontal swipe
      if (absDiffX > threshold) {
        if (diffX > 0) {
          onSwipeLeft?.()
        } else {
          onSwipeRight?.()
        }
      }
    } else {
      // Vertical swipe
      if (absDiffY > threshold) {
        if (diffY > 0) {
          onSwipeUp?.()
        } else {
          onSwipeDown?.()
        }
      }
    }

    isSwiping.value = false
  }

  onMounted(() => {
    const element = target.value
    if (!element) return

    element.addEventListener('touchstart', handleTouchStart, { passive: true })
    element.addEventListener('touchmove', handleTouchMove, { passive: true })
    element.addEventListener('touchend', handleTouchEnd, { passive: true })
  })

  onUnmounted(() => {
    const element = target.value
    if (!element) return

    element.removeEventListener('touchstart', handleTouchStart)
    element.removeEventListener('touchmove', handleTouchMove)
    element.removeEventListener('touchend', handleTouchEnd)
  })

  return {
    isSwiping
  }
}
