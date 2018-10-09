<?php

/**
 * Created by hieu.pham.
 * Date: Sat, 06 Oct 2018 10:43:43 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Appointment
 * 
 * @property int $id
 * @property int $user_id
 * @property int $lead_id
 * @property int $state
 * @property int $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Lead $lead
 * @property \App\Models\User $user
 *
 * @package App\Models\Base
 */
class Appointment extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'user_id' => 'int',
		'lead_id' => 'int',
		'state' => 'int',
		'type' => 'int'
	];

	public function lead()
	{
		return $this->belongsTo(\App\Models\Lead::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
