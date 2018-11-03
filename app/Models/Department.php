<?php

namespace App\Models;

use App\Enums\UserPosition;

class Department extends \App\Models\Base\Department
{
    protected $fillable = [
        'name',
        'province_id',
    ];
    public static $logName = 'Department';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $labels = [
        'name'     => 'Tên phòng',
        'position' => 'Vị trí',
    ];

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

    public function getPositionsAttribute()
    {
        return UserPosition::toSelectArray();
    }
}
