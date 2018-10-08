@php /** @var \App\Models\Lead $lead */ @endphp
<form id="leads_form" class="m-form m-form--label-align-right m-form--group-seperator-dashed m-form--state" method="post" action="{{ $action }}">
    @csrf
    @isset($method)
        @method('put')
    @endisset
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
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
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('title') ? 'has-danger' : ''}}">
                <label for="select_title">{{ $lead->label('title') }}</label>
                {{--<input class="form-control" name="title" type="text" id="txt_title" value="{{ $lead->title ?? old('title')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">--}}
                <select name="state" class="form-control select" id="select_title" required>
                    <option></option>
                    @foreach ($lead->titles as $key => $title)
                        <option value="{{ $key }}" {{ $lead->title == $title || (! $lead->exists && $key === 1) ? ' selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('title', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('birthday') ? 'has-danger' : ''}}">
                <label for="txt_birthday">{{ $lead->label('birthday') }}</label>
                <input class="form-control text-datepicker" name="birthday" type="text" id="txt_birthday" value="{{ $lead->birthday ?? old('birthday')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('birthday', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            {{--<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('gender') ? 'has-danger' : ''}}">--}}
                {{--<label for="select_gender">{{ $lead->label('gender') }}</label>--}}
                {{--<select name="gender" class="form-control select" id="select_gender">--}}
                    {{--<option></option>--}}
                    {{--@foreach ($lead->genders as $key => $gender)--}}
                        {{--<option value="{{ $key }}" {{ $lead->gender == $key ? ' selected' : '' }}>{{ $gender }}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
                {{--<span class="m-form__help"></span>--}}
                {{--{!! $errors->first('gender', '<div class="form-control-feedback">:message</div>') !!}--}}
            {{--</div>--}}
        </div>
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('address') ? 'has-danger' : ''}}">
                <label for="txt_address">{{ $lead->label('address') }}</label>
                <input class="form-control" name="address" type="text" id="txt_address" value="{{ $lead->address ?? old('address')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('address', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('phone') ? 'has-danger' : ''}}">
                <label for="txt_phone">{{ $lead->label('phone') }}</label>
                <input class="form-control" name="phone" type="text" id="txt_phone" value="{{ $lead->phone ?? old('phone')}}" placeholder="{{ __('Enter value') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('phone', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('state') ? 'has-danger' : ''}}">
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
        </div>
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('comment') ? 'has-danger' : ''}}">
                <label for="textarea_comment">{{ $lead->label('comment') }}</label>
                <textarea class="form-control" rows="5" name="comment" id="textarea_comment">{{ $lead->comment ?? ''}}</textarea>
                {!! $errors->first('comment', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
        <div class="m-form__actions m-form__actions--right">
            <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
            <a href="{{ route('leads.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-ban"></i><span>@lang('Cancel')</span></span></a>
        </div>
    </div>
</form>