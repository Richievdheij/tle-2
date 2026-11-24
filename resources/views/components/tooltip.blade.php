{{--
    Tooltip: a short aria-hidden label shown on hover and focus. Place it as a direct child of a position: relative host that carries the same text as aria-label.

    <x-tooltip>{{ __('Edit') }}</x-tooltip>

    Props: position: top|bottom. resources/js/components/tooltip.js lets Escape hide it.
--}}
@props([
    'position' => 'top',
])

<span {{ $attributes->class(['tooltip', 'tooltip--'.$position]) }} aria-hidden="true">{{ $slot }}</span>
