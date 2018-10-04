<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\LeadState;

/**
 * App\Models\Lead
 *
 * @property int $id
 * @property string|null $title
 * @property string $name
 * @property string|null $email
 * @property int $gender 1: Nam; 2: Nữ
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $address
 * @property int|null $province_id Tỉnh thành phố
 * @property string|null $phone
 * @property int $state 1: New Customer; 2: DeadNumber; 3: WrongNumber; 4: OtherCity; 5: NoAnswer; 6: NoInterested; 7: CallLater; 8: Appointment
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \App\Models\ActivityLog $createdBy
 * @property-read \App\Models\ActivityLog $deletedBy
 * @property-read mixed $confirmations
 * @property-read mixed $gender_text
 * @property-read mixed $genders
 * @property-read mixed $state_text
 * @property-read mixed $states
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\ActivityLog $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lead extends \App\Models\Base\Lead
{
    public static $logName = 'Lead';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public $labels = [
        'name'     => 'Họ tên',
        'birthday' => 'Ngày sinh',
    ];
    public $filters = [
        'name'    => 'like',
        'email'   => 'like',
        'phone'   => 'like',
        'address' => 'like',
        'gender'  => '=',
        'state'   => '=',
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
        'title',
        'name',
        'email',
        'gender',
        'birthday',
        'address',
        'province_id',
        'phone',
        'state',
        'comment'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return parent::getDescriptionEvent($eventName);
    }

    public function getGendersAttribute()
    {
        return Gender::toSelectArray();
    }

    public function getStatesAttribute()
    {
        return LeadState::toSelectArray();
    }

    public function getGenderTextAttribute()
    {
        return Gender::getDescription($this->gender);
    }

    public function getStateTextAttribute()
    {
        return LeadState::getDescription($this->state);
    }
}
