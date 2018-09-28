<form id="users_search_form">
    <div class="form-group m-form__group row">
        <div class="col-12 col-md-3 m-form__group-sub">
            <label for="txt_username">{{ $user->label('username') }}</label>
            <input class="form-control" name="username" id="txt_username">
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <label for="txt_name">{{ $user->label('name') }}</label>
            <input class="form-control" name="name" id="txt_name">
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <label for="txt_phone">{{ $user->label('phone') }}</label>
            <input class="form-control" name="phone" id="txt_phone">
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <label for="select_state">{{ $user->label('state') }}:</label>
            <select name="state" class="form-control select" id="select_state">
                <option></option>
                <option value="1">@lang('Active')</option>
                <option value="0">@lang('Inactive')</option>
            </select>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub mt-6">
            <button class="btn btn-brand m-btn m-btn--custom m-btn--icon" id="btn_filter"><span> <i class="fa fa-search"></i> <span>@lang('Search')</span> </span></button>
            <button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" id="btn_reset_filter"><span> <i class="fa fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>