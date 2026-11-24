{{-- Site footer. Links come from config/navigation.php; a missing route renders as a placeholder. --}}
@php
    $href = static fn (array $item): ?string => Route::has($item['route']) ? route($item['route']) : null;
    $signedIn = auth()->check();
    $visible = static fn (array $item): bool => ! (($item['guest'] ?? false) && $signedIn) && ! (($item['auth'] ?? false) && ! $signedIn);
@endphp

<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <x-logo class="logo--flush" theme="dark" />
                <p class="site-footer__tagline">
                    {{ __('Together we keep rivers and oceans clean. Donate, join an event or follow the impact of your contribution.') }}
                </p>
            </div>

            <nav class="site-footer__columns" aria-label="{{ __('Footer navigation') }}">
                @foreach (config('navigation.footer', []) as $heading => $items)
                    <div class="site-footer__column">
                        <h2 class="site-footer__heading">{{ __($heading) }}</h2>
                        <ul class="site-footer__links" role="list">
                            @foreach (array_filter($items, $visible) as $item)
                                <li><x-footer-link :href="$href($item)">{{ __($item['label']) }}</x-footer-link></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </div>

        <div class="site-footer__bottom">
            <p class="site-footer__copyright">
                © {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
            </p>

            <ul class="site-footer__legal" role="list">
                @foreach (config('navigation.legal', []) as $item)
                    <li><x-footer-link tone="small" :href="$href($item)">{{ __($item['label']) }}</x-footer-link></li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
