<form id="change_state_leads_form" class="m-form m-form--state" method="post" action="{{ route('leads.change_state', $lead) }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('Change status')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @csrf
        <div class="m-portlet__body">
            <div role="alert" class="alert alert-dismissible fade show m-alert m-alert--air alert-danger" style="display: none;">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"></button>
                <strong></strong>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6 m-form__group-sub">
                    <label for="select_state_modal">{{ $lead->label('state') }}</label>
                    <select name="state" class="form-control select" id="select_state_modal">
                        <option></option>
                        @foreach ($lead->states as $key => $state)
                            <option value="{{ $key }}" {{ $lead->state == $key || (! $lead->exists && $key === 1) ? ' selected' : '' }}>{{ $state }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('comment') ? 'has-danger' : ''}}">
                    <label for="textarea_comment">{{ $lead->label('comment') }}</label>
                    <textarea class="form-control" rows="5" name="comment" id="textarea_comment">{{ $lead->comment ?? ''}}</textarea>
                    {!! $errors->first('comment', '<div class="form-control-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
        <button type="button" class="btn btn-secondary m-btn--custom m-btn--icon" data-dismiss="modal">
            <span>
                <i class="fa fa-ban"></i>
                <span>@lang('Close')</span>
            </span>
        </button>
    </div>
</form>