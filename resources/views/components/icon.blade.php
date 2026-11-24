{{--
    Icon: a line icon in currentColor. Decorative unless you pass label (needed when no text sits next to it).

    <x-icon name="search" size="24" :label="__('Search')" />

    Props: name (required): arrow-right|arrow-left|check|close|download|search|chevron-down|user|log-out|calendar|map-pin|menu|spinner|share|clock|edit|trash|plus|more|mail|filter|sort|arrow-up|arrow-down|chart-bars|chart-line, size: 16|24, label.
--}}
@props([
    'name',
    'size' => 16,
    'label' => null,
])

@php
    $maskId = 'icon-mask-'.str()->random(8);
@endphp

<svg
    {{ $attributes->class(['icon', 'icon--24' => (int) $size === 24, 'icon--spinner' => $name === 'spinner']) }}
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 16 16"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    focusable="false"
    @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif
>
@switch($name)
    @case('arrow-right')
        <path d="M1 8H15M9 14L15 8L9 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('arrow-left')
        <path d="M13 8H3M7.5 12.5L3 8L7.5 3.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('check')
        <path d="M2 8.5L6 12.5L14 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('close')
        <path d="M3 3L13 13M13 3L3 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('download')
        <path d="M8 1V11M12.5 6.5L8 11L3.5 6.5M2 15H14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('search')
        <path d="M10.5 10.5L14 14M11.5 7C11.5 9.48528 9.48528 11.5 7 11.5C4.51472 11.5 2.5 9.48528 2.5 7C2.5 4.51472 4.51472 2.5 7 2.5C9.48528 2.5 11.5 4.51472 11.5 7Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('chevron-down')
        <path d="M3.5 6L8 10.5L12.5 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('user')
        <path d="M2.5 14.5C3.2 11.8 5.4 10.5 8 10.5C10.6 10.5 12.8 11.8 13.5 14.5M11 5.5C11 7.15685 9.65685 8.5 8 8.5C6.34315 8.5 5 7.15685 5 5.5C5 3.84315 6.34315 2.5 8 2.5C9.65685 2.5 11 3.84315 11 5.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('log-out')
        <path d="M6 2.5H3.5V13.5H6M7.5 8H14M11 11L14 8L11 5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('calendar')
        <path d="M2 7H14M5.5 1.5V4.5M10.5 1.5V4.5M3 3.5H13C13.5523 3.5 14 3.94772 14 4.5V13C14 13.5523 13.5523 14 13 14H3C2.44772 14 2 13.5523 2 13V4.5C2 3.94772 2.44772 3.5 3 3.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('map-pin')
        <mask id="{{ $maskId }}" fill="white">
        {{-- One even-odd path: the pin with the dot cut out, so the masked stroke stays inside the pin. --}}
        <path fill-rule="evenodd" d="M8 14.5C8 14.5 13 10.2 13 6.5C13 3.7 10.8 1.5 8 1.5C5.2 1.5 3 3.7 3 6.5C3 10.2 8 14.5 8 14.5ZM8 8.25C8.9665 8.25 9.75 7.4665 9.75 6.5C9.75 5.5335 8.9665 4.75 8 4.75C7.0335 4.75 6.25 5.5335 6.25 6.5C6.25 7.4665 7.0335 8.25 8 8.25Z"/>
        </mask>
        <path d="M8 14.5C8 14.5 13 10.2 13 6.5C13 3.7 10.8 1.5 8 1.5C5.2 1.5 3 3.7 3 6.5C3 10.2 8 14.5 8 14.5ZM8 8.25C8.9665 8.25 9.75 7.4665 9.75 6.5C9.75 5.5335 8.9665 4.75 8 4.75C7.0335 4.75 6.25 5.5335 6.25 6.5C6.25 7.4665 7.0335 8.25 8 8.25Z" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" mask="url(#{{ $maskId }})"/>
        @break
    @case('menu')
        <path d="M2 4H14M2 8H14M2 12H14" stroke-width="2" stroke-linecap="round" stroke="currentColor"/>
        @break
    @case('spinner')
        <path opacity="0.25" d="M14 8C14 11.3137 11.3137 14 8 14C4.68629 14 2 11.3137 2 8C2 4.68629 4.68629 2 8 2C11.3137 2 14 4.68629 14 8Z" stroke-width="2" stroke="currentColor"/>
        <path d="M8 2C9.5913 2 11.1174 2.63214 12.2426 3.75736C13.3679 4.88258 14 6.4087 14 8" stroke-width="2" stroke-linecap="round" stroke="currentColor"/>
        @break
    @case('share')
        <path d="M13.5 7V2.5H9M13.5 2.5L7.5 8.5M11.5 10V13.5H2.5V4.5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('clock')
        <path d="M8 4.75V8L10.25 9.5M14 8C14 11.3137 11.3137 14 8 14C4.68629 14 2 11.3137 2 8C2 4.68629 4.68629 2 8 2C11.3137 2 14 4.68629 14 8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('edit')
        <path d="M9 4L12 7M10.5 2.5L13.5 5.5L6 13H3V10L10.5 2.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('trash')
        <path d="M2.5 4.5H13.5M6 4.5V2.5H10V4.5M4 4.5L4.75 13.5H11.25L12 4.5M6.75 7V11M9.25 7V11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('plus')
        <path d="M8 3V13M3 8H13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('more')
        <path d="M3 8H3.01M8 8H8.01M13 8H13.01" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('mail')
        <path d="M2.5 4L8 8.5L13.5 4M2.5 3.5H13.5V12.5H2.5V3.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('filter')
        <path d="M2.5 4H13.5M4.5 8H11.5M6.5 12H9.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('sort')
        <path d="M5 3V13M7.5 5.5L5 3L2.5 5.5M11 13V3M13.5 10.5L11 13L8.5 10.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('arrow-up')
        <path d="M8 13V3M12 7L8 3L4 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('arrow-down')
        <path d="M8 3V13M12 9L8 13L4 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('chart-bars')
        <path d="M3 13V8M8 13V3M13 13V6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @case('chart-line')
        <path d="M2 12L6 7L9 10L14 3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"/>
        @break
    @default
        @php
            throw new InvalidArgumentException("Unknown icon [{$name}]. See resources/views/components/icon.blade.php for the set.");
        @endphp
@endswitch
</svg>
