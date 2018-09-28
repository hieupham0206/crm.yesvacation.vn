@php
$breadcrumbs = ['breadcrumb' => 'translation_managers.index',  'label' =>  __('Translation manager')];
@endphp
@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/translation_managers/index.js') }}"></script>
@endpush

@section('title', __('Translation manager'))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => __('Translation manager'), 'model' => 'log', 'createUrl' => ''])
            <div class="m-portlet__body">
                <table class="table table-borderless table-hover nowrap" id="table_translation_managers" style="width:100%" data-url="{{ route('translation_managers.table') }}">
                    <thead>
                    <tr>
                        <th>@lang('Key')</th>
                        <th>@lang('Translated text')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection