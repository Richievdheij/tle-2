{{--
    Skeleton row: loading state of one list row. Decorative; put aria-busy and one "Loading" text on the list.

    <x-skeleton-row />
--}}
<div {{ $attributes->class('skeleton-row') }} aria-hidden="true">
    <x-skeleton shape="circle" />

    <div class="skeleton-row__lines">
        <x-skeleton class="skeleton-row__line" shape="text" />
        <x-skeleton class="skeleton-row__line skeleton-row__line--short" shape="text" />
    </div>
</div>
