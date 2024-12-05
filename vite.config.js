import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler',
            }
        }
    },
    plugins: [
        laravel({
            input: ['resources/scss/app.scss'],
            refresh: true,
        }),
    ],
});
