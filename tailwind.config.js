import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                // Semantic colors for theming
                skin: {
                    base: 'var(--bg-primary)',
                    'base-sec': 'var(--bg-secondary)', 
                    'base-ter': 'var(--bg-tertiary)',
                    'bg-alt': 'var(--bg-alt)',
                    'fill': 'var(--bg-fill)',
                    text: 'var(--text-primary)',
                    'text-muted': 'var(--text-secondary)',
                    'text-base-muted': 'var(--text-muted)',
                    'text-inv': 'var(--text-inverted)',
                    border: 'var(--border-color)',
                    'border-light': 'var(--border-color-light)',
                    'border-dark': 'var(--border-color-dark)',
                },
                umera: {
                    DEFAULT: '#890706',
                    50: '#fdf2f2',
                    100: '#fde3e3',
                    200: '#fbd0d0',
                    300: '#f7aab9',
                    400: '#f27a7a',
                    500: '#ea4e4e',
                    600: '#d92626',
                    700: '#b91c1c',
                    800: '#890706', // Base color
                    900: '#7f1d1d',
                    950: '#450a0a',
                },
                gold: {
                    DEFAULT: '#B8976A',
                    50: '#fbf8f3',
                    100: '#f5efe4',
                    200: '#ebdeca',
                    300: '#dec4a3',
                    400: '#cea276',
                    500: '#b8976a', // Base color
                    600: '#9e7a53',
                    700: '#7f5f43',
                    800: '#684d39',
                    900: '#554032',
                    950: '#2d211a',
                },
            },
        },
    },

    plugins: [forms],
};
