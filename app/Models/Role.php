<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 5/10/2018
 * Time: 3:26 PM
 */

namespace App\Models;

use App\Traits\{Core\Labelable, Core\Queryable, Core\Searchable};
use Illuminate\Database\Eloquent\Builder;
use Spatie\{Activitylog\Traits\LogsActivity, Permission\Models\Role as Eloquent};

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role dateBetween($fromDate, $toDate, $column = 'created_at', $format = 'd-m-Y')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Eloquent
{
    use LogsActivity, Searchable, Labelable, Queryable;

    public static $logName = 'Role';

    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public $filters = [
        'name' => 'like',
    ];

    protected $fillable = [
        'name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('hideadmin', function (Builder $builder) {
            $builder->where('name', '!=', 'Admin');
        });
    }

    public static function groupRole()
    {
        $permissionConfigs = getPermissionConfig();

        $datas = [];

        foreach ($permissionConfigs as $key => $permissionConfig) {
            $moduleDatas = self::getRolePermission($permissionConfig['modules']);
            $datas[]     = [
                'name'    => __(ucwords($key)),
                'icon'    => $permissionConfig['icon'] ?? '',
                'modules' => $moduleDatas
            ];
        }

        return $datas;
    }

    /**
     * @param $modules
     *
     * @return array
     */
    public static function getRolePermission($modules): array
    {
        $datas = [];
        foreach ($modules as $moduleName => $module) {
            $actions         = $module['actions'];
            $permissionNames = collect($actions)->map(function ($action) use ($moduleName) {
                return ["$action-$moduleName"];
            })->flatten()->toArray();

            $label = ucwords(camel2words($moduleName));

            if (isset($module['hide'])) {
                continue;
            }

            $datas[] = [
                'name'            => __($label),
                'module'          => $module,
                'permissionNames' => $permissionNames,
                'permissions'     => $actions,
            ];
        }

        return $datas;
    }

    /**
     * @inheritdoc
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $modelValName = '';
        if ( ! empty($this->{'name'})) {
            $modelValName = $this->{'name'};
        } elseif ( ! empty($this->{'code'})) {
            $modelValName = $this->{'code'};
        } elseif ( ! empty($this->{'title'})) {
            $modelValName = $this->{'title'};
        }

        $user     = auth()->user();
        $username = $user ? $user->username : 'admin';

        return sprintf('%s %s%s %s', __(ucfirst(static::$logName)), $modelValName, __(" has been {$eventName} by "), $username);
    }
}