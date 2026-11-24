{{--
    Page header: breadcrumb, the page's H1, intro, a details row and an aside card.

    <x-page-header :title="__('Events')" :intro="__('…')" :crumbs="[['label' => __('Home'), 'href' => route('home')], ['label' => __('Events')]]">
        <x-slot:details>
            <x-tag tone="success" icon="check">{{ __('Completed') }}</x-tag>
            <x-meta-item icon="calendar">{{ $event->date }}</x-meta-item>
        </x-slot:details>
        <x-slot:aside><x-organizer-card … /></x-slot:aside>
    </x-page-header>

    Props: title (required), intro, crumbs, back (passed to the breadcrumb).
--}}
@props([
    'title',
    'intro' => null,
    'crumbs' => [],
    'back' => true,
])

<header {{ $attributes->class('page-header') }}>
    <div class="container page-header__inner">
        <div class="page-header__content">
            @if ($crumbs)
                <x-breadcrumb :crumbs="$crumbs" :back="$back" />
            @endif

            <h1 class="page-header__title">{{ $title }}</h1>

            @if ($intro)
                <p class="page-header__intro">{{ $intro }}</p>
            @endif

            @isset($details)
                <div class="page-header__details">
                    <div class="page-header__detail-list">{{ $details }}</div>
                </div>
            @endisset

            @if ($slot->isNotEmpty())
                <div class="page-header__extra">{{ $slot }}</div>
            @endif
        </div>

        @isset($aside)
            <div class="page-header__aside">{{ $aside }}</div>
        @endisset
    </div>
</header>
