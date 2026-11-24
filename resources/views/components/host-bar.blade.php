{{--
    Host bar: a dark band below the navbar on pages the host manages, with a link to the public page.

    <x-host-bar :href="route('events.show', $event)" />

    Props: title, note (null hides it), link (link label), href (null hides the link).
--}}
@props([
    'title' => null,
    'note' => false,
    'link' => null,
    'href' => null,
])

@php
    $note = $note === false ? __('Only you as the host can see this page.') : $note;
@endphp

<div {{ $attributes->class('host-bar') }} role="region" aria-label="{{ $title ?? __('You are managing this event') }}">
    <div class="container host-bar__inner">
        <p class="host-bar__notification">
            <strong class="host-bar__title">{{ $title ?? __('You are managing this event') }}</strong>
            @if ($note)
                <span class="host-bar__note">{{ $note }}</span>
            @endif
        </p>

        @if ($href)
            <x-footer-link class="host-bar__link" :href="$href">{{ $link ?? __('View public page') }}</x-footer-link>
        @endif
    </div>
</div>
