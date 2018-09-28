@extends('layouts.login')@section('title', __('Register'))

@section('content')
    <div class="m-login__container">
        <div class="m-login__logo">
            <a href="#">
                <img src="{{ asset('images/logo.png') }}">
            </a>
        </div>
        <div class="m-login__signin">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-login__form m-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group m-form__group">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} m-input" name="name" placeholder="{{ __('Full name') }}" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input" placeholder="{{ __('Password') }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group m-form__group">
                    <input id="password-confirm" type="password" class="form-control m-input" name="password_confirmation" placeholder="{{ __('Confirm password') }}" required>
                </div>
                <div class="m-login__form-action">
                    <button type="submit" class="btn btn-sm btn-brand m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                        @lang('Register')
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-outline-brand m-btn m-btn--pill m-btn--custom m-login__btn">
                        @lang('Back')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
