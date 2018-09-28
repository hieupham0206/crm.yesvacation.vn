@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'roles.show', 'model' => $role];
@endphp
@extends("$layout.app")

@push('scripts')
    <style>
        td,
        th {
            vertical-align: top !important;
        }
    </style>
    <script src="{{ asset('js/admin/roles/form.js') }}"></script>
@endpush

@section('title', __('action.View Model', ['model' => lcfirst(__('Role'))]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-form">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <div class="form-group m-form__group">
                                <label for="txt_name">{{ __('Role') }}</label>
                                <input class="form-control" name="name" type="text" id="txt_name" value="{{ $role->name or ''}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            @include('admin.roles._permission_table', ['groups' => $groups, 'disabled' => true ])
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--right">
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-brand">@lang('Edit')</a>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">@lang('Back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
