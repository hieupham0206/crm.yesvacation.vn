<?php

namespace App\Models;

class EventData extends \App\Models\Base\EventData
{
	protected $fillable = [
		'lead_id',
		'appointment_datetime',
		'time_in',
		'time_out',
		'show_up',
		'deal'
	];
	public static $logName = 'EventData';

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
