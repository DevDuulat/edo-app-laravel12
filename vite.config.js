import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/dropdown.css',
                'resources/js/photoswipe-init.js',
                'resources/js/folder-interactions.js',
                'resources/js/folders.js',
                'resources/js/document-create-templates-editor.js',
                'resources/js/document-edit-templates-editor.js'

            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});