// Escape hides visible tooltips until their host is left (WCAG 1.4.13).
export function initialiseTooltips() {
  const hosts = [...document.querySelectorAll('[data-tooltip-host]')]

  if (hosts.length === 0) {
    return
  }

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
      return
    }

    for (const host of hosts) {
      if (host.matches(':hover, :focus-visible')) {
        host.dataset.tooltipDismissed = ''
      }
    }
  })

  for (const host of hosts) {
    const reset = () => delete host.dataset.tooltipDismissed

    host.addEventListener('mouseleave', reset)
    host.addEventListener('blur', reset)
  }
}
