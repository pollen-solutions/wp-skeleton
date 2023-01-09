import {defineConfig} from 'vite'
import {resolve} from 'path'
import {writeFileSync} from 'fs'
import { rm } from 'node:fs/promises'
require('dotenv-flow').config()
import 'url'
// Plugins
import Inspect from 'vite-plugin-inspect'
import viteImagemin from 'vite-plugin-imagemin'

const os = require('os')
const projectRootDir = resolve(__dirname)

const vitePollenServe = ({manifestName = 'manifest'} = {}) => {
  let config, root, base

  const resolveHostname = (optionsHost) => {
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
  }

  const normalizePath = (path) => {
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
  }

  return {
    name: 'pollen-serve',
    apply: 'serve',

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
            hostname = resolveHostname(config.server.host || 'localhost'),
            port = config.server.port,
            url = {local: '', network: []}

        let APP_URL = undefined
        if (process.env.APP_URL !== undefined) {
          APP_URL = process.env.APP_URL
        }

        if (APP_URL !== undefined) {
          const appUrl = new URL(APP_URL || null)
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
          manifest.inputs['main'] = normalizePath(inputOptions)
        } else if (Array.isArray(inputOptions)) {
          for (const name of inputOptions) {
            manifest.inputs[name] = normalizePath(name)
          }
        } else {
          for (const [name, path] of Object.entries(inputOptions)) {
            manifest.inputs[name] = normalizePath(path)
          }
        }

        writeFileSync(resolve(config.root, `${manifestName}.json`), JSON.stringify(manifest))
      })
    }
  }
}

const isServe = (env) => {
  return env.command === 'serve'
}

const inDev = (env) => {
  return env.command === 'serve' || env.mode === 'watch'
}

export default defineConfig(env => {
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
      viteImagemin({
        svgo: false
      }),
      {
        name: "Cleaning assets folder",
        async buildStart() {
          await rm('public/assets', { recursive: true, force: true });
        }
      }
    ],
    root: './resources/assets',
    base: isServe(env) ? './' : './',
    server: {
      host: '0.0.0.0',
      port: 3000,
      watch: {
        disableGlobbing: false,
      },
    },
    build: {
      manifest: true,
      assetsDir: 'assets',
      outDir: '../../public',
      sourcemap: inDev(env),
      rollupOptions: {
        output: {
          manualChunks: undefined
        },
        input: {
          'app': './resources/assets/app.js'
        }
      },
      minify: inDev(env) ? false : 'esbuild'
    }
  }
})