<?php

namespace App\Models;

/**
 * App\Models\Appointment
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $lead_id
 * @property string|null $code
 * @property string|null $spouse_name
 * @property string|null $spouse_phone
 * @property \Illuminate\Support\Carbon|null $appointment_datetime
 * @property int $state -1: Hủy; 1: Sử dụng;
 * @property int $is_show_up -1: Không; 1: Có
 * @property int $is_queue -1: Không; 1: Có
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \App\Models\ActivityLog $createdBy
 * @property-read \App\Models\ActivityLog $deletedBy
 * @property-read mixed $confirmations
 * @property-read \App\Models\Lead $lead
 * @property-read \App\Models\ActivityLog $updatedBy
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereAppointmentDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereIsQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereIsShowUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereSpouseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereSpousePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Appointment whereUserId($value)
 * @mixin \Eloquent
 */
class Appointment extends \App\Models\Base\Appointment
{
    protected $fillable = [
        'user_id',
        'lead_id',
        'state',
        'type',
        'appointment_datetime',
        'code',
        'spouse_name',
        'spouse_phone',
        'is_show_up'
    ];
    public static $logName = 'Appointment';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $labels = [];

    public $filters = [
        'user_id' => '=',
        'code'    => 'like',
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
