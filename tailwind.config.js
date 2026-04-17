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
            colors: {
                // OctaBit brand palette
                'octa': {
                    50:  '#f0edff',
                    100: '#e2dbff',
                    200: '#c4b7ff',
                    300: '#a693ff',
                    400: '#886fff',
                    500: '#7c3aed', // primary purple
                    600: '#6d28d9',
                    700: '#5b21b6',
                    800: '#4c1d95',
                    900: '#2e1065',
                    950: '#1a0840',
                },
                'cyan': {
                    400: '#22d3ee',
                    500: '#06b6d4',
                },
                // Dark background palette
                'bg': {
                    primary:   '#0a0b14',
                    secondary: '#12131e',
                    elevated:  '#1c1d2e',
                    border:    '#2a2b3d',
                },
            },
            fontFamily: {
                sans: ['Inter', 'DM Sans', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'glow': '0 0 15px rgba(124, 58, 237, 0.3)',
                'glow-sm': '0 0 8px rgba(124, 58, 237, 0.2)',
            },
        },
    },
    plugins: [forms],
};
