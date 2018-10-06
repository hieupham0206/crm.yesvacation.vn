<?php

namespace App\Tables\Admin;

use App\Models\Callback;
use App\Tables\DataTable;

class CallBackTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'call_backs.name';
                break;
            case '2':
                $column = 'call_backs.title';
                break;
            case '3':
                $column = 'call_backs.created_at';
                break;
            default:
                $column = 'call_backs.id';
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
            $btnEdit = $btnDelete = '';

            if ($canUpdateCallback) {
                $btnEdit = ' <a href="' . route('call_backs.edit', $callBack, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</a>';
            }

            if ($canDeleteCallback) {
                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $callBack->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('call_backs.destroy', $callBack, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }

            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $callBack->id . '"><span></span></label>',
                $callBack->name,
                $callBack->lead->title,
                $callBack->created_at,

                '<a href="' . route('call_backs.show', $callBack, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
					<i class="fa fa-eye"></i>
				</a>' . $btnEdit . $btnDelete
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