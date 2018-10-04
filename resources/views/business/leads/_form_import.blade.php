<form id="import_customers_form" class="m-form m-form--state" method="post" action="{{ route('customers.import') }}" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title">@lang('Import')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @csrf
        <div class="m-portlet__body">
            <div role="alert" class="alert alert-dismissible fade show m-alert m-alert--air alert-danger" style="display: none;">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"></button>
                <strong></strong>
            </div>
            <div class="form-group row">
                {{--@if ($user->isAdmin() || $user->isCrmExpert() || $user->isIt())--}}
                    {{--<div class="col-12 col-md-6 m-form__group-sub">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="select_modal_store_id">{{ $customer->label('store') }}</label>--}}
                            {{--<select name="store_id" class="form-control select2-ajax" id="select_modal_store_id" data-url="{{ route('stores.list') }}" required>--}}
                                {{--<option></option>--}}
                                {{--@if ($user->isCrmExpert())--}}
                                    {{--@php--}}
                                        {{--$employeeStore = $user->employee_first_store--}}
                                    {{--@endphp--}}

                                    {{--@if ($employeeStore)--}}
                                        {{--<option value="{{ $employeeStore->id }}" selected>{{ $employeeStore->name }}</option>--}}
                                    {{--@endif--}}
                                {{--@endif--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-12 col-md-6 m-form__group-sub">--}}
                        {{--<label for="select_modal_employee_id">{{ $customer->label('employee') }}</label>--}}
                        {{--<select name="employee_id" class="form-control" id="select_modal_employee_id" data-url="{{ route('employees.list') }}" required>--}}
                            {{--<option></option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--@endif--}}
                <div class="col-lg-12">
                    <div class="fileinput fileinput-new">
                        <div class="input-group">
                            <div class="form-control" data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                            <div class="input-group-append">
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">@lang('Select file')</span>
                                    <span class="fileinput-exists">@lang('Change')</span>
                                    <input type="file" name="file_import" accept=".xlsx, .xls">
                                </span>
                                <button class="btn btn-brand fileinput-exists">{{ __('Import') }}</button>
                                <a href="#" class="btn btn-brand fileinput-exists" data-dismiss="fileinput">@lang('Delete')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{ asset('files/sample_customer.xlsx') }}" download>
            <button type="button" class="btn btn-brand m-btn--custom m-btn--icon" id="download_file_sample">
                <span><i class="fa fa-download"></i>
                    <span>@lang('Download file sample')</span>
                </span>
            </button>
        </a>
        <button type="button" class="btn btn-brand m-btn--custom m-btn--icon" data-dismiss="modal">
            <span>
                <i class="fa fa-ban"></i>
                <span>@lang('Close')</span>
            </span>
        </button>
    </div>
</form>