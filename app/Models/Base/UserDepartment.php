<?php

/**
 * Created by hieu.pham.
 * Date: Fri, 05 Oct 2018 10:13:00 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class UserDepartment
 * 
 * @property int $id
 * @property int $department_id
 * @property int $user_id
 * @property int $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Department $department
 * @property \App\Models\User $user
 *
 * @package App\Models\Base
 */
class UserDepartment extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;
	protected $table = 'user_department';

	protected $casts = [
		'department_id' => 'int',
		'user_id' => 'int',
		'type' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(\App\Models\Department::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
