@if (is_object($paginator) && get_class($paginator) == 'Illuminate\Pagination\LengthAwarePaginator')
    @if ($paginator->lastPage() > 1)
        <div class="pagination-module">
            <ul>
                @if ($paginator->previousPageUrl())
                    <li><a href="{{ $paginator->previousPageUrl() }}"> <span class="icon-angle-left"></span> </a></li>
                @endif

                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    @if (ViewHelper::paginatorFrom($paginator, 7) < $i && $i < ViewHelper::paginatorTo($paginator, 7))
                        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            @if (!empty($appends))
                                <a href="{{ $paginator->appends($appends)->url($i) }}">{{ $i }}</a>
                            @else
                                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                            @endif
                        </li>
                    @endif
                @endfor

                @if ($paginator->nextPageUrl())
                    <li><a href="{{ $paginator->nextPageUrl() }}"> <span class="icon-angle-right"></span> </a></li>
                @endif
            </ul>
        </div>
    @endif
@endif