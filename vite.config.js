import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/admin_analytics.js", // Tambahkan file ini
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/detail_produk.js',
                'resources/js/landing.js',
                'resources/js/keranjang.js',
                'resources/js/login.js',
                'resources/js/confirm.js',
                'resources/js/admin_dashboard.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
