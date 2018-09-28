<div class="m-subheader">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            {{--<h3 class="m-subheader__title m-subheader__title--separator">@yield('title')</h3>--}}
            @if(isset($model))
                {{ Breadcrumbs::render($breadcrumb, ['model' => $model, 'label' => $label ?? null]) }}

            @else
                {{ Breadcrumbs::render($breadcrumb, $label ?? null) }}
            @endif
        </div>
    </div>
</div>