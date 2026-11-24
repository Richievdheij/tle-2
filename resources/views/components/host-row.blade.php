{{--
    Host row: a table row with a selection checkbox in front. Use inside <x-table> instead of <x-table.row>.

    <x-host-row :value="$participant->id" :label="__('Select :name', ['name' => $participant->name])">
        <x-table.cell type="person" :text="$participant->name" :subtext="$participant->email" />
    </x-host-row>

    Props: value (required), label (required; checkbox name for screen readers), selected, name (default "selected[]"), id.
    Needs resources/js/components/host-row.js for click-anywhere selection.
--}}
@props([
    'value',
    'label',
    'selected' => false,
    'name' => 'selected[]',
    'id' => null,
])

@php
    $id ??= 'host-row-'.preg_replace('/[^A-Za-z0-9_-]/', '', $name).'-'.$value;
@endphp

<tr {{ $attributes->class('host-row') }} data-host-row>
    <x-table.cell class="host-row__select" type="select">
        <x-checkbox
            :name="$name"
            :value="$value"
            :id="$id"
            :label="$label"
            hide-label
            :checked="$selected"
            data-host-row-select
        />
    </x-table.cell>

    {{ $slot }}
</tr>
