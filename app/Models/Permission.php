<?php

namespace App\Models;

use App\Traits\Core\Labelable;
use App\Traits\Core\Queryable;
use Illuminate\Support\Collection;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $module
 * @property string $action
 * @property string $namespace
 * @property string $can_delete 0: không được delete, 1: có thể delete
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends \App\Models\Base\Permission
{
    use Labelable, Queryable;

    public static $logName = 'permission';

    protected static $logOnlyDirty = true;

    protected static $recordEvents = ['updated', 'deleted'];

    /**
     * @inheritdoc
     */
    public function getRouteKeyName(): string
    {
        return 'module';
    }

    /**
     * @param Permission[] $permissions
     * @param $module
     *
     * @return Collection
     */
    public static function getModulePermission($permissions, $module): Collection
    {
        return $permissions->filter(function ($permission) use ($module) {
            return strpos($permission->name, $module);
        })->map(function ($permission) use ($module) {
            $action = str_before($permission->name, "-{$module}");

            $action = ucfirst(trim($action));

            return [
                'action'     => $action,
                'can_delete' => $permission->can_delete
            ];
        });
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return parent::getDescriptionEvent($eventName);
    }
}
