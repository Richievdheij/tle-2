{{--
    Signed-out shell (login, register, password reset): <x-layouts.guest :title="__('Log in')">…</x-layouts.guest>.
    Props: title (used in <title> and as the card's <h1>).
--}}
@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => $title])
    </head>

    <body>
        <a class="skip-link" href="#main">{{ __('Skip to content') }}</a>

        <div class="guest">
            <x-logo />

            <main class="guest__main card" id="main" tabindex="-1">
                @if ($title)
                    <header class="card__header">
                        <h1 class="card__title">{{ $title }}</h1>
                    </header>
                @endif

                @include('partials.flash')

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
