@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/system_logs/index.js') }}"></script>
@endpush

@section('title', __('System Log'))

@section('content')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => 'system_logs.index'])
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => __('Activity Log'), 'model' => 'log', 'createUrl' => ''])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.system_logs._search')])
                <table class="table table-hover" id="table_system_logs" width="100%">
                    <thead>
                    <tr>
                        <th>@lang('Environment')</th>
                        <th>@lang('Level')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Content')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection