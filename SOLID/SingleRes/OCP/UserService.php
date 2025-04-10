<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FileUploader;

class UserService
{
    use FileUploader;

    /**
     * Crée un nouvel utilisateur avec tous les champs obligatoires
     */
    public function createUser(Request $request): User
    {
        $user = new User();
        $this->fillUserData($user, $request);

        // Mot de passe requis à la création
        $user->password = bcrypt($request->password);
        $user->password_decrypt = $request->password;

        // Upload image si présente
        if ($request->hasFile('image')) {
            $user->image = $this->uploadImage($request, 'users/', 'image');
        }

        $user->save();
        return $user;
    }

    /**
     * Met à jour un utilisateur existant (champs partiels possibles)
     */
    public function updateUser(User $user, Request $request): User
    {
        $this->fillUserData($user, $request);

        // Ne modifier le mot de passe que s’il est fourni
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->password_decrypt = $request->password;
        }

        // Mettre à jour l’image si une nouvelle est uploadée
        if ($request->hasFile('image')) {
            $user->image = $this->uploadImage($request, 'users/', 'image');
        }

        $user->save();
        return $user;
    }

    /**
     * Remplit les champs généraux d’un utilisateur (communs à create & update)
     */
    private function fillUserData(User $user, Request $request)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;
    }
}
