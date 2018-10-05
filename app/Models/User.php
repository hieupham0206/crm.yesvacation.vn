<?php

namespace App\Models;

use App\Enums\Confirmation;
use App\Enums\UserState;
use App\Traits\{Core\Labelable, Core\Linkable, Core\Modelable, Core\Queryable, Core\Searchable};
use Illuminate\{Database\Eloquent\SoftDeletes, Foundation\Auth\User as Authenticatable, Notifications\Notifiable};
use Spatie\{Activitylog\Traits\LogsActivity, Permission\Traits\HasRoles};

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string $email
 * @property string|null $phone
 * @property int $state                  -1: Chưa kích hoạt; 1: Đã kích hoạt
 * @property int|null $actor_id
 * @property string|null $actor_type
 * @property int $use_otp                1: có sử dụng; -1: Không sử dụng
 * @property string|null $otp
 * @property string|null $otp_expired_at OTP hết hạn trong 5 phút
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $last_login
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $actor
 * @property-read mixed $is_use_otp
 * @property-read mixed $state_name
 * @property-read mixed $state_text
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtpExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUseOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, LogsActivity, HasRoles, Searchable, Labelable, Queryable, SoftDeletes, Linkable, Modelable;

    public static $logName = 'User';
    protected static $logAttributes = ['username', 'employee_id'];
    protected static $ignoreChangedAttributes = ['last_login', 'remember_token', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public $route = 'users';
    public $action = '';
    public $displayAttribute = 'username';
    public $labels = [
        'use_otp' => 'Sử dụng OTP',
        'name'    => 'Tên người dùng'
    ];
    public $filters = [
        'username' => 'like',
        'name'     => 'like',
        'phone'    => 'like',
        'email'    => 'like',
        'state'    => '='
    ];
    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'password',
        'state',
//        'use_otp',
//        'otp',
//        'otp_expired_at',
        'actor_id',
        'birthday',
        'first_day_work',
        'address',
        'note',
        'basic_salary',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'last_login'
    ];

    public function actor()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function (User $user) {
            if ($user->isDirty('state')) {
                $user->action = 'activated';
                if ($user->state == 0) {
                    $user->action = 'deactivated';
                }
            }
        });

        self::deleted(function (User $user) {
            $user->update([
                'username' => $user->username . '_' . time()
            ]);
        });
    }

    public function getIsUseOtpAttribute()
    {
        return Confirmation::getDescription($this->state);
    }

    /**
     * @param $username
     *
     * @return string
     */
    public static function getPhone($username)
    {
        $user = self::query()->where('username', $username)->where('use_otp', 1)->first();

        return $user->phone ?? '';
    }

    public function getStateNameAttribute()
    {
        return UserState::getDescription($this->state);
    }

    public function getStateTextAttribute()
    {
        return $this->contextBadge($this->state_name, $this->state === 1 ? 'success' : 'danger');
    }

    public function getStatesAttribute()
    {
        return \App\Enums\UserState::toSelectArray();
    }

    /**
     * Check tài khoản có duoc active hay không
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->state == 1;
    }

    /**
     * Check tài khoản có phãi admin hay không
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * @param $username
     *
     * @return bool
     */
    public static function isUseOtp($username)
    {
        return self::query()->where('username', $username)->where('use_otp', 1)->exists();
    }
}
