@php
    $breadcrumbs = ['breadcrumb' => 'activity_logs.index', 'label' => __('Activity log')];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/activity_logs/index.js') }}"></script>
@endpush

@section('title', __('Activity log'))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => __('Activity log'), 'model' => 'log', 'createUrl' => '', 'quickAction' => false])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.activity_logs._search')])
                <table class="table table-borderless table-hover nowrap" id="table_logs" style="width:100%">
                    <thead>
                    <tr>
                        <th>@lang('Log type')</th>
                        <th>@lang('Cause by')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection