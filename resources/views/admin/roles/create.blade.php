@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'roles.create', 'model' => $role];
@endphp
@extends("$layout.app")

@push('styles')
    <style>
        td,
        th {
            vertical-align: top !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/roles/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => $role->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            <form id="role_form" class="m-form m-form--state" method="post" action="{{ route('roles.store') }}">
                @csrf
                <div class="m-portlet__body">
                    <flash></flash>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : ''}}">
                                <label for="txt_name">{{ $role->label('role') }}</label>
                                <input class="form-control" name="name" type="text" id="txt_name" value="{{ $role->name or ''}}" required autocomplete="off">
                                {!! $errors->first('name', '<div class="form-control-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            @include('admin.roles._permission_table', ['groups' => $groups, 'isCreate' => true, 'disabled' => false ])
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--right">
                        <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-ban"></i><span>@lang('Cancel')</span></span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
