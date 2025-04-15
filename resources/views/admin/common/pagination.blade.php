@if ($pagination)
    @if ($pagination['total'] > $pagination['perPage'])
        <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Previous Page Link -->
            <li class="page-item {{ ($pagination['currentPage'] == 1) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pagination['previousPageUrl'] }}">Previous</a>
            </li>

            <!-- Pagination Elements -->
            @if($pagination['currentPage'] > 2)
                <li class="page-item"><a class="page-link" href="{{ $pagination['url'](1) }}">1</a></li>
            @endif
            @if($pagination['currentPage'] > 3)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif

            @for ($i = max(1, $pagination['currentPage'] - 1); $i <= min($pagination['lastPage'], $pagination['currentPage'] + 1); $i++)
                <li class="page-item {{ ($pagination['currentPage'] == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $pagination['url']($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if($pagination['currentPage'] < $pagination['lastPage'] - 2)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
            @if($pagination['currentPage'] < $pagination['lastPage'] - 1)
                <li class="page-item"><a class="page-link" href="{{ $pagination['url']($pagination['lastPage']) }}">{{ $pagination['lastPage'] }}</a></li>
            @endif

            <!-- Next Page Link -->
            <li class="page-item {{ ($pagination['currentPage'] == $pagination['lastPage']) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pagination['nextPageUrl'] }}">Next</a>
            </li>
        </ul>
        </nav>
    @endif
@endif

