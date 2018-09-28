<div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">
    @foreach ($groups as $group)
        <div class="m-accordion__item">
            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_2_item_{{ $loop->index }}_head" data-toggle="collapse" href="#m_accordion_2_item_{{ $loop->index }}_body" aria-expanded="false">
                <span class="m-accordion__item-icon"><i class="{{ $group['icon'] }}"></i></span>
                <span class="m-accordion__item-title">
                    {{ $group['name'] }}
                </span>
                <span class="m-accordion__item-mode"></span>
            </div>
            <div class="m-accordion__item-body collapse" id="m_accordion_2_item_{{ $loop->index }}_body" role="tabpanel" aria-labelledby="m_accordion_2_item_{{ $loop->index }}_head" data-parent="#m_accordion_2" style="">
                <div class="m-accordion__item-content">
                    <table class="table table-inverse table-hover m-table">
                        <tbody>
                        @foreach ($group['modules'] as $module)
                            <tr>
                                <td>{{ $module['name'] }}</td>
                                @if (!$disabled)
                                    <td>
                                        <label class="m-checkbox  m-checkbox--solid m-checkbox--bold m-checkbox--brand">
                                            <input type="checkbox" class="chk_all_permission"> @lang('All')
                                            <span></span>
                                        </label>
                                    </td>
                                @endif
                                @foreach ($module['permissionNames'] as $role)
                                    @if ($role !== null)
                                        @if(! empty($isCreate))
                                            <td>
                                                <label class="m-checkbox  m-checkbox--solid m-checkbox--bold m-checkbox--brand">
                                                    <input type="checkbox" class="chk_permission" name="permissions[]" value="{{ $role }}"> {{ __(ucfirst($module['permissions'][$loop->index])) }}
                                                    <span></span>
                                                </label>
                                            </td>
                                        @else
                                            @php
                                                $checked = in_array($role, $permissions, true) ? 'checked' : '';
                                            @endphp
                                            <td>
                                                <label class="m-checkbox  m-checkbox--solid m-checkbox--bold m-checkbox--brand">
                                                    <input type="checkbox" class="chk_permission" name="permissions[]" {{ $disabled ? 'disabled' : '' }} value="{{ $role }}" {{ $checked }}> {{ __(ucfirst($module['permissions'][$loop->index])) }}
                                                    <span></span>
                                                </label>
                                            </td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                                @php
                                    $totalPermission = count($module['permissionNames']);
                                    $offset = 4 - $totalPermission;
                                @endphp
                                @if ($offset)
                                    @for ($i = 0; $i < $offset; $i++)
                                        <td width="200px"></td>
                                    @endfor
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>