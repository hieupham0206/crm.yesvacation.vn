<form id="break_form" class="m-form m-form--state" method="post" action="{{ route('users.break') }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('Pause reason')</h5>
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
                    <label for="select_reason_break">{{ $user->label('reason_break') }}</label>
                    <select name="reason_break_id" class="form-control select" id="select_reason_break" required>
                        <option></option>
                        @foreach ($reasonBreaks as $reasonBreak)
                            <option value="{{ $reasonBreak->id }}">{{ $reasonBreak->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-6 m-form__group-sub" id="another_reason_section" style="display: none">
                    <label for="textarea_reason">{{ $user->label('reason') }}</label>
                    <textarea class="form-control" rows="5" name="reason" id="textarea_reason"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('OK')</span></span></button>
        <button type="button" class="btn btn-secondary m-btn--custom m-btn--icon" data-dismiss="modal">
            <span>
                <i class="fa fa-ban"></i>
                <span>@lang('Close')</span>
            </span>
        </button>
    </div>
</form>