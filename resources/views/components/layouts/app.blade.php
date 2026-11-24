{{--
    Page shell: <x-layouts.app :title="__('Profile')">…</x-layouts.app>.
    Props: title (prepended to the app name in <title>). Optional $header slot renders a band above the content.
--}}
@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => $title])
    </head>

    <body>
        {{-- First focusable element, so keyboard users can skip the navigation. --}}
        <a class="skip-link" href="#main">{{ __('Skip to content') }}</a>

        <div class="site">
            {{-- Header and content fill at least one screen; the footer starts below it. --}}
            <div class="site__screen">
                @include('partials.header')

                <main class="site__main" id="main" tabindex="-1">
                    @isset($header)
                        <div class="site__intro">
                            <div class="container">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    <div class="container site__content">
                        @include('partials.flash')

                        {{ $slot }}
                    </div>
                </main>
            </div>

            @include('partials.footer')
        </div>
    </body>
</html>
