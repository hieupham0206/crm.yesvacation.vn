<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Tables\Admin\RoleTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected $name = 'role';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.roles.index')->with('role', new Role);
    }

    /**
     * Index table
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new RoleTable()))->getDataTable();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $groups = Role::groupRole();
        $role   = new Role;

        return view('admin.roles.create', compact('groups', 'role'));
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Role $role)
    {
        if ($role->id == 1) {
            return redirect(route('roles.home'));
        }
        $permissions = $role->permissions->pluck('name')->toArray();
        $groups      = Role::groupRole();

        return view('admin.roles.show', compact('groups', 'permissions', 'role'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $permissions = $request->get('permissions', []);
        $roleName    = $request->get('name');

        $role = Role::create(['name' => $roleName]);
        $role->givePermissionTo($permissions);

        return redirect(route('roles.index'))->with('message', __('Data created successfully'));
    }

    public function edit(Role $role)
    {
        if ($role->id == 1) {
            return redirect(route('roles.home'));
        }
        $permissions = $role->permissions->pluck('name')->toArray();

        $groups = Role::groupRole();

        return view('admin.roles.edit', compact('groups', 'permissions', 'role'));
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $roleName           = $request->get('name');
        $permissions        = $request->get('permissions');
        $currentPermissions = $role->permissions->pluck('name');

        $removePermissions = $currentPermissions->diff($permissions);
        $newPermissions    = collect($permissions)->diff($currentPermissions);

        $role->update(['name' => $roleName]);

        //add new permission
        if ($newPermissions) {
            $role->givePermissionTo($newPermissions);
        }

        //remove permission
        if ($removePermissions) {
            $role->revokePermissionTo($removePermissions->toArray());
        }

        return redirect(route('roles.index'))->with('message', __('Data edited successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully')
        ]);
    }

    /**
     * Remove multiple resource from storage.
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroys()
    {
        try {
            $ids = \request()->get('ids');
            Role::destroy($ids);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}"
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully')
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles(Request $request)
    {
        $query      = $request->get('query', '');
        $page       = $request->get('page', 1);
        $excludeIds = $request->get('excludeIds', []);

        $offset = ($page - 1) * 10;
        $roles  = Role::query()->select(['id', 'name']);

        if ($query) {
            $roles = $roles->where('name', 'like', "%{$query}%");
        }

        if ($excludeIds) {
            $roles = $roles->whereNotIn('id', $excludeIds);
        }

        return response()->json([
            'total_count' => $roles->count(),
            'items'       => $roles->offset($offset)->limit(10)->get()->toArray(),
        ]);
    }
}
