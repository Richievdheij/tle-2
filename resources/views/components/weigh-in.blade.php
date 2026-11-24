{{--
    Weigh-in: the source line below an impact figure (who weighed it, role, reference date).

    <x-weigh-in name="Lisa de Vries" :role="__('Organizer')" date="7 Nov 2026" />

    Props: name (required), date (required), role (default "Organizer").
--}}
@props([
    'name',
    'role' => null,
    'date',
])

<p {{ $attributes->class('weigh-in') }}>
    <x-avatar :name="$name" size="xs" tone="primary" />

    <span class="weigh-in__by">
        {{ __('Weighed by') }} <strong class="weigh-in__name">{{ $name }}</strong>
    </span>

    <span class="weigh-in__divider" aria-hidden="true"></span>

    <span class="weigh-in__role">{{ $role ?? __('Organizer') }}</span>

    <span class="weigh-in__divider" aria-hidden="true"></span>

    <span class="weigh-in__date">
        <x-icon name="calendar" size="14" />
        {{ __('Reference date :date', ['date' => $date]) }}
    </span>
</p>
