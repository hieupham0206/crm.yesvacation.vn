<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 1/23/2018
 * Time: 2:01 PM
 */

namespace App\Tables\Admin;

use App\Models\ActivityLog;
use App\Tables\DataTable;

class ActivityLogTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '0':
                $column = 'activity_log.log_name';
                break;
            case '1':
                $column = 'activity_log.causer_id';
                break;
            case '2':
                $column = 'activity_log.descriptrion';
                break;
            case '3':
                $column = 'activity_log.created_at';
                break;
            default:
                $column = 'activity_log.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        $models       = $this->getModels();
        $dataArray    = [];
        /** @var ActivityLog[] $models */
        foreach ($models as $model) {
            $routeViewDetail = route('activity_logs.view_detail');
            $dataArray[]     = [
                __($model->log_name),
                optional($model->causer)->username,
                "<span title='" . $model->description . "'>" . str_limit($model->description, 50) . '</span>',
                optional($model->created_at)->format('d/m/Y H:i:s'),
                '<a href="javascript:void(0)" data-id="' . $model->id . '" data-url="' . $routeViewDetail . '" 
                 class="btn btn-sm btn-view-detail btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('View') . '">
					<i class="fa fa-eye"></i>
				</a>'
            ];
        }

        return $dataArray;
    }

    /**
     * @return ActivityLog[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $logs = ActivityLog::query()->with('causer');

        $this->totalRecords = $this->totalFilteredRecords = $logs->count();

        if ($this->isFilterNotEmpty) {
            $logs->andFilterWhere(['description', 'like', $this->filters['description']]);

            $this->totalFilteredRecords = $logs->count();
        }

        $logs = $logs->limit($this->length)->offset($this->start)
                     ->orderBy($this->column, $this->direction)->get();

        return $logs;
    }
}