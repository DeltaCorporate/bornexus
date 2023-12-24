/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./src/Twig/**/*.php",
  ],
  theme: {
    fontFamily: {
      sans: ['"Inter"', 'sans-serif']
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

        'primary': "#A8EB74", // ROSE

        'secondary': '#7EB0FA', // NOIR

        'accent': "rgba(33, 33, 33, 0.70);",
        'text': '#212121',
        'base': '#FFF', // BLANC
        
        'neutral': '#F6F7FA', // CARD
        
        'error': '#ED714A', // ORANGE
        'success': '#92DB4B', // VERT
        'warning': '#ECEE84', // JAUNE
      },
      translate: {
        '-1/2': '-50%',
      }
      
      },
   
  },
  safelist: [
    {
      pattern: /(bg|text|border|ring)-(primary|secondary|accent|text|background|card|error|success|warning)/,
      variants: ['hover']
    },

    'hover:brightness-75',
  ],

  plugins: [ require('@tailwindcss/forms')]
}