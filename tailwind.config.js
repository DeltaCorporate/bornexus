/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./src/Twig/**/*.php",
    ],
    theme: {
        fontFamily: {
            sans: ['Inter', 'sans-serif']
        },
        extend: {
            colors: {
                'primary': "#A8EB74", // ROSE
                'secondary': '#7EB0FA', // NOIR
                'accent': "rgba(33, 33, 33, 0.70);",
                'text': '#212121',
                'base': '#FFF', // BLANC
                'neutral': '#F6F7FA', // CARD
                'darkgrey': '#D9D9D9',
                'error': '#E14A3B', // ORANGE
                'success': '#92DB4B', // VERT
                'warning': '#ECEE84', // JAUNE
            },
            translate: {
                '-1/2': '-50%',
            },
            container: {
                center: true,
            },
        },
    },
    safelist: [
        {
            pattern: /(bg|text|border|ring)-(primary|secondary|accent|text|background|card|error|success|warning|darkgrey)/,
            variants: ['hover']
        },
        {
            pattern: /(w|h)-(100|[1-9][0-9]?)/,
        },
        'hover:brightness-75',
    ],

    // plugins: [require('@tailwindcss/forms')]
}