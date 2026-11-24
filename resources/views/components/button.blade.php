{{--
    Button: renders <a> with href, <button> otherwise. A link navigates, a button acts.

    <x-button variant="accent" arrow>{{ __('Donate now') }}</x-button>
    <x-button variant="danger" icon="trash" type="submit">{{ __('Delete') }}</x-button>
    <x-button :href="route('home')">{{ __('Back') }}</x-button>

    Props: variant: primary|accent|secondary|danger|ghost|link, href, type: button|submit|reset, icon, iconPosition: end|start, arrow, loading, disabled, block.
    One accent button per screen. Other attributes (form, command, commandfor, aria-*) land on the element.
--}}
@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'end',
    'arrow' => false,
    'loading' => false,
    'disabled' => false,
    'block' => false,
])

@php
    $classes = [
        'button',
        'button--'.$variant,
        'button--block' => $block,
        'button--icon-start' => $icon && $iconPosition === 'start',
        'is-loading' => $loading,
    ];

    $inert = $disabled || $loading;
@endphp

@if ($href)
    <a
        {{ $attributes->class($classes) }}
        @unless ($inert) href="{{ $href }}" @endunless
        @if ($inert) aria-disabled="true" role="link" @endif
        @if ($loading) aria-busy="true" @endif
    >
@else
    <button
        {{ $attributes->class($classes) }}
        type="{{ $type }}"
        @if ($inert) disabled @endif
        @if ($loading) aria-busy="true" @endif
    >
@endif
    <span class="button__label">{{ $slot }}</span>

    @if ($loading)
        <x-icon class="button__icon" name="spinner" />
    @elseif ($icon)
        <x-icon class="button__icon" :name="$icon" />
    @endif

    @if ($arrow && ! $loading)
        <x-icon class="button__arrow" name="arrow-right" />
    @endif
@if ($href)
    </a>
@else
    </button>
@endif
