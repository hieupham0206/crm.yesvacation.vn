@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/department/events/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => __('Event')]))

@section('content')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => 'events.create'])

    <div class="m-content">
        <flash message="{{ session('message') }}"></flash>
        <div class="m-portlet">
			@include('department.events._form', ['event' => null, 'action' => route('events.store')])
        </div>
    </div>
@endsection