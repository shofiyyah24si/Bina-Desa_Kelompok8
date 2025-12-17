@if ($paginator->hasPages())
    <nav class="mt-10 flex justify-center select-none">
        <ul class="flex items-center gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="w-9 h-9 flex items-center justify-center rounded-xl 
                           bg-slate-800/40 text-slate-500 cursor-not-allowed">
                    &#x2039;
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl 
                              bg-slate-800 hover:bg-slate-700 transition text-slate-200">
                        &#x2039;
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)

                {{-- Separator (…) --}}
                @if (is_string($element))
                    <li class="px-3 py-2 text-slate-500 text-sm">{{ $element }}</li>
                @endif

                {{-- Page Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        {{-- Active Page --}}
                        @if ($page == $paginator->currentPage())
                            <li class="w-9 h-9 flex items-center justify-center rounded-xl
                                       bg-accent text-white font-semibold 
                                       shadow-lg shadow-blue-500/40">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="w-9 h-9 flex items-center justify-center rounded-xl
                                          bg-slate-800 hover:bg-slate-700 
                                          text-slate-200 transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif

                    @endforeach
                @endif

            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl 
                              bg-slate-800 hover:bg-slate-700 transition text-slate-200">
                        &#x203A;
                    </a>
                </li>
            @else
                <li class="w-9 h-9 flex items-center justify-center rounded-xl 
                           bg-slate-800/40 text-slate-500 cursor-not-allowed">
                    &#x203A;
                </li>
            @endif

        </ul>
    </nav>
@endif
