<?php

namespace App\Models;

/**
 * App\Models\HistoryCall
 *
 * @property int $id
 * @property int $user_id
 * @property int $lead_id
 * @property int|null $member_id
 * @property int $time_of_call Thoi gian gọi, tính bằng giây
 * @property int $type 1: Manual; 2: HistoryCall; 3:CallBackCall; 4: AppointmentCall
 * @property string|null $comment
 * @property int $state Tương ứng cột state bên lead
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \App\Models\ActivityLog $createdBy
 * @property-read \App\Models\ActivityLog $deletedBy
 * @property-read mixed $confirmations
 * @property-read \App\Models\Lead $lead
 * @property-read \App\Models\Member|null $member
 * @property-read \App\Models\ActivityLog $updatedBy
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereTimeOfCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HistoryCall whereUserId($value)
 * @mixin \Eloquent
 */
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

    public $filters = [
        'user_id' => '=',
        'lead_id' => '=',
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
