{{--
    Logo: the mark plus the product name, linking home.

    <x-logo />
    <x-logo theme="dark" />

    Props: theme: light|dark, name (defaults to config('app.name')), href (defaults to route('home'); false renders no link).
--}}
@props([
    'theme' => 'light',
    'name' => null,
    'href' => null,
])

@php
    $name ??= config('app.name');
    $href = $href === false ? null : ($href ?? route('home'));
    $tag = $href ? 'a' : 'span';
@endphp

<{{ $tag }}
    {{ $attributes->class(['logo', 'logo--'.$theme]) }}
    @if ($href) href="{{ $href }}" @endif
>
    <span class="logo__mark" aria-hidden="true">
        <svg class="logo__glyph" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
            <path d="M9 22C12 18 15 18 18 22C21 26 24 26 27 22C29 19.5 30.5 19 31 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
        </svg>
    </span>
    <span class="logo__name">{{ $name }}</span>
</{{ $tag }}>
