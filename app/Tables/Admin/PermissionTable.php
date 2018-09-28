<?php

namespace App\Tables\Admin;

use App\Models\Permission;
use App\Tables\DataTable;

class PermissionTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case 1:
                $column = 'module';
                break;
            default:
                $column = 'permissions.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        [$modules, $permissions] = $this->getModels();
        $dataArray = [];

        $namespaces = $modules->pluck('namespace');
        $modules    = $modules->pluck('module')->unique();

        /** @var Permission[] $modules */
        foreach ($modules as $key => $module) {
            $actions = Permission::getModulePermission($permissions, $module);

            $htmlAction = '<a href="' . route('permissions.edit', $module) . '" class="btn btn-sm btn-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="' . __('Edit') . '">
					<i class="la la-edit"></i>
				</a>';
            if ($namespaces[$key] == 'admin') {
                $htmlAction = '';
            }
            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox"><span></span></label>',
                __(ucfirst($module)),
                implode(', ', $actions->pluck('action')->toArray()),
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * @return Permission[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $modules     = $this->getModule();
        $permissions = $this->getPermission();

        return [$modules, $permissions];
    }

    private function getModule()
    {
        $modules = Permission::query()->groupBy('module');

        if ( ! empty($this->filters['action'])) {
            $modules = $modules->where('action', 'like', "%{$this->filters['action']}%");
        }

        if ( ! empty($this->searchValue)) {
            $modules = $modules->where('action', 'like', "%{$this->searchValue}%");
        }

        $modules = $modules
            ->limit($this->length)->offset($this->start)
            ->orderBy($this->column, $this->direction)->get();

        $this->totalRecords         = $modules->count();
        $this->totalFilteredRecords = $modules->count();

        return $modules;
    }

    private function getPermission()
    {
        $permissions = Permission::query();

        $permissions = $permissions
            ->limit($this->length)->offset($this->start)
            ->orderBy($this->column, $this->direction)->get();

        return $permissions;
    }
}