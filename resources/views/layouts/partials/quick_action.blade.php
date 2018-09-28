<!--suppress HtmlUnknownAttribute -->
<ul class="m-portlet__nav">
    <li class="m-portlet__nav-item">
        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
            <a href="#" class="m-portlet__nav-link btn btn-sm btn-secondary m-btn m-btn--icon m-btn--icon-only m-btn--pill m-dropdown__toggle">
                <i class="fa fa-ellipsis-h m--font-brand"></i>
            </a>
            <div class="m-dropdown__wrapper" style="z-index: 101">
                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 21px;"></span>
                <div class="m-dropdown__inner">
                    <div class="m-dropdown__body">
                        <div class="m-dropdown__content">
                            <ul class="m-nav">
                                <li class="m-nav__item m-nav__section m-nav__section--first mb-1">
                                    <span class="m-nav__section-text">@lang('Export file')</span>
                                </li>
                                <li class="m-nav__item">
                                    <a href="#" class="m-nav__link" id="btn_export_excel">
                                        <i class="m-nav__link-icon fa fa-file-excel"></i>
                                        <span class="m-nav__link-text">Xuất Excel</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="#" class="m-nav__link" id="btn_export_pdf">
                                        <i class="m-nav__link-icon fa fa-file-pdf"></i>
                                        <span class="m-nav__link-text">Xuất Pdf</span>
                                    </a>
                                </li>
                                @if (can('delete-'. lcfirst($model)) || ($editUrl && can('update-'. lcfirst($model))))
                                    <li class="m-nav__item m-nav__section m-nav__section--first mb-1">
                                        <span class="m-nav__section-text">@lang('Quick actions')</span>
                                    </li>
                                    @if(can('delete-'. lcfirst($model)))
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" data-url="{{ route(str_plural($model) . '.destroys') }}" class="m-nav__link" id="link_delete_selected_rows">
                                                <i class="m-nav__link-icon fa fa-trash"></i>
                                                <span class="m-nav__link-text">@lang('Delete selected rows')</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($editUrl && can('update-'. lcfirst($model)))
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" data-url="{{ $editUrl }}" class="m-nav__link" id="link_edit_selected_rows">
                                                <i class="m-nav__link-icon fa fa-edit"></i>
                                                <span class="m-nav__link-text">@lang('Edit selected rows')</span>
                                            </a>
                                        </li>
                                    @endif
                                @endunless
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>