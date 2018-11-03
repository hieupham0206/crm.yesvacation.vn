<?php

namespace App\Tables\Admin;

use App\Models\Department;
use App\Tables\DataTable;

class DepartmentTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'departments.name';
                break;
            case '2':
                $column = 'departments.province_id';
                break;
            default:
                $column = 'departments.id';
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
        $departments  = $this->getModels();
        $dataArray    = [];
        $modelName    = (new Department)->classLabel(true);

        $canUpdateDepartment = can('update-department');
        $canDeleteDepartment = can('delete-department');

        /** @var Department[] $departments */
        foreach ($departments as $department) {
            $btnEdit = $btnDelete = '';

            if ($canUpdateDepartment) {
                $btnEdit = ' <a href="' . route('departments.edit', $department, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="fa fa-edit"></i>
				</a>';
            }

            if ($canDeleteDepartment) {
                $btnDelete = ' <button type="button" data-title="' . __('Delete') . ' ' . $modelName . ' ' . $department->name . ' !!!" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill"
                data-url="' . route('departments.destroy', $department, false) . '" title="' . __('Delete') . '">
                    <i class="fa fa-trash"></i>
                </button>';
            }

            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $department->id . '"><span></span></label>',
                $department->name,
                $department->province->name,

                '<a href="' . route('departments.show', $department, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
					<i class="fa fa-eye"></i>
				</a>' . $btnEdit . $btnDelete,
            ];
        }

        return $dataArray;
    }

    /**
     * @return Department[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $departments = Department::query()->with(['province']);

        $this->totalFilteredRecords = $this->totalRecords = $departments->count();

        if ($this->isFilterNotEmpty) {
            $departments->filters($this->filters);

            $this->totalFilteredRecords = $departments->count();
        }

        return $departments->limit($this->length)->offset($this->start)
                           ->orderBy($this->column, $this->direction)->get();
    }
}