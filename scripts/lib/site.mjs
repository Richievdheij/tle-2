/**
 * Where the site can be opened, as a URL.
 *
 * Herd's layout is read by App\Support\Herd and nowhere else, so this asks that
 * class rather than re-reading Herd's configuration in a second language. It loads
 * the Composer autoloader and that one class — never the application — so it
 * keeps `make status` independent of a bootable app.
 *
 * Returns null only when the question cannot be asked: no vendor/ yet, or no PHP.
 */

import { execFileSync } from 'node:child_process'
import { existsSync } from 'node:fs'
import { basename } from 'node:path'
import { homedir } from 'node:os'
import { projectPorts } from './ports.mjs'

const ASK_HERD = `
require 'vendor/autoload.php';
$herd = App\\Support\\Herd::forHome($argv[1]);
echo json_encode([
  'url' => $herd->siteUrl(getcwd()),
  'installed' => $herd->isInstalled(),
  'nameServes' => $herd->directoryServedAs($argv[2]),
]);
`

/**
 * The PHP to run. Under `composer run`, Composer names the binary it runs on in
 * PHP_BINARY — the real executable, where `php` on Windows may be a .bat shim
 * that execFileSync cannot start.
 */
export const php = process.env.PHP_BINARY || 'php'

/**
 * The site name `herd link` gives this folder: its name, in lower case.
 */
export const herdSiteName = () => basename(process.cwd()).toLowerCase()

/**
 * `nameServes` is the directory Herd already serves under `herdSiteName()`, or
 * null when that name is free — linking over it would take that site away.
 *
 * @returns {{ url: string, servedBy: 'herd' | 'artisan serve', herdInstalled: boolean, nameServes: string | null } | null}
 */
export function site(envFile = '.env') {
  if (!existsSync('vendor/autoload.php')) return null

  let answer
  try {
    answer = JSON.parse(
      execFileSync(php, ['-r', ASK_HERD, '--', process.env.HOME || homedir(), herdSiteName()], {
        encoding: 'utf8',
        stdio: ['ignore', 'pipe', 'ignore'],
      }),
    )
  } catch {
    return null
  }

  if (typeof answer.url === 'string') {
    return { url: answer.url, servedBy: 'herd', herdInstalled: true, nameServes: answer.nameServes }
  }

  const app = projectPorts(envFile).find((p) => p.name === 'app')
  return {
    url: `http://localhost:${app.port}`,
    servedBy: 'artisan serve',
    herdInstalled: answer.installed === true,
    nameServes: typeof answer.nameServes === 'string' ? answer.nameServes : null,
  }
}
