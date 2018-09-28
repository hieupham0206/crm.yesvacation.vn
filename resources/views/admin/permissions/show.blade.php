@php
    $breadcrumbs = ['breadcrumb' => 'permissions.show', 'model' => $permission];
@endphp
@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => lcfirst(__('Permission'))]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr><th> {{ __('Name') }} </th><td> {{ $permission->name }} </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--right">
                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-brand">@lang('Edit')</a>
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">@lang('Back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
