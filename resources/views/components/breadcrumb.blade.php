{{--
    Breadcrumb: an optional "Go back" link above a trail of links; the last crumb is the current page.

    <x-breadcrumb :crumbs="[['label' => __('Home'), 'href' => route('home')], ['label' => $event->title]]" />

    Props: crumbs (list of ['label', 'href']; last needs no href), back: true (previous URL)|string (URL)|false (hidden), label (nav name, default "Breadcrumb").
--}}
@props([
    'crumbs' => [],
    'back' => true,
    'label' => null,
])

@php
    $backHref = match (true) {
        $back === false || $back === null => null,
        is_string($back) => $back,
        default => url()->previous(),
    };
    $lastIndex = count($crumbs) - 1;
@endphp

<nav {{ $attributes->class('breadcrumb') }} aria-label="{{ $label ?? __('Breadcrumb') }}">
    @if ($backHref)
        <a class="breadcrumb__back" href="{{ $backHref }}">
            <x-icon class="breadcrumb__back-icon" name="arrow-left" />
            <span>{{ __('Go back') }}</span>
        </a>
    @endif

    @if ($crumbs)
        <ol class="breadcrumb__list" role="list">
            @foreach ($crumbs as $index => $crumb)
                <li class="breadcrumb__item">
                    @if ($index === $lastIndex || empty($crumb['href']))
                        <span class="breadcrumb__current" @if ($index === $lastIndex) aria-current="page" @endif>{{ $crumb['label'] }}</span>
                    @else
                        <a class="breadcrumb__link" href="{{ $crumb['href'] }}">{{ $crumb['label'] }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif
</nav>
