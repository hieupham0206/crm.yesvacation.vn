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
                <label for="select_province_id">{{ $department->label('province') }}</label>
                <select name="province_id" class="form-control select2-ajax" id="select_province_id" data-url="{{ route('leads.provinces.table') }}">
                    <option></option>
                    @if($department->exists)
                        <option value="{{ $department->province_id }}" selected>{{ $department->province->name }}</option>
                    @endif
                </select>
                <span class="m-form__help"></span>
                {!! $errors->first('province_id', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label for="select_user">{{ $department->label('user') }}</label>
                <select class="form-control" id="select_user" data-url="{{ route('users.list') }}">
                    <option></option>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="select_position">{{ $department->label('position') }}</label>
                <select class="form-control select" id="select_position">
                    <option></option>
                    @foreach ($department->positions as $key => $position)
                        <option value="{{ $key }}">{{ $position }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-1">
                <button type="button" class="btn btn-accent m-btn m-btn--custom mt-6" id="btn_add_user">{{ __('Add') }}</button>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-4">
                <table class="table table-hover table-bordered nowrap" id="table_user_department">
                    <thead class="">
                    <tr>
                        <th>{{ $department->label('user') }}</th>
                        <th>{{ $department->label('position') }}</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($userDepartments)
                        @foreach ($userDepartments as $key => $userDepartment)
                            @php
                                $pivot = $userDepartment->departments->first()->pivot
                            @endphp
                            <tr>
                                <td>
                                    <input type="hidden" name="UserDepartment[user_id][{{ $key }}][]" value="{{ $userDepartment->id }}" class="txt-user-id">
                                    <input type="hidden" name="UserDepartment[position][{{ $key }}][]" value="{{ $pivot->position }}" class="txt-position">
                                    {{ $userDepartment->username }}
                                </td>
                                <td>{{ \App\Enums\UserPosition::getDescription($pivot->position) }}</td>
                                <td>
                                    <button type="button" class="btn-delete-user btn btn-sm btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="Delete">
                                        <i class="la la-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
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