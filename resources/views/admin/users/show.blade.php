@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.show', 'model' => $user];
@endphp@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => $user->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>{{ $user->label('username') }}</th>
                            <td>{{ $user->username }} </td>
                        </tr>
                        <tr>
                            <th>{{ $user->label('email') }}</th>
                            <td>{{ $user->email }} </td>
                        </tr>
                        <tr>
                            <th>{{ $user->label('role') }}</th>
                            <td> {{ optional($user->roles)[0]['name'] }} </td>
                        </tr>
                        <tr>
                            <th>{{ $user->label('state') }}</th>
                            <td>{!! $user->state_text !!} </td>
                        </tr>
                        <tr>
                            <th> {{ $user->label('created_at') }} </th>
                            <td> {{ $user->created_at }} </td>
                        </tr>
                        <tr>
                            <th> {{ $user->label('last_login') }} </th>
                            <td> {{ $user->last_login }} </td>
                        </tr>
                        <tr>
                            <th> {{ $user->label('use_otp') }} </th>
                            <td> {{ $user->is_use_otp }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if (can('view-log'))
                    <div class="m-portlet m-portlet--head-sm m-portlet--collapse portlet-search" data-portlet="true">
                        <a href="javascript:void(0)" class="m-portlet__nav-link m-portlet__nav-link--icon portlet-toggle-link">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">@lang('Activity log')</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="m-portlet__body open">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-12">
                                    <table class="table table-hovered table-bordered datatables" id="table_orders_log">
                                        <thead class="">
                                        <tr>
                                            <th>{{ $user->label('Description') }}</th>
                                            <th>{{ $user->label('Properties') }}</th>
                                            <th>{{ $user->label('Created at') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($logs as $key => $log)
                                            <tr>
                                                <td>{!! $log->description  !!}</td>
                                                <td>{!! $log->properties  !!}</td>
                                                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--right">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-edit"></i><span>@lang('Edit')</span></span></a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-arrow-left"></i><span>@lang('Back')</span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

