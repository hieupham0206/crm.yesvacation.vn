<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissionConfigs = getPermissionConfig();

        $permissions = [];

        foreach ($permissionConfigs as $permissionConfig) {
            $modules = $permissionConfig['modules'];
            foreach ($modules as $moduleName => $module) {
                foreach ($module['actions'] as $action) {
                    // create permissions
                    $permissions[] = [
                        'name'       => "{$action}-{$moduleName}",
                        'guard_name' => 'web',
                        'module'     => $moduleName,
                        'action'     => $action,
                        'can_delete' => 0,
                        'namespace'  => 'admin'
                    ];

                }
            }
        }

        Permission::insert($permissions);
    }
}
