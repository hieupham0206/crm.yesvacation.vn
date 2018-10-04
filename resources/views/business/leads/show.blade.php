@php /** @var \App\Models\Lead $lead */
$breadcrumbs = ['breadcrumb' => 'leads.show', 'model' => $lead];
@endphp@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => $lead->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th> {{ $lead->label('name') }} </th>
                            <td> {{ $lead->name }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('title') }} </th>
                            <td> {{ $lead->title }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('email') }} </th>
                            <td> {{ $lead->email }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('gender') }} </th>
                            <td> {{ $lead->gender_text }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('birthday') }} </th>
                            <td> {{ $lead->birthday }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('address') }} </th>
                            <td> {{ $lead->address }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('phone') }} </th>
                            <td> {{ $lead->phone }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('state') }} </th>
                            <td> {{ $lead->state_text }} </td>
                        </tr>
                        <tr>
                            <th> {{ $lead->label('comment') }} </th>
                            <td> {{ $lead->comment }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
                    <div class="m-form__actions m-form__actions--right">
                        @if (can('update-lead'))
                            <a href="{{ route('leads.edit', $lead) }}" class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-edit"></i><span>@lang('Edit')</span></span></a>
                        @endif
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-arrow-left"></i><span>@lang('Back')</span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
