@php /** @var \App\Models\Lead $lead */ @endphp
<div class="modal-header">
    <h5 class="modal-title">Confirmation</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <div class="col-sm-12 col-md-8 m-form__group-sub">
                <button type="button" class="btn btn-info m-btn m-btn--icon m-btn--custom" id="btn_reappointment">
                    <span><i class="fa fa-redo"></i><span>Re-App</span></span>
                </button>
                <button type="button" class="btn btn-danger m-btn m-btn--icon m-btn--custom" id="btn_cancel_appointment">
                    <span><i class="fa fa-ban"></i><span>Cancel-App</span></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary m-btn--icon m-btn--custom" data-dismiss="modal"><span><i class="fa fa-window-close"></i><span>@lang('Close')</span></span></button>
</div>
