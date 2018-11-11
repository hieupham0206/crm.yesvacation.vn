<?php

namespace App\Tables\Admin;

use App\Enums\EventDataState;
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
//        $modelName    = (new EventData)->classLabel(true);

//        $canUpdateEventData = can('update-eventData');
//        $canDeleteEventData = can('delete-eventData');

        /** @var EventData[] $eventDatas */
        foreach ($eventDatas as $eventData) {
//            $btnEdit = $btnDelete = '';
            $btnNotDeal = '
				<button type="button" data-state="'.EventDataState::NOT_DEAL.'" data-message="" title="Not deal" data-title="Hủy deal khách hàng ' . $eventData->lead->name . ' !!!" 
				data-url="' . route('event_datas.change_state', $eventData->id, false) . '" class="btn btn-sm btn-danger btn-change-event-status m-btn m-btn--icon m-btn--icon-only m-btn--pill">
							<i class="fa fa-trash"></i>
						</button>
			';
            $btnDeal = '
				<button type="button" data-state="'.EventDataState::DEAL.'" data-message="" title="Deal" data-title="Chốt deal khách hàng ' . $eventData->lead->name . ' !!!" 
				data-url="' . route('event_datas.change_state', $eventData->id, false) . '" class="btn btn-sm btn-success btn-change-event-status m-btn m-btn--icon m-btn--icon-only m-btn--pill">
							<i class="fa fa-check"></i>
						</button>
			';
            $btnBusy = '
				<button type="button" data-state="'.EventDataState::BUSY.'" data-message="" title="Busy" data-title="Hủy deal khách hàng ' . $eventData->lead->name . ' !!!" 
				data-url="' . route('event_datas.change_state', $eventData->id, false) . '" class="btn btn-sm btn-success btn-change-event-status m-btn m-btn--icon m-btn--icon-only m-btn--pill">
							<i class="fa fa-street-view"></i>
						</button>
			';
            $btnOverflow = '
				<button type="button" data-state="'.EventDataState::OVERFLOW.'" data-message="" title="Overflow" data-title="Hủy deal khách hàng ' . $eventData->lead->name . ' !!!" 
				data-url="' . route('event_datas.change_state', $eventData->id, false) . '" class="btn btn-sm btn-danger btn-change-event-status m-btn m-btn--icon m-btn--icon-only m-btn--pill">
							<i class="fa fa-ban"></i>
						</button>
			';

//            if ($canUpdateEventData) {
//                $btnEdit = ' <a href="' . route('event_datas.edit', $eventData, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
//					<i class="fa fa-edit"></i>
//				</a>';
//            }
//
//            if ($canDeleteEventData) {
//                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $eventData->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
//                data-url="' . route('event_datas.destroy', $eventData, false) . '" title="' . __('Delete') . '">
//                    <i class="fa fa-trash"></i>
//                </button>';
//            }

            $dataArray[] = [
//                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $eventData->id . '"><span></span></label>',
                "<a class='link-event-data m-link m--font-brand' href='javascript:void(0)' data-event-id='{$eventData->id}'>{$eventData->created_at}</a>",
                $eventData->lead->title,
                $eventData->lead->name,
                $eventData->lead->phone,
                $eventData->voucher_code,
                $eventData->note,
                $eventData->to,
                $eventData->rep,
                $btnBusy . $btnOverflow . $btnDeal . $btnNotDeal
            ];
        }

        return $dataArray;
    }

    /**
     * @return EventData[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $eventDatas = EventData::query()->with('lead');

        $this->totalFilteredRecords = $this->totalRecords = $eventDatas->count();

        if ($this->isFilterNotEmpty) {
            $eventDatas->filters($this->filters);

            $this->totalFilteredRecords = $eventDatas->count();
        }

        return $eventDatas->limit($this->length)->offset($this->start)
                          ->orderBy($this->column, $this->direction)->get();
    }
}