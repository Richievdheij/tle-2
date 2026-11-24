{{--
    Organizer card: "Organized by", the organizer with one fact, and the faces of who joined.

    <x-organizer-card name="Lisa de Vries" :fact="__('Has organized :count events', ['count' => 4])" :participants="['Max Kok', 'Sanne Bos']" :total="38" />

    Props: name (required), fact, participants (up to three names shown; empty hides the row), participantsText (default "joined"), total (extra faces become "+N").
--}}
@props([
    'name',
    'fact' => null,
    'participants' => [],
    'participantsText' => null,
    'total' => null,
])

@php
    $shown = array_slice($participants, 0, 3);
    $rest = max(0, ($total ?? count($participants)) - count($shown));
    $tones = ['accent', 'neutral', 'subtle'];
@endphp

<div {{ $attributes->class('organizer-card') }}>
    <p class="organizer-card__label">{{ __('Organized by') }}</p>

    <div class="organizer-card__organizer">
        <x-avatar :name="$name" size="md" tone="primary" />
        <div class="organizer-card__text">
            <p class="organizer-card__name">{{ $name }}</p>
            @if ($fact)
                <p class="organizer-card__fact">{{ $fact }}</p>
            @endif
        </div>
    </div>

    @if ($shown)
        <hr class="organizer-card__divider">

        <div class="organizer-card__participants">
            <span class="organizer-card__faces">
                @foreach ($shown as $index => $participant)
                    <span class="organizer-card__face">
                        <x-avatar :name="$participant" size="sm" :tone="$tones[$index % 3]" />
                    </span>
                @endforeach
                @if ($rest > 0)
                    <span class="organizer-card__face">
                        <x-avatar :initials="'+'.$rest" size="sm" tone="neutral" />
                    </span>
                @endif
            </span>
            <span class="organizer-card__joined">{{ $participantsText ?? __('joined') }}</span>
        </div>
    @endif
</div>
