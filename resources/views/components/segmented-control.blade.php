{{--
    Segmented control: switches between views of the same data.

    <x-segmented-control :label="__('View')">
        <x-segmented-control.segment :href="$participantsUrl" count="46" selected>{{ __('Participants') }}</x-segmented-control.segment>
        <x-segmented-control.segment :href="$donationsUrl" count="31">{{ __('Donations') }}</x-segmented-control.segment>
    </x-segmented-control>

    Props: label (required; group name for screen readers).
--}}
@props([
    'label',
])

<nav {{ $attributes->class('segmented-control') }} aria-label="{{ $label }}">
    <ul class="segmented-control__list" role="list">
        {{ $slot }}
    </ul>
</nav>
