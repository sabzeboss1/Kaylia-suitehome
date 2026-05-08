/**
 * Image URL Utility
 * 
 * Handles image URL construction with proper base URL from environment.
 * Provides fallback images when needed.
 */

/**
 * Get full image URL from relative or absolute path
 */
export function getImageUrl(path: string | undefined): string {
  if (!path) {
    return '/images/placeholder.jpg'
  }

  // Already a full URL
  if (path.startsWith('http://') || path.startsWith('https://')) {
    return path
  }

  // Data URL
  if (path.startsWith('data:')) {
    return path
  }

  // Relative path - build full URL
  const baseUrl = import.meta.env.VITE_API_BASE_URL?.replace('/api', '') || ''
  return `${baseUrl}${path}`
}

/**
 * Get apartment images with fallback
 */
export function getApartmentImages(apartment: any): string[] {
  if (!apartment?.images || apartment.images.length === 0) {
    return [
      '/images/apartments/default1.jpg',
      '/images/apartments/default2.jpg',
      '/images/apartments/default3.jpg',
    ]
  }

  return apartment.images.map((img: any) => {
    const url = typeof img === 'string' ? img : (img.image_url || img.thumbnail_url)
    return getImageUrl(url)
  })
}

/**
 * Get thumbnail URL with fallback
 */
export function getThumbnailUrl(image: any): string {
  if (!image) {
    return '/images/placeholder-thumb.jpg'
  }

  if (typeof image === 'string') {
    return getImageUrl(image)
  }

  const url = image.thumbnail_url || image.image_url
  return getImageUrl(url)
}

/**
 * Get full image URL (not thumbnail)
 */
export function getFullImageUrl(image: any): string {
  if (!image) {
    return '/images/placeholder.jpg'
  }

  if (typeof image === 'string') {
    return getImageUrl(image)
  }

  const url = image.image_url || image.thumbnail_url
  return getImageUrl(url)
}
