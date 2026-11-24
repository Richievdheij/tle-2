{{--
    Skeleton card: loading state of an event or project card; announces itself as loading.

    <x-skeleton-card />

    Props: label (screen-reader text, default "Loading").
--}}
@props([
    'label' => null,
])

<div {{ $attributes->class('skeleton-card') }} role="status" aria-busy="true">
    <span class="sr-only">{{ $label ?? __('Loading') }}</span>

    <x-skeleton class="skeleton-card__image" shape="image" />

    <div class="skeleton-card__content">
        <x-skeleton shape="tag" />
        <x-skeleton class="skeleton-card__heading" shape="heading" />
        <x-skeleton class="skeleton-card__line" shape="text" />
        <x-skeleton class="skeleton-card__line skeleton-card__line--short" shape="text" />

        <div class="skeleton-card__link">
            <x-skeleton class="skeleton-card__circle" shape="circle" />
            <x-skeleton class="skeleton-card__link-text" shape="text" />
        </div>
    </div>
</div>
