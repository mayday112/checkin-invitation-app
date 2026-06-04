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
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                neon: {
                    pink: '#ff007f',
                    cyan: '#00f0ff',
                    purple: '#b026ff',
                },
                glass: {
                    dark: 'rgba(15, 23, 42, 0.7)',
                    light: 'rgba(255, 255, 255, 0.1)',
                }
            },
            boxShadow: {
                'neon-pink': '0 0 10px #ff007f, 0 0 20px #ff007f',
                'neon-cyan': '0 0 10px #00f0ff, 0 0 20px #00f0ff',
            }
        },
    },

    plugins: [forms],
};
