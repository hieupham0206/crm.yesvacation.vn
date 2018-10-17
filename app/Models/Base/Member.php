<?php

/**
 * Created by hieu.pham.
 * Date: Mon, 15 Oct 2018 10:47:02 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Member
 * 
 * @property int $id
 * @property string $title
 * @property string $name
 * @property int $gender
 * @property \Carbon\Carbon $birthday
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $email
 * @property string $spouce_name
 * @property string $spouce_phone
 * @property \Carbon\Carbon $spouce_birthday
 * @property string $spouce_email
 * @property string $product_type
 * @property string $membership_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $contracts
 * @property \Illuminate\Database\Eloquent\Collection $history_calls
 *
 * @package App\Models\Base
 */
class Member extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \Spatie\Activitylog\Traits\LogsActivity;

	protected $casts = [
		'gender' => 'int'
	];

	protected $dates = [
		'birthday',
		'spouce_birthday'
	];

	public function contracts()
	{
		return $this->hasMany(\App\Models\Contract::class);
	}

	public function history_calls()
	{
		return $this->hasMany(\App\Models\HistoryCall::class);
	}
}
