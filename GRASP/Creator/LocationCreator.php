<?php

namespace App\Factories;

use App\Models\{
    Cluster,
    Facility,
    Building,
    Section,
    Office,
    OfficeType
};

class LocationCreator
{
    // Définition de la hiérarchie des entités et de leurs attributs
    private static $hierarchy = [
        // Cluster : modèle, format de référence et champs à remplir
        'cluster' => [
            'model' => Cluster::class,
            'reference_format' => 'C%02u', // Format de référence pour Cluster
            'fields' => ['name', 'description', 'address', 'latitude', 'longitude']
        ],
        // Facility : modèle, parent (Cluster), format de référence et champs à remplir
        'facility' => [
            'model' => Facility::class,
            'parent' => 'cluster', // Facility appartient à un Cluster
            'reference_format' => '%s-F%02u', // Format de référence pour Facility
            'fields' => ['name', 'description', 'address', 'latitude', 'longitude']
        ],
        // Building : modèle, parent (Facility), format de référence et champs à remplir
        'building' => [
            'model' => Building::class,
            'parent' => 'facility', // Building appartient à une Facility
            'reference_format' => '%s-B%02u', // Format de référence pour Building
            'fields' => ['name', 'description', 'address', 'latitude', 'longitude']
        ],
        // Section : modèle, parent (Building), format de référence et champs à remplir
        'section' => [
            'model' => Section::class,
            'parent' => 'building', // Section appartient à un Building
            'reference_format' => '%s-S%02u', // Format de référence pour Section
            'fields' => ['name', 'description', 'address', 'longitude', 'latitude']
        ],
        // Office : modèle, parent (Section), format de référence et champs à remplir
        'office' => [
            'model' => Office::class,
            'parent' => 'section', // Office appartient à une Section
            'reference_format' => '%s-%s%02u', // Format de référence pour Office
            'fields' => ['name', 'description', 'office_type_id'],
            'extra_logic' => true // Logique supplémentaire pour Office
        ]
    ];

    /**
     * Crée une instance d'une entité en fonction du type fourni (cluster, facility, building, section, office).
     *
     * @param string $type Le type de location à créer (cluster, facility, building, section, office)
     * @param array $attributes Attributs supplémentaires pour personnaliser l'entité
     * @param mixed $parent Le parent de l'entité (utilisé dans la hiérarchie si nécessaire)
     * @return \Illuminate\Database\Eloquent\Model L'instance créée de l'entité demandée
     */
    public static function create(string $type, array $attributes = [], $parent = null)
    {
        // Vérification si le type existe dans la hiérarchie
        if (!array_key_exists($type, self::$hierarchy)) {
            throw new \InvalidArgumentException("Type de location invalide: $type");
        }

        // Récupération de la configuration pour le type d'entité
        $config = self::$hierarchy[$type];
        $modelClass = $config['model'];

        // Gestion du parent si nécessaire (ex: Facility a besoin d'un Cluster en parent)
        if (isset($config['parent']) && !$parent) {
            // Récupère un parent aléatoire pour cette entité dans la hiérarchie
            $parent = $modelClass::{$config['parent']}()->getRelated()::inRandomOrder()->first();
        }

        // Préparation des données à insérer dans l'entité
        $data = array_merge(
            self::generateFakeData($config['fields']), // Générer des données factices
            $attributes // Fusionner avec les attributs personnalisés si fournis
        );

        // Création de l'instance de l'entité (avec ou sans parent)
        if ($parent) {
            $instance = $parent->{$type.'s'}()->create($data); // Crée l'entité avec son parent
        } else {
            $instance = $modelClass::create($data); // Crée l'entité sans parent
        }

        // Génération de la référence pour l'entité
        $instance->reference = self::generateReference($instance, $config);
        $instance->save(); // Sauvegarde l'entité avec sa référence

        // Logique spécifique pour Office : Ajout de l'office_type_id si nécessaire
        if ($type === 'office' && !isset($data['office_type_id'])) {
            $instance->office_type_id = OfficeType::inRandomOrder()->first()->id; // Récupérer un OfficeType aléatoire
            $instance->save();
        }

        return $instance; // Retourner l'entité créée
    }

    /**
     * Génère des données factices pour les champs spécifiés.
     *
     * @param array $fields Les champs à générer
     * @return array Les données générées
     */
    private static function generateFakeData(array $fields): array
    {
        // Créer une instance de Faker pour générer des données aléatoires
        $faker = \Faker\Factory::create();
        $data = [];

        // Pour chaque champ à générer
        foreach ($fields as $field) {
            if (in_array($field, ['name', 'description'])) {
                // Pour 'name' et 'description', générer un mot aléatoire en anglais et en arabe
                $data[$field] = [
                    'en' => $faker->word,
                    'ar' => $faker->word
                ];
            } elseif ($field === 'address') {
                // Pour 'address', générer une adresse aléatoire
                $data[$field] = $faker->address;
            } elseif (in_array($field, ['latitude', 'longitude'])) {
                // Pour 'latitude' et 'longitude', générer une coordonnée aléatoire
                $data[$field] = $faker->{$field};
            }
        }

        return $data; // Retourner les données générées
    }

    /**
     * Génère une référence unique pour l'entité, selon la configuration fournie.
     *
     * @param $instance L'entité créée
     * @param array $config La configuration du type d'entité
     * @return string La référence générée
     */
    private static function generateReference($instance, array $config): string
    {
        // Si le format de la référence contient '%s-%s%02u' et que l'entité est un Office
        if ($config['reference_format'] === '%s-%s%02u' && $instance instanceof Office) {
            // Générer la référence pour un Office en utilisant la section et le type d'office
            return sprintf(
                $config['reference_format'],
                $instance->section->reference, // Référence de la section
                $instance->officeType->abbreviation, // Abréviation du type d'office
                $instance->id // ID de l'office
            );
        }

        // Si le format de la référence contient '%s' et qu'il y a un parent
        if (str_contains($config['reference_format'], '%s') && isset($config['parent'])) {
            // Générer la référence en utilisant la référence du parent
            return sprintf(
                $config['reference_format'],
                $instance->{$config['parent']}->reference, // Référence du parent
                $instance->id // ID de l'entité
            );
        }

        // Dans les autres cas, simplement utiliser l'ID de l'entité
        return sprintf($config['reference_format'], $instance->id);
    }
}
