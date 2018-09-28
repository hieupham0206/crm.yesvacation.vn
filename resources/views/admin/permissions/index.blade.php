@php
    $breadcrumbs = ['breadcrumb' => 'permissions.index'];
@endphp
@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/permissions/index.js') }}"></script>
@endpush

@section('title', $permission->classLabel())

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => $permission->classLabel(), 'model' => 'permission', 'createUrl' => null])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.permissions._search')->with('permission', $permission)])
                <table class="table table-borderless table-hover nowrap" id="table_permissions" data-url="{{ route('permissions.table') }}" width="100%">
                    <thead>
                    <tr>
                        <th width="5%"><label class="m-checkbox m-checkbox--all m-checkbox--solid m-checkbox--brand"><input type="checkbox"><span></span></label></th>
                        <th>@lang('Module')</th>
                        <th>@lang('Permission')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection