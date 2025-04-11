
<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function paginateUsers(int $perPage);
    public function createUser(array $data): User;
    public function updateUser(User $user, array $data): User;
    public function deleteUser(int $userId): bool;
    public function findUserById(int $id): ?User;
    public function getFilteredUsers(Request $request);
}
