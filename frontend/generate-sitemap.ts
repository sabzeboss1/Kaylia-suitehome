/**
 * Script pour générer le sitemap.xml
 * À exécuter: npx tsx generate-sitemap.ts
 */

import { writeFileSync } from 'fs'
import { join } from 'path'
import axios from 'axios'
import { generateSitemap, getStaticUrls, getApartmentUrls } from './src/utils/sitemap-generator'

const BASE_URL = process.env.VITE_APP_URL || 'https://kayliasuitehome.com'
const API_URL = process.env.VITE_API_URL || 'http://localhost:8000'

async function main() {
  console.log('🗺️  Génération du sitemap...')

  try {
    // URLs statiques
    const staticUrls = getStaticUrls(BASE_URL)
    console.log(`✅ ${staticUrls.length} URLs statiques ajoutées`)

    // URLs dynamiques des appartements
    let apartmentUrls: any[] = []
    try {
      const response = await axios.get(`${API_URL}/api/apartments`)
      const apartments = response.data.data || response.data
      apartmentUrls = getApartmentUrls(BASE_URL, apartments)
      console.log(`✅ ${apartmentUrls.length} appartements ajoutés`)
    } catch (error) {
      console.warn('⚠️  Impossible de récupérer les appartements, sitemap avec URLs statiques uniquement')
    }

    // Générer le XML
    const allUrls = [...staticUrls, ...apartmentUrls]
    const sitemapXml = generateSitemap(allUrls)

    // Écrire le fichier
    const outputPath = join(__dirname, 'public', 'sitemap.xml')
    writeFileSync(outputPath, sitemapXml, 'utf-8')

    console.log(`✅ Sitemap généré avec succès: ${outputPath}`)
    console.log(`📊 Total: ${allUrls.length} URLs`)
  } catch (error) {
    console.error('❌ Erreur lors de la génération du sitemap:', error)
    process.exit(1)
  }
}

main()
