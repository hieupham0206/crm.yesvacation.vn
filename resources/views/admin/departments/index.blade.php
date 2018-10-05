@php /** @var \App\Models\department $department */
$breadcrumbs = ['breadcrumb' => 'departments.index'];
@endphp

@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/departments/index.js') }}"></script>
@endpush

@section('title', $department->classLabel())

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => $department->classLabel(true), 'model' => 'department', 'createUrl' => route('departments.create')])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.departments._search')->with('department', $department)])
                <table class="table table-borderless table-hover nowrap" id="table_departments" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"><label class="m-checkbox m-checkbox--all m-checkbox--solid m-checkbox--brand"><input type="checkbox"><span></span></label></th>
                            <th>{{ $department->label('name') }}</th><th>{{ $department->label('province id') }}</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection