@extends('layouts.login')@section('title', __('Forget password'))

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
            <form class="m-login__form m-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group m-form__group">
                    <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input" name="email" value="{{ old('email') }}" required autocomplete="off">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="m-login__form-action">
                    <button type="submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                        @lang('Send')
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-outline-brand m-btn m-btn--pill m-btn--custom m-login__btn">
                        @lang('Back')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
