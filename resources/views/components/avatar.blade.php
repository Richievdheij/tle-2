{{--
    Avatar: a circle with initials or a photo. Decorative unless you pass label.

    <x-avatar :name="$user->name" size="md" />

    Props: size: xs|sm|md|lg, tone: accent|primary|neutral|subtle, initials, name (derives initials: "Richie van der Heij" → "RH"), src, label.
--}}
@props([
    'size' => 'md',
    'tone' => 'accent',
    'initials' => null,
    'name' => null,
    'src' => null,
    'label' => null,
])

@php
    if ($initials === null && $name !== null) {
        $words = preg_split('/\s+/', trim($name)) ?: [];
        $first = $words[0] ?? '';
        $last = count($words) > 1 ? end($words) : '';
        $initials = mb_strtoupper(mb_substr($first, 0, 1).mb_substr($last, 0, 1));
    }
@endphp

<span
    {{ $attributes->class(['avatar', 'avatar--'.$size, 'avatar--'.$tone => $tone !== 'accent']) }}
    @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif
>
    @if ($src)
        <img class="avatar__photo" src="{{ $src }}" alt="">
    @else
        <span class="avatar__initials">{{ $initials }}</span>
    @endif
</span>
