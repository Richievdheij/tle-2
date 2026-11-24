{{--
    Modal: a native <dialog> for confirming an irreversible action. Open/close with invoker commands; resources/js/app.js adds a fallback and backdrop click.

    <x-button command="show-modal" commandfor="delete-event">{{ __('Delete') }}</x-button>
    <x-modal name="delete-event" :title="__('Delete event?')" :text="__('This cannot be undone.')">
        <x-slot:actions>
            <x-button variant="secondary" command="close" commandfor="delete-event">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" icon="trash" type="submit" form="delete-event-form">{{ __('Delete') }}</x-button>
        </x-slot:actions>
    </x-modal>

    Props: name (required; the dialog id), title, text, show (open on load, e.g. after a failed submit), $actions slot.
    A dialog holding a form puts the whole form in the slot, with its buttons in a .modal__actions div.
--}}
@props([
    'name',
    'show' => false,
    'title' => null,
    'text' => null,
])

<dialog
    {{ $attributes->class('modal') }}
    id="{{ $name }}"
    closedby="any"
    data-modal
    @if ($title) aria-labelledby="{{ $name }}-title" @endif
    @if ($text) aria-describedby="{{ $name }}-text" @endif
    @if ($show) open data-modal-show @endif
>
    <div class="modal__body">
        @if ($title)
            <h2 class="modal__title" id="{{ $name }}-title">{{ $title }}</h2>
        @endif

        @if ($text)
            <p class="modal__text" id="{{ $name }}-text">{{ $text }}</p>
        @endif

        {{ $slot }}

        @isset($actions)
            <div class="modal__actions">{{ $actions }}</div>
        @endisset
    </div>
</dialog>
