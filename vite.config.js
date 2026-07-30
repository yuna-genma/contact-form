import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/sanitize.css',
                'resources/css/index.css',
                'resources/css/confirm.css',
                'resources/css/thanks.css',
                ],
            refresh: true,
        }),
    ],
});
