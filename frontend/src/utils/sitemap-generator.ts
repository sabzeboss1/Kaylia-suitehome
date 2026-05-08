/**
 * Générateur de sitemap dynamique
 * À exécuter côté serveur ou en build pour générer le sitemap.xml
 */

export interface SitemapUrl {
  loc: string
  lastmod?: string
  changefreq?: 'always' | 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly' | 'never'
  priority?: number
}

export function generateSitemap(urls: SitemapUrl[]): string {
  const xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>'
  const urlsetOpen = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
  const urlsetClose = '</urlset>'

  const urlEntries = urls.map(url => {
    let entry = '  <url>\n'
    entry += `    <loc>${escapeXml(url.loc)}</loc>\n`
    
    if (url.lastmod) {
      entry += `    <lastmod>${url.lastmod}</lastmod>\n`
    }
    
    if (url.changefreq) {
      entry += `    <changefreq>${url.changefreq}</changefreq>\n`
    }
    
    if (url.priority !== undefined) {
      entry += `    <priority>${url.priority.toFixed(1)}</priority>\n`
    }
    
    entry += '  </url>'
    return entry
  }).join('\n')

  return `${xmlHeader}\n${urlsetOpen}\n${urlEntries}\n${urlsetClose}`
}

function escapeXml(unsafe: string): string {
  return unsafe.replace(/[<>&'"]/g, (c) => {
    switch (c) {
      case '<': return '&lt;'
      case '>': return '&gt;'
      case '&': return '&amp;'
      case '\'': return '&apos;'
      case '"': return '&quot;'
      default: return c
    }
  })
}

/**
 * Génère les URLs statiques du site
 */
export function getStaticUrls(baseUrl: string): SitemapUrl[] {
  const now = new Date().toISOString()

  return [
    {
      loc: baseUrl,
      lastmod: now,
      changefreq: 'daily',
      priority: 1.0
    },
    {
      loc: `${baseUrl}/nos-appartements`,
      lastmod: now,
      changefreq: 'daily',
      priority: 0.9
    },
    {
      loc: `${baseUrl}/appartements`,
      lastmod: now,
      changefreq: 'daily',
      priority: 0.9
    },
    {
      loc: `${baseUrl}/studio`,
      lastmod: now,
      changefreq: 'weekly',
      priority: 0.8
    },
    {
      loc: `${baseUrl}/spa`,
      lastmod: now,
      changefreq: 'weekly',
      priority: 0.8
    },
    {
      loc: `${baseUrl}/contact`,
      lastmod: now,
      changefreq: 'monthly',
      priority: 0.7
    },
    {
      loc: `${baseUrl}/histoire`,
      lastmod: now,
      changefreq: 'monthly',
      priority: 0.6
    }
  ]
}

/**
 * Génère les URLs dynamiques des appartements
 */
export function getApartmentUrls(baseUrl: string, apartments: any[]): SitemapUrl[] {
  const now = new Date().toISOString()

  return apartments.map(apartment => ({
    loc: `${baseUrl}/appartements/${apartment.slug}`,
    lastmod: apartment.updated_at || now,
    changefreq: 'weekly' as const,
    priority: 0.8
  }))
}
