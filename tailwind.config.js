import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Badge colors for ticket types
        'bg-blue-900', 'text-blue-200',
        'bg-green-900', 'text-green-200',
        'bg-amber-900', 'text-amber-200',
        'bg-slate-700', 'text-slate-100',
        // Badge colors for ticket status
        'bg-red-900', 'text-red-200',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
