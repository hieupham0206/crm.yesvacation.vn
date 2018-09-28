<div class="modal-header">
    <h5 class="modal-title">@lang('Activity log detail')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="m-scrollable" data-scrollable="true" data-height="200" data-mobile-height="200">
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <div class="form-group m-form__group">
                    <label for="txt_log_type">{{ __('Log type') }}</label>
                    <input type="text" class="form-control m-input--solid" readonly id="txt_log_type" value="{{ $log->log_name }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-form__group">
                    <label for="txt_cause_by">{{ __('Cause by') }}</label>
                    <input type="text" class="form-control m-input--solid" readonly id="txt_cause_by" value="{{ optional($log->causer)->username }}">
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <div class="form-group m-form__group">
                    <label for="txt_date">{{ __('Date') }}</label>
                    <input type="text" class="form-control m-input--solid" readonly id="txt_date" value="{{ $log->created_at->format('d/m/Y H:i:s') }}">
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <div class="form-group m-form__group">
                    <label for="textarea_description">{{ __('Description') }}</label>
                    <textarea id="textarea_description" cols="30" rows="5" class="form-control m-input--solid" readonly>{{ $log->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <div class="form-group m-form__group">
                    <label for="textarea_properties">{{ __('Properties') }}</label>
                    <textarea id="textarea_properties" cols="30" rows="5" class="form-control m-input--solid" readonly>{{ $log->properties }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
</div>