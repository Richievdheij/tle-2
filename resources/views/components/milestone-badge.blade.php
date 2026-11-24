{{--
    Milestone badge: a medal with a title and an "Achieved :date" / "Still to achieve" line.

    <x-milestone-badge symbol="1st" :title="__('First gift')" achieved="12 Mar 2026" />

    Props: symbol (required, 1–2 characters), title (required), achieved (date string; null = not yet).
--}}
@props([
    'symbol',
    'title',
    'achieved' => null,
])

<div {{ $attributes->class(['milestone-badge', 'milestone-badge--achieved' => $achieved, 'milestone-badge--pending' => ! $achieved]) }}>
    <span class="milestone-badge__medal" aria-hidden="true">
        <span class="milestone-badge__symbol">{{ $symbol }}</span>
    </span>

    <p class="milestone-badge__title">{{ $title }}</p>

    <p class="milestone-badge__date">
        @if ($achieved)
            {{ __('Achieved :date', ['date' => $achieved]) }}
        @else
            {{ __('Still to achieve') }}
        @endif
    </p>
</div>
