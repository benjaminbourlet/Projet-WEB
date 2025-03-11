<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder {
    public function run(): void 
    {
        $cities = [
            // Île-de-France
            ['name' => 'Paris', 'region_id' => 1],
            ['name' => 'Versailles', 'region_id' => 1],
            ['name' => 'Boulogne-Billancourt', 'region_id' => 1],
            ['name' => 'Saint-Denis', 'region_id' => 1],
            ['name' => 'Montreuil', 'region_id' => 1],

            // Provence-Alpes-Côte d'Azur
            ['name' => 'Marseille', 'region_id' => 2],
            ['name' => 'Nice', 'region_id' => 2],
            ['name' => 'Toulon', 'region_id' => 2],
            ['name' => 'Aix-en-Provence', 'region_id' => 2],
            ['name' => 'Antibes', 'region_id' => 2],

            // Auvergne-Rhône-Alpes
            ['name' => 'Lyon', 'region_id' => 3],
            ['name' => 'Grenoble', 'region_id' => 3],
            ['name' => 'Saint-Étienne', 'region_id' => 3],
            ['name' => 'Clermont-Ferrand', 'region_id' => 3],
            ['name' => 'Annecy', 'region_id' => 3],

            // Nouvelle-Aquitaine
            ['name' => 'Bordeaux', 'region_id' => 4],
            ['name' => 'Limoges', 'region_id' => 4],
            ['name' => 'Poitiers', 'region_id' => 4],
            ['name' => 'La Rochelle', 'region_id' => 4],
            ['name' => 'Pau', 'region_id' => 4],

            // Occitanie
            ['name' => 'Toulouse', 'region_id' => 5],
            ['name' => 'Montpellier', 'region_id' => 5],
            ['name' => 'Nîmes', 'region_id' => 5],
            ['name' => 'Perpignan', 'region_id' => 5],
            ['name' => 'Carcassonne', 'region_id' => 5],

            // Bourgogne-Franche-Comté
            ['name' => 'Dijon', 'region_id' => 6],
            ['name' => 'Besançon', 'region_id' => 6],
            ['name' => 'Chalon-sur-Saône', 'region_id' => 6],
            ['name' => 'Nevers', 'region_id' => 6],
            ['name' => 'Montbéliard', 'region_id' => 6],

            // Grand-Est
            ['name' => 'Strasbourg', 'region_id' => 7],
            ['name' => 'Reims', 'region_id' => 7],
            ['name' => 'Nancy', 'region_id' => 7],
            ['name' => 'Metz', 'region_id' => 7],
            ['name' => 'Mulhouse', 'region_id' => 7],

            // Hauts-de-France
            ['name' => 'Lille', 'region_id' => 8],
            ['name' => 'Amiens', 'region_id' => 8],
            ['name' => 'Roubaix', 'region_id' => 8],
            ['name' => 'Tourcoing', 'region_id' => 8],
            ['name' => 'Calais', 'region_id' => 8],

            // Normandie
            ['name' => 'Caen', 'region_id' => 9],
            ['name' => 'Le Havre', 'region_id' => 9],
            ['name' => 'Rouen', 'region_id' => 9],
            ['name' => 'Évreux', 'region_id' => 9],
            ['name' => 'Dieppe', 'region_id' => 9],

            // Bretagne
            ['name' => 'Rennes', 'region_id' => 10],
            ['name' => 'Brest', 'region_id' => 10],
            ['name' => 'Quimper', 'region_id' => 10],
            ['name' => 'Vannes', 'region_id' => 10],
            ['name' => 'Lorient', 'region_id' => 10],

            // Pays de la Loire
            ['name' => 'Nantes', 'region_id' => 11],
            ['name' => 'Angers', 'region_id' => 11],
            ['name' => 'Le Mans', 'region_id' => 11],
            ['name' => 'La Roche-sur-Yon', 'region_id' => 11],
            ['name' => 'Saint-Nazaire', 'region_id' => 11],

            // Centre-Val de Loire
            ['name' => 'Orléans', 'region_id' => 12],
            ['name' => 'Tours', 'region_id' => 12],
            ['name' => 'Bourges', 'region_id' => 12],
            ['name' => 'Châteauroux', 'region_id' => 12],
            ['name' => 'Blois', 'region_id' => 12],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

// Seeder 2