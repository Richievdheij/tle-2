{{-- Site navbar; below 768px everything moves into the hamburger menu. Links come from config/navigation.php. --}}
@php
    $link = static fn (array $item): array => [
        'label' => __($item['label']),
        'href' => Route::has($item['route']) ? route($item['route']) : null,
        'active' => request()->routeIs($item['active'] ?? $item['route']),
        'icon' => $item['icon'] ?? null,
    ];

    $mainLinks = array_map($link, config('navigation.main', []));
    $accountLinks = array_map($link, config('navigation.account', []));
    $searchAction = Route::has('search') ? route('search') : null;
    $user = auth()->user();
@endphp

<header class="navbar">
    <div class="container navbar__inner">
        <div class="navbar__start">
            <x-logo class="navbar__logo" />

            <nav class="navbar__menu" aria-label="{{ __('Main navigation') }}">
                <ul class="navbar__links" role="list">
                    @foreach ($mainLinks as $item)
                        <li>
                            <x-nav-link :href="$item['href']" :active="$item['active']">{{ $item['label'] }}</x-nav-link>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <div class="navbar__actions">
            {{-- Tablet and desktop only. --}}
            <div class="navbar__wide">
                <x-search-bar id="navbar-search" :action="$searchAction" />

                @if ($user)
                    <x-user-menu :user="$user">
                        @foreach ($accountLinks as $item)
                            <x-menu-item
                                :href="$item['href']"
                                :placeholder="$item['href'] === null"
                                :icon="$item['icon']"
                                :active="$item['active']"
                            >{{ $item['label'] }}</x-menu-item>
                        @endforeach

                        <x-slot:footer>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-menu-item tone="danger" icon="log-out" type="submit">{{ __('Log out') }}</x-menu-item>
                            </form>
                        </x-slot:footer>
                    </x-user-menu>
                @else
                    <x-button variant="primary" :href="route('login')">{{ __('Log in') }}</x-button>
                @endif
            </div>

            {{-- The hamburger menu, below 768px only. --}}
            <details class="mobile-menu" data-disclosure>
                <summary class="mobile-menu__toggle">
                    <x-icon class="mobile-menu__open" name="menu" />
                    <x-icon class="mobile-menu__close" name="close" />
                    <span class="sr-only">{{ __('Menu') }}</span>
                </summary>

                <div class="mobile-menu__panel">
                    <div class="container mobile-menu__body">
                        <x-search-bar id="mobile-search" :action="$searchAction" open />

                        <nav aria-label="{{ __('Main navigation') }}">
                            <ul class="mobile-menu__list" role="list">
                                @foreach ($mainLinks as $item)
                                    <li>
                                        <x-menu-item
                                            :href="$item['href']"
                                            :placeholder="$item['href'] === null"
                                            :active="$item['active']"
                                            strong
                                        >{{ $item['label'] }}</x-menu-item>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>

                        <hr class="mobile-menu__divider">

                        @if ($user)
                            <div class="mobile-menu__user">
                                <x-avatar :name="$user->name" size="md" />
                                <div class="mobile-menu__identity">
                                    <span class="mobile-menu__name">{{ $user->name }}</span>
                                    <span class="mobile-menu__email">{{ $user->email }}</span>
                                </div>
                            </div>

                            <ul class="mobile-menu__list" role="list">
                                @foreach ($accountLinks as $item)
                                    <li>
                                        <x-menu-item
                                            :href="$item['href']"
                                            :placeholder="$item['href'] === null"
                                            :icon="$item['icon']"
                                            :active="$item['active']"
                                        >{{ $item['label'] }}</x-menu-item>
                                    </li>
                                @endforeach
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-menu-item tone="danger" icon="log-out" type="submit">{{ __('Log out') }}</x-menu-item>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <x-button variant="primary" :href="route('login')" block>{{ __('Log in') }}</x-button>
                        @endif
                    </div>
                </div>
            </details>
        </div>
    </div>
</header>
