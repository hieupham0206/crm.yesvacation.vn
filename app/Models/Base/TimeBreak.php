<?php

/**
 * Created by hieu.pham.
 * Date: Tue, 09 Oct 2018 00:38:08 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class TimeBreak
 * 
 * @property int $id
 * @property int $reason_break_id
 * @property int $user_id
 * @property \Carbon\Carbon $start_break
 * @property \Carbon\Carbon $end_break
 * @property string $another_reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\ReasonBreak $reason_break
 * @property \App\Models\User $user
 *
 * @package App\Models\Base
 */
class TimeBreak extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'reason_break_id' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'start_break',
		'end_break'
	];

	public function reason_break()
	{
		return $this->belongsTo(\App\Models\ReasonBreak::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
