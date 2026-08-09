@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="is-disabled">&larr;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="is-disabled">{{ $element }}</span>
            @else
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">&rarr;</a>
        @else
            <span class="is-disabled">&rarr;</span>
        @endif
    </nav>
@endif
