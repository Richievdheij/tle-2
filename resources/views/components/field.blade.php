{{--
    Text field: label, input, and hint or validation error, with aria-invalid/aria-describedby wired up.

    <x-field name="email" type="email" :label="__('Email address')" :hint="__('We send your receipts here.')" required />

    Props: name (required), label (defaults to name), type (default text), value (old($name) wins), hint, error (defaults to the bag's error for name), id (defaults to name), bag (error bag, for validateWithBag).
    Other attributes (required, autocomplete, placeholder, disabled) land on the <input>.
--}}
@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'hint' => null,
    'error' => null,
    'id' => null,
    'bag' => 'default',
])

@php
    $id ??= $name;
    $fieldErrors = $errors->getBag($bag);
    $message = $error ?? ($fieldErrors->has($name) ? $fieldErrors->first($name) : null);
    $hasError = $message !== null;
    $describedBy = array_filter([
        $hint && ! $hasError ? $id.'-hint' : null,
        $hasError ? $id.'-error' : null,
    ]);
@endphp

<div @class(['field', 'field--invalid' => $hasError])>
    <label class="field__label" for="{{ $id }}">{{ $label ?? $name }}</label>

    <input
        {{ $attributes->class('field__control') }}
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if ($hasError) aria-invalid="true" @endif
        @if ($describedBy) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
    >

    @if ($hasError)
        <p class="field__error" id="{{ $id }}-error">{{ $message }}</p>
    @elseif ($hint)
        <p class="field__hint" id="{{ $id }}-hint">{{ $hint }}</p>
    @endif
</div>
