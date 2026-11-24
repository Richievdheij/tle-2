{{-- Flash messages from session('status') and session('error'). Breeze's keyed statuses below are shown by their own forms. --}}
@php
    $keyedStatuses = ['profile-updated', 'password-updated', 'verification-link-sent'];
@endphp

@if (session('status') && ! in_array(session('status'), $keyedStatuses, true))
    <x-alert tone="success" :title="__('Done')" role="status">
        {{ session('status') }}
    </x-alert>
@endif

@if (session('error'))
    <x-alert tone="error" :title="__('Something went wrong')" role="alert">
        {{ session('error') }}
    </x-alert>
@endif
