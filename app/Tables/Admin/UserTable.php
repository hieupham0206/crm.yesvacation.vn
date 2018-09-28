<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 1/23/2018
 * Time: 2:01 PM
 */

namespace App\Tables\Admin;

use App\Models\User;
use App\Tables\DataTable;

class UserTable extends DataTable
{
    public function getColumn(): string
    {
        $column = $this->column;

        switch ($column) {
            case '1':
                $column = 'username';
                break;
            case '2':
                $column = 'email';
                break;
            case '3':
                $column = 'state';
                break;
            case '4':
                $column = 'last_login';
                break;
            default:
                $column = 'users.id';
                break;
        }

        return $column;
    }

    public function getData(): array
    {
        $this->column = $this->getColumn();
        $users        = $this->getModels();
        $dataArray    = [];
        $modelName    = lcfirst(__('User'));

        $canUpdateUser = can('update-user');
        $canDeleteUser = can('delete-user');

        /** @var User[] $users */
        foreach ($users as $user) {
            $htmlChangeStatus = '
				<button type="button" data-state="1" data-message="' . __('Do you want to activate?') . '" data-title="' . __('Activate') . ' ' . $modelName . ' ' . $user->username . ' !!!" data-url="' . route('users.change_state',
                    $user->id, false) . '" class="btn btn-sm btn-warning btn-change-status m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Activate') . '">
							<i class="fa fa-unlock"></i>
						</button>
			';
            if ($user->state == 1) {
                $htmlChangeStatus = '
				<button type="button" data-state="-1" data-message="' . __('Do you want to deactivate?') . '" data-title="' . __('Deactivate') . ' ' . $modelName . ' ' . $user->username . ' !!!" data-url="' . route('users.change_state',
                        $user->id, false) . '" class="btn btn-sm btn-warning btn-change-status m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Deactivate') . '">
							<i class="fa fa-lock"></i>
						</button>';
            }

            $buttonEdit = $buttonDelete = '';
            if ($canUpdateUser) {
                $buttonEdit = ' <a href="' . route('users.edit', $user->id, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('Edit') . '">
						    <i class="fa fa-edit"></i>
						</a>';
            }

            if ($canDeleteUser) {
                $buttonDelete = ' <button type="button" class="btn btn-sm btn-danger btn-delete m-btn m-btn--icon m-btn--icon-only m-btn--pill" 
						data-title="' . __('Delete') . ' ' . $modelName . ' ' . $user->username . ' !!!" data-url="' . route('users.destroy', $user->id, false) . '" title="' . __('Delete') . '">
							<i class="fa fa-trash"></i>
						</button>';
            }

            $htmlAction  = $htmlChangeStatus . ' <a href="' . route('users.show', $user->id, false) . '" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--pill" title="' . __('View') . '">
						    <i class="fa fa-eye"></i></a>' . $buttonEdit . $buttonDelete;

            $dataArray[] = [
                '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="' . $user->id . '"><span></span></label>',
                $user->getViewLink($user->username),
                $user->name,
                $user->phone,
                $user->email,
                $user->state_text,
                optional($user->last_login)->format('d-m-Y H:i:s'),
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModels()
    {
        $users = User::where('username', '<>', 'admin')->whereKeyNot(auth()->id());

        $this->totalFilteredRecords = $this->totalRecords = $users->count();

        if ($this->isFilterNotEmpty) {
            $users->filters($this->filters);

            $this->totalFilteredRecords = $users->count();
        }

        return $users->limit($this->length)
                     ->offset($this->start)
                     ->orderBy($this->column, $this->direction)->get();
    }
}