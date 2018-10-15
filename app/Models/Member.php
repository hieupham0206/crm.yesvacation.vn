<?php

namespace App\Models;

class Member extends \App\Models\Base\Member
{
	protected $fillable = [
		'title',
		'name',
		'gender',
		'birthday',
		'address',
		'city',
		'phone',
		'email',
		'spouce_name',
		'spouce_phone',
		'spouce_birthday',
		'spouce_email',
		'product_type',
		'membership_type'
	];
	public static $logName = 'Member';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $labels = [];

    public $filters = [];

    /**
     * Route của model dùng cho Linkable trait
     * @var string
     */
    public $route = '';

    /**
     * Column dùng để hiển thị cho model (Default là name)
     * @var string
     */
     public $displayAttribute = 'name';

	public function getDescriptionForEvent(string $eventName): string
    {
        return parent::getDescriptionEvent($eventName);
    }
}
