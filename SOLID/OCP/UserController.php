<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests.UserUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\FileUploader;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use FileUploader;

    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            Log::critical('index user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function create()
    {
        try {
            return view('admin.users.create', [
                'roles' => Role::select('name', 'id', 'traduction_name')->get(),
                'permissions' => Permission::select('name', 'id', 'traduction_name')->get()
            ]);
        } catch (\Exception $e) {
            Log::critical('create user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function store(UserCreateRequest $request, UserService $userService)
    {
        try {
            $user = $userService->createUser($request);
            $user->assignRole($request->role);
            $user->givePermissionTo(Role::findById($request->role)->permissions);
            $this->success(__('admin.messages.success_add'));
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::critical('store user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function edit(User $user)
    {
        try {
            return view('admin.users.edit', compact('user'), [
                'roles' => Role::select('name', 'id', 'traduction_name')->get(),
                'permissions' => Permission::select('name', 'id', 'traduction_name')->get()
            ]);
        } catch (\Exception $e) {
            Log::critical('edit user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function update(User $user, UserUpdateRequest $request, UserService $userService)
    {
        try {
            $userService->updateUser($user, $request);
            $user->syncRoles($request->role);
            $user->syncPermissions(Role::findById($request->role)->permissions);
            $this->success(__('admin.messages.success_edit'));
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::critical('edit user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if (!empty($user)) {
                $user->delete();

                return response()->json([
                    'status' => 1,
                    'message' => __('admin.messages.success_delete', ['model' => __('admin.models.user')]),
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => __('admin.messages.error_delete_not_found', ['model' => __('admin.models.user')]),
            ]);
        } catch (\Exception $e) {
            Log::critical('destroy user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function show(User $user)
    {
        $locale = app()->getLocale();

        $permissions = DB::table('permissions')
            ->select('id', "traduction_name->{$locale} as traduction_name")
            ->whereIn('id', Role::findByName($user->getRole())->permissions()->get()->pluck('id'))
            ->get();

        try {
            return view('admin.users.show', compact('user'), [
                'role' => $user->getRole(),
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            Log::critical('show user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if (!empty($user)) {
                $user->status = ($user->status == 'enabled') ? 'not_enabled' : 'enabled';
                $user->update();

                return response()->json([
                    'status' => 1,
                    'message' => 'success',
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => __('admin.messages.error_delete_not_found', ['model' => __('admin.models.user')]),
            ]);
        } catch (\Exception $e) {
            Log::critical('change status user error ' . $e->getMessage());
            abort(500);
        }
    }

    public function getAllPermissionsRole(Role $role, Request $request)
    {
        return response()->json([
            'error' => false,
            'data' => $role->permissions()->get()->pluck('id'),
        ], 200);
    }

    public function getUsers(Request $request)
    {
        $users = User::query();

        if ($request->has('search') && !empty($request->search)) {
            $users->search($request->search);
        }

        $view = view('admin.users.filter', [
            'users' => $users->latest()->paginate(10),
        ]);

        return response()->json([
            'data' => $view->render(),
        ]);
    }
}
