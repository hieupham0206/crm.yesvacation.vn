@php /** @var \App\Models\Role $role */
$breadcrumbs = ['breadcrumb' => 'roles.index'];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/roles/index.js') }}"></script>
@endpush

@section('title', $role->classLabel())

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => $role->classLabel(true), 'model' => 'user', 'createUrl' => route('roles.create')])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.roles._search')->with('role', $role)])
                <table class="table table-borderless table-hover nowrap" id="table_roles" width="100%">
                    <thead>
                    <tr>
                        {{--<th width="5%"><label class="m-checkbox m-checkbox--all m-checkbox--solid m-checkbox--brand"><input type="checkbox"><span></span></label></th>--}}
                        <th>@lang('Role')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection