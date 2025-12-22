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
                'resources/css/editor.css',
                'resources/js/app.js',
                'resources/css/dropdown.css',
                'resources/js/photoswipe-init.js',
                'resources/js/folder-interactions.js',
                'resources/js/folders.js',
                'resources/js/editor.js',
                'resources/js/documentForm.js',
                'resources/js/wysiwyg.js',
                'resources/js/workflow-tabs.js',

            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});