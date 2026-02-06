import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/front/app.css',
                'resources/js/front/app.js',
                'resources/css/author/app.css',
                'resources/css/author/auth.css',
                'resources/js/author/app.js',
            ],
            refresh: [
                'resources/views/**',
                'resources/css/**',
                'app/Http/Controllers/**',
                'routes/**',
            ],
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
