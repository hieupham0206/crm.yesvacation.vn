<?php

/**
 * Created by hieu.pham.
 * Date: Sun, 07 Oct 2018 15:58:25 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class ReasonBreak
 * 
 * @property int $id
 * @property string $name
 * @property int $time_alert
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $time_breaks
 *
 * @package App\Models\Base
 */
class ReasonBreak extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'time_alert' => 'int'
	];

	public function time_breaks()
	{
		return $this->hasMany(\App\Models\TimeBreak::class);
	}
}
