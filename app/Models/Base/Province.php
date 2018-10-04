<?php

/**
 * Created by hieu.pham.
 * Date: Wed, 03 Oct 2018 18:53:30 +0700.
 */

namespace App\Models\Base;

use App\Models\BaseModel as Eloquent;

/**
 * Class Province
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $leads
 *
 * @package App\Models\Base
 */
class Province extends Eloquent
{
	use \Spatie\Activitylog\Traits\LogsActivity;
	public $timestamps = false;

	public function leads()
	{
		return $this->hasMany(\App\Models\Lead::class);
	}
}
