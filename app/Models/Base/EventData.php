<?php

/**
 * Created by hieu.pham.
 * Date: Fri, 19 Oct 2018 00:16:30 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class EventData
 * 
 * @property int $id
 * @property int $lead_id
 * @property \Carbon\Carbon $appointment_datetime
 * @property \Carbon\Carbon $time_in
 * @property \Carbon\Carbon $time_out
 * @property int $show_up
 * @property int $deal
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Lead $lead
 * @property \Illuminate\Database\Eloquent\Collection $contracts
 * @property \Illuminate\Database\Eloquent\Collection $event_data_details
 *
 * @package App\Models\Base
 */
class EventData extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'lead_id' => 'int',
		'is_show_up' => 'int',
		'deal' => 'int'
	];

	protected $dates = [
		'appointment_datetime',
		'time_in',
		'time_out'
	];

	public function lead()
	{
		return $this->belongsTo(\App\Models\Lead::class);
	}

	public function contracts()
	{
		return $this->hasMany(\App\Models\Contract::class);
	}

	public function event_data_details()
	{
		return $this->hasMany(\App\Models\EventDataDetail::class);
	}
}
