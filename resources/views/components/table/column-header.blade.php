{{--
    Column header: a <th>, optionally a sort link. Sorting is server-side: href is the URL of the next order (none → ascending → descending → none).

    <x-table.column-header sorting="ascending" :href="route('events.index', ['sort' => 'date', 'direction' => 'desc'])">{{ __('Date') }}</x-table.column-header>

    Props: sorting: none|ascending|descending, href (absent = not sortable), width.
--}}
@props([
    'sorting' => 'none',
    'href' => null,
    'width' => null,
])

@php
    $icon = match ($sorting) {
        'ascending' => 'arrow-up',
        'descending' => 'arrow-down',
        default => 'sort',
    };
@endphp

<th
    {{ $attributes->class(['table__cell', 'table__cell--header', 'table__column-header', 'is-sorted' => $sorting !== 'none']) }}
    scope="col"
    @if ($href && $sorting !== 'none') aria-sort="{{ $sorting }}" @endif
    @if ($width) style="inline-size: {{ $width }}" @endif
>
    <div class="table__cell-content">
        @if ($href)
            <a class="table__sort" href="{{ $href }}">
                <span>{{ $slot }}</span>
                <x-icon class="table__sort-icon" :name="$icon" />
            </a>
        @else
            <span>{{ $slot }}</span>
        @endif
    </div>
</th>
