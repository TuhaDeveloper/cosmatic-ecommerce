import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                theme: {
                    primary: '#a28e46',
                    'primary-hover': '#8e7b39',
                    'primary-dark': '#6d5d28',
                    'primary-light': '#f7f4ec',
                    'primary-soft': '#faf7f0',
                    dark: '#1e1e1e',
                    gray: '#666666',
                    light: '#fcfbfa',
                    border: '#e8e4dc',
                    gold: '#a28e46',
                },
            },
            fontFamily: {
                sans: ['Outfit', 'Inter', 'Segoe UI', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'Georgia', ...defaultTheme.fontFamily.serif],
                display: ['Playfair Display', 'serif'],
            },
            boxShadow: {
                'theme-sm': '0 2px 8px rgba(162, 142, 70, 0.08)',
                'theme-md': '0 4px 20px rgba(0, 0, 0, 0.08)',
                'theme-lg': '0 10px 30px rgba(162, 142, 70, 0.15)',
            },
        },
    },

    plugins: [forms],
};

