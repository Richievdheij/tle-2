{{--
    Table date cell: a date block on a vertical timeline that joins the rows of one series.

    <x-table.date-cell position="first"><x-date-block :date="$event->starts_at" /></x-table.date-cell>

    Props: position: first|middle|last|single.
--}}
@props([
    'position' => 'single',
])

<td {{ $attributes->class(['table__cell', 'table__date-cell', 'table__date-cell--'.$position]) }}>
    <div class="table__cell-content">
        {{ $slot }}
    </div>
</td>
