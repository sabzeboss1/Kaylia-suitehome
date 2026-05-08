/**
 * Composable pour la gestion du SEO dynamique
 * Injecte les meta tags pour chaque page
 */

export interface SEOMetaData {
  title: string
  description: string
  keywords?: string
  ogTitle?: string
  ogDescription?: string
  ogImage?: string
  ogUrl?: string
  canonical?: string
  robots?: string
}
const getOrganizationSchema = () => {
  return {
    "@context": "https://schema.org",
    "@type": "LodgingBusiness",
    "name": "Kaylia Suite Home",
    "url": "https://kayliasuitehome.com",
    "description": "Appartements de luxe et SPA à Yaoundé, Cameroun",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Yaoundé",
      "addressCountry": "CM"
    },
    "telephone": "",
    "priceRange": "$$"
  }
}

export function useSEO() {
  const setMetaTags = (meta: SEOMetaData) => {
    // Title
    document.title = meta.title

    // Description
    updateMetaTag('name', 'description', meta.description)

    // Keywords
    if (meta.keywords) {
      updateMetaTag('name', 'keywords', meta.keywords)
    }

    // Robots
    updateMetaTag('name', 'robots', meta.robots || 'index, follow')

    // Open Graph
    updateMetaTag('property', 'og:title', meta.ogTitle || meta.title)
    updateMetaTag('property', 'og:description', meta.ogDescription || meta.description)
    updateMetaTag('property', 'og:type', 'website')
    
    if (meta.ogImage) {
      updateMetaTag('property', 'og:image', meta.ogImage)
    }
    
    if (meta.ogUrl) {
      updateMetaTag('property', 'og:url', meta.ogUrl)
    }

    // Twitter Card
    updateMetaTag('name', 'twitter:card', 'summary_large_image')
    updateMetaTag('name', 'twitter:title', meta.ogTitle || meta.title)
    updateMetaTag('name', 'twitter:description', meta.ogDescription || meta.description)
    
    if (meta.ogImage) {
      updateMetaTag('name', 'twitter:image', meta.ogImage)
    }

    // Canonical URL
    if (meta.canonical) {
      updateLinkTag('canonical', meta.canonical)
    }
  }

  const updateMetaTag = (attr: string, key: string, content: string) => {
    let element = document.querySelector(`meta[${attr}="${key}"]`)
    
    if (!element) {
      element = document.createElement('meta')
      element.setAttribute(attr, key)
      document.head.appendChild(element)
    }
    
    element.setAttribute('content', content)
  }

  const updateLinkTag = (rel: string, href: string) => {
    let element = document.querySelector(`link[rel="${rel}"]`)
    
    if (!element) {
      element = document.createElement('link')
      element.setAttribute('rel', rel)
      document.head.appendChild(element)
    }
    
    element.setAttribute('href', href)
  }

  const setStructuredData = (data: any) => {
    let script = document.querySelector('script[type="application/ld+json"]')
    
    if (!script) {
      script = document.createElement('script')
      script.setAttribute('type', 'application/ld+json')
      document.head.appendChild(script)
    }
    
    script.textContent = JSON.stringify(data)
  }

  return {
    setMetaTags,
    setStructuredData,
    getOrganizationSchema
  }
}
