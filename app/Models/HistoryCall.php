<?php

namespace App\Models;

class HistoryCall extends \App\Models\Base\HistoryCall
{
	protected $fillable = [
		'user_id',
		'lead_id',
		'member_id',
		'name',
		'phone',
		'time_of_call',
		'type'
	];
	public static $logName = 'HistoryCall';

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
