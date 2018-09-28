<?php

namespace App\Tables\Department;

use App\Models\Event;
use App\Tables\DataTable;

class EventTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            default:
                $column = 'events.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        $models       = $this->getModels();
        $dataArray    = [];
        /** @var Event[] $models */
        foreach ($models as $model) {
            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $model->id . '"><span></span></label>',
                $model->name,
                '<a href="' . route('events.show', $model->id) . '" class="btn btn-sm btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('View') . '">
					<i class="la la-eye"></i>
				</a>
				<a href="' . route('events.edit', $model->id) . '" class="btn btn-sm btn-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('Edit') . '">
					<i class="la la-edit"></i>
				</a>
				<button type="button" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" data-url="' . route('events.destroy', $model->id) . '" title="' . __('Delete') . '">
					<i class="la la-trash"></i>
				</button>'
            ];
        }

        return $dataArray;
    }

    /**
     * @return Event[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $events = Event::query();

        $this->totalRecords = $events->count();
        if ( ! empty($this->filters['name'])) {
            $events = $events->where('name', 'like', "%{$this->filters['name']}%");
        }
        $this->totalFilteredRecords = $events->count();

        $events = $events->limit($this->length)->offset($this->start)
                         ->orderBy($this->column, $this->direction)->get();

        return $events;
    }
}