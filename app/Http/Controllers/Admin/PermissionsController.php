<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Tables\Admin\PermissionTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    protected $name = 'permission';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.permissions.index')->with('permission', new Permission);
    }

    /**
     * Index table
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new PermissionTable()))->getDataTable();
    }

    /**
     *
     * @return void
     */
    public function create()
    {
        //note: không sử dụng
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        //note: không sử dụng
    }

    /**
     *
     * @param  Permission $permission
     *
     * @return void
     */
    public function show(Permission $permission)
    {
        //note: không sử dụng
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission $permission
     *
     * @return \Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        if ($permission->namespace == 'admin') {
            abort(403);
        }
        $module      = $permission->module;
        $permissions = Permission::getModulePermission(Permission::all(['name', 'can_delete']), $module);

        return view('admin.permissions.edit', compact('permission', 'permissions', 'module'))->with('submitButtonText', __('Update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'module' => 'required'
        ]);
        $permissions       = $request->get('permissions');
        $module            = $request->get('module');
        $modulePermissions = Permission::getModulePermission(Permission::all(['name', 'can_delete']), $module);

        //add new permission
        $newPermissions  = array_diff($permissions, $modulePermissions->pluck('action')->toArray());
        $permissionDatas = [];
        foreach ($newPermissions as $newPermission) {
            $action            = strtolower(str_slug($newPermission));
            $permissionDatas[] = [
                'name'       => "{$action}-{$module}",
                'module'     => $module,
                'action'     => $action,
                'can_delete' => 1
            ];
        }
        Permission::insert($permissionDatas);

        //delete permission if any
        $deletePermissions = array_diff($modulePermissions->pluck('action')->toArray(), $permissions);
        if ($deletePermissions) {
            $deletePermissions = array_values($deletePermissions);
            $deletePermissions = array_map('lcfirst', $deletePermissions);

            $permissionDeleteIds = Permission::query()->where('module', $module)
                                             ->whereIn('action', $deletePermissions)
                                             ->get(['id']);
            Permission::destroy($permissionDeleteIds->toArray());
        }

        return redirect(route('permissions.index'))->with('message', __('Data edited successfully'));
    }

    /**
     *
     * @param Permission $permission
     *
     * @return void
     */
    public function destroy(Permission $permission)
    {
        //note: không sử dụng
    }
}