// Progressive enhancement only: every function improves markup that already works without it.

import { initialiseHostRows } from './components/host-row.js'
import { initialiseHostTables } from './components/host-table.js'
import { initialiseTooltips } from './components/tooltip.js'

// Dismiss a flash message.
function initialiseDismissibleAlerts() {
  for (const button of document.querySelectorAll('[data-dismiss="alert"]')) {
    button.addEventListener('click', () => {
      button.closest('.alert')?.remove()
    })
  }
}

// <details> menus: Escape or an outside click closes them.
function initialiseDisclosures() {
  const disclosures = [...document.querySelectorAll('[data-disclosure]')]

  if (disclosures.length === 0) {
    return
  }

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
      return
    }

    for (const disclosure of disclosures) {
      if (disclosure.open) {
        disclosure.open = false
        disclosure.querySelector('summary')?.focus()
      }
    }
  })

  document.addEventListener('click', (event) => {
    for (const disclosure of disclosures) {
      if (disclosure.open && !disclosure.contains(event.target)) {
        disclosure.open = false
      }
    }
  })
}

// The search bar closes on blur (:focus-within); reset and Escape move focus off it.
function initialiseSearchBars() {
  for (const bar of document.querySelectorAll('[data-search-bar]')) {
    const close = () => {
      if (bar.contains(document.activeElement)) {
        document.activeElement.blur()
      }
    }

    bar.addEventListener('reset', () => setTimeout(close))
    bar.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        bar.reset()
      }
    })
  }
}

// Modals: invoker-command fallback, and reopen a server-rendered open dialog as a real modal.
function initialiseModals() {
  const supportsInvokers = 'command' in HTMLButtonElement.prototype

  if (!supportsInvokers) {
    for (const button of document.querySelectorAll('button[commandfor]')) {
      button.addEventListener('click', () => {
        const dialog = document.getElementById(button.getAttribute('commandfor'))
        const command = button.getAttribute('command')

        if (!(dialog instanceof HTMLDialogElement)) {
          return
        }

        if (command === 'show-modal' && !dialog.open) {
          dialog.showModal()
        } else if (command === 'close') {
          dialog.close()
        }
      })
    }
  }

  for (const dialog of document.querySelectorAll('dialog[data-modal]')) {
    // A backdrop click targets the <dialog> itself, a content click a child.
    dialog.addEventListener('click', (event) => {
      if (event.target === dialog) {
        dialog.close()
      }
    })

    if (dialog.hasAttribute('data-modal-show')) {
      const opener = document.querySelector(`[commandfor="${dialog.id}"][command="show-modal"]`)

      dialog.close()
      dialog.showModal()
      dialog.addEventListener('close', () => opener?.focus(), { once: true })
    }
  }
}

// Fade out transient status messages ("Saved.") after two seconds.
function initialiseTransientMessages() {
  for (const message of document.querySelectorAll('[data-transient]')) {
    setTimeout(() => {
      message.dataset.transient = 'done'
      message.addEventListener('transitionend', () => (message.hidden = true), { once: true })
    }, 2000)
  }
}

document.addEventListener('DOMContentLoaded', () => {
  initialiseDismissibleAlerts()
  initialiseDisclosures()
  initialiseSearchBars()
  initialiseModals()
  initialiseTransientMessages()
  initialiseHostRows()
  initialiseHostTables()
  initialiseTooltips()
})
