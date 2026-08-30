import fs from 'node:fs';
import path from 'node:path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

const browserOrigin = 'http://localhost:5173';

function laravelHotFileBrowserOrigin() {
    return {
        name: 'laravel-hot-file-browser-origin',

        configureServer(server) {
            const writeHotFile = () => {
                const resolvedOrigin = (
                    server.config.server.origin || browserOrigin
                ).replace(/\/$/, '');

                const url = resolvedOrigin.includes(
                    '__laravel_vite_placeholder__'
                )
                    ? browserOrigin
                    : resolvedOrigin;

                fs.writeFileSync(
                    path.join(process.cwd(), 'public', 'hot'),
                    url
                );
            };

            server.httpServer?.once('listening', () => {
                setTimeout(writeHotFile, 0);
            });
        },
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/customer/order.js',
                'resources/js/customer/virtual-fitting.js',
            ],

            refresh: true,

            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),

                bunny('Cormorant Garamond', {
                    weights: [400, 500, 600, 700],
                }),
            ],
        }),

        laravelHotFileBrowserOrigin(),

        tailwindcss(),
    ],

    server: {
        // Docker harus bisa mengakses Vite
        host: '0.0.0.0',

        // Port Vite
        port: 5173,

        // Jangan pindah ke port lain kalau 5173 sedang digunakan
        strictPort: true,

        // URL Vite yang ditulis ke public/hot
        origin: browserOrigin,

        // Izinkan Laravel di localhost:8000
        // mengakses asset Vite di localhost:5173
        cors: {
            origin: 'http://localhost:8000',
        },

        // Hot Module Replacement
        hmr: {
            host: 'localhost',
            port: 5173,
            clientPort: 5173,
        },

        // Watch settings for Docker on Windows
        watch: {
            usePolling: true,
            interval: 100,
            ignored: [
                '**/storage/framework/views/**',
            ],
        },
    },
});