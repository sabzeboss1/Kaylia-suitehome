/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}"
  ],
  theme: {
    extend: {
      colors: {
        // Official Kaylia Brand Colors from Design System
        'dusty-taupe': '#c9b5a0',      // Ton poudré, subtil et neutre
        'deep-slate-blue': '#2d5a5f',  // Bleu profond, sobre et structuré
        'stone-brown': '#8b7355',      // Brun doux et naturel
        'relic-blue': '#4a7c8c',       // Bleu profond et frais
        'obsidian-black': '#1a1a1a',   // Noir profond
        'white-smoke': '#f5f5f5',      // Blanc brumeux
        
        // Legacy aliases for backward compatibility
        primary: {
          dark: '#1a2e35',
          teal: '#2d5a5f',
          blue: '#4a7c8c',
          beige: '#c9b5a0',
          'beige-dark': '#8b7355'
        }
      },
      fontFamily: {
        serif: ['Cormorant Garamond', 'serif'],
        sans: ['Montserrat', 'sans-serif']
      }
    }
  },
  plugins: []
}
