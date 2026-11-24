{{--
    Stat tile: a key figure for the host with a label and a note.

    <x-stat-tile :label="__('Registrations')" value="46" :note="__('8 cancelled or did not show up')" />

    Props: label (required), value (required), note.
--}}
@props([
    'label',
    'value',
    'note' => null,
])

<div {{ $attributes->class('stat-tile') }}>
    <p class="stat-tile__label">{{ $label }}</p>
    <p class="stat-tile__value">{{ $value }}</p>

    @if ($note)
        <p class="stat-tile__note">{{ $note }}</p>
    @endif
</div>
