@extends("$layout.error")

@push('scripts')

@endpush

@section('title', __('auth.500'))

@section('content')
    <div class="m-content m-error_container mt-5">
        <div class="m-portlet">
            <div class="m-portlet__body text-center">
                <div class="m-error_number"><h1>500</h1></div>
                <h2>@lang('auth.Something wrong, please try again later')</h2>
                @if(auth()->check())
                    <a href="{{ route('home') }}" class="btn btn-brand">@lang('Dashboard')</a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('Back')</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-brand">@lang('Sign in')</a>
                @endif
            </div>
        </div>
    </div>
@endsection