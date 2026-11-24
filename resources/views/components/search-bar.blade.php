{{--
    Search bar: a search icon that expands into a field on focus. Works without JS; resources/js/app.js moves focus out on close.

    <x-search-bar :action="route('search')" />

    Props: placeholder, open (always open), action (GET target), name (default q), value (defaults to request($name)), id (default "search"; unique per page).
--}}
@props([
    'placeholder' => null,
    'open' => false,
    'action' => null,
    'name' => 'q',
    'value' => null,
    'id' => 'search',
])

@php
    $value ??= request()->query($name);
@endphp

<form
    {{ $attributes->class(['search-bar', 'search-bar--open' => $open]) }}
    role="search"
    method="get"
    @if ($action) action="{{ $action }}" @endif
    data-search-bar
>
    <label class="search-bar__toggle" for="{{ $id }}">
        <x-icon class="search-bar__icon" name="search" />
        <span class="sr-only">{{ __('Search') }}</span>
    </label>

    <input
        class="search-bar__input"
        id="{{ $id }}"
        type="search"
        name="{{ $name }}"
        value="{{ is_string($value) ? $value : '' }}"
        placeholder="{{ $placeholder ?? __('Search projects and events') }}"
        autocomplete="off"
        enterkeyhint="search"
    >

    <button class="search-bar__close" type="reset" data-search-bar-close>
        <x-icon name="close" />
        <span class="sr-only">{{ __('Close search') }}</span>
    </button>
</form>
