<form id="permissions_form" class="m-form m-form--state" method="post" action="{{ $action }}">
    @csrf
    @isset($method)
        @method('put')
    @endisset
    <div class="m-portlet__body">
        <div class="m-form__content">
            <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="error_summary">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text"></div>
                <div class="m-alert__close">
                    <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-4">
                <div class="form-group m-form__group {{ $errors->has('module') ? 'has-danger' : ''}}">
                    <label for="txt_module">{{ $permission->label('Module') }}</label>
                    <input disabled class="form-control" name="module" type="text" id="txt_module" value="{{ $module ?? ''}}" required placeholder="{{ __('Enter value') }}">
                    {!! $errors->first('module', '<div class="form-control-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="form-group m-form-__roup row">
            <div class="col-lg-4">
                <div class="form-group m-form__group">
                    <label for="txt_permission">{{ $permission->label('Permission') }}</label>
                    <input class="form-control" type="text" id="txt_permission">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group m-form__group">
                    <button type="button" class="btn btn-brand m-btn m-btn--icon mt-6" id="btn_add_permission"><span> <i class="la la-plus"></i> <span>@lang('Add')</span> </span></button>
                </div>
            </div>
        </div>
        <div class="form-group m-form-__roup row">
            <div class="col-lg-12">
                <table class="table table-borderless table-hover nowrap" id="table_permissions">
                    <thead>
                    <tr>
                        <th>@lang('Permission')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission['action'] }}
                                <input type="hidden" name="permissions[]" value="{{ $permission['action'] }}">
                            </td>
                            <td>
                                @if ($permission['can_delete'])
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-permission m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="{{ __( 'Delete' )  }}"><i class="la la-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit m-portlet__foot-no-border">
        <div class="m-form__actions m-form__actions--right">
            <button type="submit" class="btn btn-brand">@lang('Save')</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
        </div>
    </div>
</form>