<?php
namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    use FileUploader;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listUsers()
    {
        return $this->userRepository->paginateUsers(10);
    }

    public function createUser(Request $request): User
    {
        $user = new User();
        $this->fillUserData($user, $request);
        $user->save();

        $user->assignRole($request->role);
        $user->givePermissionTo(Role::findById($request->role)->permissions);

        return $user;
    }

    public function updateUser(User $user, Request $request): User
    {
        $this->fillUserData($user, $request);
        $user->save();

        $user->syncRoles($request->role);
        $user->syncPermissions(Role::findById($request->role)->permissions);

        return $user;
    }

    public function deleteUser(Request $request): bool
    {
        return $this->userRepository->deleteUser($request->user_id);
    }

    public function getFilteredUsers(Request $request)
    {
        return $this->userRepository->getFilteredUsers($request);
    }

    private function fillUserData(User $user, Request $request)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);
        $user->password_decrypt = $request->password;

        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'users/', 'image');
            $user->image = $image;
        }
    }
}
