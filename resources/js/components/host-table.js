// Host table selection: shows the selection bar, updates its count and marks rows aria-selected.
export function initialiseHostTables() {
  for (const table of document.querySelectorAll('[data-host-table]')) {
    const checkboxes = () => [...table.querySelectorAll('[data-host-table-select]')]
    const selectAll = table.querySelector('[data-host-table-select-all]')
    const bar = table.querySelector('[data-host-table-selection]')
    const count = table.querySelector('[data-host-table-count]')
    const template = bar?.dataset.template ?? ':count'

    const update = () => {
      const boxes = checkboxes()
      const selected = boxes.filter((box) => box.checked).length

      for (const box of boxes) {
        box.closest('tr, [role="row"]')?.setAttribute('aria-selected', String(box.checked))
      }

      if (selectAll) {
        selectAll.checked = selected > 0 && selected === boxes.length
        selectAll.indeterminate = selected > 0 && selected < boxes.length
      }

      if (bar) {
        bar.hidden = selected === 0
      }

      if (count) {
        count.textContent = template.replace(':count', String(selected))
      }
    }

    table.addEventListener('change', (event) => {
      if (event.target === selectAll) {
        for (const box of checkboxes()) {
          box.checked = selectAll.checked
        }
      }

      update()
    })

    table.querySelector('[data-host-table-clear]')?.addEventListener('click', () => {
      for (const box of checkboxes()) {
        box.checked = false
      }

      update()
    })

    update()
  }
}
