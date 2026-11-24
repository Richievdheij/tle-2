{{--
    Skeleton: one decorative grey loading shape. Mark the loading region with aria-busy and say "Loading" once.

    <x-skeleton shape="text" style="inline-size: 12rem" />

    Props: shape: text|heading|tag|circle|button|image.
--}}
@props([
    'shape' => 'text',
])

<span {{ $attributes->class(['skeleton', 'skeleton--'.$shape]) }} aria-hidden="true"></span>
