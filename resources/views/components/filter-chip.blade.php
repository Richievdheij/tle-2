{{--
    Filter chip: a link with href (active gets aria-current), otherwise a toggle <button> with aria-pressed.

    <x-filter-chip :href="$url" count="38" active>{{ __('Present') }}</x-filter-chip>

    Props: href, count (null hides it), active, type: button|submit.
--}}
@props([
    'href' => null,
    'count' => null,
    'active' => false,
    'type' => 'button',
])

@php
    $classes = ['filter-chip', 'is-active' => $active];
@endphp

@if ($href)
    <a {{ $attributes->class($classes) }} href="{{ $href }}" @if ($active) aria-current="true" @endif>
@else
    <button {{ $attributes->class($classes) }} type="{{ $type }}" aria-pressed="{{ $active ? 'true' : 'false' }}">
@endif
    <span class="filter-chip__label">{{ $slot }}</span>
    @if ($count !== null)
        <span class="filter-chip__count">{{ $count }}</span>
    @endif
@if ($href)
    </a>
@else
    </button>
@endif
