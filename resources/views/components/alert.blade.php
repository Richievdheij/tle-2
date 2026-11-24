{{--
    Alert: a tinted message with a title, text and a close button.

    <x-alert tone="success" :title="__('Change saved')">{{ __('Your monthly gift is now €15.00.') }}</x-alert>

    Props: tone: info|success|warning|error, title, dismissible (default true; closed by resources/js/app.js), variant: success|danger (legacy alias for tone).
    Role follows the tone (alert for error/warning, status otherwise) unless you pass role.
--}}
@props([
    'tone' => null,
    'variant' => null,
    'title' => null,
    'dismissible' => true,
])

@php
    $tone ??= match ($variant) {
        'danger' => 'error',
        null => 'info',
        default => $variant,
    };

    $role = $attributes->get('role', in_array($tone, ['error', 'warning'], true) ? 'alert' : 'status');
@endphp

<div {{ $attributes->except('role')->class(['alert', 'alert--'.$tone]) }} role="{{ $role }}">
    <div class="alert__body">
        @if ($title)
            <p class="alert__title">{{ $title }}</p>
        @endif

        <div class="alert__text">{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <div class="alert__action">
            <button class="alert__close" type="button" data-dismiss="alert">
                <x-icon name="close" />
                <span class="sr-only">{{ __('Dismiss') }}</span>
            </button>
        </div>
    @endif
</div>
