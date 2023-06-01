import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
            build: {
                manifest: true,
                rollupOptions: {
                    input: {
                        app: 'resources/js/app.js',
                    },
                },
                publicDir: 'public',
                outDir: 'public/build',
                assetsDir: '',
                manifestFile: 'public/build/manifest.json',
                emptyOutDir: true,
                writeManifestFile: true,
            },
            mix: {
                manifest: 'public/build/mix-manifest.json',
                resourceRoot: '/',
                assetPublicPath: '/',
            },
            https: true, // Agrega esta línea para habilitar HTTPS
        }),
    ],
});
