/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./auth/**/*.php",         // páginas de login, registo, etc.
    "./components/**/*.php",   // se tiveres componentes PHP separados
    "./index.php",             // página principal
    "./assets/js/**/*.js",     // JS que pode gerar classes dinamicamente
  ],
  theme: {
    extend: {
      colors: {
        description: '#7D7987',
        primary: {
          DEFAULT: '#F1F7F7',
          dark: '#3A9B8A',
          dark_green: '#085543',
          light: '#6DCBB5',
        },
        dark: '#1F2937',
        light: '#F3F4F6',
      },
      fontFamily: {
        sans: ['Montserrat', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
