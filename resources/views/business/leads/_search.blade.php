<form id="leads_search_form">
    <div class="form-group m-form__group row">
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="txt_name">{{ $lead->label('name') }}</label>
                <input class="form-control" name="name" id="txt_name">
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="txt_email">{{ $lead->label('email') }}</label>
                <input class="form-control" name="email" id="txt_email">
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="select_gender">{{ $lead->label('gender') }}</label>
                <select name="gender" class="form-control select" id="select_gender">
                    <option></option>
                    @foreach ($lead->genders as $key => $gender)
                        <option value="{{ $key }}">{{ $gender }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="txt_birthday">{{ $lead->label('birthday') }}</label>
                <input class="form-control" name="birthday" id="txt_birthday">
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="txt_address">{{ $lead->label('address') }}</label>
                <input class="form-control" name="address" id="txt_address">
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="txt_phone">{{ $lead->label('phone') }}</label>
                <input class="form-control" name="phone" id="txt_phone">
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub">
            <div class="form-group">
                <label for="select_state">{{ $lead->label('state') }}</label>
                <select name="state" class="form-control select" id="select_state">
                    <option></option>
                    @foreach ($lead->states as $key => $state)
                        <option value="{{ $key }}">{{ $state }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 col-md-3 m-form__group-sub mt-6">
            <button class="btn btn-brand m-btn m-btn--custom m-btn--icon" id="btn_filter"><span> <i class="fa fa-search"></i> <span>@lang('Search')</span> </span></button>
            <button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" id="btn_reset_filter"><span> <i class="fa fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>