<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $permissions = \is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user = app('auth')->user();
        if ($user->hasRole('Admin') || $user->hasAnyPermission($permissions)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
