<?php

namespace App\Models;

class TimeBreak extends \App\Models\Base\TimeBreak
{
	protected $fillable = [
		'reason_break_id',
		'start_break',
		'end_break',
		'another_reason',
        'user_id'
	];
	public static $logName = 'TimeBreak';

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
