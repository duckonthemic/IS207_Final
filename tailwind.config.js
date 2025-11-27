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
                sans: ['Barlow', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'cyber-black': '#ffffff',
                'cyber-white': '#000000',
                'cyber-gray': '#f4f4f5',
                'cyber-gray-light': '#e4e4e7',
                'cyber-border': '#d4d4d8',
                'cyber-text': '#18181b',
                'cyber-text-muted': '#71717a',
                'cyber-accent': '#000000',
            },
            boxShadow: {
                'cyber': '0 0 0 1px #d4d4d8',
                'cyber-hover': '0 0 15px rgba(0, 0, 0, 0.1)',
            }
        },
    },

    plugins: [forms],
};
