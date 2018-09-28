@extends("$layout.app")

@push('styles')
    <link href="{{ asset('js/department/events/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/department/events/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/department/events/index.js') }}"></script>
@endpush

@section('title', __('Event'))

@section('content')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => 'events.index'])

    <div class="m-content">
        <flash message="{{ session('message') }}"></flash>
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => __('Event'), 'model' => 'event', 'createUrl' => route('events.create'), 'isModal' => true])
            <div class="m-portlet__body">
                <div id="m_calendar"></div>
            </div>
        </div>
    </div>
@endsection