<div class="m-list-search__results">
    @if ($results)
        <span class="m-list-search__result-category m-list-search__result-category--first">
            @lang('Search result')
        </span>

        @foreach ($results as $result)
            @if($result)
                <a href="{{ $result['url'] }}" class="m-list-search__result-item">
                    {{--<span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-warning"></i></span>--}}
                    <span class="m-list-search__result-item-text">{{ $result['text'] }}</span>
                </a>
            @endif
        @endforeach
    @else
        <span class="m-list-search__result-message">
            @lang('No search result found')
        </span>
    @endif
</div>