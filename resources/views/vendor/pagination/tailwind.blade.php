@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
        
        <!-- Results Information -->
        <div>
            <p style="font-size: 0.875rem; color: #374151; margin: 0;">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span style="font-weight: 500;">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span style="font-weight: 500;">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span style="font-weight: 500;">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <!-- Pagination Links -->
        <div>
            <span style="display: inline-flex; border-radius: 4px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #9ca3af; background-color: #fff; border: 1px solid #d1d5db; border-top-left-radius: 4px; border-bottom-left-radius: 4px; cursor: default;">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; background-color: #fff; border: 1px solid #d1d5db; border-top-left-radius: 4px; border-bottom-left-radius: 4px; text-decoration: none;" aria-label="{{ __('pagination.previous') }}">
                        {!! __('pagination.previous') !!}
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; background-color: #fff; border: 1px solid #d1d5db; border-left: none;">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #4b5563; background-color: #f3f4f6; border: 1px solid #d1d5db; border-left: none; cursor: default;">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; background-color: #fff; border: 1px solid #d1d5db; border-left: none; text-decoration: none;" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; background-color: #fff; border: 1px solid #d1d5db; border-left: none; border-top-right-radius: 4px; border-bottom-right-radius: 4px; text-decoration: none;" aria-label="{{ __('pagination.next') }}">
                        {!! __('pagination.next') !!}
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #9ca3af; background-color: #fff; border: 1px solid #d1d5db; border-left: none; border-top-right-radius: 4px; border-bottom-right-radius: 4px; cursor: default;">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
