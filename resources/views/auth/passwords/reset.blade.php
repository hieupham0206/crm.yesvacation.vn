@extends('layouts.login')@section('title', __('Reset password'))

@section('content')
    <div class="m-login__container">
        <div class="m-login__logo">
            <a href="#">
                <img src="{{ asset('images/logo.png') }}">
            </a>
        </div>
        <div class="m-login__signin">
            <div class="m-login__head">
                <h3 class="m-login__title">@yield('title')</h3>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-login__form m-form m-form--state" method="POST" action="{{ route('password.request') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group m-form__group row">
                    <input id="email" type="text" placeholder="{{ __('Username') }}" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} m-input" name="username" value="" required autofocus autocomplete="off">
                    @if ($errors->has('username'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group row">
                    <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group row">
                    <input id="password-confirm" placeholder="{{ __('Confirm password') }}" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} m-input" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="m-login__form-action">
                    <button type="submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                        @lang('Reset password')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
