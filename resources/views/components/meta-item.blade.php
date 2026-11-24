{{--
    Meta item: one detail (date, time, location) with a decorative icon.

    <x-meta-item icon="map-pin">Strandweg, Hoek van Holland</x-meta-item>

    Props: icon (default calendar), tag: div|li.
--}}
@props([
    'icon' => 'calendar',
    'tag' => 'div',
])

<{{ $tag }} {{ $attributes->class('meta-item') }}>
    <x-icon class="meta-item__icon" :name="$icon" />
    <span class="meta-item__text">{{ $slot }}</span>
</{{ $tag }}>
