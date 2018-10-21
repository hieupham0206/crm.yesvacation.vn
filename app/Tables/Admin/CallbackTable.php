<?php

namespace App\Tables\Admin;

use App\Enums\HistoryCallType;
use App\Models\Callback;
use App\Tables\DataTable;

class CallbackTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
//            case '1':
//                $column = 'callbacks.name';
//                break;
//            case '2':
//                $column = 'callbacks.title';
//                break;
//            case '3':
//                $column = 'callbacks.created_at';
//                break;
            default:
                $column = 'callbacks.callback_datetime';
                break;
        }

        return $column;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getData(): array
    {
        $this->column = $this->getColumn();
        $callBacks    = $this->getModels();
        $dataArray    = [];
        $modelName    = (new Callback)->classLabel(true);

        $canUpdateCallback = can('update-callBack');
        $canDeleteCallback = can('delete-callBack');

        /** @var Callback[] $callBacks */
        foreach ($callBacks as $callBack) {
            $btnEdit = $btnCall = $btnDelete = '';

            if ($canUpdateCallback) {
//                $btnEdit = ' <a href="' . route('callbacks.edit', $callBack, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
//					<i class="fa fa-edit"></i>
//				</a>';
                $btnEdit = ' <button data-id="'.$callBack->id.'" data-url="'.route('leads.edit_callback_time', $callBack).'" class="btn btn-sm btn-brand btn-edit-datetime m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</button>';
            }

            if ($canDeleteCallback) {
                $btnDelete = ' <button type="button" data-route="callbacks" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $callBack->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('callbacks.destroy', $callBack, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }

//            if ($canDeleteCallback) {
                $btnCall = ' <button type="button" data-id="'.$callBack->id.'" data-lead-id="'. $callBack->lead_id  . ' !!!" data-type-call="'.HistoryCallType::CALLBACK.'" 
                class="btn btn-sm btn-callback-call btn-primary m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Call') . '">
                    <i class="fa fa-phone"></i>
                </button>';
//            }

            $dataArray[] = [
                "<a class='link-lead-name m-link m--font-brand' href='javascript:void(0)' data-lead-id='{$callBack->lead_id}'>{$callBack->lead->name}</a>",
                $callBack->lead->title,
                "<span class='span-datetime'>".optional($callBack->callback_datetime)->format('d-m-Y H:i') . '</span>',

                $btnCall . $btnEdit . $btnDelete
            ];
        }

        return $dataArray;
    }

    /**
     * @return Callback[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $callBacks = Callback::query();

        $this->totalFilteredRecords = $this->totalRecords = $callBacks->count();

        if ($this->isFilterNotEmpty) {
            $callBacks->filters($this->filters);

            $this->totalFilteredRecords = $callBacks->count();
        }

        return $callBacks->limit($this->length)->offset($this->start)
                         ->orderBy($this->column, $this->direction)->get();
    }
}