<?php

namespace App\Models;

class Lead extends \App\Models\Base\Lead
{
	protected $fillable = [
		'title',
		'name',
		'email',
		'gender',
		'birthday',
		'address',
		'province_id',
		'phone',
		'state',
		'comment'
	];
	public static $logName = 'Lead';

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
