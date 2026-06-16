@if ($paginator->hasPages())
<nav class="pagination-nav">
    @if ($paginator->onFirstPage())
        <span class="page-btn page-btn--disabled">← Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">← Prev</a>
    @endif

    <span class="page-info">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }} &nbsp;·&nbsp; {{ $paginator->total() }} total</span>

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next →</a>
    @else
        <span class="page-btn page-btn--disabled">Next →</span>
    @endif
</nav>
@endif
