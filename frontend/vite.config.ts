import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
      watch: {
          usePolling: true
      },
      port: 8080,
      proxy: {
        '/sanctum/csrf-cookie': {
          target: 'http://127.0.0.1:8000',
          changeOrigin: true,
          secure: false,
          rewrite: (path) => path.replace(/^\/api/, '')
        },
        '/api': {
          target: 'http://127.0.0.1:8000',
          changeOrigin: true,
          secure: false
        },
        '/register' : {
          target: 'http://127.0.0.1:8000',
          changeOrigin: true,
          secure: false
        },
        '/logout' : {
          target: 'http://127.0.0.1:8000',
          changeOrigin: true,
          secure: false
        }
      }
  }
})
