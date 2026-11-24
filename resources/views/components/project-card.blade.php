{{--
    Project card: photo, tag, title, description and a progress bar towards the goal. The whole card is one link (the title).

    <x-project-card :href="route('projects.show', $project)" :title="$project->title" :description="$project->summary" :value="3240" :max="5000" :raised="__(':amount raised', ['amount' => '€3,240'])" :goal="__('goal :amount', ['amount' => '€5,000'])" :image="$project->photo_url" :alt="$project->photo_alt" />

    Props: title (required), href (required), description, raised, goal (texts), value, max (numbers; both needed for the bar), image, alt (required with image), tag, tagTone (default accent), linkLabel, level (default 3).
--}}
@props([
    'title',
    'href',
    'description' => null,
    'raised' => null,
    'goal' => null,
    'value' => null,
    'max' => null,
    'image' => null,
    'alt' => null,
    'tag' => null,
    'tagTone' => 'accent',
    'linkLabel' => null,
    'level' => 3,
])

@php
    if ($image && $alt === null) {
        throw new InvalidArgumentException('<x-project-card> needs `alt` text for its image.');
    }

    $hasBar = is_numeric($value) && is_numeric($max) && $max > 0;
@endphp

<article {{ $attributes->class('project-card') }}>
    <div class="project-card__media">
        @if ($image)
            <img class="project-card__photo" src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
        @endif
    </div>

    <div class="project-card__content">
        @if ($tag)
            <span class="project-card__tag"><x-tag :tone="$tagTone">{{ $tag }}</x-tag></span>
        @endif

        <h{{ $level }} class="project-card__title">
            <a class="project-card__link" href="{{ $href }}">{{ $title }}</a>
        </h{{ $level }}>

        @if ($description)
            <p class="project-card__description">{{ $description }}</p>
        @endif

        @if ($hasBar || $raised || $goal)
            <div class="project-card__progress">
                @if ($hasBar)
                    <progress
                        class="project-card__bar"
                        value="{{ min($value, $max) }}"
                        max="{{ $max }}"
                        aria-label="{{ trim($raised.', '.$goal, ', ') ?: __('Progress towards the goal') }}"
                    ></progress>
                @endif

                <p class="project-card__amounts">
                    <span class="project-card__raised">{{ $raised }}</span>
                    <span class="project-card__goal">{{ $goal }}</span>
                </p>
            </div>
        @endif

        <span class="project-card__cta" aria-hidden="true">
            <span class="project-card__circle"><x-icon name="arrow-right" /></span>
            <span class="project-card__cta-label">{{ $linkLabel ?? __('View project') }}</span>
        </span>
    </div>
</article>
