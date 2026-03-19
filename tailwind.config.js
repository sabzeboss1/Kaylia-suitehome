/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./includes/**/*.php",
    "./views/**/*.php",
    "./assets/js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          dark: '#1a2e35',
          teal: '#2d5a5f',
          blue: '#0a7ea4',
          beige: '#b8956a',
          'beige-dark': '#9d7e56'
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
