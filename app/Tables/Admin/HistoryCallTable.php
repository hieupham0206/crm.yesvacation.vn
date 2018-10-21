<?php

namespace App\Tables\Admin;

use App\Enums\HistoryCallType;
use App\Models\HistoryCall;
use App\Tables\DataTable;

class HistoryCallTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'history_calls.name';
                break;
            case '2':
                $column = 'history_calls.created_at';
                break;
            default:
                $column = 'history_calls.id';
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
        $historyCalls = $this->getModels();
        $dataArray    = [];
        $modelName    = (new HistoryCall)->classLabel(true);

//        $canUpdateHistoryCall = can('update-historyCall');
        $canDeleteHistoryCall = can('delete-historyCall');

        /** @var HistoryCall[] $historyCalls */
        foreach ($historyCalls as $historyCall) {
            $btnEdit = $btnDelete = '';
//
//            if ($canUpdateHistoryCall) {
//                $btnEdit = ' <a href="' . route('history_calls.edit', $historyCall, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
//					<i class="fa fa-edit"></i>
//				</a>';
//            }
//
            if ($canDeleteHistoryCall) {
                $btnDelete = ' <button type="button" data-route="history_calls"  data-title="' . __('Delete') . ' ' . $modelName . ' ' . $historyCall->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('history_calls.destroy', $historyCall, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }
            $btnCall = ' <button type="button" data-lead-id="'. $historyCall->lead_id  . ' !!!" data-type-call="'.HistoryCallType::HISTORY.'" 
                class="btn btn-sm btn-history-call btn-primary m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Call') . '">
                    <i class="fa fa-phone"></i>
                </button>';

            $dataArray[] = [
                "<a class='link-lead-name m-link m--font-brand' href='javascript:void(0)' data-lead-id='{$historyCall->lead_id}'>{$historyCall->lead->name}</a>",
                $historyCall->lead->title,
                $historyCall->created_at,
                $btnCall . $btnDelete
//                '<a href="' . route('history_calls.show', $historyCall, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
//					<i class="fa fa-eye"></i>
//				</a>' . $btnEdit . $btnDelete
            ];
        }

        return $dataArray;
    }

    /**
     * @return HistoryCall[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $historyCalls = HistoryCall::query();

        $this->totalFilteredRecords = $this->totalRecords = $historyCalls->count();

        if ($this->isFilterNotEmpty) {
            $historyCalls->filters($this->filters);

            $this->totalFilteredRecords = $historyCalls->count();
        }

        return $historyCalls->limit($this->length)->offset($this->start)
                            ->orderBy($this->column, $this->direction)->get();
    }
}