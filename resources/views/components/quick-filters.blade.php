{{--
    Quick filters: a row of filter chips above a table, with "Clear filters" when a non-first filter is active.

    <x-quick-filters :label="__('Filter participants')" :clear-href="$baseUrl" :filters="[
        ['label' => __('All'), 'count' => 46, 'href' => $baseUrl, 'active' => $status === null],
        ['label' => __('Present'), 'count' => 38, 'href' => $baseUrl.'?status=present', 'active' => $status === 'present'],
    ]" />

    Props: filters (required; list of ['label', 'count', 'href', 'active'], first is "All"), label (required; group name), clearHref (null hides the link).
--}}
@props([
    'filters',
    'label',
    'clearHref' => null,
])

@php
    $filters = array_values($filters);
    $isFiltered = collect($filters)->skip(1)->contains(fn (array $filter): bool => (bool) ($filter['active'] ?? false));
@endphp

<nav {{ $attributes->class('quick-filters') }} aria-label="{{ $label }}">
    <ul class="quick-filters__list" role="list">
        @foreach ($filters as $filter)
            <li>
                <x-filter-chip
                    :href="$filter['href'] ?? null"
                    :count="$filter['count'] ?? null"
                    :active="(bool) ($filter['active'] ?? false)"
                >{{ $filter['label'] }}</x-filter-chip>
            </li>
        @endforeach
    </ul>

    @if ($isFiltered && $clearHref)
        <a class="quick-filters__clear" href="{{ $clearHref }}">{{ __('Clear filters') }}</a>
    @endif
</nav>
