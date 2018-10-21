<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ReasonBreak;
use App\Models\Role;
use App\Models\TimeBreak;
use App\Models\User;
use App\Tables\Admin\UserTable;
use App\Tables\TableFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Tên dùng để phần quyền
     * @var string
     */
    protected $name = 'user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['rolepermission:update-user'], ['only' => ['changeStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index')->with('user', new User);
    }

    /**
     * @return string
     */
    public function table()
    {
        return (new TableFacade(new UserTable))->getDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Role::groupRole();
        $user   = new User;

        return view('admin.users.create', compact('user', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username|string|max:255',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            ],
        ]);

        /** @var User $user */
        $user = User::create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'password' => \Hash::make($request->input('password')),
        ]);

        //DIRECT PERMISSION
        $permissions = $request->get('permissions', []);
        $user->givePermissionTo($permissions);

        //PERMISSION VIA ROLE
        $roleId = $request->get('role_id', '');
        if ($roleId) {
            $user->assignRole(Role::find((int) $request->input('role_id')));
        }

        return redirect(route('users.index'))->with('message', __('Data created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $logs = ActivityLog::whereCauserId($user->id)->whereSubjectType(\get_class($user))->select(['description', 'properties', 'created_at'])->latest()->get();

        return view('admin.users.show', compact('user', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles  = $user->roles->toArray();
        $groups = Role::groupRole();

        $permissions = $user->permissions->pluck('name')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'groups', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required|string|max:255',
            'password' => [
                'sometimes',
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            ],
        ]);

        $user->fill($request->all());
        $user->password = $user->getOriginal('password');
        $newPassword    = $request->get('password');
        if ($newPassword) {
            $user->password = \Hash::make($newPassword);
        }
        $user->update();

        //DIRECT PERMISSION
        $permissions        = $request->get('permissions');
        $currentPermissions = $user->permissions->pluck('name');
        $removePermissions  = $currentPermissions->diff($permissions);
        $newPermissions     = collect($permissions)->diff($currentPermissions);

        //add new permission
        if ($newPermissions) {
            $user->givePermissionTo($newPermissions);
        }

        //remove permission
        if ($removePermissions) {
            $user->revokePermissionTo($removePermissions->toArray());
        }

        //PERMISSION VIA ROLE
        $roleId = $request->get('role_id');
        if ($roleId) {
            $currentRole = $user->roles->first();

            if ( ! $currentRole || $currentRole->id != $roleId) {
                //Xóa role hien tai di
                if ($currentRole) {
                    $user->removeRole($currentRole->id);
                }

                $role = Role::find((int) $roleId);
                if ( ! $user->hasRole($role)) {
                    $user->assignRole($role);
                }
            }
        }

        if ($request->isConfirm) {
            return response()->json([
                'message' => __('Data edited successfully'),
            ]);
        }

        return redirect(route('users.index'))->with('message', __('Data edited successfully'));
    }

    /**
     * Show the form for editing the multiple resource.
     *
     * @param  \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edits(User $user)
    {
        $action = route('users.updates');

        return view('admin.users._form_edit', compact('user', 'action'));
    }

    /**
     * Update the multiple resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updates(Request $request)
    {
        $this->validate($request, [
            'password' => 'sometimes|nullable|confirmed',
        ]);
        $ids   = explode(',', $request->get('ids'));
        $users = User::query()->whereIn('id', $ids)->get();
        /** @var User[] $users */
        foreach ($users as $user) {
            $user->fillable([
                'password',
                'state',
            ]);

            $user->fill($request->all());
            $user->password = $user->getOriginal('password');
            $newPassword    = $request->get('password');
            if ($newPassword) {
                $user->password = \Hash::make($newPassword);
            }

            $user->update();

            $roleId = $request->get('role_id');
            if ( ! empty($roleId)) {
                $role = Role::find((int) $roleId);
                if ( ! $user->hasRole($role)) {
                    $user->assignRole($role);
                }
            }
        }

        return response()->json([
            'message' => __('Data edited successfully'),
        ]);
    }

    /**
     * Lấy danh sách User theo dạng json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
    {
        $query      = request()->get('query', '');
        $page       = request()->get('page', 1);
        $excludeIds = request()->get('excludeIds', []);
        $offset     = ($page - 1) * 10;
        $users      = User::query()->select(['id', 'username']);

        $users->andFilterWhere([
            ['id', '!=', $excludeIds],
            ['username', 'like', $query],
        ]);

        $totalCount = $users->count();
        $users      = $users->offset($offset)->limit(10)->get();

        return response()->json([
            'total_count' => $totalCount,
            'items'       => $users->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeState(Request $request, User $user)
    {
        $state = $request->post('state');

        try {
            if ($state !== null && $user->update(['state' => $state])) {
                return response()->json([
                    'message' => __('Data edited successfully'),
                ]);
            }

            return response()->json([
                'message' => __('Data edited unsuccessfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully'),
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
            User::destroy($ids);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Error: {$e->getMessage()}",
            ], $e->getCode());
        }

        return response()->json([
            'message' => __('Data deleted successfully'),
        ]);
    }

    public function formChangePassword()
    {
        return view('admin.users._form_change_password', ['user' => auth()->user()]);
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password'         => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            ],
        ]);

        $currentPassword = $request->get('current_password');
        $password        = $request->get('password');

        /** @var User $user */
        $user = auth()->user();

        if (password_verify($currentPassword, $user->password)) {
            $user->password = \Hash::make($password);

            $user->setRememberToken(Str::random(60));

            $user->save();

            return response()->json([
                'message' => __('Password changed successfully'),
            ]);
        }

        return response()->json([
            'message' => __('Current password is not correct'),
        ], 500);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formBreak()
    {
        $reasonBreaks = ReasonBreak::get();
        $user         = auth()->user();

        return view('admin.users._form_break', compact('reasonBreaks', 'user'));
    }

    public function break(Request $request)
    {
        $reasonBreakId     = $request->reason_break_id;
        $anotherReasonText = $request->get('reason', '');

        $breakDatas = [
            'start_break'     => now()->toDateTimeString(),
            'reason_break_id' => $reasonBreakId,
            'user_id'         => auth()->id(),
        ];
        if ($anotherReasonText) {
            $breakDatas['another_reason'] = $anotherReasonText;
        }

        $timebreak = TimeBreak::create($breakDatas);

        return response()->json([
            'message'      => __('Data edited successfully'),
            'maxTimeBreak' => $timebreak->reason_break->time_alert * 60,
        ]);
    }

    public function resume()
    {
        $timebreak = TimeBreak::query()->where('user_id', auth()->id())
                              ->whereNotNull('start_break')
                              ->whereNull('end_break')
                              ->latest()
                              ->first();

        if ($timebreak) {
            $timebreak->update([
                'end_break' => now()->toDateTimeString(),
            ]);

            return response()->json([
                'message' => __('Data edited successfully'),
            ]);
        }

        return response()->json([
            'message' => __('Data edited unsuccessfully'),
        ]);
    }
}
