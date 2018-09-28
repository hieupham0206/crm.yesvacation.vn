@php
    $breadcrumbs = ['breadcrumb' => 'permissions.edit', 'model' => $permission];
@endphp
@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/admin/permissions/form.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => lcfirst(__('Permission'))]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('admin.permissions._form', ['method' => 'put', 'action' => route('permissions.update', $permission->module)])
        </div>
    </div>
@endsection