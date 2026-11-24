{{--
    Nav link: a navbar link with an underline indicator; active adds aria-current="page".

    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')">{{ __('Events') }}</x-nav-link>

    Props: href (without it renders a non-clickable placeholder), active.
--}}
@props([
    'href' => null,
    'active' => false,
])

<a
    {{ $attributes->class(['nav-link', 'is-active' => $active]) }}
    @if ($href) href="{{ $href }}" @endif
    @if ($active) aria-current="page" @endif
>
    <span class="nav-link__label">{{ $slot }}</span>
</a>
