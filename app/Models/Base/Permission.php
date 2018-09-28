<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 10 May 2018 08:58:45 +0700.
 */

namespace App\Models\Base;

use Spatie\Permission\Models\Permission as Eloquent;

/**
 * App\Models\Base\Permission
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Eloquent
{
    use \Spatie\Activitylog\Traits\LogsActivity;
}
