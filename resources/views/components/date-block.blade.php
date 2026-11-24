{{--
    Date block: a small calendar page (weekday, day, month) for a date column.

    <x-date-block :date="$event->starts_at" next />
    <x-date-block weekday="Sat" day="28" month="Nov" />

    Props: date (DateTimeInterface|string), next (navy "next up" style), weekday, day, month (override the derived parts).
--}}
@props([
    'date' => null,
    'next' => false,
    'weekday' => null,
    'day' => null,
    'month' => null,
])

@php
    $moment = $date ? \Illuminate\Support\Carbon::parse($date)->locale(app()->getLocale()) : null;
    $weekday ??= $moment ? rtrim($moment->isoFormat('ddd'), '.') : '';
    $day ??= $moment ? $moment->isoFormat('D') : '';
    $month ??= $moment ? rtrim($moment->isoFormat('MMM'), '.') : '';
@endphp

<time
    {{ $attributes->class(['date-block', 'date-block--next' => $next]) }}
    @if ($moment) datetime="{{ $moment->toDateString() }}" @endif
>
    <span class="date-block__weekday" aria-hidden="true">{{ $weekday }}</span>
    <span class="date-block__day" aria-hidden="true">{{ $day }}</span>
    <span class="date-block__month" aria-hidden="true">{{ $month }}</span>
    <span class="sr-only">{{ $moment ? $moment->isoFormat('dddd D MMMM YYYY') : trim($weekday.' '.$day.' '.$month) }}</span>
</time>
