{{--
    Participants: the participant count with "Registration open" or "Full" below it.

    <x-participants :count="40" full />

    Props: count (required; an int is pluralised, a string shown as is), full.
--}}
@props([
    'count',
    'full' => false,
])

<div {{ $attributes->class(['participants', 'participants--full' => $full]) }}>
    <p class="participants__count">
        {{ is_int($count) ? trans_choice(':count participant|:count participants', $count) : $count }}
    </p>
    <p class="participants__status">
        {{ $full ? __('Full, registration closed') : __('Registration open') }}
    </p>
</div>
