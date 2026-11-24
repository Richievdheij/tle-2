{{--
    Host table: toolbar (search, view switch), quick filters, selection bar, the table and pagination.

    <x-host-table :selected-text="__(':count participants selected')">
        <x-slot:views><x-segmented-control …>…</x-segmented-control></x-slot:views>
        <x-slot:filters><x-quick-filters …>…</x-quick-filters></x-slot:filters>
        <x-table>…</x-table>
        <x-slot:pagination><x-pagination … /></x-slot:pagination>
    </x-host-table>

    Props: selected (count on load), selectedText (with :count), search (default true), searchPlaceholder, searchName (default q), searchValue, action. Slots: $views, $filters, $actions, $selectionActions, $pagination.
    Row checkboxes need data-host-table-select (select-all: data-host-table-select-all); resources/js/components/host-table.js drives the selection bar.
--}}
@props([
    'selected' => 0,
    'selectedText' => null,
    'search' => true,
    'searchPlaceholder' => null,
    'searchName' => 'q',
    'searchValue' => null,
    'action' => null,
])

@php
    $selectedText ??= __(':count rows selected');
    $searchValue ??= request()->query($searchName);
    $searchId = 'host-table-search-'.str()->random(6);
@endphp

<div {{ $attributes->class('host-table') }} data-host-table>
    @if ($search || isset($views) || isset($actions))
        <div class="host-table__toolbar">
            <div class="host-table__controls">
                @if ($search)
                    <form class="host-table__search" role="search" method="get" @if ($action) action="{{ $action }}" @endif>
                        <label class="host-table__search-label" for="{{ $searchId }}">
                            <x-icon name="search" />
                            <span class="sr-only">{{ __('Search') }}</span>
                        </label>
                        <input
                            class="host-table__search-input"
                            id="{{ $searchId }}"
                            type="search"
                            name="{{ $searchName }}"
                            value="{{ is_string($searchValue) ? $searchValue : '' }}"
                            placeholder="{{ $searchPlaceholder ?? __('Search by name or email') }}"
                            autocomplete="off"
                        >
                    </form>
                @endif

                {{ $views ?? '' }}
            </div>

            @isset($actions)
                <div class="host-table__actions">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    @isset($filters)
        <div class="host-table__filters">{{ $filters }}</div>
    @endisset

    <div class="host-table__list">
        <div
            class="host-table__selection"
            role="status"
            data-host-table-selection
            data-template="{{ $selectedText }}"
            @if ($selected < 1) hidden @endif
        >
            <p class="host-table__selection-text" data-host-table-count>{{ str_replace(':count', (string) $selected, $selectedText) }}</p>

            <div class="host-table__selection-actions">
                @isset($selectionActions)
                    {{ $selectionActions }}
                @else
                    <x-button variant="secondary" icon="close" data-host-table-clear>{{ __('Clear selection') }}</x-button>
                    <x-button variant="primary" icon="download">{{ __('Export selection') }}</x-button>
                @endisset
            </div>
        </div>

        <div class="host-table__surface">
            {{ $slot }}
        </div>

        @isset($pagination)
            <div class="host-table__pagination">{{ $pagination }}</div>
        @endisset
    </div>
</div>
