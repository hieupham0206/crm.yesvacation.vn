<?php

namespace App\Models;

class EventData extends \App\Models\Base\EventData
{
	protected $fillable = [
		'appointment_id',
		'lead_id',
		'code',
		'time_in',
		'time_out',
		'show_up',
		'deal',
		'rep_id',
		'to_id',
	];
	public static $logName = 'EventData';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $labels = [];

    public $filters = [
        'code' => 'like'
    ];

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
