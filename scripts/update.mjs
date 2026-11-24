/**
 * Brings a working copy up to date after a pull or a branch switch: dependencies,
 * database and built assets, and a stale public/hot removed. So the site Herd
 * serves without `make dev` shows the new styling and schema, not the old ones.
 *
 *   make update            on macOS, Linux and WSL2
 *   composer run refresh   anywhere, Windows included, no make needed
 *
 * The post-merge, post-checkout and post-rewrite hooks run it too.
 *
 * A dependency tree is reinstalled only when its lockfile is newer than what was
 * last installed from it. The marker is touched afterwards, because an install
 * that finds nothing to do leaves it alone, and the next run would reinstall for
 * nothing. An unchanged pull therefore costs about half a second. The build is
 * always rerun: it takes well under a second, and deciding which files feed it
 * would be a second list of Vite's inputs, drifting from vite.config.js.
 *
 * Written in Node rather than in the Makefile so that one implementation serves
 * both front doors, and so it runs on Windows, where there is no make.
 */

import { execFileSync } from 'node:child_process'
import { existsSync, rmSync, statSync, utimesSync } from 'node:fs'
import { HOT_FILE, isFree, projectPorts } from './lib/ports.mjs'
import { php } from './lib/site.mjs'

const isWindows = process.platform === 'win32'
const c = {
  log: (s) => console.log(`\x1b[1;36m▶\x1b[0m ${s}`),
  ok: (s) => console.log(`\x1b[1;32m✓\x1b[0m ${s}`),
}

/** composer and npm are .bat/.cmd shims on Windows, which only a shell can run. */
const run = (command, args) =>
  execFileSync(command, args, { stdio: 'inherit', shell: isWindows && command !== php })

const isNewer = (file, than) => !existsSync(than) || statSync(file).mtimeMs > statSync(than).mtimeMs

const touch = (file) => {
  const now = new Date()
  utimesSync(file, now, now)
}

try {
  const installed = 'vendor/composer/installed.json'
  if (!existsSync('vendor/autoload.php') || isNewer('composer.lock', installed)) {
    c.log('composer.lock changed — installing PHP dependencies…')
    run('composer', ['install', '--no-interaction', '--prefer-dist'])
    touch(installed)
  }

  const npmMarker = 'node_modules/.package-lock.json'
  if (isNewer('package-lock.json', npmMarker)) {
    c.log('package-lock.json changed — installing frontend dependencies…')
    run('npm', ['ci'])
    touch(npmMarker)
  }

  // A Vite that crashed leaves public/hot behind, and every page then asks a dead
  // server for its CSS: an unstyled site with nothing in any log.
  const vite = projectPorts().find((p) => p.name === 'vite')
  if (existsSync(HOT_FILE) && (await isFree(vite.port))) {
    rmSync(HOT_FILE, { force: true })
    c.log(`removed a stale ${HOT_FILE} — the built assets are served again`)
  }

  run(php, ['artisan', 'migrate', '--no-interaction'])
  run('npm', ['run', 'build', '--silent'])
  c.ok('Up to date — dependencies, database and assets')
} catch (error) {
  // The failing command has already printed its own output through stdio:'inherit'.
  console.error(
    `\x1b[1;31m✗\x1b[0m ${[error.path, ...(error.spawnargs ?? []).slice(1)].join(' ') || error.message} failed — fix the above, then run it again`,
  )
  process.exitCode = 1
}
