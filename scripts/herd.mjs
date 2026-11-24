/**
 * Lets Herd serve this folder, so the site is up at https://<folder>.test without
 * anything running in a terminal. `composer run setup` and `make install` run it;
 * `make herd` runs it alone.
 *
 * Herd serves a folder only when it is linked, or sits DIRECTLY inside a parked
 * directory. A clone at ~/Herd/development/<folder> is neither, and answers
 * "Site not found" — the commonest first-day surprise. This closes that gap with
 * `herd link --secure`, and is safe to repeat: a folder Herd already serves is
 * left exactly as it is.
 *
 * It never fails the install. Without Herd — Linux, WSL2, or a machine without
 * it — `composer run dev` serves the site through `php artisan serve` instead,
 * and that is a supported setup rather than an error. Herd on Windows works the
 * same as on macOS.
 *
 * It refuses to link over a site name another folder already uses: `herd link`
 * would silently repoint it and take that project's site away.
 */

import { execFileSync } from 'node:child_process'
import { pass, warn } from './lib/check.mjs'
import { herdSiteName, site } from './lib/site.mjs'

const HINT = "README.md, 'Opening the site'"

/** On Windows `herd` is a .bat shim, which only a shell can run. */
const shell = process.platform === 'win32'
const name = herdSiteName()
const before = site()

const hasHerdCli = () => {
  try {
    execFileSync('herd', ['--version'], { stdio: 'ignore', shell })
    return true
  } catch {
    return false
  }
}

if (before === null) {
  warn('herd', HINT, () => console.error("  Cannot ask Herd yet: run 'composer install' first."))
} else if (before.servedBy === 'herd') {
  pass('herd', `serves this folder at ${before.url}`)
} else if (!before.herdInstalled) {
  pass('herd', `not installed — 'composer run dev' serves the site at ${before.url}`)
} else if (before.nameServes !== null) {
  warn('herd', HINT, () => {
    console.error(`  The site name '${name}' is already taken by ${before.nameServes}.`)
    console.error('  Linking over it would take that site away, so this folder is not linked.')
    console.error(`  Pick another name, from this folder:  herd link --secure <other-name>`)
  })
} else if (!hasHerdCli()) {
  warn('herd', HINT, () => {
    console.error("  Herd is installed but its 'herd' command is not on PATH.")
    console.error(`  Open Herd once, or run from this folder:  herd link --secure ${name}`)
  })
} else {
  try {
    execFileSync('herd', ['link', '--secure', '--no-interaction', name], {
      stdio: 'inherit',
      shell,
    })
  } catch {
    // Reported below: the second look at Herd's configuration is the verdict,
    // not the exit status of a CLI whose output we do not control.
  }

  const after = site()
  if (after?.servedBy === 'herd') {
    pass('herd', `linked — serves this folder at ${after.url}`)
  } else {
    warn('herd', HINT, () => {
      console.error(`  'herd link --secure ${name}' did not make Herd serve this folder.`)
      console.error("  Until it does, 'composer run dev' serves the site at http://localhost:8000.")
    })
  }
}
