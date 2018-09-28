@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.edit', 'model' => $user];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/users/form.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => $user->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('admin.users._form', ['method' => 'put', 'action' => route('users.update', $user), 'groups' => $groups, 'permissions' => $permissions])
        </div>
    </div>
@endsection

