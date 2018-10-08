@extends("$layout.app")@section('title', __('Home'))

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush

@section('content')
    <div class="m-content my-3">
        <input type="hidden" id="txt_user_id" value="{{ auth()->id() }}">
        <input type="hidden" id="txt_lead_id" value="{{ $lead->id }}">
        <div class="row">
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet  m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Customer Info</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <button class="btn btn-brand m-btn m-btn--icon m-btn--custom mr-2" id="btn_pause" data-url="{{ route('users.form_break') }}">
                                <span><i class="fa fa-pause"></i><span>@lang('Pause')</span></span>
                            </button>
                            <button class="btn btn-brand m-btn m-btn--icon m-btn--custom" id="btn_resume" data-url="{{ route('users.resume') }}">
                                <span><i class="fa fa-play"></i><span>@lang('Resume')</span></span>
                            </button>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form id="leads_form" class="m-form m-form--label-align-right m-form--group-seperator-dashed m-form--state" method="post" action="{{ route('leads.update', $lead) }}">
                            @csrf
                            @isset($method)
                                @method('put')
                            @endisset
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('name') ? 'has-danger' : ''}}">
                                        <label for="txt_name">{{ $lead->label('name') }}</label>
                                        <input class="form-control" name="name" type="text" id="txt_name" value="{{ $lead->name ?? old('name')}}" required placeholder="{{ __('Enter value') }}" autocomplete="off">
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('name', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('email') ? 'has-danger' : ''}}">
                                        <label for="txt_email">{{ $lead->label('email') }}</label>
                                        <input class="form-control" name="email" type="email" id="txt_email" value="{{ $lead->email ?? old('email')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('email', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('title') ? 'has-danger' : ''}}">
                                        <label for="select_title">{{ $lead->label('title') }}</label>
                                        {{--<input class="form-control" name="title" type="text" id="txt_title" value="{{ $lead->title ?? old('title')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">--}}
                                        <select name="title" class="form-control select" id="select_title" required>
                                            <option></option>
                                            @foreach ($lead->titles as $key => $title)
                                                <option value="{{ $key }}" {{ $lead->title == $title || (! $lead->exists && $key === 1) ? ' selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('birthday') ? 'has-danger' : ''}}">
                                        <label for="txt_birthday">{{ $lead->label('birthday') }}</label>
                                        <input class="form-control text-datepicker" name="birthday" type="text" id="txt_birthday" value="{{ $lead->birthday->format('d-m-Y') ?? old('birthday')}}" placeholder="{{ __('Enter value') }}"
                                               autocomplete="off">
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('birthday', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('address') ? 'has-danger' : ''}}">
                                        <label for="txt_address">{{ $lead->label('address') }}</label>
                                        <input class="form-control" name="address" type="text" id="txt_address" value="{{ $lead->address ?? old('address')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('address', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('phone') ? 'has-danger' : ''}}">
                                        <label for="txt_phone">{{ $lead->label('phone') }}</label>
                                        <input class="form-control" name="phone" type="text" id="txt_phone" value="{{ $lead->phone ?? old('phone')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('phone', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('state') ? 'has-danger' : ''}}">
                                        <label for="select_state">{{ $lead->label('state') }}</label>
                                        <select name="state" class="form-control select" id="select_state" required>
                                            <option></option>
                                            @foreach ($lead->states as $key => $state)
                                                <option value="{{ $key }}" {{ $lead->state == $key || (! $lead->exists && $key === 1) ? ' selected' : '' }}>{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        <span class="m-form__help"></span>
                                        {!! $errors->first('state', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-form__group-sub {{ $errors->has('comment') ? 'has-danger' : ''}}">
                                        <label for="textarea_comment">{{ $lead->label('comment') }}</label>
                                        <textarea class="form-control" rows="5" name="comment" id="textarea_comment">{{ $lead->comment ?? ''}}</textarea>
                                        {!! $errors->first('comment', '<div class="form-control-feedback">:message</div>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border" style="background: none">
                                <div class="m-form__actions m-form__actions--center">
                                    <button class="btn btn-brand m-btn m-btn--icon m-btn--custom" id="btn_form_change_state" data-url="{{ route('leads.form_change_state', $lead) }}">
                                        <span><i class="fa fa-save"></i><span>@lang('New Customer')</span></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--End::Portlet-->
            </div>
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">History Call</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-borderless table-hover nowrap" id="table_history_calls" width="100%">
                            <thead>
                            <tr>
                                <th>{{ $lead->label('name') }}</th>
                                <th>{{ $lead->label('title') }}</th>
                                <th>{{ $lead->label('created_at') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--End::Portlet-->
            </div>
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Call Back List</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-borderless table-hover nowrap" id="table_callback" width="100%">
                            <thead>
                            <tr>
                                <th>{{ $lead->label('name') }}</th>
                                <th>{{ $lead->label('title') }}</th>
                                <th>{{ $lead->label('created_at') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--End::Portlet-->
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Customer History</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-borderless table-hover nowrap" id="table_customer_history" width="100%">
                            <thead>
                            <tr>
                                <th>{{ $lead->label('created_at') }}</th>
                                <th>{{ $lead->label('state') }}</th>
                                <th>{{ $lead->label('comment') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--End::Portlet-->
            </div>
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">Appointment</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-borderless table-hover nowrap" id="table_appointment" width="100%">
                            <thead>
                            <tr>
                                <th>{{ $lead->label('name') }}</th>
                                <th>{{ $lead->label('title') }}</th>
                                <th>{{ $lead->label('created_at') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--End::Portlet-->
            </div>
        </div>
    </div>
@endsection