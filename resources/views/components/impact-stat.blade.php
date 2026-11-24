{{--
    Impact stat: overline, a large figure, what it means and its source. Always give the unit, source and reference date.

    <x-impact-stat :overline="__('Your impact')" value="128 kg" :description="__('…')" :source="__('Source: The Ocean Cleanup - reference date 1 Nov 2026')" />

    Props: value (required), theme: light|dark, overline, description, source, tag: div|li.
--}}
@props([
    'theme' => 'light',
    'overline' => null,
    'value',
    'description' => null,
    'source' => null,
    'tag' => 'div',
])

<{{ $tag }} {{ $attributes->class(['impact-stat', 'impact-stat--'.$theme]) }}>
    @if ($overline)
        <p class="impact-stat__overline">{{ $overline }}</p>
    @endif

    <p class="impact-stat__value">{{ $value }}</p>

    @if ($description)
        <p class="impact-stat__description">{{ $description }}</p>
    @endif

    @if ($source)
        <p class="impact-stat__source">{{ $source }}</p>
    @endif
</{{ $tag }}>
