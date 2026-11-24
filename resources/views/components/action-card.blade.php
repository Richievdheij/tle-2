{{--
    Action card: an icon, a title, one line of explanation and an arrow link to the action.

    <x-action-card icon="edit" :title="__('Edit event')" :description="__('…')" :href="route('events.edit', $event)" :link="__('Edit')" />

    Props: title (required), href (required), icon (default edit), description, link (label; defaults to title), level (heading level, default 3).
--}}
@props([
    'icon' => 'edit',
    'title',
    'description' => null,
    'href',
    'link' => null,
    'level' => 3,
])

<div {{ $attributes->class('action-card') }}>
    <span class="action-card__icon" aria-hidden="true">
        <x-icon :name="$icon" />
    </span>

    <div class="action-card__text">
        <h{{ $level }} class="action-card__title">{{ $title }}</h{{ $level }}>

        @if ($description)
            <p class="action-card__description">{{ $description }}</p>
        @endif
    </div>

    <div class="action-card__link">
        <x-arrow-link :href="$href">{{ $link ?? $title }}</x-arrow-link>
    </div>
</div>
