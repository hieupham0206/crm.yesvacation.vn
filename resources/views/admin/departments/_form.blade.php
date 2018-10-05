@php /** @var \App\Models\Department $department */ @endphp
<form id="departments_form" class="m-form m-form--label-align-right m-form--group-seperator-dashed m-form--state" method="post" action="{{ $action }}">
    @csrf
    @isset($method)
        @method('put')
    @endisset
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="txt_name">{{ $department->label('name') }}</label>
                <input class="form-control" name="name" type="text" id="txt_name" value="{{ $department->name ?? old('name')}}" required placeholder="{{ __('Enter value') }}" autocomplete="off">
                <span class="m-form__help"></span>
                {!! $errors->first('name', '<div class="form-control-feedback">:message</div>') !!}
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 m-form__group-sub {{ $errors->has('province_id') ? 'has-danger' : ''}}">
                <label for="select_province_id">{{ $department->label('province_id') }}</label>
                <select name="province_id" class="form-control" id="select_province_id">
                    <option></option>
                    @if($department->exists)
                        <option value="{{ $department->province_id }}" selected>{{ $department->province->name }}</option>
                    @endif
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('province_id', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
        <div class="m-form__actions m-form__actions--right">
            <button class="btn btn-brand m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-save"></i><span>@lang('Save')</span></span></button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--custom"><span><i class="fa fa-ban"></i><span>@lang('Cancel')</span></span></a>
        </div>
    </div>
</form>