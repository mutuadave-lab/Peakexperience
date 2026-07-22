<div class="page-transition" data-page-transition aria-hidden="false">
    <div class="page-transition__content" role="status" aria-live="polite" aria-label="Loading next page">
        @if (filled($logoUrl ?? ''))
            <img class="page-transition__logo" src="{{ $logoUrl }}" alt="Peak Experience">
        @else
            <span class="page-transition__brand">Peak Experience</span>
        @endif
        <span class="page-transition__dots" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </div>
</div>
