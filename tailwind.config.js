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
                sans: ['Vazirmatn', ...defaultTheme.fontFamily.sans],
                display: ['Inter', 'Vazirmatn', ...defaultTheme.fontFamily.sans],
                body: ['Inter', 'Vazirmatn', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eef2f9',
                    100: '#d7e1f0',
                    200: '#b5c8e4',
                    300: '#8fa9d1',
                    400: '#6888bd',
                    500: '#2a4d8f',
                    600: '#1f3d73',
                    700: '#16305c',
                    800: '#102448',
                    900: '#0c1c38',
                    950: '#070f20',
                },
                accent: {
                    50: '#fdf8ef',
                    100: '#f9edcf',
                    200: '#f2d89e',
                    300: '#e9be64',
                    400: '#d9a441',
                    500: '#c48f2a',
                    600: '#a87420',
                    700: '#8a5a1c',
                    800: '#72491f',
                    900: '#5f3c1e',
                },
                success: {
                    DEFAULT: '#1f9d55',
                    50: '#eef9f2',
                    100: '#d6f0df',
                    500: '#1f9d55',
                    600: '#18804a',
                    700: '#14663c',
                },
                warning: {
                    DEFAULT: '#d98c15',
                    50: '#fef8ec',
                    100: '#fbecd0',
                    500: '#d98c15',
                    600: '#b57410',
                    700: '#8f5c10',
                },
                danger: {
                    DEFAULT: '#d92d20',
                    50: '#fef3f2',
                    100: '#fee4e2',
                    500: '#d92d20',
                    600: '#b42318',
                    700: '#912018',
                },
                neutral: {
                    0: '#ffffff',
                    50: '#f8f9fb',
                    100: '#f1f2f5',
                    200: '#e4e6ea',
                    300: '#d1d5dc',
                    400: '#9aa0ab',
                    500: '#787e8a',
                    600: '#5b616e',
                    700: '#444a55',
                    800: '#2b2f38',
                    900: '#1a1d24',
                    950: '#14161b',
                },
            },
            borderRadius: {
                'base': '0.625rem',
                'lg': '0.5rem',
                'xl': '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'card': '0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04)',
                'card-hover': '0 20px 40px -12px rgba(0, 0, 0, 0.1), 0 8px 16px -8px rgba(0, 0, 0, 0.06)',
                'elevated': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05)',
                'elevated-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.05)',
                'sidebar': '4px 0 24px -4px rgba(0, 0, 0, 0.08)',
                'filament': '0 0 0 1px rgba(0, 0, 0, 0.05), 0 1px 3px 0 rgba(0, 0, 0, 0.1)',
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-out forwards',
                'slide-up': 'slideUp 0.4s ease-out forwards',
                'slide-down': 'slideDown 0.3s ease-out forwards',
                'scale-in': 'scaleIn 0.2s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%': { opacity: '0', transform: 'translateY(-8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
            transitionDuration: {
                '150': '150ms',
                '200': '200ms',
            },
        },
    },

    plugins: [forms],
};
