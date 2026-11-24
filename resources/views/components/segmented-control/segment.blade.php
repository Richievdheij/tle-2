{{--
    Segment: one view in an <x-segmented-control>. A link with href (selected gets aria-current), otherwise a toggle <button>.

    <x-segmented-control.segment :href="$url" count="46" selected>{{ __('Participants') }}</x-segmented-control.segment>

    Props: href, count (null hides the badge), selected.
--}}
@props([
    'href' => null,
    'count' => null,
    'selected' => false,
])

@php
    $classes = ['segmented-control__segment', 'is-selected' => $selected];
@endphp

<li class="segmented-control__item">
    @if ($href)
        <a {{ $attributes->class($classes) }} href="{{ $href }}" @if ($selected) aria-current="true" @endif>
    @else
        <button {{ $attributes->class($classes) }} type="button" aria-pressed="{{ $selected ? 'true' : 'false' }}">
    @endif
        <span class="segmented-control__label">{{ $slot }}</span>
        @if ($count !== null)
            <span class="segmented-control__count">{{ $count }}</span>
        @endif
    @if ($href)
        </a>
    @else
        </button>
    @endif
</li>
