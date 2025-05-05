<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Factories\LocationCreator;

class LocationSeeder extends Seeder
{
    /**
     * Exécute le Seeder pour créer des entités de type Cluster, Facility, Building, Section, et Office.
     *
     * @return void
     */
    public function run()
    {
        // Créer un certain nombre de clusters
        for ($i = 1; $i <= 3; $i++) {
            // Créer un cluster
            $cluster = LocationCreator::create('cluster', [
                'name' => "Cluster $i",
                'description' => "Description du Cluster $i",
                'address' => "Adresse du Cluster $i",
                'latitude' => mt_rand(-90, 90),
                'longitude' => mt_rand(-180, 180),
            ]);

            // Créer des facilities pour chaque cluster
            for ($j = 1; $j <= 2; $j++) {
                $facility = LocationCreator::create('facility', [
                    'name' => "Facility $i-$j",
                    'description' => "Description de la Facility $i-$j",
                    'address' => "Adresse de la Facility $i-$j",
                    'latitude' => mt_rand(-90, 90),
                    'longitude' => mt_rand(-180, 180),
                ], $cluster);

                // Créer des buildings pour chaque facility
                for ($k = 1; $k <= 2; $k++) {
                    $building = LocationCreator::create('building', [
                        'name' => "Building $i-$j-$k",
                        'description' => "Description du Building $i-$j-$k",
                        'address' => "Adresse du Building $i-$j-$k",
                        'latitude' => mt_rand(-90, 90),
                        'longitude' => mt_rand(-180, 180),
                    ], $facility);

                    // Créer des sections pour chaque building
                    for ($l = 1; $l <= 2; $l++) {
                        $section = LocationCreator::create('section', [
                            'name' => "Section $i-$j-$k-$l",
                            'description' => "Description de la Section $i-$j-$k-$l",
                            'address' => "Adresse de la Section $i-$j-$k-$l",
                            'latitude' => mt_rand(-90, 90),
                            'longitude' => mt_rand(-180, 180),
                        ], $building);

                        // Créer des offices pour chaque section
                        for ($m = 1; $m <= 3; $m++) {
                            LocationCreator::create('office', [
                                'name' => "Office $i-$j-$k-$l-$m",
                                'description' => "Description de l'Office $i-$j-$k-$l-$m",
                                'office_type_id' => mt_rand(1, 5), // ID aléatoire de type de bureau
                            ], $section);
                        }
                    }
                }
            }
        }
    }
}
