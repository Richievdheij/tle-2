{{--
    User menu: the signed-in user's avatar in a <details> that opens an <x-dropdown-menu>. resources/js/app.js adds Escape and click-outside.

    <x-user-menu :user="auth()->user()">
        <x-menu-item :href="route('profile.edit')" icon="user">{{ __('My profile') }}</x-menu-item>
        <x-slot:footer>…log out…</x-slot:footer>
    </x-user-menu>

    Props: user (required), open, $footer slot.
--}}
@props([
    'user',
    'open' => false,
])

<details {{ $attributes->class('user-menu') }} data-disclosure @if ($open) open @endif>
    <summary class="user-menu__trigger">
        <span class="sr-only">{{ __('Account menu') }}</span>
        <x-avatar :name="$user->name" size="md" />
        <x-icon class="user-menu__chevron" name="chevron-down" />
    </summary>

    <x-dropdown-menu class="user-menu__panel" :name="$user->name" :email="$user->email">
        {{ $slot }}

        @isset($footer)
            <x-slot:footer>{{ $footer }}</x-slot:footer>
        @endisset
    </x-dropdown-menu>
</details>
