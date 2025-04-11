<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function paginateUsers(int $perPage)
    {
        return User::paginate($perPage);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function deleteUser(int $userId): bool
    {
        $user = User::find($userId);
        return $user ? $user->delete() : false;
    }

    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }

    public function getFilteredUsers(Request $request)
    {
        $query = User::query();
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        return $query->latest()->paginate(10);
    }
}
