/**
 * Helper pour obtenir l'URL complète d'une image d'appartement
 * 
 * @param image - Peut être une string (URL) ou un objet avec image_url/thumbnail_url
 * @param fallback - Image par défaut si aucune image n'est fournie
 * @returns URL complète de l'image
 */
export function getImageUrl(image: any, fallback: string = '/images/placeholder-apartment.svg'): string {
  // Si pas d'image, retourner le fallback
  if (!image) {
    return fallback
  }
  
  // Si c'est déjà une string (URL)
  if (typeof image === 'string') {
    // Si l'URL est relative, ajouter le backend URL
    if (image.startsWith('/storage/')) {
      return `http://localhost:8000${image}`
    }
    return image
  }
  
  // Si c'est un objet avec thumbnail_url ou image_url
  const url = image.thumbnail_url || image.image_url
  if (!url) {
    return fallback
  }
  
  // Si l'URL est relative, ajouter le backend URL
  if (url.startsWith('/storage/')) {
    return `http://localhost:8000${url}`
  }
  
  return url
}

/**
 * Helper pour obtenir l'URL de la première image d'un appartement
 * 
 * @param images - Tableau d'images
 * @param fallback - Image par défaut
 * @returns URL de la première image ou fallback
 */
export function getFirstImageUrl(images: any[], fallback: string = '/images/placeholder-apartment.svg'): string {
  if (!images || images.length === 0) {
    return fallback
  }
  
  return getImageUrl(images[0], fallback)
}

/**
 * Helper pour obtenir toutes les URLs d'images d'un appartement
 * 
 * @param images - Tableau d'images
 * @returns Tableau d'URLs
 */
export function getAllImageUrls(images: any[]): string[] {
  if (!images || images.length === 0) {
    return []
  }
  
  return images.map(img => getImageUrl(img)).filter(url => url !== '/images/placeholder-apartment.svg')
}
