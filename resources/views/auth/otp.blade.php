@extends('layouts.login')@section('title', __('OTP'))

@push('scripts')
    <script src="{{ asset('js/auth/otp.js') }}"></script>
@endpush

@section('content')
    <div class="m-login__container">
        <div class="m-login__logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo_hmobile.png') }}" class="ml-3" style="max-width: 220px; height: auto;">
            </a>
        </div>
        <div class="m-login__signin">
            <div class="m-login__head">
                <h4 class="m-login__title">Mã OTP đã được gửi tới số điện thoại {{ $phone }}</h4>
                <flash></flash>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-login__form m-form" method="POST" action="{{ route('login_otp') }}">
                @csrf
                <div class="form-group m-form__group">
                    <input id="otp" placeholder="SMS OTP" type="text" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }} m-input" name="otp" value="{{ old('otp') }}" required autocomplete="off">
                    <input type="hidden" name="username" value="{{ $username }}">
                    <input type="hidden" name="password">
                    @if ($errors->has('otp'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('otp') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="m-login__form-action">
                    <button type="submit" class="btn btn-sm btn-brand m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                        @lang('Send')
                    </button>
                    <button type="button" id="btn_resend_otp" data-url="{{ route('resend_otp', compact('phone', 'username')) }}" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-login__btn">
                        @lang('Resend OTP')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
