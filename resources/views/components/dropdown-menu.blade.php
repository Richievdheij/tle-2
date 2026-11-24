{{--
    Dropdown menu panel: signed-in user, menu items and a footer. Only the panel; the opener lives elsewhere (see <x-user-menu>).

    <x-dropdown-menu :name="$user->name" :email="$user->email">
        <x-menu-item :href="route('profile.edit')" icon="user">{{ __('My profile') }}</x-menu-item>
        <x-slot:footer><x-menu-item tone="danger" icon="log-out" type="submit">{{ __('Log out') }}</x-menu-item></x-slot:footer>
    </x-dropdown-menu>

    Props: name, email (omit both to drop the header), $footer slot.
--}}
@props([
    'name' => null,
    'email' => null,
])

<div {{ $attributes->class('dropdown-menu') }}>
    @if ($name || $email)
        <div class="dropdown-menu__user">
            @if ($name)
                <span class="dropdown-menu__name">{{ $name }}</span>
            @endif
            @if ($email)
                <span class="dropdown-menu__email">{{ $email }}</span>
            @endif
        </div>

        <hr class="dropdown-menu__divider">
    @endif

    {{ $slot }}

    @isset($footer)
        <hr class="dropdown-menu__divider">

        {{ $footer }}
    @endisset
</div>
