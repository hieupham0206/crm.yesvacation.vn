<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 1/23/2018
 * Time: 2:01 PM
 */

namespace App\Tables\Admin;

use App\Models\Role;
use App\Tables\DataTable;

class RoleTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '0':
                $column = 'name';
                break;
            default:
                $column = 'roles.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        $roles        = $this->getModels();
        $dataArray    = [];
        $modelName    = lcfirst(__('Role'));

        $canUpdateRole = can('update-role');
        $canDeleteRole = can('delete-role');

        /** @var Role[] $roles */
        foreach ($roles as $role) {
            $deleteButton = $editButton = '';
            if ($canDeleteRole) {
                $deleteButton = ' <button type="button" data-title="Xóa ' . $modelName . ' ' . $role->name . ' !!!" 
				class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill" data-url="' . route('roles.destroy', $role->id) . '" title="' . __('Delete') . '">
					<i class="la la-trash"></i>
				</button>';
            }

            if ($canUpdateRole) {
                $editButton = ' <a href="' . route('roles.edit', $role->id) . '" class="btn btn-sm btn-info m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
					<i class="la la-edit"></i>
				</a>';
            }

            $htmlAction = ' <a href="' . route('roles.show', $role->id) . '" class="btn btn-sm btn-success btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
					<i class="la la-eye"></i>
				</a>' . $editButton . $deleteButton;

            $dataArray[] = [
//                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $model->id . '"><span></span></label>',
                $role->name,
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * @return Role[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $roles = Role::query()->hideAdmin();

        $this->totalRecords = $this->totalFilteredRecords = $roles->count();

        if ($this->isFilterNotEmpty) {
            $roles->filters($this->filters);

            $this->totalFilteredRecords = $roles->count();
        }

        $roles = $roles->limit($this->length)->offset($this->start)
                       ->orderBy($this->column, $this->direction)->get();

        return $roles;
    }
}