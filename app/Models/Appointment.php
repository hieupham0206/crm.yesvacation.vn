<?php

namespace App\Models;

class Appointment extends \App\Models\Base\Appointment
{
	protected $fillable = [
		'user_id',
		'lead_id',
		'state',
		'type',
        'appointment_datetime',
        'code'
	];
	public static $logName = 'Appointment';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $labels = [];

    public $filters = [
        'user_id' => '='
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
