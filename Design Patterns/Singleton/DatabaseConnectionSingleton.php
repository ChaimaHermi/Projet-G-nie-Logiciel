<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

class DatabaseConnectionSingleton
{
    private static $instance = null; // Initialisation à null

    // Connexion à la base de données
    private $connection;

    // Le constructeur est privé
    private function __construct()
    {
        // Initialisation de la connexion à la base de données avec Laravel
        $this->connection = DB::connection();
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

    // Retourne la connexion
    public function getConnection()
    {
        echo 'Connection is valid';
        return $this->connection;
    }
}
