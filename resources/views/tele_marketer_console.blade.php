@extends("$layout.app")@section('title', __('Home'))

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush

@section('content')
    <div class="m-content my-3">
        <input type="hidden" id="txt_user_id" value="{{ auth()->id() }}">
        <input type="hidden" id="txt_lead_id" value="{{ $lead->id }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Customer No: <span id="span_customer_no">0</span></h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <label for="" class="mr-3 label-span-time">Login time: <span id="span_login_time" class="span-time" data-diff-login-time="{{ $diffLoginString }}"></span></label>
                            <label for="" class="mr-3 label-span-time">Pause time: <span id="span_pause_time" class="span-time" data-diff-break-time="{{ $diffBreakString }}" data-max-break-time="{{ $maxBreakTime }}">00:00:00</span></label>
                            <button class="btn btn-brand btn-sm m-btn m-btn--icon m-btn--custom mr-2" id="btn_pause" data-url="{{ route('users.form_break') }}">
                                <span><i class="fa fa-pause"></i><span>@lang('Pause')</span></span>
                            </button>
                            <button class="btn btn-brand btn-sm m-btn m-btn--icon m-btn--custom" id="btn_resume" data-url="{{ route('users.resume') }}" style="display: none">
                                <span><i class="fa fa-play"></i><span>@lang('Resume')</span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Customer Info</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <span class="m-portlet__head-text">Type call: <span id="span_call_type">Auto</span></span>
                            <span class="m-portlet__head-text ml-3 span-auto-call-time">Time: <span id="span_call_time" class="span-time">00:00:00</span></span>
                        </div>
                    </div>
                    <form id="leads_form" class="m-form m-form--label-align-right m-form--state" method="post" action="{{ route('leads.update', $lead) }}">
                        <div class="m-portlet__body">
                            {{--<div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="300" data-scrollbar-shown="true">--}}
                            @csrf
                            @isset($method)
                                @method('put')
                            @endisset
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-4 m-form__group-sub">
                                    <label for="span_lead_title">{{ $lead->label('title') }}</label>
                                    <span id="span_lead_title">{{ $lead->title }}</span>
                                    <span class="m-form__help"></span>
                                    {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-12 col-md-4 m-form__group-sub">
                                    <label for="span_lead_name">{{ $lead->label('name') }}</label>
                                    <span id="span_lead_name">{{ $lead->name }}</span>
                                </div>
                                <div class="col-sm-12 col-md-4 m-form__group-sub">
                                    <label for="span_lead_birthday">{{ $lead->label('birthday') }}</label>
                                    <span id="span_lead_birthday">{{ optional($lead->birthday)->format('d-m-Y') }}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-8 m-form__group-sub">
                                    <label for="span_lead_phone">{{ $lead->label('phone') }}</label>
                                    <span class="font-weight-bold m--font-danger m--icon-font-size-lg4 ml-3" id="span_lead_phone">{{ $lead->phone }}</span>
                                </div>
                                <div class="col-sm-12 col-md-4 m-form__group-sub">
                                    <button class="btn btn-brand m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                        <span><i class="fa fa-save"></i><span>@lang('New Customer')</span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">Customer History</h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="200" data-scrollbar-shown="true">
                                <table class="table table-borderless table-hover nowrap" id="table_customer_history" width="100%">
                                    <thead>
                                    <tr>
                                        <th>{{ $lead->label('created_at') }}</th>
                                        <th>{{ $lead->label('state') }}</th>
                                        <th>{{ $lead->label('comment') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">History Call</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="200" data-mobile-height="200">
                            <table class="table table-borderless table-hover nowrap" id="table_history_calls" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ $lead->label('created_at') }}</th>
                                    <th>{{ $lead->label('state') }}</th>
                                    <th>{{ $lead->label('comment') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12">
                <div class="m-portlet ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Call Back List</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="200" data-scrollbar-shown="true">
                            <table class="table table-borderless table-hover nowrap" id="table_callback" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ $lead->label('name') }}</th>
                                    <th>{{ $lead->label('title') }}</th>
                                    <th>{{ $lead->label('created_at') }}</th>
                                    <th>{{ $lead->label('actions') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Appointment List</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="412" data-scrollbar-shown="true">
                            <table class="table table-borderless table-hover nowrap" id="table_appointment" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ $lead->label('name') }}</th>
                                    <th>{{ $lead->label('title') }}</th>
                                    <th>{{ $lead->label('appointment_datetime') }}</th>
                                    <th>{{ $lead->label('comment') }}</th>
                                    <th>{{ $lead->label('actions') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection