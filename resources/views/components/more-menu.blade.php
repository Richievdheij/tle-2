{{--
    More menu: a three-dots <details> that opens an <x-dropdown-menu>. resources/js/app.js adds Escape and click-outside.

    <x-more-menu>
        <x-menu-item icon="download">{{ __('Export') }}</x-menu-item>
        <x-slot:footer><x-menu-item tone="danger" icon="trash" command="show-modal" commandfor="delete-event">{{ __('Delete') }}</x-menu-item></x-slot:footer>
    </x-more-menu>

    Props: open, label (default "More actions"), align: end|start, $footer slot.
--}}
@props([
    'open' => false,
    'label' => null,
    'align' => 'end',
])

<details {{ $attributes->class(['more-menu', 'more-menu--start' => $align === 'start']) }} data-disclosure @if ($open) open @endif>
    <summary class="more-menu__trigger">
        <x-icon name="more" />
        <span class="sr-only">{{ $label ?? __('More actions') }}</span>
    </summary>

    <x-dropdown-menu class="more-menu__panel">
        {{ $slot }}

        @isset($footer)
            <x-slot:footer>{{ $footer }}</x-slot:footer>
        @endisset
    </x-dropdown-menu>
</details>
