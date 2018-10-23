<?php

namespace App\Models;

class Callback extends \App\Models\Base\Callback
{
    public static $logName = 'Callback';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public $labels = [];
    public $filters = [
        'user_id' => '=',
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
    protected $fillable = [
        'user_id',
        'lead_id',
        'state',
        'callback_datetime',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return parent::getDescriptionEvent($eventName);
    }
}
