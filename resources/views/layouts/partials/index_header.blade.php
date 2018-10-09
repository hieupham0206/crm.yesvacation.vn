<div class="m-portlet__head index-header">
    <div class="m-portlet__head-caption"></div>
    <div class="m-portlet__head-tools">
        @if(can('create-'. lcfirst(studly_case($model))) && $createUrl)
            @if(isset($isModal))
                <button type="button" id="btn_create" data-url="{{ $createUrl }}" class="btn btn-sm btn-brand m-btn m-btn--custom m-btn--icon mr-2">
                    <span>
                        <i class="fa fa-plus"></i>
                        <span>{{ $createText ?? __('action.Create Model', ['model' => $modelName]) }}</span>
                    </span>
                </button>
            @else
                <a href="{{ $createUrl }}" class="btn btn-sm btn-brand m-btn m-btn--custom m-btn--icon mr-2">
                    <span>
                        <i class="fa fa-plus"></i>
                        <span>{{ $createText ?? __('action.Create Model', ['model' => $modelName]) }}</span>
                    </span>
                </a>
            @endif
        @endif
        @isset($buttons)
            @foreach ($buttons as $button)
                @if (isset($button['canDo']) && $button['canDo'])
                    @if (isset($button['isLink']))
                        <a href="{{ $button['route'] }}" class="btn btn-sm {{ $button['btnClass'] }} m-btn m-btn--custom m-btn--icon mr-2">
                            <span>
                                <i class="{{ $button['icon'] }}"></i>
                                <span>{{ $button['text'] }}</span>
                            </span>
                        </a>
                    @else
                        <button type="button" data-url="{{ $button['route'] }}" class="btn btn-sm {{ $button['btnClass'] }} m-btn m-btn--custom m-btn--icon mr-2">
                            <span>
                                <i class="{{ $button['icon'] }}"></i>
                                <span>{{ $button['text'] }}</span>
                            </span>
                        </button>
                    @endif
                @endif
            @endforeach
        @endisset
        @includeWhen(isset($model) && ! isset($quickAction) && can('delete-'. lcfirst($model)), 'layouts.partials.quick_action', ['model' => $model, 'editUrl' => $editUrl ?? null])
    </div>
</div>
