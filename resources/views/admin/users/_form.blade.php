@php /** @var \App\Models\User $user */ @endphp
<form id="users_form" class="m-form m-form--group-seperator-dashed m-form--state" method="post" action="{{ $action }}" data-confirm="false">
    @csrf
    @isset($method)
        @method('put')
    @endisset
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('username') ? 'has-danger' : ''}}">
                <label for="txt_username">{{ $user->label('username') }}</label>
                @if ($user->exists)
                    <input type="text" name="username" id="txt_username" class="form-control m-input m-input--solid" value="{{ $user->username ?? old('username') }}" readonly autocomplete="off">
                @else
                    <input type="text" name="username" id="txt_username" class="form-control m-input" placeholder="{{ __('Enter value') }}" autocomplete="off" required>
                @endif
                <span class="m-form__help"></span>
                {!! $errors->first('username', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="txt_email">{{ $user->label('email') }}</label>
                <input type="email" name="email" id="txt_email" class="form-control m-input" placeholder="{{ __('Enter value') }}" value="{{ $user->email ?? old('email') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('email', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('password') ? 'has-danger' : ''}}">
                <label for="select_role">{{ $user->label('Password') }}</label>
                <input type="password" id="txt_password" name="password" class="form-control m-input" placeholder="{{ __('Enter value') }}" data-value="{{ $user ? $user->password : '' }}"
                       data-msg-pwCheck="{{ __('validation.custom.password.regex') }}">
                <span class="m-form__help"></span>
                {!! $errors->first('password', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                <label for="select_role">{{ $user->label('Confirm password') }}</label>
                <input type="password" name="password_confirmation" class="form-control m-input" placeholder="{{ __('Enter value') }}">
                <span class="m-form__help"></span>
                {!! $errors->first('password_confirmation', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="txt_name">{{ $user->label('name') }}</label>
                <input type="text" name="name" id="txt_name" class="form-control m-input" placeholder="{{ __('Enter value') }}" value="{{ $user->name ?? old('name') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('name', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('role_id') ? 'has-danger' : ''}}">
                <label for="select_role">{{ $user->label('Role') }}</label>
                <select name="role_id" id="select_role" class="form-control select2-ajax" data-url="{{ route('roles.list') }}">
                    <option></option>
                    @if (isset($roles) && $roles)
                        <option value="{{ $roles[0]['id'] }}" selected>{{ $roles[0]['name'] }}</option>
                    @endif
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('role_id', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('state') ? 'has-danger' : ''}}">
                <label for="select_state">{{ $user->label('State') }}</label>
                <select name="state" class="form-control select" id="select_state">
                    <option></option>
                    @foreach ($user->states as $key => $state)
                        <option value="{{ $key }}" {{ $user->state == $key ? ' selected' : '' }}>{{ $state }}</option>
                    @endforeach
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('state', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('use_otp') ? 'has-danger' : ''}}">
                <label for="select_use_otp">{{ $user->label('use_otp') }}</label>
                <select name="use_otp" class="form-control select" id="select_use_otp">
                    <option></option>
                    @foreach ($user->confirmations as $key => $confirmation)
                        <option value="{{ $key }}" {{ $user->use_otp == $key ? ' selected' : '' }}>{{ $confirmation }}</option>
                    @endforeach
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('use_otp', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--head-sm m-portlet--collapse portlet-search" data-portlet="true">
                    <a href="javascript:void(0)" class="m-portlet__nav-link m-portlet__nav-link--icon portlet-toggle-link">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">@lang('Direct permission')</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="m-portlet__body open">
                        <div class="form-group m-form__group row">
                            <div class="col-md-12">
                                @include('admin.roles._permission_table', ['groups' => $groups, 'isCreate' => ! $user->exists, 'disabled' => false ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
        <div class="m-form__actions m-form__actions--right">
            <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-ban"></i><span>@lang('Cancel')</span></span></a>
        </div>
    </div>
</form>