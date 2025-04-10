import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/detail_produk.js',
                'resources/js/landing.js',
                'resources/js/keranjang.js',
                'resources/js/login.js',
                'resources/js/confirm.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
