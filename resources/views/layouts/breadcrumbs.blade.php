@if (count($breadcrumbs))

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="m-nav__item">
                    <a href="{{ $breadcrumb->url }}" class="m-nav__link m-link m--font-boldest">
                        {{ $breadcrumb->title }}
                    </a>
                </li>
                <li class="m-nav__separator">/</li>
            @else
                <li class="m-nav__item active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ul>

@endif