<?php

namespace App\Tables\Admin;

use App\Entities\Core\SystemLog;
use App\Tables\DataTable;

class SystemLogTable extends DataTable
{

    public function getData(): array
    {
        $models    = $this->getModels();
        $dataArray = [];
        /** @var \Log[] $models */
        foreach ($models as $model) {
            $dataArray[] = [
                $model['context'],
                '<span class="m-badge m-badge--' . $model['level_class'] . ' m-badge--wide m-badge--rounded">' . $model['level'] . '</span>',
                $model['date'],
                substr($model['text'], 0, 100) . '...',
                '
				<input type="hidden" class="txt-content" value="' . str_replace('"', '\'', $model['text']) . '"/>
				<input type="hidden" class="txt-stack" value="' . str_replace('"', '\'', $model['stack']) . '"/>
				<button data-url="' . route('system_logs.view_detail') . '" class="btn btn-sm btn-success btn-view m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('View') . '">
						<i class="la la-eye"></i>
				</button>
				'
            ];
        }

        return $dataArray;
    }

    public function getModels()
    {
        $collection = collect(SystemLog::all());

        $this->totalRecords = $collection->count();
        $searchValue        = $this->searchValue;
        if ( ! empty($searchValue)) {
            $collection = $collection->filter(function ($item) use ($searchValue) {
                return strpos($item['date'], $searchValue) !== false
                       or strpos($item['text'], $searchValue) !== false
                       or strpos($item['level'], $searchValue) !== false;
            });
        }

        if ( ! empty($this->filters['level'])) {
            $collection = $collection->where('level', $this->filters['level']);
        }

        $this->totalFilteredRecords = $collection->count();

        return $collection;
    }
}