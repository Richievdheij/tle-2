{{--
    Organizer inline: a small avatar and the name, for a table cell or meta line.

    <x-organizer name="Lisa de Vries" active />

    Props: name (required), active (navy avatar, bold name).
--}}
@props([
    'name',
    'active' => false,
])

<span {{ $attributes->class(['organizer', 'organizer--active' => $active]) }}>
    <x-avatar :name="$name" size="xs" :tone="$active ? 'primary' : 'neutral'" />
    <span class="organizer__name">{{ $name }}</span>
</span>
