@if ($paginator->hasPages())
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-xs text-black/45">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </p>
        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 rounded-full grid place-items-center text-black/20"><i class="fa-solid fa-chevron-left text-xs"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-chevron-left text-xs"></i></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-8 h-8 grid place-items-center text-black/30 text-xs">{{ $element }}</span>
                @else
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 rounded-full bg-primary text-ink grid place-items-center text-xs font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 rounded-full grid place-items-center text-xs font-medium hover:bg-black/5 transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-chevron-right text-xs"></i></a>
            @else
                <span class="w-8 h-8 rounded-full grid place-items-center text-black/20"><i class="fa-solid fa-chevron-right text-xs"></i></span>
            @endif
        </div>
    </div>
@endif
