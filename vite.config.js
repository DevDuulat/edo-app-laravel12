import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Обеспечиваем относительные пути для ассетов
            buildDirectory: 'build',
            publicDirectory: 'public',
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        https: true,
    },
    base: '/',
});
