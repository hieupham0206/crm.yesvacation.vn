<form id="events_form" class="m-form m-form--state" method="post" action="{{ $action }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('action.Create Model', ['model' => lcfirst(__('Event'))])</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="m-scrollable" data-scrollable="true" data-scrollbar-shown="true">
            @csrf
            @isset($method)
                @method('put')
            @endisset
            <div class="m-portlet__body">
                {{--<flash></flash>--}}
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : ''}}">
                            <label for="txt_title">{{ __('Title') }}</label>
                            <input class="form-control" name="title" type="text" id="txt_title" value="{{ $event->title ?? ''}}" required placeholder="{{ __('Enter value') }}" autocomplete="off">
                            {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group m-form__group {{ $errors->has('color') ? 'has-danger' : ''}}">
                            <label for="txt_color">{{ __('Color') }}</label>
                            <input class="form-control text-colorpicker" name="color" type="text" id="txt_color" value="{{ $event->color ?? ''}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                            {!! $errors->first('color', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <div class="form-group m-form__group {{ $errors->has('start_at') ? 'has-danger' : ''}}">
                            <label for="txt_start_at">{{ __('Start time') }}</label>
                            <input class="form-control text-datetimepicker" name="start_at" type="text" id="txt_start_at" value="{{ $event->start_at ?? ''}}" required placeholder="{{ __('Enter value') }}" autocomplete="off">
                            {!! $errors->first('start_at', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group m-form__group {{ $errors->has('end_at') ? 'has-danger' : ''}}">
                            <label for="txt_end_at">{{ __('End time') }}</label>
                            <input class="form-control text-datetimepicker" name="end_at" type="text" id="txt_end_at" value="{{ $event->end_at ?? ''}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                            {!! $errors->first('end_at', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <div class="form-group m-form__group {{ $errors->has('all_day') ? 'has-danger' : ''}}">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                <input type="checkbox" value="6" name="all_day" id="chk_all_day" {{ isset($event) && $event->all_day ? 'checked' : ''}}>{{ __('All day') }}
                                <span></span>
                            </label>
                            {!! $errors->first('all_day', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-12">
                        <div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : ''}}">
                            <label for="textarea_description">{{ __('Description') }}</label>
                            <textarea name="description" id="textarea_description" cols="30" rows="5" class="form-control">{{ $event->description ?? ''}}</textarea>
                            {!! $errors->first('description', '<div class="form-control-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-brand">@lang('Save')</button>
        @isset($method)
            <button type="button" class="btn btn-danger" id="btn_delete_event" data-url="{{ route('events.destroy', $event) }}" data-title="{{ $event->title }}">@lang('Delete')</button>
        @endisset
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
    </div>
</form>