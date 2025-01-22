import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

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
        },
    },

    plugins: [forms, daisyui], // Añade DaisyUI aquí
    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: '#4CAF50',
                    secondary: '#FF9800',
                    accent: '#607D8B',
                    neutral: '#3D4451',
                    'base-100': '#FFFFFF',
                },
            },
            'dark', // Tema oscuro predefinido
            'cupcake', // Tema predefinido
        ],
    },
};
