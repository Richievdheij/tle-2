<x-layouts.guest :title="__('Log in')">
    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <x-field
            name="email"
            type="email"
            :label="__('Email')"
            required
            autofocus
            autocomplete="username"
        />

        <x-field
            name="password"
            type="password"
            :label="__('Password')"
            required
            autocomplete="current-password"
        />

        <x-checkbox name="remember" id="remember_me" :label="__('Remember me')" />

        <div class="form__actions">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-button variant="primary" type="submit">
                {{ __('Log in') }}
            </x-button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="card__footer">
            {{ __('No account yet?') }}
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </p>
    @endif
</x-layouts.guest>
