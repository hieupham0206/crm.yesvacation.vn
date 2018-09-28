@php
    $breadcrumbs = ['breadcrumb' => 'permissions.create', 'model' => $permission];
@endphp
@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/admin/permissions/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => lcfirst(__('Permission'))]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
			@include('admin.permissions._form', ['permission' => null, 'action' => route('permissions.store')])
        </div>
    </div>
@endsection