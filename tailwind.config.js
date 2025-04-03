import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundSize: {
                '200': '200% 200%',
            },
            keyframes: {
                gradientHorizontal: {
                    '0%, 100%': { 'background-position': '0% 50%' },
                    '50%': { 'background-position': '100% 50%' },
                },
                gradientAnimation: {
                    '0%': { 'background-position': '0%' },
                    '100%': { 'background-position': '200%' },
                   
                },
            },
            animation: {
                gradientHorizontal: 'gradientHorizontal 5s ease infinite',
                gradientAnimation: 'gradientAnimation 5s ease infinite',
            },
        },
    },
    plugins: [],
};
