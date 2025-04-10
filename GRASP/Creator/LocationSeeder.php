<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Factories\LocationCreator;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nombre d'éléments à créer par niveau
        $clusterCount = 3;
        $facilityPerCluster = 2;
        $buildingPerFacility = 2;
        $sectionPerBuilding = 3;
        $officePerSection = 4;

        for ($i = 0; $i < $clusterCount; $i++) {
            // Créer un Cluster
            $cluster = LocationCreator::create('cluster');

            for ($j = 0; $j < $facilityPerCluster; $j++) {
                // Créer une Facility liée au Cluster
                $facility = LocationCreator::create('facility', [], $cluster);

                for ($k = 0; $k < $buildingPerFacility; $k++) {
                    // Créer un Building lié à la Facility
                    $building = LocationCreator::create('building', [], $facility);

                    for ($l = 0; $l < $sectionPerBuilding; $l++) {
                        // Créer une Section liée au Building
                        $section = LocationCreator::create('section', [], $building);

                        for ($m = 0; $m < $officePerSection; $m++) {
                            // Créer un Office lié à la Section
                            LocationCreator::create('office', [], $section);
                        }
                    }
                }
            }
        }
    }
}
