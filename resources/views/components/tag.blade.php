{{--
    Tag: a status label on a light tint with a coloured bar.

    <x-tag tone="success" icon="check">{{ __('Active') }}</x-tag>

    Props: tone: neutral|info|success|warning|error|accent, icon.
--}}
@props([
    'tone' => 'neutral',
    'icon' => null,
])

<span {{ $attributes->class(['tag', 'tag--'.$tone]) }}>
    @if ($icon)
        <x-icon class="tag__icon" :name="$icon" size="14" />
    @endif
    <span class="tag__label">{{ $slot }}</span>
</span>
