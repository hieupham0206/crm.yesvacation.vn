<?php

/**
 * Created by hieu.pham.
 * Date: Fri, 05 Oct 2018 10:13:20 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property int $state
 * @property string $phone
 * @property float $basic_salary
 * @property \Carbon\Carbon $birthday
 * @property \Carbon\Carbon $first_day_work
 * @property string $address
 * @property string $note
 * @property int $use_otp
 * @property string $otp
 * @property \Carbon\Carbon $otp_expired_at
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $last_login
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $bonuses
 * @property \Illuminate\Database\Eloquent\Collection $contract_details
 * @property \Illuminate\Database\Eloquent\Collection $event_data_details
 * @property \Illuminate\Database\Eloquent\Collection $final_salaries
 * @property \Illuminate\Database\Eloquent\Collection $history_calls
 * @property \Illuminate\Database\Eloquent\Collection $departments
 *
 * @package App\Models\Base
 */
class User extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'state' => 'int',
		'basic_salary' => 'float',
		'use_otp' => 'int'
	];

	protected $dates = [
		'birthday',
		'first_day_work',
		'otp_expired_at',
		'last_login'
	];

	public function bonuses()
	{
		return $this->hasMany(\App\Models\Bonus::class);
	}

	public function contract_details()
	{
		return $this->hasMany(\App\Models\ContractDetail::class);
	}

	public function event_data_details()
	{
		return $this->hasMany(\App\Models\EventDataDetail::class);
	}

	public function final_salaries()
	{
		return $this->hasMany(\App\Models\FinalSalary::class);
	}

	public function history_calls()
	{
		return $this->hasMany(\App\Models\HistoryCall::class);
	}

	public function departments()
	{
		return $this->belongsToMany(\App\Models\Department::class, 'user_department')
					->withPivot('id', 'type')
					->withTimestamps();
	}
}
