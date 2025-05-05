<?php

namespace App\Utils;  // Le fichier est dans le dossier App/Utils

use Illuminate\Support\Facades\DB;  // On importe le "facade" DB de Laravel pour interagir avec la base de données

/**
 * Classe DatabaseConnectionSingleton
 * Cette classe suit le **design pattern Singleton** pour s'assurer qu'on utilise **une seule instance** 
 * pour accéder à la connexion à la base de données dans toute l'application.
 */
class DatabaseConnectionSingleton
{
    // Stocke l'unique instance de la classe
    private static $instance = null;

    /**
     * Constructeur privé
     * Cela empêche la création d'une instance de la classe avec "new" de l'extérieur.
     * => Seule la méthode "getInstance()" pourra créer l'objet.
     */
    private function __construct()
    {
        // Rien à faire ici, car Laravel gère déjà automatiquement les connexions à la base de données.
    }

    /**
     * Méthode __clone privée
     * Cela interdit de cloner l'objet avec "clone", pour éviter d'avoir plusieurs instances.
     */
    private function __clone() {}

    /**
     * Méthode __wakeup privée
     * Cela interdit de "désérialiser" l'objet (ex : recréer une instance depuis une chaîne de caractères).
     */
    private function __wakeup() {}

    /**
     * Méthode publique pour obtenir l'unique instance de la classe
     * - Si elle n'existe pas encore, on la crée
     * - Sinon, on retourne l'instance existante
     */
    public static function getInstance()
    {
        // Si aucune instance n'a encore été créée...
        if (self::$instance === null) {
            // On crée une nouvelle instance
            self::$instance = new self();
        }

        // On retourne l'instance existante
        return self::$instance;
    }
}
