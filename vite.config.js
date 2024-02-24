import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                    'resources/css/filament/member/theme.css',
                    'resources/css/app.css',
                    'resources/js/app.js',
                ],
            refresh: true,
        }),
    ],
});

