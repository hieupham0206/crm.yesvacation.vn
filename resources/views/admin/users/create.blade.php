@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.create', 'model' => $user];
@endphp

@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/users/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => $user->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('admin.users._form', ['user' => $user, 'action' => route('users.store'), 'groups' => $groups])
        </div>
    </div>
@endsection