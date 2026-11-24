{{--
    Event card: photo, tag, title, date, location and a "View event" cue. The whole card is one link (the title).

    <x-event-card :href="route('events.show', $event)" :title="$event->title" :date="$date" :location="$event->location" :image="$event->photo_url" :alt="$event->photo_alt" :tag="__('Cleanup')" />

    Props: title (required), href (required), date, location, image, alt (required with image), tag, tagTone (default info), linkLabel, level (default 3).
--}}
@props([
    'title',
    'href',
    'date' => null,
    'location' => null,
    'image' => null,
    'alt' => null,
    'tag' => null,
    'tagTone' => 'info',
    'linkLabel' => null,
    'level' => 3,
])

@php
    if ($image && $alt === null) {
        throw new InvalidArgumentException('<x-event-card> needs `alt` text for its image.');
    }
@endphp

<article {{ $attributes->class('event-card') }}>
    <div class="event-card__media">
        @if ($image)
            <img class="event-card__photo" src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
        @endif
    </div>

    <div class="event-card__content">
        @if ($tag)
            <span class="event-card__tag"><x-tag :tone="$tagTone">{{ $tag }}</x-tag></span>
        @endif

        <h{{ $level }} class="event-card__title">
            <a class="event-card__link" href="{{ $href }}">{{ $title }}</a>
        </h{{ $level }}>

        @if ($date)
            <p class="event-card__meta">
                <x-icon name="calendar" />
                <span>{{ $date }}</span>
            </p>
        @endif

        @if ($location)
            <p class="event-card__meta">
                <x-icon name="map-pin" />
                <span>{{ $location }}</span>
            </p>
        @endif

        <span class="event-card__cta" aria-hidden="true">
            <span class="event-card__circle"><x-icon name="arrow-right" /></span>
            <span class="event-card__cta-label">{{ $linkLabel ?? __('View event') }}</span>
        </span>
    </div>
</article>
