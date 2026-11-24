{{--
    Arrow link: a text link with a cyan arrow circle. Always navigates; for an action use <x-button>.

    <x-arrow-link :href="route('projects.index')">{{ __('View all projects') }}</x-arrow-link>

    Props: href (without it renders a non-clickable placeholder).
--}}
@props([
    'href' => null,
])

<a {{ $attributes->class('arrow-link') }} @if ($href) href="{{ $href }}" @endif>
    <span class="arrow-link__circle" aria-hidden="true">
        <x-icon name="arrow-right" />
    </span>
    <span class="arrow-link__label">{{ $slot }}</span>
</a>
