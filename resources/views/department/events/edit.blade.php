@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/department/events/form.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => __('Event')]))

@section('content')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => 'events.edit', 'model' => $event])

    <div class="m-content">
        <flash message="{{ session('message') }}"></flash>
        <div class="m-portlet">
            @include('department.events._form', ['method' => 'put', 'action' => route('events.update', $event)])
        </div>
    </div>
@endsection