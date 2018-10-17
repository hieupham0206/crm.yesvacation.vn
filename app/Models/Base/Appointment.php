<?php

/**
 * Created by hieu.pham.
 * Date: Tue, 16 Oct 2018 21:48:13 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Appointment
 * 
 * @property int $id
 * @property int $user_id
 * @property int $lead_id
 * @property string $code
 * @property string $spouse_name
 * @property string $spouse_phone
 * @property \Carbon\Carbon $appointment_datetime
 * @property int $type
 * @property int $state
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
		'type' => 'int',
		'state' => 'int'
	];

	protected $dates = [
		'appointment_datetime'
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
