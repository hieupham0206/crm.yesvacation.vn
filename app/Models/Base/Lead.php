<?php

/**
 * Created by hieu.pham.
 * Date: Wed, 03 Oct 2018 19:12:05 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Lead
 * 
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $email
 * @property int $gender
 * @property \Carbon\Carbon $birthday
 * @property string $address
 * @property int $province_id
 * @property string $phone
 * @property int $state
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Province $province
 * @property \Illuminate\Database\Eloquent\Collection $event_datas
 * @property \Illuminate\Database\Eloquent\Collection $history_calls
 *
 * @package App\Models\Base
 */
class Lead extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'gender' => 'int',
		'province_id' => 'int',
		'state' => 'int'
	];

	protected $dates = [
		'birthday'
	];

	public function province()
	{
		return $this->belongsTo(\App\Models\Province::class);
	}

	public function event_datas()
	{
		return $this->hasMany(\App\Models\EventData::class);
	}

	public function history_calls()
	{
		return $this->hasMany(\App\Models\HistoryCall::class);
	}
}
