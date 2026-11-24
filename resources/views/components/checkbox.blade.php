{{--
    Checkbox: a real <input type="checkbox"> with a styled box and label.

    <x-checkbox name="remember" :label="__('Remember me')" checked />

    Props: name (required), label (required), hideLabel (sr-only), checked (old($name) wins after a failed submit), value (default "1"), id (defaults to name).
    Other attributes (disabled, required, form, aria-*) land on the <input>.
--}}
@props([
    'name',
    'label',
    'hideLabel' => false,
    'checked' => false,
    'value' => '1',
    'id' => null,
])

@php
    $id ??= $name;
    $isChecked = old() === [] ? $checked : (bool) old($name);
@endphp

<div class="checkbox">
    <span class="checkbox__box">
        <input
            {{ $attributes->class('checkbox__control') }}
            id="{{ $id }}"
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($isChecked)
        >
        <x-icon class="checkbox__check" name="check" size="14" />
    </span>

    <label @class(['checkbox__label', 'sr-only' => $hideLabel]) for="{{ $id }}">{{ $label }}</label>
</div>
