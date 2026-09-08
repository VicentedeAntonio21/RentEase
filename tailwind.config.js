import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#556EE6',
                    dark: '#4458C9',
                    light: '#EEF1FD',
                },
                sidebar: {
                    DEFAULT: '#2A3042',
                    hover: '#32394E',
                },
                success: '#34C38F',
                warning: '#F1B44C',
                danger: '#F46A6A',
            },
        },
    },

    plugins: [forms],
};