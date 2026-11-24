{{--
    Icon button: one icon with a tooltip; the label is also its aria-label. Renders <a> with href, <button> otherwise.

    <x-icon-button icon="edit" :label="__('Edit')" />
    <x-icon-button icon="trash" variant="danger" :label="__('Delete')" command="show-modal" commandfor="delete-event" />

    Props: icon (required), label (required), variant: ghost|secondary|danger, disabled, href, type: button|submit|reset, tooltip (default true).
--}}
@props([
    'icon',
    'label',
    'variant' => 'ghost',
    'disabled' => false,
    'href' => null,
    'type' => 'button',
    'tooltip' => true,
])

@php
    $classes = ['icon-button', 'icon-button--'.$variant];
@endphp

@if ($href)
    <a
        {{ $attributes->class($classes) }}
        @unless ($disabled) href="{{ $href }}" @endunless
        @if ($disabled) aria-disabled="true" role="link" @endif
        aria-label="{{ $label }}"
        data-tooltip-host
    >
@else
    <button
        {{ $attributes->class($classes) }}
        type="{{ $type }}"
        @if ($disabled) disabled @endif
        aria-label="{{ $label }}"
        data-tooltip-host
    >
@endif
    <x-icon class="icon-button__icon" :name="$icon" />

    @if ($tooltip)
        <x-tooltip>{{ $label }}</x-tooltip>
    @endif
@if ($href)
    </a>
@else
    </button>
@endif
