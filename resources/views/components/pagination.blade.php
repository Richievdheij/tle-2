{{--
    Pagination: a range summary plus Previous, page numbers and Next.

    <x-pagination :paginator="$participants" />
    <x-pagination :current="2" :last="5" url="?page=:page" />

    Props: paginator (LengthAwarePaginator), current, last, url (with :page; used without a paginator), summary (default ":from–:to of :total" with a paginator), window (default 2).
--}}
@props([
    'paginator' => null,
    'current' => 1,
    'last' => 1,
    'url' => null,
    'summary' => null,
    'window' => 2,
])

@php
    if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $pageUrl = fn (int $page): string => $paginator->url($page);
        $summary ??= __(':from–:to of :total', [
            'from' => $paginator->firstItem() ?? 0,
            'to' => $paginator->lastItem() ?? 0,
            'total' => $paginator->total(),
        ]);
    } else {
        $pageUrl = fn (int $page): ?string => $url !== null ? str_replace(':page', (string) $page, $url) : null;
    }

    $current = max(1, (int) $current);
    $last = max(1, (int) $last);

    // 1 … 4 5 [6] 7 8 … 20; a gap of a single page shows that page instead of an ellipsis.
    $pages = collect(range(1, $last))
        ->filter(fn (int $page): bool => $page === 1 || $page === $last || abs($page - $current) <= $window
            || ($page === 2 && $current - $window === 3) || ($page === $last - 1 && $current + $window === $last - 2))
        ->values();
@endphp

<div {{ $attributes->class('pagination') }}>
    @if ($summary)
        <p class="pagination__summary">{{ $summary }}</p>
    @endif

    <nav class="pagination__pages" aria-label="{{ __('Page navigation') }}">
        @if ($current > 1 && $pageUrl($current - 1))
            <a class="pagination__step" href="{{ $pageUrl($current - 1) }}" rel="prev">
                <x-icon name="arrow-left" />
                <span>{{ __('Previous') }}</span>
            </a>
        @else
            <span class="pagination__step" aria-disabled="true">
                <x-icon name="arrow-left" />
                <span>{{ __('Previous') }}</span>
            </span>
        @endif

        <ul class="pagination__list" role="list">
            @foreach ($pages as $index => $page)
                @if ($index > 0 && $page - $pages[$index - 1] > 1)
                    <li class="pagination__gap" aria-hidden="true">…</li>
                @endif
                <li>
                    @if ($page === $current)
                        <a class="pagination__page is-current" @if ($pageUrl($page)) href="{{ $pageUrl($page) }}" @endif aria-current="page">
                            <span class="sr-only">{{ __('Page') }}</span> {{ $page }}
                        </a>
                    @else
                        <a class="pagination__page" @if ($pageUrl($page)) href="{{ $pageUrl($page) }}" @endif>
                            <span class="sr-only">{{ __('Page') }}</span> {{ $page }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>

        @if ($current < $last && $pageUrl($current + 1))
            <a class="pagination__step" href="{{ $pageUrl($current + 1) }}" rel="next">
                <span>{{ __('Next') }}</span>
                <x-icon name="arrow-right" />
            </a>
        @else
            <span class="pagination__step" aria-disabled="true">
                <span>{{ __('Next') }}</span>
                <x-icon name="arrow-right" />
            </span>
        @endif
    </nav>
</div>
