import {defineConfig} from 'vite'
import {resolve} from 'path'
import {writeFileSync} from 'fs'
require('dotenv-flow').config()
import 'url'
// Plugins
import Inspect from 'vite-plugin-inspect'
import viteImagemin from 'vite-plugin-imagemin'
import {viteStaticCopy} from 'vite-plugin-static-copy'

const os = require('os')
const projectRootDir = resolve(__dirname)

const vitePollenServe = ({manifestName = 'manifest'} = {}) => {
  let config, root, base

  return {
    name: 'pollen-serve',
    apply: 'serve',

    _resolveHostname(optionsHost) {
      let host

      if (optionsHost === undefined ||
          optionsHost === false ||
          optionsHost === 'localhost') {
        // Use a secure default
        host = '127.0.0.1'
      } else if (optionsHost === true) {
        // If passed --host in the CLI without arguments
        host = undefined // undefined typically means 0.0.0.0 or :: (listen on all IPs)
      } else {
        host = optionsHost
      }
      // Set host name to localhost when possible, unless the user explicitly asked for '127.0.0.1'
      const name = (optionsHost !== '127.0.0.1' && host === '127.0.0.1') ||
      host === '0.0.0.0' ||
      host === '::' ||
      host === undefined ? 'localhost' : host

      return {host, name}
    },

    _normalizePath(path) {
      if (root !== '/' && path.startsWith(root)) {
        path = path.slice(root.length)

        if (path[0] !== '/') {
          path = `/${path}`
        }
      }

      if (path.startsWith(base)) {
        path = path.slice(base.length)
      }

      if (path[0] === '/') {
        path = path.slice(1)
      }

      return path
    },

    configResolved(ResolvedConfig) {
      config = ResolvedConfig
      root = config.root
      base = config.base
    },

    configureServer({httpServer, watcher, ws}) {
      if (!config.env.DEV) {
        return
      }

      // Watch view template changes
      watcher.add(resolve('./resources/views/**/*'))
      watcher.on('change', function (path) {
        if (path.endsWith('.php') || path.endsWith('.twig') || path.endsWith('.blade')) {
          ws.send({
            type: 'full-reload'
          })
        }
      })

      httpServer?.once('listening', () => {
        const protocol = config.server.https ? 'https' : 'http',
            hostname = this._resolveHostname(config.server.host || 'localhost'),
            port = config.server.port,
            url = {local: '', network: []}

        if (process.env.APP_URL !== undefined) {
          const appUrl = new URL(process.env.APP_URL || null)
          config.server.origin = `${appUrl.protocol}//${appUrl.hostname}:3000`
        }

        if (hostname.host === '127.0.0.1') {
          url.local = `${protocol}://${hostname.name}:${port}${base}`
        } else {
          Object.values(os.networkInterfaces())
              .flatMap((nInterface) => nInterface !== null && nInterface !== void 0 ? nInterface : [])
              .filter((detail) => detail && detail.address && detail.family === 'IPv4')
              .map((detail) => {
                const host = detail.address.replace('127.0.0.1', hostname.name)

                const resp = {local: detail.address.includes('127.0.0.1')}
                resp.url = `${protocol}://${host}:${port}${base}`.replace(/\/$/, "")

                return resp
              })
              .forEach(resolved => {
                if (resolved.local) {
                  url.local = resolved.url
                } else {
                  url.network.push(resolved.url)
                }
              })

          if (!config.server.origin && url.network.length === 1) {
            config.server.origin = url.network[0]
          }
        }

        const manifest = {
          url,
          inputs: {},
        }
        const inputOptions = config.build.rollupOptions?.input ?? {}

        if (typeof inputOptions === 'string') {
          manifest.inputs['main'] = this._normalizePath(inputOptions)
        } else if (Array.isArray(inputOptions)) {
          for (const name of inputOptions) {
            manifest.inputs[name] = this._normalizePath(name)
          }
        } else {
          for (const [name, path] of Object.entries(inputOptions)) {
            manifest.inputs[name] = this._normalizePath(path)
          }
        }

        writeFileSync(resolve(config.root, `${manifestName}.json`), JSON.stringify(manifest))
      })
    }
  }
}

export default defineConfig(({command, mode}) => {
  return {
    resolve: {
      alias: [
        {find: /^~(.*)/, replacement: '$1'},
        {find: /^pollen-solutions\/(.*)/, replacement: resolve(projectRootDir, 'vendor/pollen-solutions/$1')},
        {find: /^wp-admin\/(.*)/, replacement: resolve(projectRootDir, 'public/wordpress/wp-admin/$1')},
        {find: /^wp-content\/(.*)/, replacement: resolve(projectRootDir, 'public/wordpress/wp-content/$1')},
        {find: /^wp-includes\/(.*)/, replacement: resolve(projectRootDir, 'public/wordpress/wp-includes/$1')},
      ]
    },
    plugins: [
      Inspect(),
      vitePollenServe(),
      viteImagemin(),
      viteStaticCopy({
        targets: [
          {
            src: 'static',
            dest: '/'
          }
        ]
      }),
    ],
    root: './resources/assets',
    base: command === 'serve' ? './' : '/assets/',
    server: {
      host: '0.0.0.0',
      port: 3000,
      watch: {
        disableGlobbing: false,
      }
    },
    build: {
      manifest: true,
      assetsDir: '',
      outDir: '../../public/assets/',
      rollupOptions: {
        output: {
          manualChunks: undefined
        },
        input: {
          'app': './resources/assets/app.js'
        }
      },
      minify: false,//'esbuild',
      emptyOutDir: true
    }
  }
})
