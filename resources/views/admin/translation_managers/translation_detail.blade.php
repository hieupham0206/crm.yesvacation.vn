<form id="form_edit_translation" action="{{ route('translation_managers.update_detail') }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('Edit Translation: ') {{ $key }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="m-scrollable" data-scrollable="true" data-height="200" data-mobile-height="200">
            @csrf
            @method('put')
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    <div class="form-group m-form__group">
                        <label for="txt_key">Key</label>
                        <input type="text" class="form-control" readonly id="txt_key" name="key" value="{{ $key }}">
                    </div>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-12">
                    <div class="form-group m-form__group">
                        <label for="textarea_translate_text">{{ __('Translated Text') }}</label>
                        <textarea id="textarea_translate_text" cols="30" rows="5" class="form-control" name="text">{{ $translatedText }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
        <button type="submit" class="btn btn-brand">@lang('Save')</button>
    </div>
</form>