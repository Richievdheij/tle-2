{{--
    Footer link: white text on navy, cyan on hover.

    <x-footer-link :href="route('login')">{{ __('Log in') }}</x-footer-link>

    Props: href (without it renders a non-clickable placeholder), tone: link|small.
--}}
@props([
    'href' => null,
    'tone' => 'link',
])

<a
    {{ $attributes->class(['footer-link', 'footer-link--'.$tone]) }}
    @if ($href) href="{{ $href }}" @endif
>{{ $slot }}</a>
