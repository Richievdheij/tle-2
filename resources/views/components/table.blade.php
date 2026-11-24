{{--
    Table: a real <table> that scrolls sideways on narrow screens. Parts: <x-table.row>, <x-table.cell>, <x-table.column-header>, <x-table.date-cell>, <x-host-row>.

    <x-table :caption="__('Upcoming events')">
        <x-slot:head>
            <x-table.row header>
                <x-table.column-header>{{ __('Event') }}</x-table.column-header>
                <x-table.column-header width="13.75rem" sorting="ascending" :href="…">{{ __('Date') }}</x-table.column-header>
            </x-table.row>
        </x-slot:head>
        <x-table.row>
            <x-table.cell type="event" :text="$event->title" :subtext="$event->location" />
            <x-table.cell :text="$event->date" />
        </x-table.row>
    </x-table>

    Props: caption (sr-only unless showCaption), showCaption, $head slot (rendered in <thead>).
--}}
@props([
    'caption' => null,
    'showCaption' => false,
])

<div {{ $attributes->class('table') }}>
    <table class="table__table">
        @if ($caption)
            <caption @class(['table__caption', 'sr-only' => ! $showCaption])>{{ $caption }}</caption>
        @endif

        @isset($head)
            <thead class="table__head">{{ $head }}</thead>
        @endisset

        <tbody class="table__body">{{ $slot }}</tbody>
    </table>
</div>
