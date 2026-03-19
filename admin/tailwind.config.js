/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          50: '#f0f1f5',
          100: '#d9dce6',
          200: '#b3b9cd',
          300: '#8d96b4',
          400: '#67739b',
          500: '#4a5578',
          600: '#343d5c',
          700: '#272e47',
          800: '#1e2438',
          900: '#1a1f36',
          950: '#111428',
        },
        gold: {
          50: '#fdf8f0',
          100: '#f9edd9',
          200: '#f2dab3',
          300: '#e5c38a',
          400: '#d4a862',
          500: '#c5a47e',
          600: '#b08a5b',
          700: '#946e45',
          800: '#7a5a3a',
          900: '#654b32',
        },
        surface: {
          50: '#f8f9fc',
          100: '#f1f3f9',
          200: '#e8ebf3',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
        display: ['Playfair Display', 'Georgia', 'serif'],
      },
      boxShadow: {
        'card': '0 1px 3px rgba(26, 31, 54, 0.06), 0 1px 2px rgba(26, 31, 54, 0.04)',
        'card-hover': '0 10px 25px rgba(26, 31, 54, 0.08), 0 4px 10px rgba(26, 31, 54, 0.05)',
        'sidebar': '4px 0 24px rgba(26, 31, 54, 0.12)',
        'header': '0 1px 3px rgba(26, 31, 54, 0.05)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'slide-down': 'slideDown 0.2s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideIn: {
          '0%': { opacity: '0', transform: 'translateX(-10px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-4px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
