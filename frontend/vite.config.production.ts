import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

// Configuration optimisée pour production cPanel
export default defineConfig({
  plugins: [vue()],
  base: '/frontend/',  // Chemin de base pour les assets
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  build: {
    outDir: '../backend/public/frontend',
    emptyOutDir: true,
    sourcemap: false,
    minify: 'esbuild',
    rollupOptions: {
      output: {
        manualChunks: {
          'vendor': ['vue', 'vue-router', 'pinia'],
          'utils': ['axios', 'date-fns'],
          'stripe': ['@stripe/stripe-js']
        },
        assetFileNames: 'assets/[name].[hash][extname]',
        chunkFileNames: 'assets/[name].[hash].js',
        entryFileNames: 'assets/[name].[hash].js'
      }
    },
    chunkSizeWarningLimit: 1000,
    assetsInlineLimit: 4096
  }
})
