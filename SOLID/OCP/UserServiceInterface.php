<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    /**
     * Crée un nouvel utilisateur
     * 
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request): User;

    /**
     * Met à jour un utilisateur existant
     * 
     * @param User $user
     * @param Request $request
     * @return User
     */
    public function updateUser(User $user, Request $request): User;
}
