// A click anywhere on a host row toggles its checkbox, except on controls inside it.
export function initialiseHostRows() {
  for (const row of document.querySelectorAll('[data-host-row]')) {
    const checkbox = row.querySelector('[data-host-row-select]')

    if (!(checkbox instanceof HTMLInputElement)) {
      continue
    }

    row.dataset.hostRowReady = ''

    row.addEventListener('click', (event) => {
      const interactive = event.target.closest(
        'a, button, input, select, textarea, label, summary, details',
      )

      if (interactive && row.contains(interactive)) {
        return
      }

      checkbox.click()
    })
  }
}
