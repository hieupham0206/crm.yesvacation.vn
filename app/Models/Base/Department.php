<?php

/**
 * Created by hieu.pham.
 * Date: Fri, 05 Oct 2018 10:12:33 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Province $province
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models\Base
 */
class Department extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'province_id' => 'int'
	];

	public function province()
	{
		return $this->belongsTo(\App\Models\Province::class);
	}

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_department')
					->withPivot('id', 'position')->with('roles')
					->withTimestamps();
	}
}
