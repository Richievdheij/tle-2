import { execFileSync } from 'node:child_process'
import { existsSync } from 'node:fs'

/** Run git and return trimmed stdout, or '' when the command fails. */
export function git(args) {
  try {
    return execFileSync('git', args, {
      encoding: 'utf8',
      stdio: ['ignore', 'pipe', 'ignore'],
    }).trim()
  } catch {
    return ''
  }
}

/**
 * Every file git knows about or would add: tracked files plus new files that are
 * not gitignored, minus files deleted in the working tree. So the checks see the
 * tree as the next commit will, and vendor/, node_modules/ and anything
 * gitignored are excluded by construction.
 */
export const trackedFiles = () => [
  ...new Set(
    git(['ls-files', '--cached', '--others', '--exclude-standard'])
      .split('\n')
      .filter((file) => file !== '' && existsSync(file)),
  ),
]

/** Tracked files whose path ends with one of `extensions`. */
export const trackedWithExtension = (...extensions) =>
  trackedFiles().filter((file) => extensions.some((extension) => file.endsWith(extension)))

/** Tracked files under any of `directories`. */
export const trackedUnder = (...directories) =>
  trackedFiles().filter((file) =>
    directories.some((directory) => file === directory || file.startsWith(`${directory}/`)),
  )
