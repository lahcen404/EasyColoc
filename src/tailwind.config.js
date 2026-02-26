import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // THE FIX: Define your custom palette here
            colors: {
                'brand-dark': '#0A6071',      // Darkest Teal
                'brand-medium': '#078291',    // Medium Teal
                'brand-light': '#8BBAB6',     // Soft Turquoise
                'brand-soft': '#E9F2F3',      // Lightest Background
            },
        },
    },

    plugins: [forms],
};
