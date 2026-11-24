{{--
    Table row: <x-table.row>…cells…</x-table.row>, or <x-table.row header> for the header row (no hover).

    Props: header.
--}}
@props([
    'header' => false,
])

<tr {{ $attributes->class(['table__row', 'table__row--header' => $header]) }}>
    {{ $slot }}
</tr>
