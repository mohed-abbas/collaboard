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
                'resources/js/board-drag-drop.js',
                'resources/js/calendar-drag-drop.js'
            ],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});