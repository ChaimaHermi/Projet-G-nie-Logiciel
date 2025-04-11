<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use App\Services\Interfaces\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Lier l'interface UserRepositoryInterface à son implémentation UserRepository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Lier l'interface UserServiceInterface à son implémentation UserService
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    public function boot()
    {
        //
    }
}
