<?php

namespace App\Tables\Admin;

use App\Models\EventData;
use App\Tables\DataTable;

class EventDataTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'event_datas.created_at';
                break;
            case '2':
                $column = 'event_datas.to';
                break;
            case '3':
                $column = 'event_datas.rep';
                break;
            default:
                $column = 'event_datas.id';
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
        $eventDatas   = $this->getModels();
        $dataArray    = [];
        $modelName    = (new EventData)->classLabel(true);

        $canUpdateEventData = can('update-eventData');
        $canDeleteEventData = can('delete-eventData');

        /** @var EventData[] $eventDatas */
        foreach ($eventDatas as $eventData) {
            $btnEdit = $btnDelete = '';

            if ($canUpdateEventData) {
                $btnEdit = ' <a href="' . route('event_datas.edit', $eventData, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</a>';
            }

            if ($canDeleteEventData) {
                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $eventData->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('event_datas.destroy', $eventData, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }

            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $eventData->id . '"><span></span></label>',
                $eventData->created_at,
                $eventData->lead->title,
                $eventData->lead->name,
                $eventData->lead->phone,
                $eventData->voucher_code,
                $eventData->note,
                $eventData->to,
                $eventData->rep,

                '<a href="' . route('event_datas.show', $eventData, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
					<i class="fa fa-eye"></i>
				</a>' . $btnEdit . $btnDelete,
            ];
        }

        return $dataArray;
    }

    /**
     * @return EventData[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $eventDatas = EventData::query();

        $this->totalFilteredRecords = $this->totalRecords = $eventDatas->count();

        if ($this->isFilterNotEmpty) {
            $eventDatas->filters($this->filters);

            $this->totalFilteredRecords = $eventDatas->count();
        }

        return $eventDatas->limit($this->length)->offset($this->start)
                          ->orderBy($this->column, $this->direction)->get();
    }
}