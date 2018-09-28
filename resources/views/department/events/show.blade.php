@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => __('Event')]))

@section('content')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => 'events.show', 'model' => $event])

    <div class="m-content">
        <flash message="{{ session('message') }}"></flash>
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr><th> {{ __('Name') }} </th><td> {{ $event->name }} </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--left">
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-brand">@lang('Edit')</a>
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">@lang('Back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
