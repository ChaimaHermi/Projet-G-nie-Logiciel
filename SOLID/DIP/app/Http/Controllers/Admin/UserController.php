<?php
<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Traits\FileUploader;

class UserController extends Controller
{
    use FileUploader;

    protected $userService;
    protected $userRepository;

    public function __construct(UserServiceInterface $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * Afficher la liste des utilisateurs.
     */
    public function index()
    {
        $users = $this->userService->listUsers();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'un utilisateur.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Créer un nouvel utilisateur.
     */
    public function store(UserCreateRequest $request)
    {
        $user = $this->userService->createUser($request);

        $this->success(__('admin.messages.success_add'));

        return redirect()->route('users.index');
    }

    /**
     * Afficher le formulaire d'édition de l'utilisateur.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur existant.
     */
    public function update(User $user, UserUpdateRequest $request)
    {
        $this->userService->updateUser($user, $request);

        $this->success(__('admin.messages.success_edit'));

        return redirect()->route('users.index');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(Request $request)
    {
        $success = $this->userRepository->deleteUser($request->user_id);

        return response()->json([
            'status' => $success ? 1 : 0,
            'message' => $success
                ? __('admin.messages.success_delete', ['model' => __('admin.models.user')])
                : __('admin.messages.error_delete_not_found', ['model' => __('admin.models.user')])
        ]);
    }

    /**
     * Récupérer des utilisateurs filtrés.
     */
    public function getUsers(Request $request)
    {
        $users = $this->userRepository->getFilteredUsers($request);

        $view = view('admin.users.filter', ['users' => $users]);

        return response()->json(['data' => $view->render()]);
    }

    /**
     * Afficher un utilisateur.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Changer le statut de l'utilisateur.
     */
    public function changeStatus(User $user, Request $request)
    {
        $user->status = $request->status;
        $user->save();

        $this->success(__('admin.messages.success_status_change'));

        return redirect()->route('users.index');
    }

    /**
     * Obtenir toutes les permissions d'un rôle.
     */
    public function getAllPermissionsRole(Request $request)
    {
        $permissions = Role::findById($request->role_id)->permissions;

        return response()->json([
            'permissions' => $permissions
        ]);
    }
}
