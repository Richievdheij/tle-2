{{--
    Menu item: one row of a dropdown or more-menu. Renders <a> with href, <button> otherwise.

    <x-menu-item :href="route('profile.edit')" icon="user">{{ __('My profile') }}</x-menu-item>
    <x-menu-item tone="danger" icon="log-out" type="submit">{{ __('Log out') }}</x-menu-item>

    Props: href, type: button|submit, icon, tone: default|danger, active (aria-current), placeholder (<a> without href), strong (bold label).
--}}
@props([
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'tone' => 'default',
    'active' => false,
    'placeholder' => false,
    'strong' => false,
])

@php
    $classes = ['menu-item', 'menu-item--'.$tone, 'menu-item--strong' => $strong, 'is-active' => $active];
@endphp

@if ($href || $placeholder)
    <a
        {{ $attributes->class($classes) }}
        @if ($href) href="{{ $href }}" @endif
        @if ($active) aria-current="page" @endif
    >
@else
    <button {{ $attributes->class($classes) }} type="{{ $type }}">
@endif
    @if ($icon)
        <x-icon class="menu-item__icon" :name="$icon" />
    @endif
    <span class="menu-item__label">{{ $slot }}</span>
@if ($href || $placeholder)
    </a>
@else
    </button>
@endif
