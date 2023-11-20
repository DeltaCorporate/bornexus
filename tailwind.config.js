/** @type {import('tailwindcss').Config} */
const plugin = require("tailwindcss/plugin");

module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    fontFamily: {
      sans: ['"Poppins"', 'sans-serif']
    },
    extend: {
      colors: {
     /* DARK THEME 
     
        'primary': "#7480FF", 
        'secondary': '#FF52D9', 
        'accent': "#C7C7C7",
        'background': '#14191E', 
        'card': '#1D232A', 
        'text': '#BAC0C9',
        'error': '#F1714F', 
        'success': '#2EC4B6', 
        'warning': '#FF9F1C', 

        */

        /* LIGHT THEME */

        'primary': "#3546AB", // ROSE

        'secondary': '#0C145A', // NOIR

        'accent': "#8084A9",
        'text': '#0C145A',
        'background': '#F6F8FD', // BLANC
        
        'card': '#FFFFFF', // CARD
        
        'error': '#F1714F', // ORANGE
        'success': '#2EC4B6', // VERT
        'warning': '#FF9F1C', // JAUNE
      }
      
      },
  },
  
  plugins: [plugin(({ addBase, theme }) => {
    addBase({
      html: {
        color: theme("colors.text"),
        fontSize: theme("fontSize.base"),
      },
    });
  }), 
  require('@tailwindcss/forms')]
}