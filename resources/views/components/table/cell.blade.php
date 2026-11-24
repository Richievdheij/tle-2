{{--
    Table cell: one column of a table row; the type sets layout and alignment.

    <x-table.cell type="two-line" text="Sat 31 October 2026" subtext="10:12" />
    <x-table.cell type="person" :text="$user->name" :subtext="$user->email" />
    <x-table.cell type="tag"><x-tag tone="success">{{ __('Present') }}</x-tag></x-table.cell>

    Props: type: text|header|two-line|data|tag|action|capacity|event|menu|select|person|export, text, subtext, width (CSS length; leave one column without), avatar (person photo URL), align: start|center|end.
--}}
@props([
    'type' => 'text',
    'text' => null,
    'subtext' => null,
    'width' => null,
    'avatar' => null,
    'align' => null,
])

@php
    $tag = $type === 'header' ? 'th' : 'td';
@endphp

<{{ $tag }}
    {{ $attributes->class(['table__cell', 'table__cell--'.$type, 'table__cell--align-'.$align => $align]) }}
    @if ($type === 'header') scope="col" @endif
    @if ($width) style="inline-size: {{ $width }}" @endif
>
    <div class="table__cell-content">
        @switch($type)
            @case('two-line')
                <span class="table__text">{{ $text ?? $slot }}</span>
                @if ($subtext)
                    <span class="table__subtext">{{ $subtext }}</span>
                @endif
                @break

            @case('person')
                <x-avatar :name="$text" :src="$avatar" size="sm" />
                <span class="table__person">
                    <span class="table__text">{{ $text }}</span>
                    @if ($subtext)
                        <span class="table__subtext">{{ $subtext }}</span>
                    @endif
                </span>
                @break

            @case('event')
                <span class="table__text">{{ $text }}</span>
                <span class="table__event-meta">
                    @if ($subtext)
                        <span class="table__subtext">{{ $subtext }}</span>
                    @endif
                    @if ($subtext && $slot->isNotEmpty())
                        <span class="table__divider" aria-hidden="true"></span>
                    @endif
                    {{ $slot }}
                </span>
                @break

            @default
                @if ($text !== null)
                    <span class="table__text">{{ $text }}</span>
                @else
                    {{ $slot }}
                @endif
        @endswitch
    </div>
</{{ $tag }}>
