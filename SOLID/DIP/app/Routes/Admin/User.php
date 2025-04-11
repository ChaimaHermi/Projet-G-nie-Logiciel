<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Afficher la liste des utilisateurs
Route::get('/', [UserController::class, 'index'])->name('.index');

// Afficher le formulaire de création
Route::get('/create', [UserController::class, 'create'])->name('.create');

// Afficher les détails d'un utilisateur
Route::get('/show/{user}', [UserController::class, 'show'])->name('.show');

// Créer un nouvel utilisateur
Route::post('/store', [UserController::class, 'store'])->name('.store');

// Afficher le formulaire d'édition
Route::get('/edit/{user}', [UserController::class, 'edit'])->name('.edit');

// Mettre à jour un utilisateur existant
Route::put('/update/{user}', [UserController::class, 'update'])->name('.update'); // Utilisation de PUT pour une mise à jour complète

// Supprimer un utilisateur
Route::delete('/destroy', [UserController::class, 'destroy'])->name('.destroy');

// Changer le statut d'un utilisateur
Route::patch('/change-status', [UserController::class, 'changeStatus'])->name('.change.status'); // Utilisation de PATCH pour une mise à jour partielle

// Obtenir toutes les permissions d'un rôle
Route::get('/getAllPermissionsRole/{role}', [UserController::class, 'getAllPermissionsRole'])->name('.getAllPermissionsRole');

// Récupérer les utilisateurs filtrés
Route::get('filter', [UserController::class, 'getUsers'])->name('.filter');
