@php /** @var \App\Models\Lead $lead */ @endphp
<form id="new_leads_form" class="m-form m-form--label-align-right m-form--group-seperator-dashed m-form--state" method="post" action="{{ route('leads.store') }}">
    <div class="modal-header">
        <h5 class="modal-title">New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="m-scrollable" data-scrollable="true" data-height="500" data-mobile-height="500">
            @csrf
            @isset($method)
                @method('put')
            @endisset
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('title') ? 'has-danger' : ''}}">
                        <label for="select_title">{{ $lead->label('title') }}</label>
                        <select name="title" class="form-control select" id="select_title">
                            <option></option>
                            @foreach ($lead->titles as $key => $title)
                                <option value="{{ $title }}" {{ $lead->title == $title || (! $lead->exists && $key === 1) ? ' selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        <span class="m-form__help"></span>
                        {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('name') ? 'has-danger' : ''}}">
                        <label for="txt_name">{{ $lead->label('name') }}</label>
                        <input class="form-control" name="name" type="text" id="txt_name" value="{{ $lead->name ?? old('name')}}" required placeholder="{{ __('Enter value') }}" autocomplete="off">
                        <span class="m-form__help"></span>
                        {!! $errors->first('name', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('email') ? 'has-danger' : ''}}">
                        <label for="txt_email">{{ $lead->label('email') }}</label>
                        <input class="form-control" name="email" type="email" id="txt_email" value="{{ $lead->email ?? old('email')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                        <span class="m-form__help"></span>
                        {!! $errors->first('email', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('state') ? 'has-danger' : ''}}">
                        <label for="select_province">{{ $lead->label('province') }}</label>
                        <select name="province_id" class="form-control" id="select_province" data-url="{{ route('leads.provinces.table') }}">
                            <option></option>
                        </select>
                        <span class="m-form__help"></span>
                        {!! $errors->first('province', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('phone') ? 'has-danger' : ''}}">
                        <label for="txt_phone">{{ $lead->label('phone') }}</label>
                        <input class="form-control num text-left" name="phone" type="text" id="txt_phone" value="{{ $lead->phone ?? old('phone')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                        <span class="m-form__help"></span>
                        {!! $errors->first('phone', '<div class="form-control-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-sm-12 col-md-6 m-form__group-sub">
                        <label for="txt_spouse_name">{{ $lead->label('spouse_name') }}</label>
                        <input class="form-control" name="spouse_name" id="txt_spouse_name" value=""/>
                    </div>
                    <div class="col-sm-12 col-md-6 m-form__group-sub">
                        <label for="txt_spouse_phone">{{ $lead->label('spouse_phone') }}</label>
                        <input class="form-control" name="spouse_phone" id="txt_spouse_phone" value=""/>
                    </div>
                </div>
                {{--<div class="form-group m-form__group row">--}}
                    {{--<div class="col-sm-12 col-md-6 m-form__group-sub">--}}
                        {{--<label for="txt_to">{{ $lead->label('TO') }}</label>--}}
                        {{--<input class="form-control" name="to" type="text" id="txt_to" value="" placeholder="{{ __('Enter value') }}">--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-12 col-md-6 m-form__group-sub">--}}
                        {{--<label for="txt_rep">{{ $lead->label('REP') }}</label>--}}
                        {{--<input class="form-control" name="rep" type="text" id="txt_rep" value="" placeholder="{{ __('Enter value') }}">--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group m-form__group row">
                    <div class="col-sm-12 col-md-6 m-form__group-sub">
                        <label for="txt_voucher">{{ $lead->label('Voucher') }}</label>
                        <input class="form-control" name="voucher" type="text" id="txt_voucher" value="" placeholder="{{ __('Enter value') }}">
                    </div>
                    <div class="col-sm-12 col-md-6 m-form__group-sub">
                        <label for="txt_note">{{ $lead->label('Note') }}</label>
                        <textarea class="form-control" name="note" row="4" id="txt_note" placeholder="{{ __('Enter value') }}"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-brand  m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
        <button type="button" class="btn btn-secondary m-btn--icon m-btn--custom" data-dismiss="modal"><span><i class="fa fa-window-close"></i><span>@lang('Close')</span></span></button>
    </div>
</form>
