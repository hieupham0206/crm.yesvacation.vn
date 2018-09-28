<form id="form_change_password" class="m-login__form m-form m-form--state" method="POST" action="{{ route('users.change_password', $user) }}">
    <div class="modal-header">
        <h5 class="modal-title">@lang('Reset password')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="m-scrollable" data-scrollable="true" data-height="500" data-mobile-height="500">
            @csrf
            <div role="alert" class="alert alert-dismissible fade show m-alert m-alert--air alert-danger" style="display: none;">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"></button>
                <strong></strong>
            </div>
            <div class="form-group m-form__group">
                <label>{{ __('Current password') }}</label>
                <input id="current_password" type="password" placeholder="{{ __('Enter value') }}" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }} m-input" name="current_password" required autofocus>
            </div>
            <div class="form-group m-form__group">
                <label>{{ __('Password') }}</label>
                <input id="password" placeholder="{{ __('Enter value') }}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input" name="password" required>
            </div>
            <div class="form-group m-form__group">
                <label>{{ __('Confirm password') }}</label>
                <input id="password-confirm" placeholder="{{ __('Enter value') }}" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} m-input" name="password_confirmation" required>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-brand  m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Reset password')</span></span></button>
        <button type="button" class="btn btn-secondary m-btn--icon m-btn--custom" data-dismiss="modal"><span><i class="fa fa-window-close"></i><span>@lang('Close')</span></span></button>
    </div>
</form>