@extends("$layout.app")@section('title', __('Reception'))

@push('scripts')
    <script src="{{ asset('js/reception.js') }}"></script>
@endpush

@section('content')
    <div class="m-content my-3">
        <input type="hidden" id="txt_user_id" value="{{ auth()->id() }}">
        <input type="hidden" id="txt_lead_id" value="">
        <div class="row">
            <div class="col-xl-6 col-lg-12">
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
                                    <th>{{ $lead->label('appointment_datetime') }}</th>
                                    <th>{{ $lead->label('title') }}</th>
                                    <th>{{ $lead->label('name') }}</th>
                                    <th>{{ $lead->label('phone') }}</th>
                                    <th>{{ $lead->label('code') }}</th>
                                    <th>{{ $lead->label('Tele marketer') }}</th>
                                    <th>{{ $lead->label('comment') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="m-portlet ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Event Data</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="200" data-scrollbar-shown="true">
                            <table class="table table-borderless table-hover nowrap" id="table_event_data" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ $lead->label('date') }}</th>
                                    <th>{{ $lead->label('title') }}</th>
                                    <th>{{ $lead->label('name') }}</th>
                                    <th>{{ $lead->label('phone') }}</th>
                                    <th>{{ $lead->label('code') }}</th>
                                    <th>{{ $lead->label('note') }}</th>
                                    <th>{{ $lead->label('TO') }}</th>
                                    <th>{{ $lead->label('REP') }}</th>
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
                                <h3 class="m-portlet__head-text">Customer Info</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="200" data-scrollbar-shown="true">
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
                                            <span id="span_lead_title"></span>
                                            {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_lead_name">{{ $lead->label('name') }}</label>
                                            <span id="span_lead_name"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_lead_phone">{{ $lead->label('phone') }}</label>
                                            <span id="span_lead_phone"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_appointment_datetime">{{ $lead->label('datetime') }}</label>
                                            <span id="span_appointment_datetime"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_tele_marketer">{{ $lead->label('tele_marketer') }}</label>
                                            <span id="span_tele_marketer"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-8 m-form__group-sub">
                                            <button class="btn btn-success m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                                <span><i class="fa fa-check"></i><span>@lang('Show up')</span></span>
                                            </button>
                                            <button class="btn btn-danger m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                                <span><i class="fa fa-ban"></i><span>@lang('Not')</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="m-portlet ">
                    {{--<div class="m-portlet__head">--}}
                        {{--<div class="m-portlet__head-caption">--}}
                            {{--<div class="m-portlet__head-title">--}}
                                {{--<h3 class="m-portlet__head-text">Customer Info</h3>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="m-portlet__body">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="200" data-scrollbar-shown="true">
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
                                            <span id="span_lead_title"></span>
                                            {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_lead_name">{{ $lead->label('name') }}</label>
                                            <span id="span_lead_name"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_lead_phone">{{ $lead->label('phone') }}</label>
                                            <span id="span_lead_phone"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_appointment_datetime">{{ $lead->label('datetime') }}</label>
                                            <span id="span_appointment_datetime"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-4 m-form__group-sub">
                                            <label for="span_tele_marketer">{{ $lead->label('tele_marketer') }}</label>
                                            <span id="span_tele_marketer"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-8 m-form__group-sub">
                                            <button class="btn btn-success m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                                <span><i class="fa fa-check"></i><span>@lang('Show up')</span></span>
                                            </button>
                                            <button class="btn btn-danger m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                                <span><i class="fa fa-ban"></i><span>@lang('Not')</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection