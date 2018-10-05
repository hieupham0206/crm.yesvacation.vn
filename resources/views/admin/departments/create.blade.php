@php /** @var \App\Models\Department $department */
$breadcrumbs = ['breadcrumb' => 'departments.create', 'model' => $department];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/admin/departments/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => $department->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
			@include('admin.departments._form', ['department' => $department, 'action' => route('departments.store')])
        </div>
    </div>
@endsection