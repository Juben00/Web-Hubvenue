/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js,php}",
    "./components/**/*.{html,js,php}",
    "./*.php",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#E73023',
        'primary-dark': '#B01B1B',
      }
    },
  },
  plugins: [
    // require('@tailwindcss/forms'),
  ],
};
