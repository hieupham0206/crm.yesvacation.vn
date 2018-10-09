<?php

namespace App\Models;

class ReasonBreak extends \App\Models\Base\ReasonBreak
{
	protected $fillable = [
		'name',
		'time_alert'
	];
	public static $logName = 'ReasonBreak';

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
