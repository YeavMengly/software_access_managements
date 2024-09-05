@if ($paginator->hasPages())
    <div class="demo">
        <nav class="pagination-outer" aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">«</span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev"
                            aria-label="@lang('pagination.previous')">«</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a href="{{ $url }}"
                                        class="page-link">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next"
                            aria-label="@lang('pagination.next')">»</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">»</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif


<style>
    .pagination-outer {
        text-align: center;
    }

    .pagination {
        font-family: 'Manrope', sans-serif;
        display: inline-flex;
        position: relative;
    }

    .pagination li a.page-link {
        color: #555;
        background: #eee;
        font-size: 16px;
        font-weight: 700;
        text-align: center;
        line-height: 32px;
        height: 32px;
        width: 32px;
        padding: 0;
        margin: 0 6px;
        border: none;
        border-radius: 0;
        display: block;
        position: relative;
        z-index: 1;
        transition: all 0.5s ease;
    }

    .pagination li:first-child a.page-link,
    .pagination li:last-child a.page-link {
        font-size: 23px;
        line-height: 28px;
    }

    .pagination li a.page-link:hover,
    .pagination li a.page-link:focus,
    .pagination li.active a.page-link:hover,
    .pagination li.active a.page-link {
        color: #c31db3;
        background: transparent;
        box-shadow: 0 0 0 1px #c31db3;
        border-radius: 5px;
    }

    .pagination li a.page-link:before,
    .pagination li a.page-link:after {
        content: '';
        background-color: #c31db3;
        height: 10px;
        width: 10px;
        opacity: 0;
        position: absolute;
        left: 0;
        top: 0;
        z-index: -2;
        transition: all 0.3s ease;
    }

    .pagination li a.page-link:after {
        right: 0;
        bottom: 0;
        top: auto;
        left: auto;
    }

    .pagination li a.page-link:hover:before,
    .pagination li a.page-link:focus:before,
    .pagination li.active a.page-link:hover:before,
    .pagination li.active a.page-link:before,
    .pagination li a.page-link:hover:after,
    .pagination li a.page-link:focus:after,
    .pagination li.active a.page-link:hover:after,
    .pagination li.active a.page-link:after {
        opacity: 1;
    }

    .pagination li a.page-link:hover:before,
    .pagination li a.page-link:focus:before,
    .pagination li.active a.page-link:hover:before,
    .pagination li.active a.page-link:before {
        left: -3px;
        top: -3px;
    }

    .pagination li a.page-link:hover:after,
    .pagination li a.page-link:focus:after,
    .pagination li.active a.page-link:hover:after,
    .pagination li.active a.page-link:after {
        right: -3px;
        bottom: -3px;
    }

    @media only screen and (max-width: 480px) {
        .pagination {
            font-size: 0;
            display: inline-block;
        }

        .pagination li {
            display: inline-block;
            vertical-align: top;
            margin: 0 0 15px;
        }
    }
</style>
