@extends('layouts.login')

@section('content')
    <div class="m-login__container">
        <div class="m-login__logo">
            <img src="{{ asset('images/logo.png') }}">
        </div>
        <div class="m-login__signin">
            <form class="m-login__form m-form m-form--state" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group m-form__group {{ $errors->has('username') ? 'has-danger' : ''}}">
                    <input id="username" type="text" class="form-control m-input" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}" title="{{ __('Username or Email') }}" required autofocus autocomplete="off">
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('otp_error'))
                        <span class="help-block">
                            <strong>{{ $errors->first('otp_error') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : ''}}">
                    <input id="password" type="password" class="form-control m-input m-login__form-input--last" name="password" placeholder="{{ __('Password') }}" title="{{ __('Password') }}" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row m-login__form-sub ml-0 mr-0 p-0">
                    <div class="col m--align-left m-login__form-left pl-0">
                        <label class="m-checkbox m-checkbox--brand">
                            <input type="checkbox" class="m-brand" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember me')
                            <span></span>
                        </label>
                    </div>
                    <div class="col m--align-right m-login__form-right pr-0">
                        <a href="{{ route('password.request') }}" id="m_login_forget_password" class="m-link m--font-bolder">
                            @lang('Forget password') ?
                        </a>
                    </div>
                </div>
                <div class="m-login__form-action mt-0">
                    <button id="m_login_signin_submit" type="submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                        @lang('Sign in')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
