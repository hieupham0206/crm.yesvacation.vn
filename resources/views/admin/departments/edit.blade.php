@php /** @var \App\Models\Department $department */
$breadcrumbs = ['breadcrumb' => 'departments.edit', 'model' => $department];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/admin/departments/form.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => $department->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('admin.departments._form', ['method' => 'put', 'action' => route('departments.update', $department)])
        </div>
    </div>
@endsection