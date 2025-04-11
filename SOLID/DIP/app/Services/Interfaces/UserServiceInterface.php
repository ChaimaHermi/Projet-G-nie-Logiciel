<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use App\Models\User;

interface UserServiceInterface
{
    public function listUsers();
    public function createUser(Request $request): User;
    public function updateUser(User $user, Request $request): User;
    public function deleteUser(Request $request): bool;
    public function getFilteredUsers(Request $request);
}
