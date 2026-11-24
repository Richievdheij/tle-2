{{--
    Timeline chart: per-day bars or lines, switched with CSS-only radio toggles; period buttons are links. Includes an sr-only data table.

    <x-timeline-chart :period="__('Week 45 · 2–8 November 2026')" :days="[
        ['weekday' => 'Mon', 'date' => '2 Nov', 'values' => ['registrations' => 6, 'cancellations' => 0, 'donations' => 0]],
        ['weekday' => 'Sat', 'date' => '7 Nov', 'highlight' => true, 'values' => […]],
    ]" :periods="[['label' => __('Week'), 'href' => …, 'active' => true]]" />

    Props: days (required; weekday, date, values, highlight), type: bars|lines, series (key, label, tone: primary|strong|accent; bottom first), title (default "Timeline"), period, periods (label, href, active; omit to hide), id (needed for two charts on a page).
--}}
@props([
    'days',
    'type' => 'bars',
    'series' => null,
    'title' => null,
    'period' => null,
    'periods' => [],
    'id' => null,
])

@php
    $id ??= 'timeline-chart';
    $title ??= __('Timeline');
    $series ??= [
        ['key' => 'registrations', 'label' => __('Registrations'), 'tone' => 'primary'],
        ['key' => 'cancellations', 'label' => __('Cancellations'), 'tone' => 'strong'],
        ['key' => 'donations', 'label' => __('Donations'), 'tone' => 'accent'],
    ];
    $tones = [
        'primary' => 'var(--color-bg-primary)',
        'strong' => 'var(--color-border-strong)',
        'accent' => 'var(--color-bg-accent)',
    ];

    $count = max(count($days), 1);
    $value = static fn (array $day, string $key): float => (float) ($day['values'][$key] ?? 0);

    // Bars scale to the highest day total (they stack); lines to the highest single value.
    $barMax = max(1, ...array_map(
        static fn (array $day): float => array_sum(array_map(static fn (array $s): float => $value($day, $s['key']), $series)),
        $days ?: [[]],
    ));
    $lineMax = max(1, ...array_map(
        static fn (array $day): float => max(0, ...array_map(static fn (array $s): float => $value($day, $s['key']), $series)),
        $days ?: [[]],
    ));

    // x in % of the plot width; y in px of the 172px plot (top of scale at 10, zero at 170).
    $x = static fn (int $i): float => round(($i + 0.5) / $count * 100, 3);
    $y = static fn (float $v): float => round(170 - $v / $lineMax * 160, 2);
@endphp

<section {{ $attributes->class('timeline-chart')->style('--days: '.$count) }} aria-labelledby="{{ $id }}-title">
    <div class="timeline-chart__header">
        <div class="timeline-chart__heading">
            <h3 class="timeline-chart__title" id="{{ $id }}-title">{{ $title }}</h3>
            @if ($period)
                <p class="timeline-chart__period">{{ $period }}</p>
            @endif
        </div>

        <div class="timeline-chart__switches">
            @if ($periods)
                <nav aria-label="{{ __('Period') }}">
                    <ul class="timeline-chart__segments" role="list">
                        @foreach ($periods as $option)
                            <li>
                                <a
                                    @class(['timeline-chart__segment', 'is-active' => $option['active'] ?? false])
                                    @if (! empty($option['href'])) href="{{ $option['href'] }}" @endif
                                    @if ($option['active'] ?? false) aria-current="page" @endif
                                >{{ $option['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif

            <fieldset class="timeline-chart__types">
                <legend class="sr-only">{{ __('Chart type') }}</legend>
                @foreach (['bars' => ['chart-bars', __('Bars')], 'lines' => ['chart-line', __('Lines')]] as $option => [$icon, $label])
                    <input
                        class="timeline-chart__type-input"
                        id="{{ $id }}-{{ $option }}"
                        type="radio"
                        name="{{ $id }}-type"
                        value="{{ $option }}"
                        @checked($type === $option)
                    >
                    <label class="timeline-chart__type" for="{{ $id }}-{{ $option }}">
                        <x-icon :name="$icon" />
                        <span class="sr-only">{{ $label }}</span>
                    </label>
                @endforeach
            </fieldset>
        </div>
    </div>

    <ul class="timeline-chart__legend" role="list" aria-hidden="true">
        @foreach ($series as $s)
            <li class="timeline-chart__legend-item" style="--series: {{ $tones[$s['tone']] ?? $tones['primary'] }}">
                <span class="timeline-chart__swatch"></span>
                {{ $s['label'] }}
            </li>
        @endforeach
    </ul>

    <div class="timeline-chart__plot" aria-hidden="true">
        {{-- Bars: per day, the series stacked bottom-up, 2px apart. --}}
        <div class="timeline-chart__bars">
            @foreach ($days as $day)
                <div class="timeline-chart__column">
                    @foreach ($series as $s)
                        @if ($value($day, $s['key']) > 0)
                            <span
                                class="timeline-chart__bar"
                                style="--series: {{ $tones[$s['tone']] ?? $tones['primary'] }}; --value: {{ round($value($day, $s['key']) / $barMax, 4) }}"
                            ></span>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Lines: one polyline per series, a dot on every day. --}}
        <div class="timeline-chart__lines">
            <svg class="timeline-chart__svg" viewBox="0 0 100 172" preserveAspectRatio="none" focusable="false">
                @foreach ([10, 50, 90, 130, 171] as $gridY)
                    <line class="timeline-chart__grid" x1="0" x2="100" y1="{{ $gridY }}" y2="{{ $gridY }}" />
                @endforeach
                @foreach ($series as $s)
                    <polyline
                        class="timeline-chart__line"
                        style="--series: {{ $tones[$s['tone']] ?? $tones['primary'] }}"
                        points="{{ collect($days)->map(fn (array $day, int $i): string => $x($i).','.$y($value($day, $s['key'])))->implode(' ') }}"
                    />
                @endforeach
            </svg>

            @foreach ($series as $s)
                @foreach ($days as $i => $day)
                    <span
                        class="timeline-chart__dot"
                        style="--series: {{ $tones[$s['tone']] ?? $tones['primary'] }}; inset-inline-start: {{ $x($i) }}%; inset-block-start: {{ $y($value($day, $s['key'])) }}px"
                    ></span>
                @endforeach
            @endforeach
        </div>
    </div>

    <ol class="timeline-chart__days" role="list" aria-hidden="true">
        @foreach ($days as $day)
            <li @class(['timeline-chart__day', 'is-highlighted' => $day['highlight'] ?? false])>
                <span class="timeline-chart__weekday">
                    {{ ($day['highlight'] ?? false) ? __(':weekday, event', ['weekday' => $day['weekday']]) : $day['weekday'] }}
                </span>
                <span class="timeline-chart__date">{{ $day['date'] }}</span>
            </li>
        @endforeach
    </ol>

    {{-- The same numbers, for screen readers. --}}
    <table class="sr-only">
        <caption>{{ $title }}@if ($period), {{ $period }}@endif</caption>
        <thead>
            <tr>
                <th scope="col">{{ __('Day') }}</th>
                @foreach ($series as $s)
                    <th scope="col">{{ $s['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                <tr>
                    <th scope="row">
                        {{ $day['weekday'] }} {{ $day['date'] }}@if ($day['highlight'] ?? false) ({{ __('event day') }})@endif
                    </th>
                    @foreach ($series as $s)
                        <td>{{ $day['values'][$s['key']] ?? 0 }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
