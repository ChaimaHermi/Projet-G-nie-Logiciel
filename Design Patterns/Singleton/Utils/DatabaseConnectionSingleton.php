<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

class DatabaseConnectionSingleton
{
    private static $instance = null; // Instance unique

    // Le constructeur est privé
    private function __construct()
    {
        // Laravel gère déjà la connexion, nous n'avons pas besoin de la stocker
    }

    // Empêche le clonage de l'instance
    private function __clone() {}

    // Empêche la désérialisation de l'instance
    private function __wakeup() {}

    // Retourne l'instance unique
    public static function getInstance()
    {
        // Vérification explicite de null
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Retourne la connexion Laravel (pas besoin de la stocker manuellement)
    public function getConnection()
    {
        return DB::connection();  // Laravel gère l'unicité de la connexion
    }
}
