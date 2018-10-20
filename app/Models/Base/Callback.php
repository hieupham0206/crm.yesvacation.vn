<?php

/**
 * Created by hieu.pham.
 * Date: Fri, 19 Oct 2018 21:04:16 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Callback
 * 
 * @property int $id
 * @property int $user_id
 * @property int $lead_id
 * @property \Carbon\Carbon $callback_datetime
 * @property int $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Lead $lead
 * @property \App\Models\User $user
 *
 * @package App\Models\Base
 */
class Callback extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'user_id' => 'int',
		'lead_id' => 'int',
		'state' => 'int'
	];

	protected $dates = [
		'callback_datetime'
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
