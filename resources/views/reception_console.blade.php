@extends("$layout.app")@section('title', __('Home'))

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush

@section('content')
    <div class="m-content my-3">
        <input type="hidden" id="txt_user_id" value="{{ auth()->id() }}">
        <input type="hidden" id="txt_lead_id" value="{{ $lead->id }}">
        <div class="row">
            <div class="col-xl-8 col-lg-12">
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
            </div>
            <div class="col-xl-4 col-lg-12">
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
        </div>
    </div>
@endsection