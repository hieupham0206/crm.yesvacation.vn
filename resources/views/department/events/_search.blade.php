<form id="events_search_form">
    <div class="form-group row">
        <div class="col-lg-3 col-xs-6">
            <label for="txt_brand">@lang('Event')</label>
            <input class="form-control" name="name" id="txt_brand">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
             <button class="btn btn-brand m-btn--custom m-btn m-btn--icon" id="btn_filter"><span> <i class="la la-search"></i> <span>@lang('Search')</span> </span></button>
             <button type="button" class="btn btn-secondary m-btn--custom m-btn m-btn--icon" id="btn_reset_filter"><span> <i class="fa fa-undo-alt"></i> <span>@lang('Reset')</span> </span></button>
        </div>
    </div>
</form>