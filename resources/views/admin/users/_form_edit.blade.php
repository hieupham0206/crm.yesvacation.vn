<form id="users_form" class="m-form m-form--state" method="post" action="{{ $action }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('action.Edit Model', ['model' => lcfirst(__('User'))])</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @csrf
        @method('put')
        <div class="m-portlet__body">
            <flash></flash>
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="form-group m-form__group {{ $errors->has('state') ? 'has-danger' : ''}}">
                        <label for="select_state">{{ __('State') }}</label>
                        <select name="state" class="form-control select" id="select_state">
                            <option></option>
                            <option value="0">@lang('Inactive')</option>
                            <option value="1">@lang('Active')</option>
                        </select>
                        <span class="m-form__help"></span>
                        {!! $errors->first('state', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group m-form__group {{ $errors->has('role_id') ? 'has-danger' : ''}}">
                        <label for="select_role">@lang('Role'):</label>
                        <select name="role_id" id="select_role" class="form-control m-select2" data-url="{{ route('roles.list') }}">
                            <option></option>
                        </select>
                        <span class="m-form__help"></span>
                        {!! $errors->first('role_id', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : ''}}">
                        <label for="">@lang('Password'):</label>
                        <input type="password" id="txt_password" name="password" class="form-control m-input" placeholder="{{ __('Enter value') }}">
                        {!! $errors->first('password', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group m-form__group {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                        <label for="">@lang('Confirm password'):</label>
                        <input type="password" name="password_confirmation" class="form-control m-input" placeholder="{{ __('Enter value') }}">
                        {!! $errors->first('password_confirmation', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-brand">@lang('Save')</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
    </div>
</form>
<script src="{{ asset('js/admin/users/form.js') }}"></script>