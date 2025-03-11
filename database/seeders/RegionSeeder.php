<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder {
    public function run(): void 
    {
        $regions = [
            'Île-de-France',
            'Provence-Alpes-Côte d\'Azur',
            'Auvergne-Rhône-Alpes',
            'Nouvelle-Aquitaine',
            'Occitanie',
            'Bourgogne-Franche-Feature',
            'Grand-Est',
            'Hauts-de-France',
            'Normandie',
            'Bretagne',
            'Pays de la Loire',
            'Centre-Val de Loire'
        ];
        foreach ($regions as $region) {
            Region::create(['name' => $region]);
        }
    }
}
// Seeder 1