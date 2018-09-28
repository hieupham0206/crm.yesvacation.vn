@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.index'];
@endphp@extends("$layout.app")

@push('scripts')
    <script src="{{ asset('js/admin/users/index.js') }}"></script>
@endpush

@section('title', $user->classLabel())

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('layouts.partials.index_header', ['modelName' => $user->classLabel(true), 'model' => 'user', 'createUrl' => route('users.create'), 'editUrl' => ''])
            <div class="m-portlet__body">
                @include('layouts.partials.search', ['form' => view('admin.users._search')->with('user', $user)])
                <table class="table table-borderless table-hover nowrap" id="table_users"  width="100%">
                    <thead>
                    <tr>
                        <th width="5%"><label class="m-checkbox m-checkbox--all m-checkbox--solid m-checkbox--brand"><input type="checkbox"><span></span></label></th>
                        <th>{{ $user->label('username') }}</th>
                        <th>{{ $user->label('name') }}</th>
                        <th>{{ $user->label('phone') }}</th>
                        <th>{{ $user->label('email') }}</th>
                        <th>{{ $user->label('state') }}</th>
                        <th>{{ $user->label('last_login') }}</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

